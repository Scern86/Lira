<?php
namespace Scern\Lira\Core;

defined('_DEXEC') or DIE;

class Request{

	protected static $instance;
	protected $get = [];
	public $post = [];

	private function __construct(){
		parse_str ($_SERVER['QUERY_STRING'], $this->get);
		$this->post = $_POST;
	}
	private function __wakeup(){}
	private function __clone(){}

	public static function getInstance() {
		if(self::$instance===null) {
			self::$instance=new self();
		}
		return self::$instance;
	}
	public function __get($key){
		return $this->get[$key];
	}
	public function post($key){
		return $this->post[$key];
	}
	public function set($type,$key,$value){
		$this->$type[$key] = $value;
	}
	public function reload($url){
		parse_str ($url, $this->get);
	}
}