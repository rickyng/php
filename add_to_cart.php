<?php
// parameters
$product_id = isset($_GET['id']) ? $_GET['id'] : "";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;
 
// make quantity a minimum of 1
$quantity=$quantity<=0 ? 1 : $quantity;
 
// connect to database
include 'config/database.php';
 
// include object
include_once "objects/cart_item.php";
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$cart_item = new CartItem($db);


 
// check if the item is in the cart, if it is, do not add
if($cart_item->readBy('product_id', $product_id)){
    // redirect to product list and tell the user it was added to cart
    header("Location: cart.php?action=exists");
}
 
// else, add the item to cart
else{
    // add to cart
    $add_entry = array();
    $add_entry['user_id']='1'; // we default to '1' because we do not have logged in user
    $add_entry['product_id']=$product_id;
    $add_entry['quantity']=$quantity;
    if($cart_item->create($add_entry)){
        // redirect to product list and tell the user it was added to cart
        header("Location: products.php?id={$product_id}&action=added");
    }else{
        header("Location: products.php?id={$product_id}&action=unable_to_add");
    }
}
?>