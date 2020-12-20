<?php
defined('_DEXEC') or DIE;

class ControllerComponentsObject extends ControllerClasses{

	public function __construct(){
		parent::__construct();
		$this->_component = 'object';
		$this->_path = 'components'.DS.$this->_component;
		$this->_text->addText('ru',$this->_component);
	}
	public function action(){
		switch($this->_request->task){
			case 'ajax':
  				if(in_array('object_ajax',$this->_user_actions)){
					$this->_ajax();
  				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'add':
				if(in_array('object_add',$this->_user_actions)){
					$this->_add();
 				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'upload':
				if(in_array('object_upload',$this->_user_actions)){
					$this->_upload();
 				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'edit':
				if(in_array('object_edit',$this->_user_actions)){
					$this->_edit();
				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'remove':
				if(in_array('object_remove',$this->_user_actions)){
					$this->_remove();
 				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'select_field':
				if(in_array('object_select_field',$this->_user_actions)){
					$this->_select_field();
  				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'add_field':
				if(in_array('object_add_field',$this->_user_actions)){
					$this->_add_field();
 				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'edit_field':
				if(in_array('object_edit_field',$this->_user_actions)){
					$this->_edit_field();
  				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'remove_field':
				if(in_array('object_remove_field',$this->_user_actions)){
					$this->_remove_field();
  				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'list':
				if(in_array('object_list',$this->_user_actions)){
					$this->_list();
  				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'show':
				$this->_show();
			break;
		}
	}
	protected function _ajax(){
		switch($this->_request->act){
			case 'load':
				$list = $this->_db->getAll('SELECT * FROM ?n o ORDER BY o.`created` DESC LIMIT ?i,?i',TBL_OBJECT,(int)$this->_request->post('offset'),(int)$this->_request->post('limit'));
				$tags = $this->_db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC',TBL_OBJECT,TBL_EXT_TAG,TBL_TAG,'type');
				if(!empty($tags)) foreach($tags as $t){
					$tag_list[$t['id_object']][] = $t['tag'];
				}
				if(!empty($list) AND !empty($tag_list)) foreach($list as $item){
					$data['list'][$item['id']] = $item;
					$data['list'][$item['id']]['tags'][] = $tag_list[$item['id']];
				}
				echo RenderCoreHelpers::render($this->_path.DS.'templates','ajax_load',$data);
				exit();
			break;
 			case 'search':
				$search = '%'.$this->_request->post('search').'%';
				if(!empty($search) AND mb_strlen($search)>2){
					$list = $this->_db->getAll('SELECT * FROM ?n o WHERE o.`title` LIKE ?s ORDER BY o.`created` DESC LIMIT 0,50',TBL_OBJECT,$search);
					$tags = $this->_db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC',TBL_OBJECT,TBL_EXT_TAG,TBL_TAG,'type');
					if(!empty($tags)) foreach($tags as $t){
						$tag_list[$t['id_object']][] = $t['tag'];
					}
					if(!empty($list) AND !empty($tag_list)) foreach($list as $item){
						$data['list'][$item['id']] = $item;
						$data['list'][$item['id']]['tags'][] = $tag_list[$item['id']];
					}
				}
				else{
					$list = $this->_db->getAll('SELECT * FROM ?n o ORDER BY o.`created` DESC LIMIT 0,50',TBL_OBJECT);
					$tags = $this->_db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC',TBL_OBJECT,TBL_EXT_TAG,TBL_TAG,'type');
					if(!empty($tags)) foreach($tags as $t){
						$tag_list[$t['id_object']][] = $t['tag'];
					}
					if(!empty($list) AND !empty($tag_list)) foreach($list as $item){
						$data['list'][$item['id']] = $item;
						$data['list'][$item['id']]['tags'][] = $tag_list[$item['id']];
					}
				}
				echo RenderCoreHelpers::render($this->_path.DS.'templates','ajax_load',$data);
				exit();
			break;
			case 'load_tags':
				$data['list'] = $this->_db->getAll('SELECT * FROM ?n ORDER BY `title` LIMIT ?i,?i',TBL_TAG,(int)$this->_request->post('offset'),(int)$this->_request->post('limit'));
				echo RenderCoreHelpers::render($this->_path.DS.'templates','ajax_load_tags',$data);
				exit();
			break;
			case 'search_tags':
				$search = '%'.$this->_request->post('search').'%';
				if(!empty($search) AND mb_strlen($search)>2){
					$data['list'] = $this->_db->getAll('SELECT * FROM ?n WHERE `title` LIKE ?s ORDER BY `title` LIMIT 0,50',TBL_TAG,$search);
				}
				else{
					$data['list'] = $this->_db->getAll('SELECT * FROM ?n ORDER BY `title` LIMIT 0,50',TBL_TAG);
				}
				echo RenderCoreHelpers::render($this->_path.DS.'templates','ajax_load_tags',$data);
				exit();
			break;
			case 'load_objects':
				$list = $this->_db->getAll('SELECT * FROM ?n o ORDER BY o.`created` DESC LIMIT ?i,?i',TBL_OBJECT,(int)$this->_request->post('offset'),(int)$this->_request->post('limit'));
				$tags = $this->_db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC',TBL_OBJECT,TBL_EXT_TAG,TBL_TAG,'type');
				if(!empty($tags)) foreach($tags as $t){
					$tag_list[$t['id_object']][] = $t['tag'];
				}
				if(!empty($list) AND !empty($tag_list)) foreach($list as $item){
					$data['list'][$item['id']] = $item;
					$data['list'][$item['id']]['tags'][] = $tag_list[$item['id']];
				}
				echo RenderCoreHelpers::render($this->_path.DS.'templates','ajax_load_objects',$data);
				exit();
			break;
			case 'search_objects':
				$search = '%'.$this->_request->post('search').'%';
				if(!empty($search) AND mb_strlen($search)>=2){
					$list = $this->_db->getAll('SELECT * FROM ?n o WHERE o.`title` LIKE ?s ORDER BY o.`created` DESC LIMIT 0,50',TBL_OBJECT,$search);
					$tags = $this->_db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC',TBL_OBJECT,TBL_EXT_TAG,TBL_TAG,'type');
					if(!empty($tags)) foreach($tags as $t){
						$tag_list[$t['id_object']][] = $t['tag'];
					}
					if(!empty($list) AND !empty($tag_list)) foreach($list as $item){
						$data['list'][$item['id']] = $item;
						$data['list'][$item['id']]['tags'][] = $tag_list[$item['id']];
					}
				}
				else{
					$list = $this->_db->getAll('SELECT * FROM ?n o ORDER BY o.`created` DESC LIMIT 0,50',TBL_OBJECT);
					$tags = $this->_db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC',TBL_OBJECT,TBL_EXT_TAG,TBL_TAG,'type');
					if(!empty($tags)) foreach($tags as $t){
						$tag_list[$t['id_object']][] = $t['tag'];
					}
					if(!empty($list) AND !empty($tag_list)) foreach($list as $item){
						$data['list'][$item['id']] = $item;
						$data['list'][$item['id']]['tags'][] = $tag_list[$item['id']];
					}
				}
				echo RenderCoreHelpers::render($this->_path.DS.'templates','ajax_load_objects',$data);
				exit();
			break;
			case 'load_attachments':
				$data['main'] = new ObjectClasses($this->_request->id);
				echo RenderCoreHelpers::render('templates'.DS.'objects'.DS.'ajax',$this->_request->type,$data);
				exit();
			break;
		}
	}
	protected function _add(){
		if($this->_request->post('action')=='add'){
			$id = GeneratorCoreHelpers::generateId(10);
			$data = [
				'id'=>$id,
				'title'=>trim(htmlspecialchars($this->_request->post('title'))),
				'created'=>date('Y-m-d H:i:s'),
			];
			if(ObjectClasses::create($data)){
				ObjectClasses::addField($id,'access',['5e1cc7832dcbd43148d5'],0);
				switch($this->_request->type){
					case 'save':
						DocumentCore::addHeader('Location: /?com=object&task=edit&id='.$id);
					break;
					case 'new':
						DocumentCore::addHeader('Location: /?com=object&task=add');
					break;
					default:
						DocumentCore::addHeader('Location: /?com=object&task=list');
					break;
				}
			}
			else{
				DocumentCore::addHeader('Location: /?com=object&task=list');
			}
		}
		else{
			DocumentCore::addString('title',$this->_text->add);
			$tb_array = [];
			DocumentCore::addContent('content',5,RenderCoreHelpers::render($this->_path.DS.'toolbars','add',$tb_array));
			DocumentCore::addContent('content',20,RenderCoreHelpers::render($this->_path.DS.'templates','add',$data));
		}
	}
	protected function _upload(){
		if($this->_request->post('action')=='upload' AND !empty($_FILES['upload']['name'][0])){
			$result = [];
			$hostname = ConfigCore::getInstance()->hostname;
			$total = count($_FILES['upload']['name']);
			$year = date('Y');
			$month = date('m');
			$day = date('d');
			$cat = bin2hex(random_bytes(1));
			$image_types = ['jpg','jpeg','png','bmp','webp','gif'];
			$document_types = ['doc','docx','rtf','txt','odt','xls','xlsx','ppt','pptx','ods','rar','zip','7z','pdf','fb2','epub','djvu','m3u','jpg','png','htm','html'];
			$music_types = ['mp3',];
			$all_types = array_merge($image_types,$document_types,$music_types);
			for($a=0;$a<$total;$a++){
				$oldFile = $_FILES['upload']['tmp_name'][$a];
				if($oldFile !=''){

					$old_filename = $_FILES['upload']['name'][$a];
					$new_filename = bin2hex(random_bytes(10)).'.'.pathinfo($old_filename)['extension'];
					//$new_filename = bin2hex(random_bytes(10));
					//$new_file_name_extension = pathinfo($old_filename)['extension'];
					$is_image = in_array(strtolower(pathinfo($old_filename)['extension']),$image_types);
					$is_document = in_array(strtolower(pathinfo($old_filename)['extension']),$document_types);
					$is_music = in_array(strtolower(pathinfo($old_filename)['extension']),$music_types);
					if(!in_array(strtolower(pathinfo($old_filename)['extension']),$all_types)) CONTINUE;
					$path = 'media'.DS.$year.DS.$month.DS.$day.DS.$cat;
					mkdir($path,0777,TRUE);
					chmod($path,0777);

					$newFile = $path.DS.$new_filename;
					if(move_uploaded_file($oldFile,$newFile)){
						$id_object = GeneratorCoreHelpers::generateId(10);
						$data = [
							'id'=>$id_object,
							'title'=>htmlspecialchars(str_replace('.'.pathinfo($old_filename)['extension'],'',$old_filename)),
							'created'=>date('Y-m-d H:i:s'),
						];
						$object = ObjectClasses::create($data);
						if($is_image){

							$this->_resizeAndCrop($path,$newFile,$new_filename,$this->_request->post('w') ?? 200,$this->_request->post('h') ?? 200,$this->_request->post('m') ?? 1280);
							ObjectClasses::addField($id_object,'small',$hostname.DS.$path.DS.'small_'.$new_filename);
							ObjectClasses::addField($id_object,'medium',$hostname.DS.$path.DS.'medium_'.$new_filename);
							ObjectClasses::addField($id_object,'large',$hostname.DS.$path.DS.$new_filename);
							ObjectClasses::addField($id_object,'type',[TagClasses::getIdByTitle('Изображение')],0);
						}
						elseif($is_document){
							ObjectClasses::addField($id_object,'path',$hostname.DS.$path.DS.$new_filename);
							ObjectClasses::addField($id_object,'type',[TagClasses::getIdByTitle('Документ')],0);
						}
						else{
							ObjectClasses::addField($id_object,'path',$hostname.DS.$path.DS.$new_filename);
							ObjectClasses::addField($id_object,'type',[TagClasses::getIdByTitle('Аудиотрек')],0);
						}
						ObjectClasses::addField($id_object,'access',['5e1cc7832dcbd43148d5'],0);
						$count++;
					}
					else {
						echo 'ACCESS DENIED TO MEDIA DIRECTORY';
						exit();
					}
				}
			}
			DocumentCore::addHeader('Location: /?com=object&task=list');
		}
		else{
			DocumentCore::addContent('content',5,RenderCoreHelpers::render($this->_path.DS.'toolbars','upload',NULL));
			DocumentCore::addContent('content',20,RenderCoreHelpers::render($this->_path.DS.'templates','upload',NULL));
		}
	}
	protected function _edit(){
		if($this->_request->post('action')=='edit'){
			$id = $this->_request->id;
			$data = [
				'id'=>$id,
				'title'=>trim(htmlspecialchars($this->_request->post('title'))),
			];
			if(ObjectClasses::update($data)){
				switch($this->_request->type){
					case 'save':
						DocumentCore::addHeader('Location: /?com=object&task=edit&id='.$id);
					break;
					case 'new':
						DocumentCore::addHeader('Location: /?com=object&task=add');
					break;
					default:
						DocumentCore::addHeader('Location: /?com=object&task=list');
					break;
				}
			}
			else{
				DocumentCore::addHeader('Location: /?com=object&task=list');
			}
		}
		else{
			DocumentCore::addString('title',$this->_text->edit);
			$data['main'] = new ObjectClasses($this->_request->id);

			$number = $this->_db->getAll('SELECT * FROM ?n WHERE `id_object`=?s',TBL_EXT_NUMBER,$this->_request->id);
			$string = $this->_db->getAll('SELECT * FROM ?n WHERE `id_object`=?s',TBL_EXT_STRING,$this->_request->id);
			$datetime = $this->_db->getAll('SELECT * FROM ?n WHERE `id_object`=?s',TBL_EXT_DATE,$this->_request->id);
			$text = $this->_db->getAll('SELECT * FROM ?n WHERE `id_object`=?s',TBL_EXT_SHORT_TEXT,$this->_request->id);
			$longtext = $this->_db->getAll('SELECT * FROM ?n WHERE `id_object`=?s',TBL_EXT_LONG_TEXT,$this->_request->id);
			$data['list_fields'] = array_merge($number,$string,$datetime,$text,$longtext);
			$data['fields'] = RenderCoreHelpers::render($this->_path.DS.'templates','fields',$data);

			$data['list_tags'] = $this->_db->getAll('SELECT * FROM ?n et,?n t WHERE et.`id_tag`=t.`id` AND et.`id_object`=?s ORDER BY et.`order`',TBL_EXT_TAG,TBL_TAG,$this->_request->id);
			$data['tags'] = RenderCoreHelpers::render($this->_path.DS.'templates','tags',$data);

			$data['list_objects'] = $this->_db->getAll('SELECT * FROM ?n eo,?n o WHERE eo.`id_object_child`=o.id AND eo.`id_object_parent`=?s ORDER BY eo.`order` ASC',TBL_EXT_OBJECT,TBL_OBJECT,$this->_request->id);
			$data['objects'] = RenderCoreHelpers::render($this->_path.DS.'templates','objects',$data);
			$tb_array = ['id'=>$this->_request->id];
			DocumentCore::addContent('content',5,RenderCoreHelpers::render($this->_path.DS.'toolbars','edit',$tb_array));
			DocumentCore::addContent('content',20,RenderCoreHelpers::render($this->_path.DS.'templates','edit',$data));
		}
	}
	protected function _remove(){
		if(ObjectClasses::remove($this->_request->id)){
			DocumentCore::addHeader('Location: /?com=object&task=list');
		}
		else{
			DocumentCore::addHeader('Location: /?com=object&task=list');
		}
	}
	protected function _select_field(){
		$data['id'] = $this->_request->id;
		DocumentCore::addContent('content',20,RenderCoreHelpers::render($this->_path.DS.'templates','select_field',$data));
	}
	protected function _add_field(){
		if($this->_request->post('action')=='add_field'){
			if(ObjectClasses::addField($this->_request->id,$this->_request->post('definition'),$this->_request->post('value'))){
				DocumentCore::addHeader('Location: /?com=object&task=edit&id='.$this->_request->id);
			}
			else{
				DocumentCore::addHeader('Location: /?com=object&task=edit&id='.$this->_request->id);
			}
		}
		else{
			switch($this->_request->type){
				case 'number':
					$data['fields'] = $this->_db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`',TBL_DEFINITION,'NUMBER');
				break;
				case 'string':
					$data['fields'] = $this->_db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`',TBL_DEFINITION,'STRING');
				break;
				case 'datetime':
					$data['fields'] = $this->_db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`',TBL_DEFINITION,'DATETIME');
				break;
				case 'text':
					$data['fields'] = $this->_db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`',TBL_DEFINITION,'TEXT');
				break;
				case 'longtext':
					$data['fields'] = $this->_db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`',TBL_DEFINITION,'LONGTEXT');
				break;
				case 'tag':
					$data['fields'] = $this->_db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`',TBL_DEFINITION,'TAG');
					$data['tags'] = $this->_db->getAll('SELECT * FROM ?n ORDER BY `title` LIMIT 0,50',TBL_TAG);
				break;
				case 'object':
					$data['fields'] = $this->_db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`',TBL_DEFINITION,'OBJECT');
					$list = $this->_db->getAll('SELECT * FROM ?n o ORDER BY o.`created` DESC LIMIT 0,50',TBL_OBJECT);
					$tags = $this->_db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC',TBL_OBJECT,TBL_EXT_TAG,TBL_TAG,'type');
					if(!empty($tags)) foreach($tags as $t){
						$tag_list[$t['id_object']][] = $t['tag'];
					}
					if(!empty($list) AND !empty($tag_list)) foreach($list as $item){
						$data['objects'][$item['id']] = $item;
						$data['objects'][$item['id']]['tags'][] = $tag_list[$item['id']];
					}
				break;
			}
			$data['id'] = $this->_request->id;
			$data['type'] = $this->_request->type;
			$tb_array = ['id'=>$this->_request->id,'type'=>$this->_request->type];
			DocumentCore::addContent('content',5,RenderCoreHelpers::render($this->_path.DS.'toolbars','add_field',$tb_array));
			DocumentCore::addContent('content',20,RenderCoreHelpers::render($this->_path.DS.'templates','add_'.$this->_request->type,$data));
		}
	}
	protected function _edit_field(){
		if($this->_request->post('action')=='edit_field'){
			switch($this->_request->type){
				case 'field':
					$result = ObjectClasses::editField($this->_request->id,key($this->_request->post('field')),$this->_request->post('field')[key($this->_request->post('field'))],$this->_request->type);
				break;
				case 'tag':
					$result = ObjectClasses::editField($this->_request->id,$this->_request->post('definition'),$this->_request->post('field'),$this->_request->type,$this->_request->post('order'));
				break;
				case 'object':
					$result = $this->_db->query('DELETE FROM ?n WHERE `id_object_parent`=?s AND `id_object_child`=?s AND `definition`=?s',TBL_EXT_OBJECT,$this->_request->id,$this->_request->post('field'),$this->_request->definition)
					AND ObjectClasses::editField($this->_request->id,$this->_request->post('definition'),$this->_request->post('field'),$this->_request->type,$this->_request->post('order'),$this->_request->post('params'));
				break;
			}
			if($result){
				DocumentCore::addHeader('Location: /?com=object&task=edit&id='.$this->_request->id);
			}
			else{
				DocumentCore::addHeader('Location: /?com=object&task=edit&id='.$this->_request->id);
			}
		}
		else{
			$data['main'] = new ObjectClasses($this->_request->id);
			$tb_array = ['id'=>$this->_request->id,'type'=>$this->_request->type,'definition'=>$this->_request->definition];
			DocumentCore::addContent('content',5,RenderCoreHelpers::render($this->_path.DS.'toolbars','edit_field',$tb_array));
			switch($this->_request->type){
				case 'field':
					DocumentCore::addContent('content',20,RenderCoreHelpers::render($this->_path.DS.'templates','edit_field',$data));
				break;
				case 'tag':
					$data['fields'] = $this->_db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`',TBL_DEFINITION,'TAG');
					$data['tag'] = $this->_db->getRow('SELECT * FROM ?n WHERE `id_object`=?s AND `id_tag`=?s',TBL_EXT_TAG,$this->_request->id,$this->_request->field);
					DocumentCore::addContent('content',20,RenderCoreHelpers::render($this->_path.DS.'templates','edit_tag',$data));
				break;
				case 'object':
					$data['mode_list'] = ['small'=>'SMALL','medium'=>'MEDIUM','large'=>'LARGE'];
					$data['type_list'] = $this->_db->getCol('SELECT t.`title` FROM ?n ft,?n t WHERE ft.`definition`=?s AND ft.`id_tag`=t.`id` AND ft.`id_object`=?s',TBL_EXT_TAG,TBL_TAG,'tag','08d6de21890349aa24c9');
					$data['fields'] = $this->_db->getAll('SELECT * FROM ?n WHERE `type` =?s ORDER BY `type`,`title`',TBL_DEFINITION,'OBJECT');
					$data['object'] = $this->_db->getRow('SELECT * FROM ?n WHERE `id_object_parent`=?s AND `id_object_child`=?s AND `definition`=?s',TBL_EXT_OBJECT,$this->_request->id,$this->_request->field,$this->_request->definition);
					DocumentCore::addContent('content',20,RenderCoreHelpers::render($this->_path.DS.'templates','edit_object',$data));
				break;
			}
		}
	}
	protected function _remove_field(){
		if(ObjectClasses::removeField($this->_request->id,$this->_request->definition,$this->_request->field)){
			DocumentCore::addHeader('Location: /?com=object&task=edit&id='.$this->_request->id);
		}
		else{
			DocumentCore::addHeader('Location: /?com=object&task=edit&id='.$this->_request->id);
		}
	}
	protected function _list(){
		DocumentCore::addString('title',$this->_text->list);
		$list = $this->_db->getAll('SELECT * FROM ?n o ORDER BY o.`created` DESC LIMIT 0,50',TBL_OBJECT);
		$tags = $this->_db->getAll('SELECT ft.`id_object`,t.`title` `tag` FROM ?n o,?n ft,?n t WHERE o.`id`=ft.`id_object` AND ft.`definition`=?s AND ft.`id_tag`=t.`id` ORDER BY o.`created` DESC',TBL_OBJECT,TBL_EXT_TAG,TBL_TAG,'type');
 		if(!empty($tags)) foreach($tags as $t){
			$tag_list[$t['id_object']][] = $t['tag'];
		}
		if(!empty($list) AND !empty($tag_list)) foreach($list as $item){
			$data['list'][$item['id']] = $item;
			$data['list'][$item['id']]['tags'][] = $tag_list[$item['id']];
		}
		$tb_array = [];
		DocumentCore::addContent('content',5,RenderCoreHelpers::render($this->_path.DS.'toolbars','list',$tb_array));
		DocumentCore::addContent('content',10,RenderCoreHelpers::render($this->_path.DS.'templates','list',$data));
	}
	protected function _show(){
		if($this->_request->alias){
			$id_object = $this->_db->getOne('SELECT `id_object` FROM ?n WHERE `field`=?s AND `definition`=?s',TBL_EXT_STRING,$this->_request->alias,'alias');
			$object = new ObjectClasses($id_object);
		}
		else $object = new ObjectClasses($this->_request->id);
		if($object->access) foreach($object->access as $item){
			$access[] = $item['id'];
		}
		if(in_array($this->_user->id,$access) OR in_array(ObjectClasses::getIdByTitle('Все'),$access) OR (UserCore::getInstance()->isLoggedIn() AND in_array(ObjectClasses::getIdByTitle('Зарегистрированные'),$access))){
			DocumentCore::addString('title',$object->title);

			if($this->_request->t AND file_exists('templates'.DS.'objects'.DS.$this->_request->t.'.php')) $template = $this->_request->t;
			else $template = array_shift($object->type)['title'];
			$params = ['mode'=>'large','show_title'=>1];
			DocumentCore::addContent('content',10,$object->render($template,$params));
		}
		else {
			DocumentCore::addHeader('Location: /');
		}
	}
	private function _resizeAndCrop($catalog_to_save,$original_file,$new_file_name,$prev_w,$prev_h,$main_w){
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