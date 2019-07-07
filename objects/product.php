<?php
include('db_object.php');

class Product extends db_object{

    // object properties
    public function __construct($db){
		// all column in table
		$all_column = array('seq', 
			'Collection' , 
			'Description' , 
			'Selling_EXW_USD_1000pc', 
			'Item_code_AW19', 
			'Item_type' );
		// editable column, used for update/ create
		$editable_column = array( 'Collection' , 
			'Description' , 
			'Selling_EXW_USD_1000pc', 
			'Item_code_AW19', 
			'Item_type' );
		parent::__construct($db, 'master2');
		parent::set_primary_key('seq');
		parent::set_all_column($all_column);
		parent::set_edit_column($editable_column);
    }
	
}
?>