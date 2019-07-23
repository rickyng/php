<?php
include_once('db_object.php');

class ProductImage extends db_object{

    // object properties
    public function __construct($db){
		// all column in table
		$all_column = array('id', 
			'product_id' , 
			'name' , 
			'created', 
			'modified' );
		// editable column, used for update/ create
		$editable_column = array( 'product_id' , 
            'name' );
		parent::__construct($db, 'product_images');
		parent::set_primary_key('id');
		parent::set_all_column($all_column);
		parent::set_edit_column($editable_column);
    }
	
}
?>