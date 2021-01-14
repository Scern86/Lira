<?php
defined('_DEXEC') or DIE;

class ObjectClasses{

	protected $_db;
	protected $_id;
	protected $_title;
	protected $_created;
	protected $_params = [];

	public function __construct($id){
		$this->_db = DbCore::getInstance()->getDatabase('main');
		$object = $this->_db->getRow('SELECT * FROM ?n WHERE `id`=?s',TBL_OBJECT,$id);
		if(!empty($object)){
			$this->_id = $object['id'];
			$this->_title = $object['title'];
			$this->_created = $object['created'];
		}
	}
	public function __get($key){
		$value = '_'.$key;
		if(isset($this->$value) AND $key<>'db'){
			return $this->$value;
		}
		else {
			return $this->_loadField($key);
		}
	}
	public function render($template='default',$params=[]){
		$this->_params = $params;
		if($template=='default') $template = array_shift($this->_loadField('type'))['title'];
		return RenderCoreHelpers::render('templates'.DS.'objects',$template,['main'=>$this]);
	}
///// Базовые процедуры	объекта
	public static function create(array $data){
		$db = DbCore::getInstance()->getDatabase('main');
		return $db->query('INSERT INTO ?n SET `id`=?s,`title`=?s,`created`=?s',TBL_OBJECT,$data['id'],$data['title'],$data['created']);
	}
	public static function update(array $data){
		$db = DbCore::getInstance()->getDatabase('main');
		return $db->query('UPDATE ?n SET `title`=?s WHERE `id`=?s',TBL_OBJECT,$data['title'],$data['id']);
	}
	public static function remove($id){
		$db = DbCore::getInstance()->getDatabase('main');
		return $db->query('DELETE FROM ?n WHERE `id`=?s',TBL_OBJECT,$id)
		 AND $db->query('DELETE FROM ?n WHERE `id_object`=?s',TBL_EXT_TAG,$id)
		 AND $db->query('DELETE FROM ?n WHERE `id_object`=?s',TBL_EXT_STRING,$id)
		 AND $db->query('DELETE FROM ?n WHERE `id_object`=?s',TBL_EXT_NUMBER,$id)
		 AND $db->query('DELETE FROM ?n WHERE `id_object`=?s',TBL_EXT_SHORT_TEXT,$id)
		 AND $db->query('DELETE FROM ?n WHERE `id_object`=?s',TBL_EXT_LONG_TEXT,$id)
		 AND $db->query('DELETE FROM ?n WHERE `id_object`=?s',TBL_EXT_DATE,$id)
		 AND $db->query('DELETE FROM ?n WHERE `id_object_parent`=?s OR `id_object_child`=?s',TBL_EXT_OBJECT,$id,$id);
	}
/* 	public function getFieldInfo($field){
		// !!!!!!!!! ??????
		return $this->_db->getRow('SELECT * FROM ?n WHERE `title`=?s',TBL_DEFINITION,$field);
	} */
	public function isHaveTag($tag){
		$result = $this->_db->getOne('SELECT t.`id` FROM ?n o,?n ft,?n t WHERE ft.`id_object`=o.`id` AND ft.`id_tag`=t.`id` AND t.`title`=?s AND o.`id`=?s',TBL_OBJECT,TBL_EXT_TAG,TBL_TAG,$tag,$this->_id);
		if($result) return TRUE;
		else return FALSE;
	}	
	public static function getIdByTitle($title){
		$db = DbCore::getInstance()->getDatabase('main');
		return  $db->getOne('SELECT `id` FROM ?n WHERE `title`=?s',TBL_OBJECT,$title);
	}
///// Работа с дополнительными полями (число,строка,текст,дата)
	public static function addField($id_object,$definition,$value,$order=0,$params=[]){
		$db = DbCore::getInstance()->getDatabase('main');
		$type = $db->getOne('SELECT `type` FROM ?n WHERE `title`=?s',TBL_DEFINITION,$definition);
		switch($type){
			case 'NUMBER':
				$result = $db->query('REPLACE ?n SET `id_object`=?s,`definition`=?s,`field`=?i',TBL_EXT_NUMBER,$id_object,$definition,(int)$value);
			break;
			case 'STRING':
				$result = $db->query('REPLACE ?n SET `id_object`=?s,`definition`=?s,`field`=?s',TBL_EXT_STRING,$id_object,$definition,trim(htmlspecialchars($value)));
			break;
			case 'DATETIME':
				$result = $db->query('REPLACE ?n SET `id_object`=?s,`definition`=?s,`field`=?s',TBL_EXT_DATE,$id_object,$definition,$value);
			break;
			case 'TEXT':
				$result = $db->query('REPLACE ?n SET `id_object`=?s,`definition`=?s,`field`=?s',TBL_EXT_SHORT_TEXT,$id_object,$definition,$value);
			break;
			case 'LONGTEXT':
				$result = $db->query('REPLACE ?n SET `id_object`=?s,`definition`=?s,`field`=?s',TBL_EXT_LONG_TEXT,$id_object,$definition,$value);
			break;
			case 'TAG':
				if(!empty($value)) foreach($value as $item){
					$result = $db->query('REPLACE ?n SET `id_object`=?s,`definition`=?s,`id_tag`=?s,`order`=?s',TBL_EXT_TAG,$id_object,$definition,$item,$order);
				}
			break;
			case 'OBJECT':
				if(!empty($value)) foreach($value as $item){
					$result = $db->query('REPLACE ?n SET `id_object_parent`=?s,`id_object_child`=?s,`definition`=?s,`order`=?i,`params`=?s',TBL_EXT_OBJECT,$id_object,$item,$definition,(int)$order,json_encode($params));
				}
			break;
		}
		return $result;
	}
	public static function editField($id_object,$definition,$value,$type,$order=0,$params=NULL){
		$db = DbCore::getInstance()->getDatabase('main');
		switch($type){
			case 'field':
				$field_type = $db->getOne('SELECT `type` FROM ?n WHERE `title`=?s',TBL_DEFINITION,$definition);
				switch($field_type){
					case 'NUMBER':
						return $db->query('UPDATE ?n SET `field`=?i WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_NUMBER,(int)$value,$id_object,$definition);
					break;
					case 'STRING':
						return $db->query('UPDATE ?n SET `field`=?s WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_STRING,trim(htmlspecialchars($value)),$id_object,$definition);
					break;
					case 'DATETIME':
						return $db->query('UPDATE ?n SET `field`=?s WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_DATE,$value,$id_object,$definition);
					break;
					case 'TEXT':
						return $db->query('UPDATE ?n SET `field`=?s WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_SHORT_TEXT,$value,$id_object,$definition);
					break;
					case 'LONGTEXT':
						return $db->query('UPDATE ?n SET `field`=?s WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_LONG_TEXT,$value,$id_object,$definition);
					break;
				}
			break;
			case 'tag':
				return $db->query('DELETE FROM ?n WHERE `id_object`=?s AND `id_tag`=?s',TBL_EXT_TAG,$id_object,$value)
				AND $db->query('INSERT INTO ?n SET `id_object`=?s,`definition`=?s,`id_tag`=?s,`order`=?i',TBL_EXT_TAG,$id_object,$definition,$value,(int)$order);
			break;
			case 'object':
				return $db->query('INSERT INTO ?n SET `id_object_parent`=?s,`definition`=?s,`id_object_child`=?s,`order`=?i,`params`=?s',TBL_EXT_OBJECT,$id_object,$definition,$value,(int)$order,json_encode($params));
			break;
		}
	}
	public static function removeField($id_object,$definition,$field=NULL){
		$db = DbCore::getInstance()->getDatabase('main');
		$type = $db->getOne('SELECT `type` FROM ?n WHERE `title`=?s',TBL_DEFINITION,$definition);
		switch($type){
			case 'NUMBER':
				$result = $db->query('DELETE FROM ?n WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_NUMBER,$id_object,$definition);
			break;
			case 'STRING':
				$result = $db->query('DELETE FROM ?n WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_STRING,$id_object,$definition);
			break;
			case 'DATETIME':
				$result = $db->query('DELETE FROM ?n WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_DATE,$id_object,$definition);
			break;
			case 'TEXT':
				$result = $db->query('DELETE FROM ?n WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_SHORT_TEXT,$id_object,$definition);
			break;
			case 'LONGTEXT':
				$result = $db->query('DELETE FROM ?n WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_LONG_TEXT,$id_object,$definition);
			break;
 			case 'TAG':
				$result = $db->query('DELETE FROM ?n WHERE `id_object`=?s AND `definition`=?s AND `id_tag`=?s',TBL_EXT_TAG,$id_object,$definition,$field);
			break;
			case 'OBJECT':
				$result = $db->query('DELETE FROM ?n WHERE `id_object_parent`=?s AND `id_object_child`=?s AND `definition`=?s',TBL_EXT_OBJECT,$id_object,$field,$definition);
			break;
		}
		return $result;
	}
	protected function _loadField($key){
		$type = $this->_db->getOne('SELECT `type` FROM ?n WHERE `title`=?s',TBL_DEFINITION,$key);
		switch($type){
			case 'NUMBER':
				$result = $this->_db->getOne('SELECT `field` FROM ?n WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_NUMBER,$this->_id,$key);
			break;
			case 'STRING':
				$result = $this->_db->getOne('SELECT `field` FROM ?n WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_STRING,$this->_id,$key);
			break;
			case 'DATETIME':
				$result = $this->_db->getOne('SELECT `field` FROM ?n WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_DATE,$this->_id,$key);
			break;
			case 'TEXT':
				$result = $this->_db->getOne('SELECT `field` FROM ?n WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_SHORT_TEXT,$this->_id,$key);
			break;
			case 'LONGTEXT':
				$result = $this->_db->getOne('SELECT `field` FROM ?n WHERE `id_object`=?s AND `definition`=?s',TBL_EXT_LONG_TEXT,$this->_id,$key);
			break;
			case 'TAG':
				$result = $this->_db->getAll('SELECT * FROM ?n et,?n t WHERE et.`id_tag`=t.`id` AND `id_object`=?s AND `definition`=?s ORDER BY et.`order`',TBL_EXT_TAG,TBL_TAG,$this->_id,$key);
			break;
			case 'OBJECT':
					$result = $this->_db->getAll('SELECT eo.`id_object_child` `id`,eo.`definition`,eo.`order`,eo.`params` FROM ?n eo,?n o WHERE eo.`id_object_child`=o.`id` AND eo.`id_object_parent`=?s AND eo.`definition`=?s ORDER BY eo.`order`,o.`title`',TBL_EXT_OBJECT,TBL_OBJECT,$this->_id,$key);
			break;
		}
		return $result;
	}
}