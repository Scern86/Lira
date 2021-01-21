<?php
namespace Scern\Lira\Classes;
use \Scern\Lira\Core as Core;
defined('_DEXEC') or DIE;

abstract class Controller{
 	protected $db;	
	protected $user;
	protected $session;
	protected $component;
	protected $path;
	protected $text;
	protected $request;
	protected $userActions;
	
	public function __construct(){
		$this->db = Core\Db::getInstance()->getDatabase('main');
		$this->user = Core\User::getInstance()->getUser();
		$this->session = Core\Session::getInstance();
		$this->text = Core\Text::getInstance();
		$this->request = Core\Request::getInstance();        
		$this->userActions = $this->db->getCol('SELECT efs.`field` FROM ?n efs,?n eo WHERE efs.`id_object`=eo.`id_object_child` AND eo.`definition`=?s AND efs.`definition`=?s AND eo.`id_object_parent`=?s', TBL_EXT_STRING, TBL_EXT_OBJECT, 'action', 'method', $this->user->id);
	}
	abstract public function action();
}