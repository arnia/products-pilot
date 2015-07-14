<!DOCTYPE html>
<html lang="en">
<head>
    <title> Products </title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #main{
            margin:auto;
            margin-top: 300px;
            width: 50%;
        }
        #toright{
            margin-left:1250px;
        }

    </style>
</head>

<body>
<div id="main">

<?php
    require_once 'mailSettings.php';
    require_once("connect.php");
    include("User.php");

    if(isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['password1']) && !empty($_POST['password1']) &&
        isset($_POST['password2']) && !empty($_POST['password2'])){
        $pass=$_POST['password1'];
        if(($_POST['password1']==$_POST['password2'])
            && (preg_match("/([A-Z]+[a-z]+[0-9]+)|([A-Z]+[0-9]+[a-z]+)|([a-z]+[A-Z]+[0-9]+)|([a-z]+[0-9]+[A-Z]+)|([0-9]+[A-Z]+[a-z]+)|([0-9]+[a-z]+[A-Z]+)/",$pass))
            && (preg_match("/^.{8,}$/",$pass)))
        {


            $password = md5($mysqli->escape_string($_POST['password1']));
            $hash = md5(rand(0,1000));
            $email=$mysqli->escape_string($_POST['email']);


            // check if e-mail address is well-formed
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $user = new User($email,$password,$hash,0);
            }
            else die("<div class='alert alert-danger'>
                        <strong>Error:</strong> Invalid email format
                        </div>");

            $query="insert into user(email,password,hash) values ('$email','$password','$hash');";
            $result = $mysqli->query($query) or die("<div class='alert alert-danger'>
                        <strong>Error:</strong> This email exist in database
                        </div>");

            $user->setId($mysqli->insert_id);

            $subject = 'Signup | Verification';
            $message = "<p>
            Thanks for signing up!
            Your account has been created, activate your account by pressing the url below.</p>
            <p>-----------------------</p>
            <p><a href='http://localhost/product_crud/verify.php?email=$email&hash=$hash'>Click Here</a> to activate your account</p>";

            //$send = mail($email, $subject, $message, $headers) or die("Error to send mail");
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = $message;
            if($mail->send()){
                echo "<div class='alert alert-info'>
                        <strong>Info:</strong> Your account has been made, <br /> please verify it by clicking the activation link that has been send to your email.
                        </div>";
            }
            else{
                echo "<div class='alert alert-danger'>
                  <strong>Error:</strong>Email could not be sent
                  </div>";
            }
            $mysqli->close();
        }
        else echo "<div class='alert alert-danger'>
                        <strong>Error:</strong> Invalid password (required minimum:8 characters, 1 uppercase, 1 lowercase, 1 numeric)
                        </div>";

    }
    else echo "<div class='alert alert-danger'>
                        <strong>Error:</strong> All fields are required
                        </div>";
?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>