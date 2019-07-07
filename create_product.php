<?php
// include database and object files
include_once 'config/core.php';
include_once 'config/database.php';
include_once 'objects/product.php';
include_once 'objects/category.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// pass connection to objects
$product = new Product($db);
$category = new Category($db);

// set page headers
$page_title = "Create Product";
include_once "layout_header.php";
 
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>Read Products</a>";
echo "</div>";
 
?>
<?php 
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
 
    // set product property values
	$request = array();
	foreach ($product->get_edit_column() as $key )
	{
		$request[$key] = $_POST[$key];
	}
	
    // create the product
    if($product->create($request)){
        echo "<div class='alert alert-success'>Product was created.</div>";
		// try to upload the submitted file
		// uploadPhoto() method will return an error message, if any.
		//echo $product->uploadPhoto();
    }
 
    // if unable to create the product, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create product.</div>";
    }
}
?>
 
<!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
 
    <table class='table table-hover table-responsive table-bordered'>
	<?php
		foreach ($product->get_all_column() as $element) {
            if ($element != $product->get_primary_key()) {
                echo "<tr>";
                echo "<td>{$element}</td>";
                echo "<td><input type='text' name='{$element}' class='form-control' /></td>";
                echo "</tr>";    
            }
		}
		?>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>
 
    </table>
</form>
<?php
 
// footer
include_once "layout_footer.php";
?>