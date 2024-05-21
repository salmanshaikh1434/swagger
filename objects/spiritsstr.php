<?php
class spiritsstr{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function getUpdatedStr($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from str where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getStr($get,$records_per_page){
			$query = "select * from str where isdel = 0";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateStr(){
		$query = "INSERT INTO str (store,name,tstamp,isdel,lreg,lstore)
			VALUES 
		(:store,:name,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		name = :name,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->store=strip_tags($this->store);
		$this->name=strip_tags($this->name);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':isdel', $this->isdel);


		if($stmt->execute()){	
			return 'OK';
		}else{
			$stmtError = $stmt->errorInfo();
		return $stmtError;
		}
	}
}
		
?>
