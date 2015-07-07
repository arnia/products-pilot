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
    include("User.php");
    $root = "/product_crud";
    if(isset($_GET['email']) && !empty($_GET['email']) &&
       isset($_GET['hash']) && !empty($_GET['email'])){
        $email=$mysqli->escape_string($_GET['email']);
        $hash=$mysqli->escape_string($_GET['hash']);
        $query="select id from user where email='$email' and hash='$hash' and verified=0;";
        $result=$mysqli->query($query) or die("<div class='alert alert-warning'>
                        <strong>Error:</strong> The url is either invalid or you already have activated your account.
                        </div>");
        if($result->num_rows==1) {
            $query="update user set verified=1 where email='$email' and hash='$hash' and verified=0;";
            $result=$mysqli->query($query) or die("<div class='alert alert-danger'>
                        <strong>Error:</strong>".mysql_error()."
                        </div>");
            echo "<div class='alert alert-success'>
                        <strong>Success:</strong> Your account has been activated
                        </div>
            <a href='login.php' type='button' class='btn btn-primary btn-md'>Login</a>";
        }
        else{
            echo ("<div class='alert alert-warning'>
                        <strong>Warning:</strong> The url is either invalid or you already have activated your account.
                        </div>");
        }

        $mysqli->close();
    }
    else{
        echo "<div class='alert alert-warning'>
                        <strong>Error:</strong> Invalid approach, please use the link that has been send to your email
                        </div>";
    }

    ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>