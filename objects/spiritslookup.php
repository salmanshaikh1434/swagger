<?php
class spiritslookup{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function getUpdatedLookup($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from lookup where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getLookup($get,$records_per_page){
			$query = "select * from lookup";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateLookup(){
		$query = "INSERT INTO lookup (cidkey,cname,cvalue,cdesc,tstamp,isdel,lreg,lstore)
			VALUES 
		(:cidkey,:cname,:cvalue,:cdesc,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		cname=:cname,
		cvalue=:cvalue,
		cdesc=:cdesc,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->cidkey=strip_tags($this->cidkey);
		$this->cname=strip_tags($this->cname);
		$this->cvalue=strip_tags($this->cvalue);
		$this->cdesc=strip_tags($this->cdesc);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':cidkey', $this->cidkey);
		$stmt->bindParam(':cname', $this->cname);
		$stmt->bindParam(':cvalue', $this->cvalue);
		$stmt->bindParam(':cdesc', $this->cdesc);
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
