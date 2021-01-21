<?php
namespace Scern\Lira\Classes;

defined('_DEXEC') or DIE;

class Definition
{

	protected $db;
	protected $title;
	protected $type;
	protected $description;
	
	public function __construct($title)
    {		
		$this->db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
 		$definition = $this->db->getRow('SELECT * FROM ?n WHERE `title`=?s',TBL_DEFINITION, $title);
		$this->title = $definition['title'];
		$this->type = $definition['type'];
		$this->description = $definition['description'];
	}	
	public static function create($data)
    {
		$db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
		return $db->query('REPLACE ?n SET `title`=?s,`type`=?s,`description`=?s',TBL_DEFINITION,$data['title'],$data['type'],$data['description']);
	}
	public static function update($data)
    {
		$db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
		return $db->query('REPLACE ?n SET `title`=?s,`type`=?s,`description`=?s',TBL_DEFINITION,$data['title'],$data['type'],$data['description']);		
	}
	public static function remove($title)
    {
		$db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
		return $db->query('DELETE FROM ?n WHERE `title`=?s',TBL_DEFINITION,$title);
	}
	public function __get($key){
		if($key<>'db'){
			return $this->$key;			
		}
		return FALSE;
	}	
}