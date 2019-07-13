<?php
include_once('db_object.php');

class User extends db_object{

    // object properties
    public function __construct($db){
		// all column in table
		$all_column = array('id',
            'firstname',
            'lastname',
            'email',
            'contact_number',
            'address',
            'password',
            'access_level',
            'access_code',
            'status',
            'created',
            'modified' );
		// editable column, used for update/ create
		$editable_column = array('firstname',
            'lastname',
            'email',
            'contact_number',
            'address',
            'password' );
		parent::__construct($db, 'users');
		parent::set_primary_key('id');
		parent::set_all_column($all_column);
		parent::set_edit_column($editable_column);
    }
	
}
?>