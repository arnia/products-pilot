<?php if(isset($error)) { ?>
    <div class='alert alert-danger' style='margin-top:10px'>
        <strong>Error:</strong> <?php echo $error ?>
    </div>
<?php } ?>
<form role="form" action="<?php echo Router::buildPath(array($controller,'install')) ?>" method="post">
    <div class="form-group">
        <label for="text">Database Host</label>
        <input type="text" class="form-control" id="db_host" name="db_host" value="localhost" required>
    </div>
    <div class="form-group">
        <label for="text">Database Name</label>
        <input type="text" class="form-control" id="db_host" name="db_name" value="db_products" required>
    </div>
    <div class="form-group">
        <label for="text">Database User </label>
        <input type="text" class="form-control" id="host" name="db_user" value="root" required>
    </div>
    <div class="form-group">
        <label for="pwd">Database User Password:</label>
        <input type="password" class="form-control" id="pwd1" name="db_password" required>
    </div>
    <div class="form-group">
        <label for="email">SuperUser Email address:</label>
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
    <button type="submit" class="btn btn-info">INSTALL DATABASE</button>
</form>