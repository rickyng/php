<?php
include_once('db_object.php');

class Category extends db_object{

    // object properties
    public function __construct($db){
		// all column in table
		$all_column = array('seq_awb',
			'seq_master', 
			'collection' , 
			'description' , 
			'item_code', 
			'time', 
			'sub_time',
			'awb_no',
			'status');
		// editable column, used for update/ create
		$editable_column = array( 'seq_master', 
			'collection' , 
			'description' , 
			'item_code', 
			'time', 
			'sub_time',
			'awb_no',
			'status' );
		parent::__construct($db, 'awb2');
		parent::set_primary_key('seq_awb');
		parent::set_all_column($all_column);
		parent::set_edit_column($editable_column);
    }
	
}
?>