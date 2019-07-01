<?php

// get ID of the product to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/core.php';
include_once 'config/database.php';
include_once 'objects/product.php';
include_once 'objects/category.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$product = new Product($db, 'master2', $master2_column);
$category = new Category($db);
 
// set ID property of product to be read
$product->id = $id;
 
// read the details of product to be read
$result = $product->readOne($id);

// set page headers
$page_title = "Read One Product";
include_once "layout_header.php";
 
// read products button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Read Products";
    echo "</a>";
echo "</div>";
 
 // HTML table for displaying a product details
echo "<table class='table table-hover table-responsive table-bordered'>";
	foreach ( $result as $key => $value )
	{
		echo "<tr>";
		echo "<td>{$key}</td>";
		echo "<td>{$value}</td>";
		echo "</tr>";
	}
echo "</table>";

// set footer
include_once "layout_footer.php";
?>