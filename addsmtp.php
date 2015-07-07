<?php
require_once 'connect.php';

function cript($input,$key){
    $vect = array();
    $k = 0;
    for($j=0;$j<strlen($input);$j++,$k++){
        if($k > strlen($key)) $k = 0;
        $i = ord($input[$j]);
        $c = ord($key[$k]);
        var_dump($i);
        var_dump($c);
        $x = (int)($i/($c+1));
        $y = $i%($c+1);
        var_dump($x);
        var_dump($y);
        $dx=$dy='';
        switch (strlen($x)){
            case 1: $dx='a'+($c%10);break;
            case 2: $dx='5'+($c%10);break;
            case 3: $dx='z'+($c%10);break;
        }
        switch (strlen($y)){
            case 1: $dy='b'+($c%10);break;
            case 2: $dy='c'+($c%10);break;
            case 3: $dy='d'+($c%10);break;
        }
        $vect[]=$dx;
        $vect[]=$x;
        $vect[]=$dy;
        $vect[]=$y;
    }
    for($i=0;$i<sizeof($vect);$i++){
        echo $vect[$i];
    }
}



if (isset($_POST['host']) && !empty($_POST['host']) &&
    isset($_POST['port']) && !empty($_POST['port']) &&
    isset($_POST['stype']) && !empty($_POST['stype']) &&
    isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['password1']) && !empty($_POST['password1']) &&
    isset($_POST['password2']) && !empty($_POST['password2'])){

    $pass=$_POST['password1'];
    if(($_POST['password1'] == $_POST['password2'])){
        $cfg = array( 'host' => $_POST['host'], 'port' => $_POST['port'], 'stype' => $_POST['stype'], 'email' => $_POST['email'], 'password' => $pass);
        $json = json_encode($cfg);
        $query = "insert into mailsetting(smtp_config) values ('$json');";
        $mysqli->query($query) or die($mysqli->error);
        $mysqli->close();

        cript($pass,"CIO");
    }
}
else die("All field are required");