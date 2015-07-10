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
    <form role="form" action="signupadd.php" method="post">
        <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd1" name="password1" required>
        </div>
        <div class="form-group">
            <label for="pwd">Password Again:</label>
            <input type="password" class="form-control" id="pwd2" name="password2" required>
        </div>

        <button type="submit" class="btn btn-default">SignUp</button>
        <a href="login.php" style="display:block; margin-top:20px;" class="btn btn-info">LogIn</a>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>