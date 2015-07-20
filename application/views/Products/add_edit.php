<form class="form-horizontal" role="form" action='<?php echo Router::buildPath(array($controller,'save')) ?>' method='post' enctype='multipart/form-data' >
    <legend>Add Product</legend>
    <fieldset id="update_form">
    <div class="form-group">
        <label class="control-label col-sm-1" for="">Name:</label>
        <div class="col-sm-3">
            <input class= "form-control" type='text' placeholder='Type something…' name='name' value='<?php if(isset($product->name)) echo $product->name?>' required>
        </div>
    </div>
    <div class="form-group">
        <label  class="control-label col-sm-1" for="sel1">Type:</label>
        <div class="col-sm-3">
            <select name='type' class="form-control" id="sel1">
                    <option <?php if(isset($product->type)) if($product->type=='Hardware') echo "selected"?>>Hardware</option>
                    <option <?php if(isset($product->type)) if($product->type=='Software') echo "selected"?>>Software</option>
                    <option <?php if(isset($product->type)) if($product->type=='Book') echo "selected"?>>Book</option>
                    <option <?php if(isset($product->type)) if($product->type=='Movie') echo "selected"?>>Movie</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-1" for="">Price:</label>
        <div class="col-sm-3">
            <input class= "form-control" type='number' min='0' max='5000' step='any' placeholder='Type something…' name='price' value='<?php if(isset($product->price)) echo $product->price?>' required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-1" for="">File:</label>
        <div class="col-sm-3" id="uploadfield">
            <?php if(isset($product->file)&&!empty($product->file)) { ?>
                <a href = "<?php echo $product->file ?>" id="file_link" download > <?php echo $product->file ?> </a>
                <button type="button" class="btn btn-danger btn-sm" onclick="delete_file('<?php echo $product->file ?>','<?php echo DOMAIN ?>')" id="file_button" >Delete</button>
            <?php } else { ?>
                <input type='file' name='file' accept='.txt,.pdf,.doc,.docx' >
            <?php } ?>
        </div>
    </div>
<input type='hidden' name='id' value='<?php if(isset($product->id)) echo $product->id?>'>
<hr  id='last_line'>
<button type='submit' class='btn btn-success'> <?php if($new) echo "Add";else echo "Update" ?> </button>
</fieldset>
</form>
<hr  id='ln'>
<a href="<?php echo Router::buildPath(array($controller,'viewall')) ?>" type='button' class='btn btn-primary btn-md'>List of products</a>