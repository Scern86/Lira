<?php
defined('_DEXEC') or DIE;

class ControllerComponentsDefinition extends ControllerClasses{

	public function __construct(){
		parent::__construct();
		$this->_component = 'definition';
		$this->_path = 'components'.DS.$this->_component;
		$this->_text->addText('ru',$this->_component);
	}
	public function action(){
		switch($this->_request->task){
			case 'ajax':
				if(in_array('definition_ajax',$this->_user_actions)){
					$this->_ajax();
 				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'add':
				if(in_array('definition_add',$this->_user_actions)){
					$this->_add();
  				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'edit':
				if(in_array('definition_edit',$this->_user_actions)){
					$this->_edit();
				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'remove':
				if(in_array('definition_remove',$this->_user_actions)){
					$this->_remove();
  				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			default:
				if(in_array('definition_list',$this->_user_actions)){
					$this->_list();
 				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
		}
	}
	protected function _ajax(){
		switch($this->_request->act){
			case 'load':
				$data['list'] = $this->_db->getAll('SELECT * FROM ?n ORDER BY `type`,`title` LIMIT ?i,?i',TBL_DEFINITION,(int)$this->_request->post('offset'),(int)$this->_request->post('limit'));
				echo RenderCoreHelpers::render($this->_path.DS.'templates','ajax_load',$data);
				exit();
			break;
			case 'search':
				$search = '%'.$this->_request->post('search').'%';
				if(!empty($search)){
					$data['list'] = $this->_db->getAll('SELECT * FROM ?n WHERE `title` LIKE ?s ORDER BY `type`,`title`',TBL_DEFINITION,$search);
				}
				else{
					$data['list'] = $this->_db->getAll('SELECT * FROM ?n ORDER BY `type`,`title` LIMIT 0,50',TBL_DEFINITION);
				}
				echo RenderCoreHelpers::render($this->_path.DS.'templates','ajax_load',$data);
				exit();
			break;
		}
	}
	protected function _add(){
		if($this->_request->post('action')=='add'){
			$data = [
				'title'=>htmlspecialchars($this->_request->post('title')),
				'type'=>htmlspecialchars($this->_request->post('type')),
				'description'=>htmlspecialchars($this->_request->post('description')),
			];
			if(DefinitionClasses::create($data)){
				switch($this->_request->type){
					case 'new':
						DocumentCore::addHeader('Location: /?com=definition&task=add');
					break;
					case 'save':
						DocumentCore::addHeader('Location: /?com=definition&task=edit&title='.htmlspecialchars($this->_request->post('title')));
					break;
					default:
						DocumentCore::addHeader('Location: /?com=definition&task=list');
					break;
				}
			}
			else{
				DocumentCore::addHeader('Location: /?com=definition&task=list');
			}
		}
		else{
			DocumentCore::addString('title',$this->_text->add);
			$data['types'] = ['NUMBER','STRING','DATETIME','TEXT','LONGTEXT','OBJECT','TAG'];
			$tb_array = [];
			DocumentCore::addContent('content',5,RenderCoreHelpers::render($this->_path.DS.'toolbars','add',$tb_array));
			DocumentCore::addContent('content',20,RenderCoreHelpers::render($this->_path.DS.'templates','add',$data));
		}
	}
	protected function _edit(){
		if($this->_request->post('action')=='edit'){
			$data = [
				'title'=>htmlspecialchars($this->_request->post('title')),
				'type'=>htmlspecialchars($this->_request->post('type')),
				'description'=>htmlspecialchars($this->_request->post('description')),
			];
			if(DefinitionClasses::update($data)){
				switch($this->_request->type){
					case 'new':
						DocumentCore::addHeader('Location: /?com=definition&task=add');
					break;
					case 'save':
						DocumentCore::addHeader('Location: /?com=definition&task=edit&title='.htmlspecialchars($this->_request->post('title')));
					break;
					default:
						DocumentCore::addHeader('Location: /?com=definition&task=list');
					break;
				}
			}
			else{
				DocumentCore::addHeader('Location: /?com=definition&task=list');
			}
		}
		else{
			DocumentCore::addString('title',$this->_text->edit);
			$data['main'] = new DefinitionClasses($this->_request->title);
			$data['types'] = ['NUMBER','STRING','DATETIME','TEXT','LONGTEXT','OBJECT','TAG'];
			$tb_array = ['title'=>$this->_request->title];
			DocumentCore::addContent('content',5,RenderCoreHelpers::render($this->_path.DS.'toolbars','edit',$tb_array));
			DocumentCore::addContent('content',20,RenderCoreHelpers::render($this->_path.DS.'templates','edit',$data));
		}
	}
	protected function _remove(){
		if(DefinitionClasses::remove($this->_request->title)){
			DocumentCore::addHeader('Location: /?com=definition&task=list');
		}
		else{
			DocumentCore::addHeader('Location: /?com=definition&task=list');
		}
	}
	protected function _list(){
		DocumentCore::addString('title',$this->_text->list);
		$tb_array = [];
		DocumentCore::addContent('content',5,RenderCoreHelpers::render($this->_path.DS.'toolbars','list',$tb_array));
		$data['list'] = $this->_db->getAll('SELECT * FROM ?n ORDER BY `type`,`title` LIMIT 0,50',TBL_DEFINITION);
		DocumentCore::addContent('content',20,RenderCoreHelpers::render($this->_path.DS.'templates','list',$data));
	}
}