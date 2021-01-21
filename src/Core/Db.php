<?php
namespace Scern\Lira\Core;

defined('_DEXEC') or DIE;

class Db{

	protected static $instance;
	protected $databases = [];

	private function __construct(){

	}
	private function __wakeup(){}
	private function __clone(){}

	public static function getInstance() {
		if(self::$instance===null) {
			self::$instance=new self();
		}
		return self::$instance;
	}
	public function init($key,$data){
		if(!array_key_exists($key,$this->databases)) $this->databases[$key] = new \Scern\Lira\Lib\Safemysql($data);
	}
	public function getDatabase($key){
		if(array_key_exists($key,$this->databases)) return $this->databases[$key];
		return false;
	}
}