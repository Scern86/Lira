<?php
defined('_DEXEC') or DIE;

class TreeModulesMod_menu{

	protected $_id;
	protected $_title;
	protected $_link;
	protected $_target;
	protected $_level;
	protected $_template;
	protected $_childs = [];
	protected $_css_id;
	protected $_module;

	public function __construct($params){
		$db = DbCore::getInstance()->getDatabase('main');
		$user = UserCore::getInstance();
		$this->_id = $params['id'];
		$link = new ObjectClasses($this->_id);
		foreach($link->access as $item){
			$access[] = $item['id'];
		}
		if(in_array($user->getUser()->id,$access) OR in_array('efec8802f9a4fe29f344',$access) OR ($user->isLoggedIn() AND in_array('5e1cc7832dcbd43148d5',$access))){
			$this->_title = $db->getOne('SELECT `title` FROM ?n WHERE `id`=?s',TBL_OBJECT,$this->_id);
			$this->_level = $params['level'];
			$this->_template = $params['template'];
			$this->_css_id = $params['css_id'];
			$this->_module = $params['module'];
			$this->_link = $db->getOne('SELECT `field` FROM ?n WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_STRING,$this->_id,'link');
			$this->_target = $db->getOne('SELECT `field` FROM ?n WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_STRING,$this->_id,'target');
			$childs = $db->getAll('SELECT eo.* FROM ?n eo,?n ft,?n t WHERE eo.`id_object_parent`=?s AND eo.`id_object_child`=ft.`id_object` AND ft.`id_tag`=t.`id` AND eo.`definition`=?s AND ft.`definition`=?s AND t.`title`=?s ORDER BY eo.`order`',TBL_EXT_OBJECT,TBL_EXT_TAG,TBL_TAG,$this->_id,'attachment','type','Ссылка');
			$next_level = $this->_level+1;
			if(!empty($childs)) foreach($childs as $item){
				$child_params = [
					'id'=>$item['id_object_child'],
					'level'=>$next_level,
					'css_id'=>'',
					'template'=>$this->_template,
				];
				$this->_childs[$item['order'].rand(100,999)] = new TreeModulesMod_menu($child_params);
			}
		}
	}
	public function __get($key){
		$value = '_'.$key;
		if(isset($this->$value)) return $this->$value;
		else return FALSE;
	}
	public function render(){
		return RenderCoreHelpers::render('modules'.DS.'mod_menu'.DS.'templates',$this->_template,['main'=>$this]);
	}	
}