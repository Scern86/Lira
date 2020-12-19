<?php
defined('_DEXEC') or DIE;

abstract class ControllerClasses{
 	protected $_db;	
	protected $_user;
	protected $_session;
	protected $_component;
	protected $_path;
	protected $_text;
	protected $_request;
	protected $_user_actions;
	
	public function __construct(){
		$this->_db = DbCore::getInstance()->getDatabase('main');
		$this->_user = UserCore::getInstance()->getUser();
		$this->_session = SessionCore::getInstance();
		$this->_text = TextCore::getInstance();
		$this->_request = RequestCore::getInstance();
		$this->_user_actions = $this->_db->getCol('SELECT efs.`field` FROM ?n efs,?n eo WHERE efs.`id_object`=eo.`id_object_child` AND eo.`definition`=?s AND efs.`definition`=?s AND eo.`id_object_parent`=?s',TBL_EXT_STRING,TBL_EXT_OBJECT,'action','method',$this->_user->id);
	}
}