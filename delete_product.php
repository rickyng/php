<?php
include_once 'config/core.php';
// check if value was posted
if($_POST){
 
    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/product.php';

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare product object
    $product = new Product($db);
      
    // delete the product
    if($product->delete($_POST['object_id'])){
        echo "Object was deleted.";	
    }
     
    // if unable to delete the product
    else{
        echo "Unable to delete object.";
    }
}
?>