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
        <?php if(isset($admin)) { ?>
        <li><a href="<?php echo Router::buildPath(array('users','control_panel'));?>">Control Panel</a></li>
        <?php } ?>
        <li><a href="<?php echo Router::buildPath(array('users','changepass'));?>">Change Password</a></li>
    </ul>
    <a class="btn btn-primary" type="button" href = "<?php echo Router::buildPath(array('users','mycart')) ?>">
        <span class="badge" style="color:red" id = 'countCart' ></span> My Shopping Cart <span class="badge" id = 'myCart' ></span>
    </a>
</div>

<div class = "products" >
<?php if ($products) {  ?>
    <?php  foreach($products as $i => $product) { ?>

        <div class="col-sm-5 col-md-3">
            <div class="thumbnail">
                <a href="<?php echo DOMAIN . '/img/' .$product->image ?>"><img src = "<?php echo DOMAIN . '/img/' .$product->image ?>"></a>
                <div class="caption">
                    <h3><?php echo $product->name ?></h3>
                    <p><?php echo substr($product->description,0,20) ?></p>
                    <p>Category: <?php echo $product->type ?></p>
                    <p>Attached file:
                        <?php if($product->file) { ?>
                        <a href="<?php  echo DOMAIN . '/uploads/' . $product->file;?>" download> <?php echo $product->file;?> </a>
                        <?php } else { ?>
                        -Not Found-
                        <?php } ?>
                    </p>
                    <h4>Price: <?php echo number_format((float)$product->price,2,',','.') ?></h4>
                </div>
                <div style = "margin:auto;width: 40%">
                <a href="#"><img src="<?php echo DOMAIN ?>/img/add_to_cart.jpg" onclick="addToCart('<?php echo $email ?>','<?php echo $product->id ?>')"></a>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } else  echo "No rows found!" ?>
</div>