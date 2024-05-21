<?php
class spiritstxc{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readTxc($getcode){
		$query = "select * from txc where txc.code = $getcode and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedTxc($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from txc where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getTxc($getcode,$records_per_page){
			$query = "select * from txc where isdel = 0";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateTxc(){
		$query = "INSERT INTO txc (code,level,descript,rate,cat,`table`,who,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:code,:level,:descript,:rate,:cat,:table,:who,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		level = :level,
		descript = :descript,
		rate = :rate,
		cat = :cat,
		`table` = :table,
		who = :who,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->code=strip_tags($this->code);
		$this->level=strip_tags($this->level);
		$this->descript=strip_tags($this->descript);
		$this->rate=strip_tags($this->rate);
		$this->cat=strip_tags($this->cat);
		$this->table=strip_tags($this->table);
		$this->who=strip_tags($this->who);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':code', $this->code);
		$stmt->bindParam(':level', $this->level);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':rate', $this->rate);
		$stmt->bindParam(':cat', $this->cat);
		$stmt->bindParam(':table', $this->table);
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
