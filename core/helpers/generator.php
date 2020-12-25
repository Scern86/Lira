<?php
defined('_DEXEC') or DIE;

class GeneratorCoreHelpers{
	
	public static function generateId($lenght=10,$prefix=''){
		$db = DbCore::getInstance()->getDatabase('main');
		$id = $prefix.bin2hex(random_bytes($lenght));
		if(empty($db->getOne('SELECT `id` FROM ?n WHERE `id`=?s',TBL_OBJECT,$id))) return $id;
		else self::generateId($lenght,$prefix);
	}
}