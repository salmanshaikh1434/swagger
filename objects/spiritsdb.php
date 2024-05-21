<?php
class spiritsdb{
	private $conn;
	
    public function __construct($db){
        $this->conn = $db;
    }

	public function countrecs($thisTable){
		$query = "SELECT count(*) as total_rows FROM $thisTable where isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;	
	}
	
	public function countrecststamp($thisTable,$getTstamp){
		$thisDate = date('Y-m-d', strtotime($getTstamp));	
		$query = "SELECT count(*) as total_rows FROM $thisTable where tstamp >= '$thisDate'";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;	
	}
	
	
}
?>