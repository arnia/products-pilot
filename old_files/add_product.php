<!DOCTYPE html>
<html lang="en">
<head>
    <title> Products </title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <style>
        #addform{
            margin:auto;
            margin-top: 100px;
            width: 10%;
        }
    </style>
</head>

<body>
<div  id="addform">
<?php
require_once("connect.php");
$root = "/products_pilot";
$upload="/uploads/";
session_start();
if((isset($_COOKIE['user_auth']) && !empty($_COOKIE['user_auth'])) || (isset($_SESSION['user_auth']) && !empty($_SESSION['user_auth'])) ) {

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "select p.name name,t.name type,p.price price,p.file file from product p
                  join type t on(t.id=p.type_id) where p.id=$id;";
        $result = $mysqli->query($query) or die("<div class='alert alert-danger'>
                                                 <strong>Warning:</strong> Database Error
                                                 </div>
                                                 <a href='add_product.php' type='button' class='btn btn-primary btn-md'>Add Product Again</a>");
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            ?>
            <form action='add.php' method='post' enctype='multipart/form-data' >
            <fieldset id="update_form">
            <legend>Add Product</legend>
            <label>Name</label>
            <input type='text' placeholder='Type something…' name='name' value=<?php echo "$row->name"?> required><br>
            <label>Type</label>
            <select name='type'>
                <option <?php if($row->type=='Hardware') echo "selected"?>>Hardware</option>
                <option <?php if($row->type=='Software') echo "selected"?>>Software</option>
                <option <?php if($row->type=='Book') echo "selected"?>>Book</option>
                <option <?php if($row->type=='Movie') echo "selected"?>>Movie</option>
            </select><br>
            <label>Price</label>
            <input type='number' min='0' max='5000' step='any' placeholder='Type something…' name='price' value=<?php echo "$row->price"?> required><br>
            <label>File</label>
            <?php
            if(!empty($row->file)) {

                //var_dump($file);
                echo '<a href = "'.$root.$upload.$row->file.'" id="file_link" download >'.$row->file.'</a>
                <button type="button" class="btn btn-danger btn-sm" onclick="delete_file(\''.$row->file.'\')" id="file_button" >Delete</button>';
            }
            else {
                echo "<input type='file' name='file' accept=''.txt,.pdf,.doc,.docx''><br>";
            }

         echo "
            <input type='hidden' name='id' value=$id>
            <hr  id='last_line'>
            <button type='submit' class='btn btn-success'>Update</button>
        </fieldset>
        </form>
        <a href='$root' type='button' class='btn btn-primary btn-md'>List of products</a>";
        }
        else {
            echo "<div class='alert alert-danger'>
                      <strong>Warning:</strong> Database Error
                      </div>
                      <a href='add_product.php' type='button' class='btn btn-primary btn-md'>Add Product Again</a>";
        }
    } else {

        ?>

        <form action="add.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Add Product</legend>
                <label>Name</label>
                <input type="text" placeholder="Type something…" name="name" required><br>
                <label>Type</label>
                <select name="type">
                    <option>Hardware</option>
                    <option>Software</option>
                    <option>Book</option>
                    <option>Movie</option>
                </select><br>
                <label>Price</label>
                <input type="number" min="0" max="5000" step="any" placeholder="Type something…" name="price"
                       required><br>

                <label>File</label>
                <input type="file" name="file" accept=".txt,.pdf,.doc,.docx"><br>
                <hr>
                <button type="submit" class="btn btn-success">Submit</button>
            </fieldset>
        </form>
        <a href="/product_crud" type="button" class="btn btn-primary btn-md">List of products</a>
    <?php
    }
}
else{
    echo ("<div class='alert alert-danger'>
    <strong>Warning:</strong> Login to access this page !
    </div>
    <a href='login.php' type='button' class='btn btn-primary btn-md'>Login</a>");
}
?>
</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script>
        function delete_file(file){
                var r = confirm("Are you sure you want to delete this file?");
                if(r == true)
                {
                    $.ajax({
                        url: 'del.php',
                        data: {'file' : file }
                    });

                    var x = document.getElementById("file_link");
                    x.parentNode.removeChild(x);
                    x = document.getElementById("file_button");
                    x.parentNode.removeChild(x);
                    var y = document.createElement("input");
                    y.type = "file";
                    y.name = "file";
                    y.accept=".txt,.pdf,.doc,.docx";
                    var x = document.getElementById("update_form");
                    var z = document.getElementById("last_line");
                    x.insertBefore(y, z);
                }
            }
    </script>
</body>
</html>