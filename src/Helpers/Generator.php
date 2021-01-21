<?php
namespace Scern\Lira\Helpers;

defined('_DEXEC') or DIE;

class Generator
{
	
	public static function generateId($lenght=10, $prefix='')
    {
		$db = \Scern\Lira\Core\Db::getInstance()->getDatabase('main');
		$id = $prefix.bin2hex(random_bytes($lenght));
		if(empty($db->getOne('SELECT `id` FROM ?n WHERE `id`=?s', TBL_OBJECT, $id))) return $id;
		else self::generateId($lenght, $prefix);
	}
}