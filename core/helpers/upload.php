<?php
defined('_DEXEC') or DIE;

class UploadCoreHelpers{
	
 	public static function upload($multiple=TRUE){		
		$request = RequestCore::getInstance();
		$config = ConfigCore::getInstance();		
		if($request->post('action')=='upload' AND !empty($_FILES['upload']['name'][0])){
			$result = [];
			$hostname = $config->hostname;
			$total = count($_FILES['upload']['name']);
			$year = date('Y');
			$month = date('m');
			$day = date('d');
			$cat = bin2hex(random_bytes(1));			
			$image_types = ['jpg','jpeg','png','bmp','webp','gif'];
			$document_types = ['txt','rtf','odt','doc','docx','pdf','ods','xls','xlsx','ppt','pptx','rar','zip','7z','fb2','epub','djvu','mp3','mp4','htm','html'];			
			$all_types = array_merge($image_types,$document_types);
			
			for($a=0;$a<$total;$a++){
				$old_file = $_FILES['upload']['tmp_name'][$a];
				if($old_file !=''){
					$old_filename = $_FILES['upload']['name'][$a];
					// Переименовываем или сохраняем оригинальное имя файла
					
					if($request->post('rename_files')==1){
						$new_filename = bin2hex(random_bytes(10)).'.'.pathinfo($old_filename)['extension'];
					}
					else{
						$new_filename = $old_filename;
					}
					// Если расширение файла недопустимое, уходим на следующий круг
					if(!in_array(strtolower(pathinfo($old_filename)['extension']),$all_types)) CONTINUE;
					// Путь к директории media (+права доступа)
					$path = $config->media_path.DS.$year.DS.$month.DS.$day.DS.$cat;
					if(!is_dir($path)) mkdir($path,0777,TRUE);
					chmod($path,0777);
					
					$new_file = $path.DS.$new_filename;
					if(move_uploaded_file($old_file,$new_file)){
						// Создаём объект, к которому впоследствии добавим нужные поля
						$id_object = GeneratorCoreHelpers::generateId(10);
						$data = [
							'id'=>$id_object,
							'title'=>htmlspecialchars(str_replace('.'.pathinfo($old_filename)['extension'],'',$old_filename)),
							'created'=>date('Y-m-d H:i:s'),
						];
						$object = ObjectClasses::create($data);
						// Если это изображение
						if(in_array(strtolower(pathinfo($old_filename)['extension']),$image_types)){
							ObjectClasses::addField($id_object,'type',[TagClasses::getIdByTitle('Изображение')],0);
							// Если надо обработать изображение
							if($request->post('resize_images')==1){
								// Меняем расширение на JPG
								$new_image_name = str_replace('.'.pathinfo($new_filename)['extension'],'',$new_filename).'.jpg';
								$new_image = $path.DS.$new_image_name;
								self::resizeAndCrop($path,$new_image,$new_image_name,$request->post('w') ?? 200,$request->post('h') ?? 200,$request->post('m') ?? 1280);
								ObjectClasses::addField($id_object,'small',$hostname.DS.$path.DS.'small_'.$new_image_name);
								ObjectClasses::addField($id_object,'medium',$hostname.DS.$path.DS.'medium_'.$new_image_name);
								ObjectClasses::addField($id_object,'large',$hostname.DS.$path.DS.$new_filename);								
							}
							else{
								ObjectClasses::addField($id_object,'small',$hostname.DS.$path.DS.$new_filename);
								ObjectClasses::addField($id_object,'medium',$hostname.DS.$path.DS.$new_filename);
								ObjectClasses::addField($id_object,'large',$hostname.DS.$path.DS.$new_filename);
							}
						}
						//Если это документ
						if(in_array(strtolower(pathinfo($old_filename)['extension']),$document_types)){
							ObjectClasses::addField($id_object,'type',[TagClasses::getIdByTitle('Документ')],0);
							ObjectClasses::addField($id_object,'path',$hostname.DS.$path.DS.$new_filename);
						}
						ObjectClasses::addField($id_object,'access',['5e1cc7832dcbd43148d5'],0);
						$result['success'][] = $id_object;						
					}
					else $result['error'][] = $old_file;
				}
			}
			if(count($result['success']>0)) {
				$result['done'] = TRUE;
				return $result;
			}
			else DocumentCore::addContent('content',20,RenderCoreHelpers::render('templates'.DS.'shared','upload',['multiple'=>$multiple,'rename_files'=>$rename_files,'resize_images'=>$resize_images]));
		}
		else{
			DocumentCore::addContent('content',20,RenderCoreHelpers::render('templates'.DS.'shared','upload',['multiple'=>$multiple,'rename_files'=>$rename_files,'resize_images'=>$resize_images]));
			return FALSE;			
		}
	}
	private static function resizeAndCrop($catalog_to_save,$original_file,$new_file_name,$prev_w,$prev_h,$main_w){
		$img_info = getimagesize($original_file);
		switch($img_info['mime']){
			case 'image/jpeg':
				$src = imagecreatefromjpeg($original_file);
			break;
			case 'image/png':
				$src = imagecreatefrompng($original_file);
			break;
			case 'image/bmp':
				$src = imagecreatefrombmp($original_file); 
			break;
			case 'image/webp':
				$src = imagecreatefromwebp($original_file); 
			break;
			case 'image/gif':
				$src = imagecreatefromgif($original_file); 
			break;			
		}

		$orig_w = imagesx($src);
		$orig_h = imagesy($src);
		$orig_aspect = $orig_w / $orig_h;
		$prev_aspect = $prev_w / $prev_h;
		if($orig_aspect >= $prev_aspect){
			$new_h = $prev_h;
			$new_w = $orig_w / ($orig_h / $prev_h);
		}
		else{
			$new_w = $prev_w;
			$new_h = $orig_h / ($orig_w / $prev_w);
		}
		$thumb = imagecreatetruecolor($prev_w,$prev_h);
		imagecopyresampled($thumb,$src,0-($new_w - $prev_w)/2,0-($new_h - $prev_h)/2,0,0,$new_w,$new_h,$orig_w,$orig_h);
		imagejpeg($thumb,$catalog_to_save.DS.'small_'.$new_file_name,80);

		$ratio = $main_w / $orig_w;
		$main_h = $orig_h * $ratio;
		$main = imagecreatetruecolor($main_w,$main_h);
		imagecopyresampled($main,$src,0,0,0,0,$main_w,$main_h,$orig_w,$orig_h);
		imagejpeg($main,$catalog_to_save.DS.'medium_'.$new_file_name,80);
	}	
}