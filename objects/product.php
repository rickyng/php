<?php
include_once('db_object.php');

class Product extends db_object{

    // object properties
    public function __construct($db){
		// all column in table
		$all_column = array('id', 
			'name' , 
			'description' , 
			'price', 
			'created', 
			'modified' );
		// editable column, used for update/ create
		$editable_column = array( 'name' , 
			'description' , 
			'price' );
		parent::__construct($db, 'products');
		parent::set_primary_key('id');
		parent::set_all_column($all_column);
		parent::set_edit_column($editable_column);
    }
	
}
?>