<?php
defined('_DEXEC') or DIE;

class ConfigCore{

	protected static $_instance;
	protected $_config;

	private function __construct(){
		include './conf.php';
		$this->_config = $config;
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
		if(array_key_exists($key,$this->_config)) return $this->_config[$key];
		else return FALSE;
	}
}