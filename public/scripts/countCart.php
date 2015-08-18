<?php

defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(dirname(__FILE__)) . '/../application'));
set_include_path(implode(PATH_SEPARATOR, array(
    APPLICATION_PATH . '/../library',
    get_include_path(),
)));


defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', 'production');


require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

// Initialize and retrieve DB resource
$bootstrap = $application->getBootstrap();
$bootstrap->bootstrap('db');
$dbAdapter = $bootstrap->getResource('db');


if (isset($_POST['email'])) $email = $_POST['email'];
else return;

echo $email;

/*$query = "select id from users where email = '$email'";
$result = $mysqli->query($query);
$user = $result->fetch_object();
$user_id = $user->id;

$query = "select count(1) nr from shoppingcarts where user_id = $user_id";

$result = $mysqli->query($query);
if($result) {
    $nr_products = $result->fetch_object()->nr;
    echo $nr_products;
}
else */echo 0;

