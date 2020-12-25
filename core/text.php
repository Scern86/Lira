<?php
defined('_DEXEC') or DIE;

class TextCore{

	protected static $_instance;
	protected $_text = [];

	private function __construct(){}
	private function __wakeup(){}
	private function __clone(){}

	public static function getInstance() {
		if(self::$_instance===null) {
			self::$_instance=new self();
		}
		return self::$_instance;
	}
	public function addText($lang,$file){
		$path = 'language'.DS.$lang.DS.$file.'.php';
		if(file_exists($path)) $text = include_once($path); 
		$this->_text = array_merge($text,$this->_text);
	}
	public function __get($key){
		return array_key_exists($key,$this->_text) ? $this->_text[$key] : ucfirst($key);
	}
}