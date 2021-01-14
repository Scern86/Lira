<?php
defined('_DEXEC') or DIE;

class TagClasses{

	protected $_db;
	protected $_id;	
	protected $_title;
	
	public function __construct($id){		
		$this->_db = DbCore::getInstance()->getDatabase('main');
 		$tag = $this->_db->getRow('SELECT * FROM ?n WHERE `id`=?s',TBL_TAG,$id);
		$this->_id = $tag['id'];
		$this->_title = $tag['title'];
	}	
	public static function create($data){
		$db = DbCore::getInstance()->getDatabase('main');
		if(!$db->getOne('SELECT `id` FROM ?n WHERE `title`=?s',TBL_TAG,$data['title'])) return $db->query('INSERT INTO ?n SET `id`=?s,`title`=?s',TBL_TAG,$data['id'],$data['title']);
		return TRUE;
	}
	public static function update($data){
		$db = DbCore::getInstance()->getDatabase('main');
		return $db->query('REPLACE ?n SET `id`=?s,`title`=?s',TBL_TAG,$data['id'],$data['title']);		
	}
	public static function remove($id){
		$db = DbCore::getInstance()->getDatabase('main');
		return  $db->query('DELETE FROM ?n WHERE `id`=?s',TBL_TAG,$id) 
		AND $db->query('DELETE FROM ?n WHERE `id_tag`=?s',TBL_EXT_TAG,$id);
	}
	public function __get($key){
		if($key<>'db'){
			$value = '_'.$key;
			return $this->$value;			
		}
		return FALSE;
	}
	public static function getIdByTitle($title){
		$db = DbCore::getInstance()->getDatabase('main');
		return  $db->getOne('SELECT `id` FROM ?n WHERE `title`=?s',TBL_TAG,$title);
	}	
}