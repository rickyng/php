<?php
include_once('db_object.php');

class CartItem extends db_object{

    // object properties
    public function __construct($db){
		// all column in table
		$all_column = array('id', 
			'product_id' , 
            'quantity' ,
            'user_id', 
			'created', 
			'modified' );
		// editable column, used for update/ create
		$editable_column = array('product_id' , 
            'quantity' ,
            'user_id');
		parent::__construct($db, 'cart_items');
		parent::set_primary_key('id');
		parent::set_all_column($all_column);
		parent::set_edit_column($editable_column);
    }
	// check if a cart item exists
	public function exists($user_id, $product_id){
		$search = array();
		$search['user_id'] = $user_id;
		$search['product_id'] = $product_id;
		echo "Search". $user_id . "  ". $product_id. "<br>";
		$result = parent::search($search);
		foreach ($result as $row){
			echo "row<br>"  ;
		}
		return (sizeof($result) > 0);
	}
}
?>