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
    require_once("connect.php");
    session_start();
    if((isset($_COOKIE['user_auth']) && !empty($_COOKIE['user_auth'])) || (isset($_SESSION['user_auth']) && !empty($_SESSION['user_auth'])) ) {

        if (isset($_POST['password1']) && !empty($_POST['password1']) && isset($_POST['password2']) && !empty($_POST['password2'])){

            $pass = $_POST['password1'];
            if (($_POST['password1'] == $_POST['password2'])
                && (preg_match("/([A-Z]+[a-z]+[0-9]+)|([A-Z]+[0-9]+[a-z]+)|([a-z]+[A-Z]+[0-9]+)|([a-z]+[0-9]+[A-Z]+)|([0-9]+[A-Z]+[a-z]+)|([0-9]+[a-z]+[A-Z]+)/", $pass))
                && (preg_match("/^.{8,}$/", $pass))
            ) {
                $password = md5($mysqli->escape_string($_POST['password1']));
                if (isset($_COOKIE['user_auth']) && !empty($_COOKIE['user_auth'])) $email = $mysqli->escape_string($_COOKIE['user_auth']);
                    else  $email = $mysqli->escape_string($_SESSION['user_auth']);

                $query = "update user set password='$password' where email='$email';";
                $result = $mysqli->query($query) or die("<div class='alert alert-danger'>
                        <strong>Error:</strong> Database error
                        </div>");

                echo "<div class='alert alert-success'>
                        <strong>Success:</strong> Password changed
                        </div>";
                $mysqli->close();
            } else echo "<div class='alert alert-danger'>
                        <strong>Error:</strong> Invalid password (required minimum:8 characters, 1 uppercase, 1 lowercase, 1 numeric)
                        </div>";
        } else echo "<div class='alert alert-danger'>
                        <strong>Error:</strong> All fields are required
                        </div>";
    }
    else{
        echo ("<div class='alert alert-danger'>
        <strong>Warning:</strong> Login to access this page !
        </div>
        <a href='login.php' type='button' class='btn btn-primary btn-md'>Login</a>");
    }
    ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>