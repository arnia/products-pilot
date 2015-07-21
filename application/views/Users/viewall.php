<div id="toright">
    <div class="btn-group" role="group" aria-label="...">
        <a href='<?php echo Router::buildPath(array('users','logout'));?>' type='button' class='btn btn-default btn-md'>LogOut</a>
    </div>
</div>
<a href='<?php echo Router::buildPath(array('users','control_panel'));?>' type='button' class='btn btn-default btn-md'>Control Panel</a>


<?php if(isset($error)) { ?>
    <div class='alert alert-danger' style='margin-top:10px'>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong></strong> <?php echo $error ?>
    </div>
<?php } ?>
<?php if(isset($success)) { ?>
    <div class='alert alert-success' style='margin-top:10px'>
        <strong>Info:</strong> <?php echo $success ?>
    </div>
<?php } ?>

<?php if ($users) {    ?>

    <table class='table table-bordered'>
        <caption>Users</caption>
        <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Verified</th>
            <th>Admin</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
<?php foreach($users as $i => $user) { ?>
    <tr>
        <td> <?php echo $user->id ?> </td>
        <td> <?php echo $user->email ?> </td>
        <td>
            <?php if($user->verified) { ?>
            <span class="glyphicon glyphicon-ok" aria-hidden="true" ></span>
            <?php } else { ?>
            <span class="glyphicon glyphicon-minus"></span>
            <?php } ?>
        </td>
        <td>
            <?php if($user->admin_id && $user->verified) { if ($user->admin_id == 1) { ?>
                <button type="button" class="btn btn-primary disabled">Super User</button>
            <?php } else { if($user->email != $currentUser) { ?>
                                <form  id='<?php echo "adForm$i" ?>' action='<?php echo Router::buildPath(array('users','umkAdmin')) ?>' onsubmit="validateForm('<?php echo "adForm$i" ?>')" method='post' >
                                    <input type = 'hidden' name = 'admin_id' value = <?php echo $user->admin_id ?> >
                                    <input type='submit' class='btn btn-danger'  value='Unmake Admin'>
                                </form>
            <?php } else { ?>
                <button type="button" class="btn btn-primary disabled">Unmake Admin</button>
            <?php } ?>
            <?php } } elseif ($user->verified) { ?>
                <form  id='<?php echo "adForm$i" ?>' action='<?php echo Router::buildPath(array('users','mkAdmin')) ?>' onsubmit="validateForm('<?php echo "adForm$i" ?>')" method='post' >
                    <input type = 'hidden' name = 'user_id' value = <?php echo $user->id ?> >
                    <input type='submit' class='btn btn-primary'  value='Make Admin'>
                </form>
            <?php } else { ?>
                <button type="button" class="btn btn-primary disabled">Make Admin</button>
            <?php } ?>
        </td>
        <td>
            <?php if ($user->admin_id == 1) { ?>
                <button type="button" class="btn btn-danger disabled">Delete</button>
            <?php } elseif($user->email != $currentUser) { ?>
                <form  id='<?php echo "delForm$i" ?>' action='<?php echo Router::buildPath(array('users','delete')) ?>' onsubmit="validateForm('<?php echo "delForm$i" ?>')" method='post' >
                    <input type = 'hidden' name = 'id' value = <?php echo $user->id ?> >
                    <input type='submit' class='btn btn-danger'  value='Delete'>
                </form>
            <?php } else { ?>
                <button type="button" class="btn btn-danger disabled">Delete</button>
            <?php } ?>
        </td>
    </tr>
<?php } ?>
        </tbody>
    </table>

<?php } else  echo "No rows found!" ?>

<a href="<?php echo Router::buildPath(array($controller,'signup')) ?>" class="btn btn-success">Add New</a>

