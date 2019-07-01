<?php
class Product{
 
    // database connection and table name
    private $conn;
	public $primary_key = 'seq';
	private $table_name;

	public $table_column;
    
    // object properties
    public function __construct($db, $name, $column){
        $this->conn = $db;
		$this->table_name = $name;
		$this->table_column = $column;
    }
 
	// create product

    function create($request){
		$array = array();
		foreach ($request as $key => $value)
		{
			$checked_value = htmlspecialchars(strip_tags($value));
			$array[] = $key. " = '". $checked_value."'";
		}
		$comma_separated = implode(",", $array);
		echo $id ."<br>";
		

        //write query
	
		$query = "INSERT INTO " . $this->table_name . " SET " . $comma_separated ;
	
        $stmt = $this->conn->prepare($query);
 
    
        if($stmt->execute()){
            return true;
        }else{
			echo $stmt->error;
            return false;
        }
 
    }


	public function readAll($from_record_num, $records_per_page){
		
		$order_by = 'Collection';
		$comma_separated = implode(",", $this->table_column);

		$items = array();
		$query = "SELECT " . $comma_separated. " FROM " . $this->table_name . 
			" ORDER BY ". $order_by. " ASC LIMIT {$from_record_num}, {$records_per_page}";
	 
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$local = array();
			foreach ($this->table_column as $element)
				$local[$element]  = $row[$element];
			$items[] = $local;
				
		}
				
	 
		return $items;
	}
	
	// used for paging products
	public function countAll(){
	 
		$query = "SELECT seq  FROM " . $this->table_name . "";
 
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
	 
		$num = $stmt->rowCount();
	 
		return $num;
	}
	
	function readOne($id){
		
		$comma_separated = implode(",", $this->table_column);

		$query = "SELECT ". $comma_separated . " FROM " . $this->table_name . 
			" WHERE seq = ? LIMIT 0,1";
		echo $query.'<br>';
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $id);
		$stmt->execute();
	 
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$result = array();
		foreach ($this->table_column as $element)
		{
			echo $element. '  '. $row[$element].'<br>';
			$result[$element] = $row[$element];
		}
		return $result;
	}
	
	function update($id, $request){
		$array = array();
		foreach ($request as $key => $value)
		{
			$checked_value = htmlspecialchars(strip_tags($value));
			$array[] = $key. " = '". $checked_value."'";
		}
		$comma_separated = implode(",", $array);
		echo $id ."<br>";
		
		$query = "UPDATE " . $this->table_name . " SET ". $comma_separated. 
				" WHERE seq = ". $id;
		echo $query."<br>";
		$stmt = $this->conn->prepare($query);
	 
		
		// execute the query
		if($stmt->execute()){
			return true;
		}
		echo $stmt->error;
		return false;
		 
	}
	
	// delete the product
	function delete($id){
	 
		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
		 
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $id);
	 
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// read products by search term
	function search($search_term, $from_record_num, $records_per_page){
	 
		$order_by = 'Collection';
		$comma_separated = implode(",", $this->table_column);
		$where= array();
		foreach ( $this->table_column as $key => $value)
		{
			$where[] = $value.  " LIKE '".  $search_term . "'";
		}		
		$where_clause = implode(" OR ", $where);
		$query = "SELECT " . $comma_separated. " FROM " . $this->table_name . 
			" WHERE " . $where_clause .
			" ORDER BY ". $order_by. " ASC LIMIT {$from_record_num}, {$records_per_page}";
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	 
		// execute query
		if(!$stmt->execute())
			echo "stmt->error";
		
		$items = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$local = array();
			foreach ($this->table_column as $element)
				$local[$element]  = $row[$element];
			$items[] = $local;
				
		}
				
	 
		return $items;
	}
	 
	public function countAll_BySearch($search_term){
	 
		$order_by = 'Collection';
		$comma_separated = implode(",", $this->table_column);
		$where= array();
		foreach ($this->table_column as $key => $value)
		{
			$where[] = $value.  " LIKE '".  $search_term . "'";
		}		
		$where_clause = implode(" OR ", $where);
		$query = "SELECT " . $comma_separated. " FROM " . $this->table_name . 
			" WHERE " . $where_clause .
			" ORDER BY ". $order_by;
		echo $query."<br>";
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	 
		// execute query
		if(!$stmt->execute()) 
			echo "$stmt->error";
		
		
		return $stmt->rowCount();
	}
	
	// will upload image file to server
	function uploadPhoto(){
	 
		$result_message="";
	 
		// now, if image is not empty, try to upload the image
		if($this->image){
	 
			// sha1_file() function is used to make a unique file name
			$target_directory = "uploads/";
			$target_file = $target_directory . $this->image;
			$file_type = pathinfo($target_file, PATHINFO_EXTENSION);
	 
			// error message is empty
			$file_upload_error_messages="";
			
			// make sure that file is a real image
			$check = getimagesize($_FILES["image"]["tmp_name"]);
			if($check!==false){
				// submitted file is an image
			}else{
				$file_upload_error_messages.="<div>Submitted file is not an image.</div>";
			}
			 
			// make sure certain file types are allowed
			$allowed_file_types=array("jpg", "jpeg", "png", "gif");
			if(!in_array($file_type, $allowed_file_types)){
				$file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
			}
			 
			// make sure file does not exist
			if(file_exists($target_file)){
				$file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
			}
			 
			// make sure submitted file is not too large, can't be larger than 1 MB
			if($_FILES['image']['size'] > (1024000)){
				$file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
			}
			 
			// make sure the 'uploads' folder exists
			// if not, create it
			if(!is_dir($target_directory)){
				mkdir($target_directory, 0777, true);
			}
			
			// if $file_upload_error_messages is still empty
			if(empty($file_upload_error_messages)){
				// it means there are no errors, so try to upload the file
				if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
					// it means photo was uploaded
				}else{
					$result_message.="<div class='alert alert-danger'>";
						$result_message.="<div>Unable to upload photo.</div>";
						$result_message.="<div>Update the record to upload photo.</div>";
					$result_message.="</div>";
				}
			}
			 
			// if $file_upload_error_messages is NOT empty
			else{
				// it means there are some errors, so show them to user
				$result_message.="<div class='alert alert-danger'>";
					$result_message.="{$file_upload_error_messages}";
					$result_message.="<div>Update the record to upload photo.</div>";
				$result_message.="</div>";
			}
	 
		}
	 
		return $result_message;
	}
}
?>