<?php
namespace Scern\Lira\Core;

defined('_DEXEC') or DIE;

class Session{

	protected static $instance;
	protected static $ssid;

	private function __construct(){
		session_start();
		self::$ssid = session_id();
	}
	private function __wakeup(){}
	private function __clone(){}

	public static function getInstance() {
		if(self::$instance===null) {
			self::$instance=new self();
		}
		return self::$instance;
	}
	public static function getSessionId(){
		return self::$ssid;
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
		session_regenerate_id(false);
		$_SESSION = [];
		setcookie('loggeIn','',time()-100);
		session_destroy();
	}
}
