<?php
defined('_DEXEC') or DIE;

class AppCore{

	protected $_system;
	protected $_config;
	protected $_db;
	protected $_session;
	protected $_request;
	protected $_user;
	protected $_text;

	public function __construct(){
		$this->_config = ConfigCore::getInstance();
		$db = DbCore::getInstance();
		$db->init('main',$this->_config->database);		
		$this->_db = $db->getDatabase('main');
		$this->_system = new ObjectClasses(ObjectClasses::getIdByTitle('Система'));		
		$this->_request = RequestCore::getInstance();
		$this->_session = SessionCore::getInstance();		
		$this->_user = UserCore::getInstance();
		$this->_text = TextCore::getInstance()->addText(ConfigCore::getInstance()->sys_lang,'main');
	}
	public function start(){
		if($this->_request->auth=='logout') $this->_user->logout();
		$this->route();
		$this->redirect();
		$this->render();
	}
	public function route(){		
  		$request_name = 'ControllerComponents'.ucfirst($this->_request->com);		
		if($this->_request->com AND class_exists($request_name) AND method_exists($request_name,'action')){			
			$component = new $request_name();			
			$component->action();
		}
		else{
 			$url = $this->_config->main_page;
			$this->_request->reload($url);
			$this->route();
		}
	}
	public function redirect(){
		DocumentCore::renderHeader();
	}
	public function render(){
		if(empty($_GET)) DocumentCore::addString('title','Главная');
		DocumentCore::addString('title',' | '.$this->_config->site_name,FALSE);
		DocumentCore::addString('site_name',$this->_config->site_name);	
		$this->_load_modules();
		$template = $this->_config->template;
		echo RenderCoreHelpers::render('templates',$template,DocumentCore::getContent());
	}
	protected function _load_modules(){
		$list_modules = $this->_db->getCol('SELECT es.`id_object` FROM ?n es,?n en WHERE es.`id_object`=en.`id_object` AND es.`definition`=?s AND en.`definition`=?s ORDER BY en.`field`',TBL_EXT_STRING,TBL_EXT_NUMBER,'module','order');
		if(!empty($list_modules)) foreach($list_modules as $item){
			$object_module = new ObjectClasses($item);
			//$ext_params = json_decode($object_module->ext_params,1);
			if($object_module->link=='all' OR $object_module->link==$_SERVER['REQUEST_URI']){
				$module_name = 'ControllerModules'.ucfirst($object_module->module);
				$module = new $module_name($object_module);
				DocumentCore::addContent($object_module->position,$object_module->order,$module->action());				
			}
		}
	}	
}