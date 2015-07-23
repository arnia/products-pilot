<?php

define('ROOT', dirname(dirname(__FILE__)));
define('UPLOAD', ROOT.'/uploads/');
define('IMG', ROOT.'/img/');

if(isset($_POST['id']) && isset($_POST['file'])){
    if($_POST['id'] == 1){
        $file = UPLOAD . $_POST['file'];
    }
    else{
        $file = IMG . $_POST['file'];
    }
    echo $file;
    if(file_exists($file)){
        unlink($file);
    }
}
