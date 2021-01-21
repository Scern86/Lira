<?php
namespace Scern\Lira\Core;

defined('_DEXEC') or DIE;

class User{
	
	protected $db;
	protected static $instance;
	private $loggedIn = false;
	protected $user;
	protected $session;
	protected $request;
	
	private function __construct(){
		$this->db = Db::getInstance()->getDatabase('main');
		$this->session = Session::getInstance();
		$this->request = Request::getInstance();
		$this->user = new \Scern\Lira\Classes\Object(0); 
 		if(!$this->checkLogin() AND $this->request->post('action')=='login') $this->verifyUser($this->request->post('login'),$this->request->post('password'));
	}
	private function __wakeup(){}
	private function __clone(){}

	public static function getInstance() {
		if(self::$instance===null) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	public function checkLogin(){		
		if($this->session->loggedIn) {
			$idUser = $this->db->getOne('SELECT l.`id_user` FROM ?n l,?n t WHERE l.`id_user`=t.`id_object` AND t.`definition`=?s AND t.`id_tag`=?s AND l.`ssid`=?s AND DATE(l.`logged_in`)=?s AND l.`ip_address`=?s',TBL_LOGIN,TBL_EXT_TAG,'type','86b5e76b8a6637060559',$this->session->getSessionId(),date('Y-m-d'),$_SERVER['HTTP_X_REAL_IP'] ?? $_SERVER['REMOTE_ADDR']);
			if(!empty($idUser)){
				$this->user = new \Scern\Lira\Classes\Object($idUser);
				$this->loggedIn = true;
				return true;				
			}
			else{
				//$this->session->destroySession();
				$this->loggedIn = false;				
			}
		}
		return FALSE;
	}
 	public function verifyUser($login,$password){
		if(!empty($login) AND !empty($password)){
			$idUser = $this->db->getOne('SELECT l.`id_object` FROM ?n l,?n p,?n t WHERE l.`id_object`=p.`id_object` AND l.`id_object`=t.`id_object` AND l.`definition`=?s AND p.`definition`=?s AND t.`definition`=?s AND l.`field`=?s AND p.`field`=?s AND t.`id_tag`=?s',TBL_EXT_STRING,TBL_EXT_STRING,TBL_EXT_TAG,'login','password','type',$login,hash('sha512',$password),'86b5e76b8a6637060559');
			if(!empty($idUser)){
				$this->db->query('INSERT INTO ?n SET `id_user`=?s,`ssid`=?s,`ip_address`=?s',TBL_LOGIN,$idUser,$this->session->getSessionId(),$_SERVER['HTTP_X_REAL_IP'] ?? $_SERVER['REMOTE_ADDR']);
				$this->user = new \Scern\Lira\Classes\Object($idUser);
				$this->loggedIn = true;
				$this->session->loggedIn = true;
				header('Location: /');
				return true;				
			}
		}
		return false;
	}
	public function logout(){
		$this->session->destroySession();
		Document::addHeader('Location: /');
	}
	public function isLoggedIn(){
		return $this->loggedIn;
	}
	public function getUser(){
		return $this->user;
	}
}