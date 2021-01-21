<?php
namespace Scern\Lira\Classes;

defined('_DEXEC') or DIE;


class Tag{

	protected $db;
	protected $id;	
	protected $title;
	
	public function __construct($id){		
		$this->db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
 		$tag = $this->db->getRow('SELECT * FROM ?n WHERE `id`=?s',TBL_TAG,$id);
		$this->id = $tag['id'];
		$this->title = $tag['title'];
	}	
	public static function create($data){
		$db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
		if(!$db->getOne('SELECT `id` FROM ?n WHERE `title`=?s',TBL_TAG,$data['title'])) return $db->query('INSERT INTO ?n SET `id`=?s,`title`=?s',TBL_TAG,$data['id'],$data['title']);
		return TRUE;
	}
	public static function update($data){
		$db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
		return $db->query('REPLACE ?n SET `id`=?s,`title`=?s',TBL_TAG,$data['id'],$data['title']);		
	}
	public static function remove($id){
		$db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
		return  $db->query('DELETE FROM ?n WHERE `id`=?s',TBL_TAG,$id) 
		AND $db->query('DELETE FROM ?n WHERE `id_tag`=?s',TBL_EXT_TAG,$id);
	}
	public function __get($key){
		if($key<>'db'){
			return $this->$key;			
		}
		return FALSE;
	}
	public static function getIdByTitle($title){
		$db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
		return $db->getOne('SELECT `id` FROM ?n WHERE `title`=?s',TBL_TAG,$title);
	}	
}