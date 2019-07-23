<?php
// get the product id
$product_id = isset($_GET['id']) ? $_GET['id'] : "";
 
// connect to database
include 'config/database.php';
 
// include object
include_once "objects/cart_item.php";
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$cart_item = new CartItem($db);
 
// remove cart item from database

$where = array();
$where['user_id'] ='1';
$where['product_id'] = $product_id;

$cart_item->delete($cart_item->where_clause($where));
 
// redirect to product list and tell the user it was added to cart
header('Location: cart.php?action=removed&id=' . $id);
?>