<?php

class ControllerModulesMod_menu{

	protected $_module;
	
	public function __construct($module){
		$this->_module = $module;
	}
	public function action(){
		$module_params = json_decode($this->_module->ext_params,1);
		$params = [
			'id'=>$module_params['id_menu'],
			'level'=>0,
			'css_id'=>$module_params['css_id'],
			'template'=>$module_params['template'],
			'module'=>$this->_module,
		];
		$tree = new TreeModulesMod_menu($params);
		$data['tree'] = $tree->render();
		$data['module'] = $this->_module;
		return RenderCoreHelpers::render('modules'.DS.'mod_menu','template',$data); 
	}
}