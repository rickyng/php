<?php
// include classes
include_once "config/database.php";
include_once "objects/cart_item.php";
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$cart_item = new CartItem($db);
 
// remove all cart item by user, from database
$where = array();
$where['user_id']='1';
$cart_item->delete($cart_item->where_clause($where));
 
// set page title
$page_title="Thank You!";
 
// include page header HTML
include_once 'layout_head.php';
 
echo "<div class='col-md-12'>";
    // tell the user order has been placed
    echo "<div class='alert alert-success'>";
        echo "<strong>Your order has been placed!</strong> Thank you very much!";
    echo "</div>";
echo "</div>";
 
// include page footer HTML
include_once 'layout_foot.php';