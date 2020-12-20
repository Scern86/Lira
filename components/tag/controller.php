<?php
defined('_DEXEC') or DIE;

class ControllerComponentsTag extends ControllerClasses{

	public function __construct(){
		parent::__construct();
		$this->_component = 'tag';
		$this->_path = 'components'.DS.$this->_component;
		$this->_text->addText('ru',$this->_component);
	}
	public function action(){
		switch($this->_request->task){
			case 'ajax':
 				if(in_array('tag_ajax',$this->_user_actions)){
					$this->_ajax();
  				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'add':
				if(in_array('tag_add',$this->_user_actions)){
					$this->_add();
  				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'edit':
				if(in_array('tag_edit',$this->_user_actions)){
					$this->_edit();
  				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			case 'remove':
 				if(in_array('tag_remove',$this->_user_actions)){
					$this->_remove();
  				}
				else {
					DocumentCore::addHeader('Location: /');
				}
			break;
			default:
				if(in_array('tag_list',$this->_user_actions)){
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
				$data['list'] = $this->_db->getAll('SELECT * FROM ?n ORDER BY `title` LIMIT ?i,?i',TBL_TAG,(int)$this->_request->post('offset'),(int)$this->_request->post('limit'));
				echo RenderCoreHelpers::render($this->_path.DS.'templates','ajax_load',$data);
				exit();
			break;
			case 'search':
				$search = '%'.$this->_request->post('search').'%';
				if(!empty($this->_request->post('search')) AND mb_strlen($this->_request->post('search'))>=2){
					$data['list'] = $this->_db->getAll('SELECT * FROM ?n WHERE `title` LIKE ?s ORDER BY `title`',TBL_TAG,$search);
				}
				else{
					$data['list'] = $this->_db->getAll('SELECT * FROM ?n ORDER BY `title` LIMIT 0,50',TBL_TAG);
				}
				echo RenderCoreHelpers::render($this->_path.DS.'templates','ajax_load',$data);
				exit();
			break;
		}
	}
	protected function _add(){
		if($this->_request->post('action')=='add'){
			$id = GeneratorCoreHelpers::generateId(10);
			$data = [
				'id'=>$id,
				'title'=>htmlspecialchars($this->_request->post('title')),
			];
			if(TagClasses::create($data)){
				switch($this->_request->type){
					case 'new':
						DocumentCore::addHeader('Location: /?com=tag&task=add');
					break;
					case 'save':
						DocumentCore::addHeader('Location: /?com=tag&task=edit&id='.$id);
					break;
					default:
						DocumentCore::addHeader('Location: /?com=tag&task=list');
					break;
				}
				}
			else{
				DocumentCore::addHeader('Location: /?com=tag&task=list');
			}
		}
		else{
			DocumentCore::addString('title',$this->_text->add);
			$tb_array = [];
			DocumentCore::addContent('content',5,RenderCoreHelpers::render($this->_path.DS.'toolbars','add',$tb_array));
			DocumentCore::addContent('content',20,RenderCoreHelpers::render($this->_path.DS.'templates','add',$data));
		}
	}
	protected function _edit(){
		if($this->_request->post('action')=='edit'){
			$id = $this->_request->id;
			$data = [
				'id'=>$id,
				'title'=>htmlspecialchars($this->_request->post('title')),
			];
			if(TagClasses::update($data)){
				switch($this->_request->type){
					case 'new':
						DocumentCore::addHeader('Location: /?com=tag&task=add');
					break;
					case 'save':
						DocumentCore::addHeader('Location: /?com=tag&task=edit&id='.$id);
					break;
					default:
						DocumentCore::addHeader('Location: /?com=tag&task=list');
					break;
				}
			}
			else{
				DocumentCore::addHeader('Location: /?com=tag&task=list');
			}
		}
		else{
			DocumentCore::addString('title',$this->_text->edit);
			$data['main'] = new TagClasses($this->_request->id);
			$tb_array = ['id'=>$this->_request->id];
			DocumentCore::addContent('content',5,RenderCoreHelpers::render($this->_path.DS.'toolbars','edit',$tb_array));
			DocumentCore::addContent('content',20,RenderCoreHelpers::render($this->_path.DS.'templates','edit',$data));
		}
	}
	protected function _remove(){
		if(TagClasses::remove($this->_request->id)){
			DocumentCore::addHeader('Location: /?com=tag&task=list');
		}
		else{
			DocumentCore::addHeader('Location: /?com=tag&task=list');
		}
	}
	protected function _list(){
		DocumentCore::addString('title',$this->_text->list);
		$tb_array = [];
		DocumentCore::addContent('content',5,RenderCoreHelpers::render($this->_path.DS.'toolbars','list',$tb_array));
		$data['list'] = $this->_db->getAll('SELECT * FROM ?n ORDER BY `title` LIMIT 0,50',TBL_TAG);
		DocumentCore::addContent('content',10,RenderCoreHelpers::render($this->_path.DS.'templates','list',$data));
	}
}