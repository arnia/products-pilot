<?php if(isset($error)) { ?>
    <div class='alert alert-danger' style='margin-top:10px'>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong></strong> <?php echo $error ?>
    </div>
<?php } ?>

<?php if(isset($success)) { ?>
    <div class='alert alert-info' style='margin-top:10px'>
        <strong>Info:</strong> <?php echo $success ?>
    </div>
<?php } ?>

<form role="form" action="<?php echo Router::buildPath(array($controller,'signupadd')) ?>" method="post">
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
    <a href="<?php echo Router::buildPath(array($controller,'login')) ?>" style="width: 50%; display:block; margin-top:20px;" class="btn btn-info">LogIn</a>
</form>