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
    $root="http://localhost/product_crud";
    require_once("connect.php");
    if(isset($_POST['email']) && !empty($_POST['email'])){
        $email=$_POST['email'];
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            die("<div class='alert alert-danger'>
                        <strong>Error:</strong> Invalid email format
                        </div>");
        //check if email is in database
        $email=$mysqli->escape_string($_POST['email']);
        $query="select id from user where email='$email';";
        $result=$mysqli->query($query) or die("
            <div class='alert alert-danger'>
            <strong>Error:</strong>Database filed
            </div>
        ");
        if($result->num_rows==1){
            $length = 8;
            $pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
            $m_pass=md5($pass);
            $query = "update user
                      set password='$m_pass'
                      where email='$email'";
            $result = $mysqli->query($query) or die("
                <div class='alert alert-danger'>
                <strong>Database filed:</strong>Password has not been changed
                </div>
                <a href='login.php' class='btn btn-default' style='margin-top:15px;'>LogIn Page</a>
            ");
            $subject = "New Password";
            $message = "<p>
            New Password for $email is: $pass</p>
            <p>-----------</p>
            <a href='$root/login.php' type='button' class='btn btn-default btn-md'> Click Here </a> to login.";

            require_once 'mailSettings.php';
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = $message;

            if($mail->send()){
                echo "<div class='alert alert-success'>
                  <strong>Success:</strong> Password has been changed, please verify your email.
                  </div>";
            }
            else{
                echo "<div class='alert alert-danger'>
                  <strong>Error:</strong>Email could not be sent
                  </div>";
            }
        }
        else{
            echo "<div class='alert alert-danger'>
            <strong>Error:</strong>The email is not in the database
            </div>
            <a href='login.php' class='btn btn-default' style='margin-top:15px;'>LogIn Page</a>
            ";
        }
    }
    else{
        echo "<div class='alert alert-info'>
              <strong>Info:</strong> Email field required
              </div>
              <a href='login.php' class='btn btn-default' style='margin-top:15px;'>LogIn Page</a>
              ";
    }
    $mysqli->close();
    ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>