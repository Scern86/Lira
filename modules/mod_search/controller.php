<?php
defined('_DEXEC') or DIE;

class ControllerModulesMod_search{
	protected $_db;
	protected $_module;
	
	public function __construct($id){
		$this->_db = DbCore::getInstance()->getDatabase('main');
		//$this->_module = new ObjectClasses($id);
	}
	public function action(){
		return RenderCoreHelpers::render('modules'.DS.'mod_search','template',[]);		
	}
}