<?php
defined('_DEXEC') or DIE;

class DocumentCore{

	public static $header = [];
	public static $document = [];
	public static $template = NULL;
	public static $lang = 'ru';

	public static function addString($string,$value,$rewrite=TRUE){
		if($rewrite) self::$document[$string] = $value;
		else self::$document[$string] = self::$document[$string].$value;
	}	
	public static function addHeader($header_string){
		array_push(self::$header,$header_string);
	}
	public static function renderHeader(){
		if(!empty(self::$header)) {
			foreach(self::$header as $item){
				header($item);
			}
			exit();
		}
	}
	public static function addContent($position,$order,$content=NULL){
		self::$document[$position][$order][] = $content;
		ksort(self::$document[$position]);
	}
	public static function getContent($position='all'){
		if($position<>'all') return self::$document[$position];
		else return self::$document;
	}
	public static function getTemplate(){
		return self::$template;		
	}	
	public static function setTemplate($template){
		self::$template = $template;
	}
	public static function getLang(){
		return self::$lang;		
	}	
	public static function setTLang($lang){
		self::$lang = $lang;
	}	
}