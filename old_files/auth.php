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
    $root = "/products_pilot";
    if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])){

            $email=$mysqli->escape_string($_POST['email']);
            $password=$mysqli->escape_string(md5($_POST['password']));
            $query="select id,verified from user where email='$email' and password='$password' and verified=1;";
            $result=$mysqli->query($query) or die("<div class='alert alert-danger'>
                            <strong>Error:</strong>Login filed, database error
                            </div>");
            if($result->num_rows==1) {
                echo "<div class='alert alert-success'>
                            <strong>Success:</strong> you can view the products
                            </div>
                <a href='$root' type='button' class='btn btn-primary btn-md'>List of products</a>
                <a href='changepass.php' type='button' class='btn btn-primary btn-md'>Change Password</a>";
                if(isset($_POST['checkbox']) && !empty($_POST['checkbox']) && $_POST['checkbox']==1){
                    setcookie("user_auth",$email,mktime()+(3600*24),"/");
                }
                else{
                    session_start();
                    $_SESSION['user_auth'] = $email;
                }
            }
            else{
                $query="select verified from user where email='$email' and verified=0;";
                $result=$mysqli->query($query) or die("<div class='alert alert-danger'>
                            <strong>Error:</strong>Login filed, database error
                            </div>");
                if($result->num_rows==1) {
                    echo "<div class='alert alert-danger'>
                            <strong>Error:</strong> Email is not verified
                            </div>";
                }
                else{
                    echo "<div class='alert alert-danger'>
                            <strong>Error:</strong> Incorrect email or password
                            </div>";
                }

            }

        }
        else{
            echo "<div class='alert alert-danger'>
                            <strong>Error:</strong> Not exist email or password
                            </div>";
        }

    ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>