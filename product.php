<?php
// include classes
include_once "config/database.php";
include_once "objects/product.php";
include_once "objects/product_image.php";
include_once "objects/cart_item.php";
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);
$cart_item = new CartItem($db);
 
// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$action = isset($_GET['action']) ? $_GET['action'] : "";
 

// to read single record product
$p = $product->readOne($id);
 
// set page title
$page_title = $p['name'];
 
// include page header HTML
include_once 'layout_head.php';

echo "<div class='col-md-12'>";
    if($action=='added'){
        echo "<div class='alert alert-info'>";
            echo "Product was added to your cart!";
        echo "</div>";
    }
 
    else if($action=='unable_to_add'){
        echo "<div class='alert alert-info'>";
            echo "Unable to add product to cart. Please contact Admin.";
        echo "</div>";
    }
echo "</div>";
 
// product thumbnail will be here
// set product id

 
// read all related product image
$stmt_product_image = $product_image->readBy('product_id',$id);
 
// count all relatd product image
$num_product_image = sizeof($stmt_product_image);
 
echo "<div class='col-md-1'>";
    // if count is more than zero
    if($num_product_image>0){
        // loop through all product images
        foreach ($stmt_product_image as $row){
            // image name and source url
            $product_image_name = $row['name'];
            $source="images/{$product_image_name}";
            echo "<img src='{$source}' class='product-img-thumb' data-img-id='{$row['id']}' />";
        }
    }else{ echo "No images."; }
echo "</div>";

echo "<div class='col-md-5'>";
 
    echo "<div class='product-detail'>Price:</div>";
    echo "<h4 class='m-b-10px price-description'>&#36;" . number_format($p['price'], 2, '.', ',') . "</h4>";
 
    echo "<div class='product-detail'>Product description:</div>";
    echo "<div class='m-b-10px'>";
        // make html
        $page_description = htmlspecialchars_decode(htmlspecialchars_decode($p['description']));
 
        // show to user
        echo $page_description;
    echo "</div>";
 
    echo "<div class='product-detail'>Product category:</div>";
    echo "<div class='m-b-10px'>{$p['category_name']}</div>";
 
echo "</div>";
// content will be here
 
// include page footer HTML
include_once 'layout_foot.php';
?>