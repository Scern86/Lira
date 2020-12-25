<?php
defined('_DEXEC') or DIE;

class RenderCoreHelpers{

 	public static function render($path,$template,$data){
		$file = $path.DS.$template.'.php';
		if(file_exists($file)){
			ob_start();
			include $file;
			$d = ob_get_contents();
			ob_end_clean();;
			return $d;
		}
	}
}