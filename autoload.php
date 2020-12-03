<?php
defined('_DEXEC') or DIE;

function Autoload($className) {
	preg_match_all('/[A-Z][^A-Z]*?/Us',$className,$res,PREG_SET_ORDER);
	foreach($res as $arr) {
		foreach($arr as $value) {
			$string[]=$value;
		}
	}
	$filename=$string[0];
	unset($string[0]);
	$path = implode(DS,$string);
	$fname = strtolower($path.DS.$filename.'.php');
	if(file_exists($fname))
		include_once $fname;
}