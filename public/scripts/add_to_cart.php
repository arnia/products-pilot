<?php

$config = dirname(dirname(dirname(__FILE__))) . "/config/config.php";
require_once($config);

$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die ("database error");

$query = "create table if not exists shoppingcarts (
          user_id int(10),
          product_id int(10),
          foreign key (user_id) references users(id),
          foreign key (product_id) references products(id)
          )";
$mysqli->query($query);

if (isset($_POST['email'])) $email = $mysqli->escape_string($_POST['email']);
if (isset($_POST['product_id'])) $product_id = $mysqli->escape_string($_POST['product_id']);

$query = "select id from users where email = '$email'";
$result = $mysqli->query($query);
$user = $result->fetch_object();
$user_id = $user->id;

$query = "insert into shoppingcarts values ($user_id, $product_id)";
$mysqli->query($query);

$query = "select name from products where id = '$product_id'";
$result = $mysqli->query($query);
$product = $result->fetch_object();
$product_name = $product->name;


$query = "select count(1) nr from shoppingcarts where user_id = $user_id";

$result = $mysqli->query($query);

$nr_products = 0;
if($result) {
    $nr_products = $result->fetch_object()->nr;
}

echo json_encode(array('product_name'=>$product_name,'nr_products'=>$nr_products));