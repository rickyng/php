<?php
include_once('db_object.php');

class User extends db_object{

    // object properties
    public function __construct($db){
		// all column in table
		$all_column = array('id',
			'first_name', 
			'last_name' , 
			'email' , 
			'contact_number', 
			'address', 
			'access_level',
			'access_code',
            'status',
            'created',
            'modified');
		// editable column, used for update/ create
		$editable_column = array( 'first_name', 
            'last_name' , 
            'email' , 
            'contact_number', 
            'address', 
            'access_level',
            'access_code',
            'status');
		parent::__construct($db, 'user');
		parent::set_primary_key('id');
		parent::set_all_column($all_column);
		parent::set_edit_column($editable_column);
    }
	
}
?>