<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('DOMAIN', '/' . basename(dirname(dirname(__FILE__))));
define('UPLOAD', ROOT.'/public/uploads/');
define('SESSIONS', ROOT.'/sessions');
define("MYSQL_CONN_ERROR", "Unable to connect to database.");

$url = isset($_GET['url']) ? $_GET['url'] : null;

require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');

