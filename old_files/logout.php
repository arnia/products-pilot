<?php
session_start();
if((isset($_COOKIE['user_auth']) && !empty($_COOKIE['user_auth'])) || (isset($_SESSION['user_auth']) && !empty($_SESSION['user_auth'])) ) {
    if((isset($_COOKIE['user_auth']) && !empty($_COOKIE['user_auth']))){
        setcookie("user_auth",null,mktime()-3600,"/");
    }
    elseif (isset($_SESSION['user_auth']) && !empty($_SESSION['user_auth'])){
        session_start();
        session_destroy();
    }
}
header("Location:login.php");
exit();