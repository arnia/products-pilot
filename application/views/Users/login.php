<?php
if(isset($error)) echo "<div class='alert alert-danger' style='margin-top:10px'>
                <strong>Error:</strong> " . $error ."
                </div>";
if(isset($success)) echo "<div class='alert alert-info' style='margin-top:10px'>
                 <strong>Info:</strong> " . $success ."
                 </div>";
?>

<form role="form" action="<?php echo Router::buildPath(array($controller,'auth')) ?>" method="post">
    <div class="form-group">
        <label for="email">Email address:</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" id="pwd" name="password" required>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="checkbox" value="1"> Remember me</label>
    </div>
    <a href="<?php
            if(isset($user_key)) echo Router::buildPath(array($controller,'logout',$user_key));
            else echo Router::buildPath(array($controller,'resetpass'));
            ?>
            ">Reset your password</a>
    <button type="submit" class="btn btn-default" style="margin-top:15px; display: block">LogIn</button>
    <a href="<?php echo Router::buildPath(array($controller,'signup')) ?>" style="display:block; margin-top:20px; width:50%;" class="btn btn-info">SignUp</a>
</form>
</div>