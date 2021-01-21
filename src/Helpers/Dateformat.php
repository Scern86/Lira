<?php 
namespace Scern\Lira\Helpers;

defined('_DEXEC') or DIE;

class Dateformat
{

	private static $day = ['Воскресенье','Понедельник','Вторник','Среда','Четверг','Пятница','Суббота'];
	private static $month = ['','Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Октября','Ноября','Декабря'];
	
	public static function formatDate($date, $dateformat)
    {
		$idxday = date("w",$date);
		$idxmonth = date("n",$date);
		$year = date("Y",$date);
		$hour = date("H",$date);
		$seconds = date("i",$date);
		$d = date("j",$date);	
	
		$search = array('%day%', '%dd%', '%mm%', '%m%', '%yyyy%','%HH%','%ii%');
		$replace = array(self::$day[$idxday], $d, self::$month[$idxmonth], $idxmonth, $year,$hour,$seconds);
		
		return str_replace($search, $replace, $dateformat);		
	}
}