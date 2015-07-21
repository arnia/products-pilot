<div id="userform">
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


<form role="form" action="<?php echo Router::buildPath(array($controller,'rpass')) ?>" method="post">
    <div class="form-group">
        <label for="email">Email address:</label>
        <input type="email" class="form-control" id="email" name="email" value="" required>
    </div>

    <button type="submit" class="btn btn-default" style="margin-top:15px;">Send mail</button>

</form>
</div>