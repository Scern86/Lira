<?php
define('_DEXEC', 1);
define('DS',DIRECTORY_SEPARATOR);

include_once 'autoload.php';
include_once 'tables.php';

spl_autoload_register('Autoload');

echo 'WORKING';

/* $app = new AppCore;

$app->auth();

$app->route();

$app->redirect();

$app->render(); */
