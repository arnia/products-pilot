<div id="toright">
    <div class="btn-group" role="group" aria-label="...">
        <a href='<?php echo Router::buildPath(array('users','logout'));?>' type='button' class='btn btn-default btn-md'>LogOut</a>
    </div>
</div>
<div class="btn-group" role="group" aria-label="...">

    <div class="btn-group" role="group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Account Settings
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="<?php echo Router::buildPath(array('users','logout'));?>">LogOut</a></li>
            <li><a href="<?php echo Router::buildPath(array('users','changepass'));?>">Change Password</a></li>
        </ul>
    </div>

    <a href='<?php echo Router::buildPath(array('users','viewall'));?>' type='button' class='btn btn-default btn-md'>Users</a>

    <a href='<?php echo Router::buildPath(array('products','viewall'));?>' type='button' class='btn btn-default btn-md'>Products</a>

    <a href='<?php echo Router::buildPath(array('mailsettings','viewall'));?>' type='button' class='btn btn-default btn-md'>Mail Settings</a>

    <a href='<?php echo Router::buildPath(array('products','shop'));?>' type='button' class='btn btn-default btn-md'>Shop</a>

</div>