<div id="toright">
    <div class="btn-group" role="group" aria-label="...">
        <a href='<?php echo Router::buildPath(array('users','logout'));?>' type='button' class='btn btn-default btn-md'>LogOut</a>
    </div>
</div>
<div class="btn-group" role="group">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Account Settings
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="<?php echo Router::buildPath(array('users','changepass'));?>">Change Password</a></li>
    </ul>
</div>
    <a href='<?php echo Router::buildPath(array('users','control_panel'));?>' type='button' class='btn btn-default btn-md'>Control Panel</a>
    <div id='toright'>
        <a href='<?php echo Router::buildPath(array($controller,'add_edit')) ?>' class='btn btn-success'>Add New</a>
    </div>

<?php
    if ($products) {
        $dpath = Router::buildPath(array($controller,'delete'));
?>
    <table class='table table-bordered'>
    <caption>Products</caption>
    <thead>
    <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Type</th>
    <th>Price</th>
    <th>File</th>
    <th>Delete</th>
    </tr>
    </thead>
    <tbody>
<?php
    foreach($products as $i => $product) {
        $apath = Router::buildPath(array($controller,'add_edit',$product->id));
?>
        <tr>
            <td>
            <a href='<?php echo $apath ?>'> <?php echo $product->id ?></a>
            </td>
            <td> <?php echo $product->name ?> </td>
            <td> <?php echo $product->type ?></td>
            <td> <?php echo $product->price ?></td>
            <td><a href="<?php echo DOMAIN . '/uploads/' . $product->file ?>" download> <?php echo $product->file ?> </a></td>
            <td>
                <form  id='<?php echo "delForm$i" ?>' action='<?php echo $dpath ?>' onsubmit="validateForm('<?php echo "delForm$i" ?>')" method='post' >
                    <input type = 'hidden' name = 'id' value = <?php echo $product->id ?> >
                    <input type = 'hidden' name = 'file' value = <?php echo $product->file ?> >
                    <input type='submit' class='btn btn-danger'  value='Delete'>
                </form>
            </td>
        </tr>
<?php } ?>

    </tbody></table>

<?php } else  echo "No rows found!" ?>