<?php
namespace Scern\Lira\Core;

defined('_DEXEC') or DIE;

class Notify{

	private static $notifications = [];
	
	public static function addNotify(array $notify){
		self::$notifications[] = $notify;
	}
}