<?php
defined('_DEXEC') or DIE;

class DefinitionClasses{

	protected $_db;
	protected $_title;
	protected $_type;
	protected $_description;
	
	public function __construct($title){		
		$this->_db = DbCore::getInstance()->getDatabase('main');
 		$definition = $this->_db->getRow('SELECT * FROM ?n WHERE `title`=?s',TBL_DEFINITION,$title);
		$this->_title = $definition['title'];
		$this->_type = $definition['type'];
		$this->_description = $definition['description'];
	}	
	public static function create($data){
		$db = DbCore::getInstance()->getDatabase('main');
		return $db->query('REPLACE ?n SET `title`=?s,`type`=?s,`description`=?s',TBL_DEFINITION,$data['title'],$data['type'],$data['description']);
	}
	public static function update($data){
		$db = DbCore::getInstance()->getDatabase('main');
		return $db->query('REPLACE ?n SET `title`=?s,`type`=?s,`description`=?s',TBL_DEFINITION,$data['title'],$data['type'],$data['description']);		
	}
	public static function remove($title){
		$db = DbCore::getInstance()->getDatabase('main');
		return $db->query('DELETE FROM ?n WHERE `title`=?s',TBL_DEFINITION,$title);
	}
	public function __get($key){
		if($key<>'db'){
			$value = '_'.$key;
			return $this->$value;			
		}
		return FALSE;
	}	
}