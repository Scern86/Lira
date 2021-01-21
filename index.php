<?php
define('_DEXEC', 1);
define('DS',DIRECTORY_SEPARATOR);

include 'vendor/autoload.php';
require_once ('tables.php');

$app = new \Scern\Lira\Core\App();

$app->start();

echo $app->render();