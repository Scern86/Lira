<?php
defined('_DEXEC') or DIE;

class RequestCore{

	protected static $_instance;
	protected $_get = [];
	public $post = [];

	private function __construct(){
		parse_str($_SERVER['QUERY_STRING'], $this->_get);
		$this->post = $_POST;
	}
	private function __wakeup(){}
	private function __clone(){}

	public static function getInstance() {
		if(self::$_instance===null) {
			self::$_instance=new self();
		}
		return self::$_instance;
	}
	public function __get($key){
		return $this->_get[$key];
	}
	public function post($key){
		return $this->post[$key];
	}
	public function set($type,$key,$value){
		$to_array = '_'.$type;
		$this->$to_array[$key] = $value;
	}
	public function reload($url){
		parse_str($url, $this->_get);
	}
}