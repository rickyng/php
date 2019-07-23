<?php


class db_object{
 
    // database connection and table name
    private $conn;
	
	private $table_name;
	public $primary_key;
	public $table_column;
	public $edit_column;
    
    // object properties
    public function __construct($db, $name){
		$this->conn = $db;
		$this->table_name = $name;
	}
	
	public function get_primary_key() {
		return $this->primary_key;
	}

	public function get_all_column(){	
		return $this->table_column;
	}

	public function get_edit_column(){
		return $this->edit_column;
	}
	
	public function set_primary_key($primary_key) {
		$this->primary_key = $primary_key;
	}

	public function set_all_column($all_column){	
		$this->table_column = $all_column;
	}

	public function set_edit_column($edit_column){
		$this->edit_column = $edit_column;
	}

	
	// create db_object
    public function create($request){
		$array = array();
		foreach ($request as $key => $value)
		{
			$checked_value = htmlspecialchars(strip_tags($value));
			$array[] = $key. " = '". $checked_value."'";
			echo $key. " = '". $checked_value."'<br>";
		}
		$comma_separated = implode(",", $array);


        //write query
	
		$query = "INSERT INTO " . $this->table_name . " SET " . $comma_separated ;
		
        $stmt = $this->conn->prepare($query);
 
    
        if($stmt->execute()){
            return true;
        }else{
			print_r($stmt->errorInfo());
            return false;
        }
 
    }


	public function readAll($from_record_num, $records_per_page){
		$comma_separated = implode(",", $this->get_all_column());

		
		$query = "SELECT " . $comma_separated. " FROM " . $this->table_name . 
			" ORDER BY ".$this->get_primary_key(). " ASC LIMIT {$from_record_num}, {$records_per_page}";
	 
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		$items = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$local = array();
			foreach ($this->get_all_column() as $element)
				$local[$element]  = $row[$element];
			$items[] = $local;
				
		}
				
	 
		return $items;
	}
	
	// used for paging db_objects
	public function countAll(){
	 
		$query = "SELECT ".$this->get_primary_key()."  FROM " . $this->table_name . "";
 
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
	 
		$num = $stmt->rowCount();
	 
		return $num;
	}
	
	public function readBy($key, $value){
		return $this->searchByOption($key. " = '". $value. "'", 0 , 0);
	}

	public function readOne($id){
		return $this->readBy($this->get_primary_key(), $id)[0];
	}

	public function update($where_clause, $request){
		$array = array();
		foreach ($request as $key => $value)
		{
			$checked_value = htmlspecialchars(strip_tags($value));
			$array[] = $key. " = '". $checked_value."'";
		}
		$comma_separated = implode(",", $array);

		
		$query = "UPDATE " . $this->table_name . " SET ". $comma_separated. 
				" WHERE ".$where_clause;
		$stmt = $this->conn->prepare($query);
	 
		echo $query. "<br>";
		// execute the query
		if($stmt->execute()){
			return true;
		}
		//echo 'Error occurred:'.implode(":",$this->conn->errorInfo());
		return false;
		 
	}
	
	// delete the db_object
	public function delete($where){		
		$query = "DELETE FROM " . $this->table_name . " WHERE ".$where;
		 
		$stmt = $this->conn->prepare($query);
		return $stmt->execute();
	}
	
	// read db_objects by search term
	public function search( $search_term, $from_record_num = 0 , $records_per_page =0 ) {
		return $this->searchByOption($this->where_clause($search_term), $from_record_num, $records_per_page);
	}
	
	public function countAll_BySearch($search_term) {
		return sizeof($this->serach($search_term));
	}

	public function where_clause( $search_term, $option = ' = ',  $conjuction = "AND"){
		$where= array();
		foreach ( $search_term as $key => $value)
		{
			$where[] = $key. " " .$option ." '".  $value . "'";
		}		
		$where_clause = implode(" ". $conjuction. " ", $where);
		return $where_clause;
	}

	private function searchByOption ( $where_clause, $from_record_num, $records_per_page ) {

		$comma_separated = implode(",", $this->table_column);
		$limit_by = "";
		if (  $records_per_page != 0 )
		{
			$limit_by = " ASC LIMIT {$from_record_num}, {$records_per_page}";
		}
		$query = "SELECT " . $comma_separated. " FROM " . $this->table_name . 
			" WHERE " . $where_clause.
			" ORDER BY ". $this->get_primary_key(). $limit_by;
		
			
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	 
		// execute query
		if(!$stmt->execute())
			$this->conn->error;
		
		$items = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$local = array();
			foreach ($this->table_column as $element)
				$local[$element]  = $row[$element];
			$items[] = $local;
				
		}
		
		return $items;
	}


	
}
?>