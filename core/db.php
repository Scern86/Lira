<?php
defined('_DEXEC') or DIE;

class DbCore{

	protected static $_instance;
	protected $_databases = [];

	private function __construct(){

	}
	private function __wakeup(){}
	private function __clone(){}

	public static function getInstance() {
		if(self::$_instance===null) {
			self::$_instance=new self();
		}
		return self::$_instance;
	}
	public function init($key,$data){
		if(!array_key_exists($key,$this->_databases)) $this->_databases[$key] = new MysqlCoreLib($data);
	}
	public function getDatabase($key){
		if(array_key_exists($key,$this->_databases)) return $this->_databases[$key];
		return FALSE;
	}
}