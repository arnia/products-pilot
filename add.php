<?php
$root="/products_pilot";
session_start();
if((isset($_COOKIE['user_auth']) && !empty($_COOKIE['user_auth'])) || (isset($_SESSION['user_auth']) && !empty($_SESSION['user_auth'])) ) {
    require_once("connect.php");
    include("Product.php");
    if(isset($_POST['type'])&&isset($_POST['name'])&&isset($_POST['price'])) {
        $type = $_POST['type'];
        $file = basename($_FILES["file"]["name"]);

        $product = new Product(array('name' => $_POST['name'], 'price' => $_POST['price'], 'file' => $file));

        $basePath = "uploads/";
        $completPath = $basePath . $file;
        $extensionFile = pathinfo($file, PATHINFO_EXTENSION);
        $allowedExt = array('txt', 'pdf', 'doc', 'docx');
        if (in_array($extensionFile, $allowedExt) || $file == NULL) {
            if (!file_exists($completPath) && isset($_FILES["file"]["tmp_name"])) {
                move_uploaded_file($_FILES["file"]["tmp_name"], $completPath);
            }
        } else die("Doar fisiere de tip txt, pdf, docx, doc");

        // select id of type
        $query = "select id from type where name='$type';";
        $result = $mysqli->query($query) or die("error to select type_id" . mysql_error());
        $row = mysqli_fetch_row($result);
        $type_id = $row[0];

        // add products
        $name = $product->getName();
        $price = $product->getPrice();
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $query = "update product set name='$name', type_id=$type_id, price=$price, file='$file'
                      where id=$id;";
        }
        else{
            $query = "insert into product(name,type_id,price,file) values ('$name',$type_id,$price,'$file');";
        }

        $mysqli->query($query) or die("error to add product in database");

        $mysqli->close();
    }
    header("Location:$root/add_product.php");
    exit();
}
else {
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title> Products </title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <style>
            #main {
                margin: auto;
                margin-top: 300px;
                width: 50%;
            }

            #toright {
                margin-left: 1250px;
            }

        </style>
    </head>

    <body>
    <div id="main">
        <div class='alert alert-danger'>
            <strong>Warning:</strong> Login to access this page !
        </div>
        <a href='/product_crud/login.php' type='button' class='btn btn-primary btn-md'>Login</a>");
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
    </html>
<?php
}
?>
