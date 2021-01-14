<?php
defined('_DEXEC') or DIE;

class ConfigCore{

	protected static $_instance;
	protected $_config;

	private function __construct(){
		$this->_config = require_once('./conf.php');
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
		return $this->_config[$key];
	}
}