<?php
class spiritstxt{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readTxt($gettable){
		$query = "select * from txt where txt.table = $gettable and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedTxt($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from txt where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getTxt($gettable,$records_per_page){
			$query = "select * from txt where isdel = 0";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateTxt(){
		$query = "INSERT INTO txt (`table`,cutoff,tax,who,`sent`,tstamp,isdel,lreg,lstore)
			VALUES 
		(:table,:cutoff,:tax,:who,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		cutoff = :cutoff,
		tax = :tax,
		who = :who,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->table=strip_tags($this->table);
		$this->cutoff=strip_tags($this->cutoff);
		$this->tax=strip_tags($this->tax);
		$this->who=strip_tags($this->who);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':table', $this->table);
		$stmt->bindParam(':cutoff', $this->cutoff);
		$stmt->bindParam(':tax', $this->tax);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':sent', $this->sent);
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
