<?php

$host="localhost";
$user="root";
$pass="ionut037";
$db="db1";

$mysqli=new mysqli($host,$user,$pass);
if (mysqli_connect_errno()) {

    die("Unable to connect!");

}

$mysqli->select_db($db) or die ("Unable to select database!");