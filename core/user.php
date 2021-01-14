<?php
defined('_DEXEC') or DIE;

class UserCore{

	protected $_db;
	protected static $_instance;
	private $_logged_in = FALSE;
	protected $_user;
	protected $_session;
	protected $_request;
	
	private function __construct(){
		$this->_db = DbCore::getInstance()->getDatabase('main');
		$this->_session = SessionCore::getInstance();
		$this->_request = RequestCore::getInstance();
		$this->_user = new ObjectClasses(0); 
 		if(!$this->checkLogin() AND $this->_request->post('action')=='login') $this->verifyUser($this->_request->post('login'),$this->_request->post('password'));
	}
	private function __wakeup(){}
	private function __clone(){}

	public static function getInstance() {
		if(self::$_instance===null) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	public function checkLogin(){		
		if($this->_session->logged_in) {
			$id_user = $this->_db->getOne('SELECT l.`id_user` FROM ?n l,?n t WHERE l.`id_user`=t.`id_object` AND t.`definition`=?s AND t.`id_tag`=?s AND l.`ssid`=?s AND DATE(l.`logged_in`)=?s AND l.`ip_address`=?s',TBL_LOGIN,TBL_EXT_TAG,'type','86b5e76b8a6637060559',$this->_session->getSessionId(),date('Y-m-d'),$_SERVER['HTTP_X_REAL_IP'] ?? $_SERVER['REMOTE_ADDR']);
			if(!empty($id_user)){
				$this->_user = new ObjectClasses($id_user);
				$this->_logged_in = TRUE;
				return TRUE;				
			}
			else{
				$this->_session->destroySession();
				$this->_logged_in = FALSE;				
			}
		}
		return FALSE;
	}
 	public function verifyUser($login,$password){
		if(!empty($login) AND !empty($password)){
			$id_user = $this->_db->getOne('SELECT l.`id_object` FROM ?n l,?n p,?n t WHERE l.`id_object`=p.`id_object` AND l.`id_object`=t.`id_object` AND l.`definition`=?s AND p.`definition`=?s AND t.`definition`=?s AND l.`field`=?s AND p.`field`=?s AND t.`id_tag`=?s',TBL_EXT_STRING,TBL_EXT_STRING,TBL_EXT_TAG,'login','password','type',$login,hash('sha512',$password),'86b5e76b8a6637060559');
			if(!empty($id_user)){
				$this->_db->query('INSERT INTO ?n SET `id_user`=?s,`ssid`=?s,`ip_address`=?s',TBL_LOGIN,$id_user,$this->_session->getSessionId(),$_SERVER['HTTP_X_REAL_IP'] ?? $_SERVER['REMOTE_ADDR']);
				$this->_user = new ObjectClasses($id_user);
				$this->logged_in = TRUE;
				$this->_session->logged_in = TRUE;
				header('Location: /');
				return TRUE;				
			}
		}
		return FALSE;
	}
	public function logout(){
		$this->_session->destroySession();
		DocumentCore::addHeader('Location: /');
	}
	public function isLoggedIn(){
		return $this->_logged_in;
	}
	public function getUser(){
		return $this->_user;
	}
}