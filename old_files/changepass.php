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
            width: 15%;
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
    ?>
    <form role="form" action="cpass.php" method="post">
        <div class="form-group">
            <label for="pwd">New Password:</label>
            <input type="password" class="form-control" id="pwd1" name="password1" required>
        </div>
        <div class="form-group">
            <label for="pwd">New Password Again:</label>
            <input type="password" class="form-control" id="pwd2" name="password2" required>
        </div>
        <button type="submit" class="btn btn-default" style="margin-top:15px;">Change Password</button>
    </form>
    <?php
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