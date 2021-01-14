<?php
defined('_DEXEC') or DIE;

class SessionCore{

	protected static $_instance;
	protected static $_ssid;

	private function __construct(){
		session_start();
		self::$_ssid = session_id();
	}
	private function __wakeup(){}
	private function __clone(){}

	public static function getInstance() {
		if(self::$_instance===null) {
			self::$_instance=new self();
		}
		return self::$_instance;
	}
	public static function getSessionId(){
		return self::$_ssid;
	}
	public function __get($key){
		return !empty($_SESSION[$key]) ? $_SESSION[$key] : $_COOKIE[$key] ;
	}
	public function __set($key,$value){
		setcookie($key,$value);
		$_SESSION[$key] = $value;
	}
	public static function remove($key){
		setcookie($key,null, -1, '/');
		unset($_SESSION[$key]);
	}
	public static function destroySession(){
		session_regenerate_id(TRUE);
		$_SESSION = [];
		setcookie('logged_in','',time()-100);
		session_destroy();
	}
}
