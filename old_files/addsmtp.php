<?php
    require_once 'connect.php';

    include_once 'cript_decript.php';

if (isset($_POST['host']) && !empty($_POST['host']) &&
    isset($_POST['port']) && !empty($_POST['port']) &&
    isset($_POST['stype']) && !empty($_POST['stype']) &&
    isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['password1']) && !empty($_POST['password1']) &&
    isset($_POST['password2']) && !empty($_POST['password2'])){

    $pass=$_POST['password1'];
    if(($_POST['password1'] == $_POST['password2'])){
        $cfg = array( 'host' => $_POST['host'], 'port' => $_POST['port'], 'stype' => $_POST['stype'], 'email' => $_POST['email'], 'password' => cript($pass,"CIO"));
        $json = json_encode($cfg);
        $query = "insert into mailsetting(smtp_config) values ('$json');";
        $mysqli->query($query) or die($mysqli->error);
        $mysqli->close();

    }
}
else die("All field are required");