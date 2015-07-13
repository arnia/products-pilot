<a href='' type='button' class='btn btn-default btn-md'>Log Out</a>
<a href='' type='button' class='btn btn-default btn-md'>Change Password</a>
<div id='toright'>
    <a href='<?php echo Router::buildPath(array($controller,'add_edit')) ?>' class='btn btn-success'>Add New</a>
</div>
<?php
if ($products) {


    $dpath = Router::buildPath(array($controller,'delete'));

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
       foreach($products as $product) {

           $apath = Router::buildPath(array($controller,'add_edit',$product->id));

           echo "<tr>";
           echo "<td><a href='$apath'>" . $product->id . "</a></td>";
           echo "<td>" . $product->name . "</td>";
           echo "<td>" . $product->type . "</td>";
           echo "<td>" . $product->price . "</td>";
           echo "<td><a href=" .$product->file. " download>" . $product->file . "</a></td>";
           echo "<td>
           <form  id = 'del_form' action = '$dpath' onsubmit='validateForm()' method='post' >
           <input type = 'hidden' name = 'id' value = $product->id >
           <input type = 'hidden' name = 'file' value = $product->file >
           <input type='submit' class='btn btn-danger'  value='Delete'>
           </form>
               </td>";
           echo "</tr>";
       }
       echo "</tbody></table>";
    } else {
    //var_dump($products);
    echo "No rows found!";
}
