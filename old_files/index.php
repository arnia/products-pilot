<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Products </title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <style>
            #main{
                margin:auto;
                margin-top: 50px;
                width: 70%;
            }
            #toright{
                margin-left:1250px;

            }

        </style>
    </head>
<body>
<div id="main">
    <?php
    require_once("connect.php");
    session_start();
    if((isset($_COOKIE['user_auth']) && !empty($_COOKIE['user_auth'])) || (isset($_SESSION['user_auth']) && !empty($_SESSION['user_auth'])) ) {
            echo "
                <a href='logout.php' type='button' class='btn btn-default btn-md'>Log Out</a>
                <a href='changepass.php' type='button' class='btn btn-default btn-md'>Change Password</a>
                <div id='toright'>
                <a href='add_product.php' class='btn btn-success'>Add New</a>
                </div>";

        $basePath = "uploads/";

        $query = "SELECT p.id,p.name,t.name,p.price,p.file FROM product p
                  left join type t on(t.id=p.type_id)";
        if ($result = $mysqli->query($query)) {
            if ($result->num_rows > 0) {
               echo "<table class='table table-bordered'>
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
            ";
                while ($row = $result->fetch_array()) {
                    echo "<tr>";
                    echo "<td><a href=add_product.php?id=".$row[0].">" . $row[0] . "</a></td>";
                    echo "<td>" . $row[1] . "</td>";
                    echo "<td>" . $row[2] . "</td>";
                    echo "<td>" . $row[3] . "</td>";
                    echo "<td><a href='$basePath$row[4]' alt='$row[4]'download>" . $row[4] . "</a></td>";
                    echo "<td>
            <form  action='delete.php' method='post' onsubmit='validateForm()'>
            <input type='hidden' name='id' value='$row[0]'>
            <input type='hidden' name='file' value='$row[4]'>
            <input type='submit' class='btn btn-danger'  value='Delete'>
            </form>
                </td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "No rows found!";
            }
        } else {
            echo "Error in query: $query. " . $mysqli->error;
        }

        $mysqli->close();
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
    function validateForm(){
        alert("Are you sure you want to delete ?");
    }
</script>
</body>
</html>