<?php
define('_DEXEC', 1);
define('DS',DIRECTORY_SEPARATOR);

include_once 'tables.php';

spl_autoload_register('Autoload');

$app = new AppCore;

$app->auth();

$app->route();

$app->redirect();

$app->render();

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