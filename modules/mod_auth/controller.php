<?php
defined('_DEXEC') or DIE;

class ControllerModulesMod_auth{
	protected $_user;
	
	public function __construct($id){
		$this->_user = UserCore::getInstance();
	}
	public function action(){
		if($this->_user->isLoggedIn()){
			return RenderCoreHelpers::render('modules'.DS.'mod_auth','template',NULL);
		}
		else{
			return RenderCoreHelpers::render('modules'.DS.'mod_auth','login',NULL);		
		}
	}
}