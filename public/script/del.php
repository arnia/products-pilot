<?php
define('ROOT', dirname(dirname(__FILE__)));
define('UPLOAD', ROOT.'/uploads/');

if(isset($_POST['file'])){
    $file = $_POST['file'];
    $file = UPLOAD . $file;
    if(file_exists($file)) unlink($file);
}
else{
    die("file not found");
}
