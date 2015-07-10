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
            width: 10%;

        }
        #toright{
            margin-left:1250px;
        }

    </style>
</head>

<body>
<div id="main">
    <form role="form" action="auth.php" method="post">
        <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" id="email" name="email" value="
                    <?php
                        session_start();
                        if (isset($_COOKIE['user_auth']) && !empty($_COOKIE['user_auth'])) echo $_COOKIE['user_auth'];
                            elseif (isset($_SESSION['user_auth']) && !empty($_SESSION['user_auth'])){
                                echo $_SESSION['user_auth'];
                            }
                                else echo "";
                    ?>" required>
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" name="password" required>
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="checkbox" value="1"> Remember me</label>
        </div>
        <a href="resetpass.php">Reset your password</a>
        <button type="submit" class="btn btn-default" style="margin-top:15px;">LogIn</button>
        <a href="signup.php" style="display:block; margin-top:20px;" class="btn btn-info">SignUp</a>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>