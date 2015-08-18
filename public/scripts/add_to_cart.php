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

$query = "create table if not exists shoppingcarts (
          user_id int(10),
          product_id int(10),
          foreign key (user_id) references users(id) on delete cascade on update cascade,
          foreign key (product_id) references products(id) on delete cascade on update cascade
          )";

$dbAdapter->getConnection()->query($query);

if (isset($_POST['user_id'])) $user_id = $_POST['user_id'];
if (isset($_POST['product_id'])) $product_id = $_POST['product_id'];

$data = array(
    'user_id'       => $user_id,
    'product_id'    => $product_id,
);
$dbAdapter->insert('shoppingcarts', $data);


$row = $dbAdapter->fetchRow($dbAdapter->select('name')->from('products')->where('id = ?', $product_id));
$product_name = $row->name;


/*$query = "select count(1) nr from shoppingcarts where user_id = $user_id";

$result = $mysqli->query($query);

$nr_products = 0;
if($result) {
    $nr_products = $result->fetch_object()->nr;
}*/

echo json_encode(array('product_name' => 'sdf', 'nr_products' => '1'));