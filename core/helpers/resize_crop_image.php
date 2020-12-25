<?php 
defined('_DEXEC') or DIE;

class Resize_crop_imageCoreHelpers{

	public static function resizeAndCrop($catalog_to_save,$original_file,$new_file_name,$prev_w,$prev_h,$main_w,$quality=80){
		$img_info = getimagesize($original_file);

		switch($img_info['mime']){
			case 'image/jpeg':
				$src = imagecreatefromjpeg($original_file);
			break;
			case 'image/png':
				$src = imagecreatefrompng($original_file);
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
		imagejpeg($thumb,$catalog_to_save.DS.'small_'.$new_file_name,$quality);

		$ratio = $main_w / $orig_w;
		$main_h = $orig_h * $ratio;
		$main = imagecreatetruecolor($main_w,$main_h);
		imagecopyresampled($main,$src,0,0,0,0,$main_w,$main_h,$orig_w,$orig_h);
		imagejpeg($main,$catalog_to_save.DS.'medium_'.$new_file_name,$quality);
	}	
}