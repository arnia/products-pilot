<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('DOMAIN', '/' . basename(dirname(dirname(__FILE__))));
define('UPLOAD', ROOT.'/public/uploads/');
$url = $_GET['url'];

require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');