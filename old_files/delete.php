<?php
    $root="/product_crud";
    require_once("connect.php");
    $basePath="uploads/";
    if(isset($_POST['id']) && isset($_POST['file'])) {
        $id = $_POST['id'];
        $file = $_POST['file'];

        if ($file != NULL) {
            $query = "SELECT id FROM product
              where file='$file';";
            $result = $mysqli->query($query) or die("Error to select number of file" . mysql_error());
            if ($result->num_rows <= 1) {
                $completPath = $basePath . $file;
                unlink($completPath);
            }
        }

        $query = "delete from product
            where id=$id ";
        $result=$mysqli->query($query) or die("Error to delete a row" . mysql_error());
        echo "succes";

        $mysqli->close();
    }
header("Location:$root");
exit();