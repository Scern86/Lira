<?php
namespace Scern\Lira\Core;

defined('_DEXEC') or DIE;

class Text{

	protected static $instance;
	protected $text = [];

	private function __construct(){}
	private function __wakeup(){}
	private function __clone(){}

	public static function getInstance() {
		if(self::$instance===null) {
			self::$instance=new self();
		}
		return self::$instance;
	}
	public function addText($lang,$file){
		$path = 'language'.DS.$lang.DS.$file.'.php';
		if (file_exists($path)) $text = include_once($path); 
		$this->text = array_merge($text,$this->text);
	}
	public function __get($key){
		return array_key_exists($key,$this->text) ? $this->text[$key] : ucfirst($key);
	}
}