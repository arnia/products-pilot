<a href='<?php echo Router::buildPath(array('users','account_settings')) ?>' type='button' class='btn btn-default btn-md'>Account Settings</a>
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
            <td><a href='<?php echo $apath ?>'> <?php echo $product->id ?></a></td>
            <td> <?php echo $product->name ?> </td>
            <td> <?php echo $product->type ?></td>
            <td> <?php echo $product->price ?></td>
            <td><a href="<?php echo $product->file ?>" download> <?php echo $product->file ?> </a></td>
            <td>
                <form  id='del_form_<?php echo $i?>' action='<?php echo $dpath ?>' onsubmit='validateForm(<?php echo $i ?>)' method='post' >
                    <input type = 'hidden' name = 'id' value = <?php echo $product->id ?> >
                    <input type = 'hidden' name = 'file' value = <?php echo $product->file ?> >
                    <input type='submit' class='btn btn-danger'  value='Delete'>
                </form>
            </td>
        </tr>
<?php } ?>

    </tbody></table>

<?php } else  echo "No rows found!" ?>