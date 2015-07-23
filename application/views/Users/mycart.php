<div id="toright" style="margin-bottom:20px">
    <div class="btn-group" role="group" aria-label="...">
        <a href='<?php echo Router::buildPath(array('users','logout'));?>' type='button' class='btn btn-default btn-md'>LogOut</a>
    </div>
</div>
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
<?php
if ($shoppingcart) {
    ?>
    <div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Coutent of your Shopping Cart:</div>
    <table class='table table-bordered'>
        <caption>Products</caption>
        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Delete</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        foreach($shoppingcart as $i => $product) {
            ?>
            <tr>
                <td> <?php echo $product->name ?> </td>
                <td> <?php echo $product->type ?></td>
                <td class="col-md-2">
                    <form  name = '<?php echo "upForm$i" ?>' action='<?php echo Router::buildPath(array('users','updatecart')) ?>' method='post' >
                        <input class="col-md-6" min='0' max='100' type="number" step="1" name="nr" value="<?php echo $product->nr ?>">
                        <input type = 'hidden' name = 'product_id' value = <?php echo $product->id ?> >
                        <a href="javascript: document.<?php echo "upForm$i" ?>.submit();">
                            <span style="margin-left:10px;" class="glyphicon glyphicon-ok"></span>
                        </a>
                    </form>
                </td>
                <td>
                    <form  id='<?php echo "delForm$i" ?>' action='<?php echo Router::buildPath(array('users','delfromcart')) ?>' method='post' >
                        <input type = 'hidden' name = 'product_id' value = <?php echo $product->id ?> >
                        <a href="javascript: delFromCart('<?php echo "delForm$i"?>')">
                            <span class="glyphicon glyphicon-remove" style="color:red;margin-left:10px;"></span>
                        </a>
                    </form>
                </td>
                <td> <?php echo number_format((float)$product->price,2,'.','') ?></td>
            </tr>
        <?php
        $total += ($product->price * $product->nr);
        }
        ?>
        </tbody>
    </table>
    <div class="panel-footer"><p class="text-right" style="margin-right:130px;font-weight: bold;" >Total price: <?php echo $total ?></p></div>
    </div>

<?php } else  echo "Your shopping cart is empty !" ?>
<hr>
<a href='<?php echo Router::buildPath(array('products','shop'));?>' type='button' class='btn btn-default btn-md'>Back to Shop</a>