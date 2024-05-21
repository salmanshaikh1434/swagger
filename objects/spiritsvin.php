<?php
class spiritsvin{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readVin($getyear){
		$query = "select * from vin where vin.year = $getyear and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedVin($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from vin where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getVin($getyear,$records_per_page){
			$query = "select * from vin where isdel = 0 order by year";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateVin(){
		$query = "INSERT INTO vin (sku,vintage,freeform1,freeform2,freeform3,freeform4,memo,who,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:sku,:vintage,:freeform1,:freeform2,:freeform3,:freeform4,:memo,:who,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		sku = :sku,
		vintage = :vintage,
		freeform1 = :freeform1,
		freeform2 = :freeform2,
		freeform3 = :freeform3,
		freeform4 = :freeform4,
		memo = :memo,
		who = :who,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->sku=strip_tags($this->sku);
		$this->vintage=strip_tags($this->vintage);
		$this->freeform1=strip_tags($this->freeform1);
		$this->freeform2=strip_tags($this->freeform2);
		$this->freeform3=strip_tags($this->freeform3);
		$this->freeform4=strip_tags($this->freeform4);
		$this->memo=strip_tags($this->memo);
		$this->who=strip_tags($this->who);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':vintage', $this->vintage);
		$stmt->bindParam(':freeform1', $this->freeform1);
		$stmt->bindParam(':freeform2', $this->freeform2);
		$stmt->bindParam(':freeform3', $this->freeform3);
		$stmt->bindParam(':freeform4', $this->freeform4);
		$stmt->bindParam(':memo', $this->memo);
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
