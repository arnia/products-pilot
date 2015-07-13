<?php  //var_dump($product); ?>

<form action='<?php echo DOMAIN . '/' . $controller ?>/save' method='post' enctype='multipart/form-data' >
    <fieldset id="update_form">
        <legend>Add Product</legend>
        <label>Name</label>
        <input type='text' placeholder='Type something…' name='name' value='<?php if(isset($product->name)) echo $product->name?>' required><br>
        <label>Type</label>
        <select name='type'>
            <option <?php if(isset($product->type)) if($product->type=='Hardware') echo "selected"?>>Hardware</option>
            <option <?php if(isset($product->type)) if($product->type=='Software') echo "selected"?>>Software</option>
            <option <?php if(isset($product->type)) if($product->type=='Book') echo "selected"?>>Book</option>
            <option <?php if(isset($product->type)) if($product->type=='Movie') echo "selected"?>>Movie</option>
        </select><br>
        <label>Price</label>
        <input type='number' min='0' max='5000' step='any' placeholder='Type something…' name='price' value='<?php if(isset($product->price)) echo $product->price?>' required><br>
        <label>File</label>
<?php
if(isset($product->file)&&!empty($product->file)) {

    //var_dump($file);
    echo '<a href = "'.$product->file.'" id="file_link" download >'.$product->file.'</a>
                <button type="button" class="btn btn-danger btn-sm" onclick="delete_file(\''.$product->file.'\')" id="file_button" >Delete</button>';
}
else {
    echo "<input type='file' name='file' accept='.txt,.pdf,.doc,.docx' ><br>";
}
?>
<input type='hidden' name='id' value='<?php if(isset($product->id)) echo $product->id?>'>
<hr  id='last_line'>
<button type='submit' class='btn btn-success'><?php if($new) echo "Add";else echo "Update" ?></button>
</fieldset>
</form>
<a href='<?php echo DOMAIN . '/' . $controller ?>/viewall' type='button' class='btn btn-primary btn-md'>List of products</a>