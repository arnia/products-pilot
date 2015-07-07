<?php
if(isset($_GET['file'])){
    $file = $_GET['file'];
    $completPath = "uploads/".$file;
    require_once 'connect.php';
    $result=$mysqli->query("select id from product where file='$file';") or die("database error");
    if($result->num_rows==1) unlink($completPath);
    else echo $file;
    $mysqli->close();
}
else{
    die("file not found");
}
?>