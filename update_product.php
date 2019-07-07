<?php
// get ID of the product to be edited
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
$product = new Product($db);
$category = new Category($db);
 
// read the details of product to be edited
$result = $product->readOne($id);
 
  
// set page header
$page_title = "Update Product";
include_once "layout_header.php";
 
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>Read Products</a>";
echo "</div>";
 
?>
<?php 
// if the form was submitted
if($_POST){
	$changed = array();
	foreach ($result as $key => $value) {
		if ( $value !=  $_POST[$key]) {
			$changed[$key] = $_POST[$key];
			$result[$key] = $_POST[$key];
		}

	}


    
    // update the product
    if($product->update($id, $changed)){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Product was updated.";
        echo "</div>";
    }
 
    // if unable to update the product, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update product.";
        echo "</div>";
    }
}
?>
 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
	
	<?php
	foreach ($result as $key => $value)
	{
		echo "<tr>";
		echo "<td>{$key}</td>";
		echo "<td><input type='text' name='{$key}' value='{$value}' class='form-control' /></td>";
		echo "</tr>";
	}
    ?>
		<tr>
			<td></td>
			<td>
				<button type="submit" class="btn btn-primary">Update</button>
			</td>
		</tr>
    </table>
</form>

<?php

 
// set page footer
include_once "layout_footer.php";
?>