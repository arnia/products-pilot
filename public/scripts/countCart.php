<?php

$config = dirname(dirname(dirname(__FILE__))) . "/config/config.php";
require_once($config);

$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die ("database error");

if (isset($_POST['email'])) $email = $mysqli->escape_string($_POST['email']);

$query = "select id from users where email = '$email'";
$result = $mysqli->query($query);
$user = $result->fetch_object();
$user_id = $user->id;

$query = "select count(1) nr from shoppingcarts where user_id = $user_id";

$result = $mysqli->query($query);
if($result) {
    $nr_products = $result->fetch_object()->nr;
    echo $nr_products;
}
else echo 0;

