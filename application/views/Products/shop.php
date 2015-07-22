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
    <a class="btn btn-primary" type="button" href = "<?php echo Router::buildPath(array('users','mycart')) ?>">
        <span class="badge" style="color:red" id = 'countCart' ></span> My Shopping Cart <span class="badge" id = 'myCart' ></span>
    </a>
</div>

<?php
if ($products) {
    $dpath = Router::buildPath(array($controller,'delete'));
    ?>
    <table class='table table-bordered'>
        <caption>Products</caption>
        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Price</th>
            <th>File</th>
            <th>Add to cart</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($products as $i => $product) {
            $apath = Router::buildPath(array($controller,'add_edit',$product->id));
            ?>
            <tr>
                <td> <?php echo $product->name ?> </td>
                <td> <?php echo $product->type ?></td>
                <td> <?php echo $product->price ?></td>
                <td> <a href="<?php echo DOMAIN . '/uploads/' . $product->file ?>" download> <?php echo $product->file ?> </a></td>
                <td> <img id="cart_logo" src="<?php echo DOMAIN ?>/img/add_to_cart.jpg" onclick="addToCart('<?php echo $email ?>','<?php echo $product->id ?>')"></td>
            </tr>
        <?php } ?>

        </tbody>
    </table>

<?php } else  echo "No rows found!" ?>
