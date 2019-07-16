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

    // check if given email exist in the database
      function emailExists($email){
            $search = array();
            $search['email'] = $email;
            $result = parent::search($search, 0 , 5);
           
            if (sizeof($result) > 0 ){
                  return true;
            }
            
            // return false if email does not exist in the database
            return false;
      }

      // used in forgot password feature
      function updateAccessCode($email, $access_code){
            $search = array();
            $search['email'] = $email;
            $result = parent::search($search, 0 , 5);
            if (sizeof($result) > 0){
                  
                  $id = $result[0]['id'];
                  $request = array();
                  $request['access_code']=$access_code;
                  echo $id. ' '. $access_code. ' <br> ';
                  return parent::update($id, $request);
            }
            
            return false;
      }

}
?>