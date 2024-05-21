<?php
class spiritscrd{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readCrd($getorder){
		$query = "select * from crd where crd.order = $getorder and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedCrd($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from crd where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getCrd($getorder,$records_per_page){
			$query = "select * from crd where isdel = 0 order by order";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateCrd(){
		$query = "INSERT INTO crd (`order`,line,crdoradj,creditpaid,crdpaydate,crdpaynbr,who,tstamp,isdel,lreg,lstore)
			VALUES 
		(:order,:line,:crdoradj,:creditpaid,:crdpaydate,:crdpaynbr,:who,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		line = :line,
		crdoradj = :crdoradj,
		creditpaid = :creditpaid,
		crdpaydate = :crdpaydate,
		crdpaynbr = :crdpaynbr,
		who = :who,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->order=strip_tags($this->order);
		$this->line=strip_tags($this->line);
		$this->crdoradj=strip_tags($this->crdoradj);
		$this->creditpaid=strip_tags($this->creditpaid);
		$this->crdpaydate=strip_tags($this->crdpaydate);
		$this->crdpaynbr=strip_tags($this->crdpaynbr);
		$this->who=strip_tags($this->who);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':order', $this->order);
		$stmt->bindParam(':line', $this->line);
		$stmt->bindParam(':crdoradj', $this->crdoradj);
		$stmt->bindParam(':creditpaid', $this->creditpaid);
		$stmt->bindParam(':crdpaydate', $this->crdpaydate);
		$stmt->bindParam(':crdpaynbr', $this->crdpaynbr);
		$stmt->bindParam(':who', $this->who);
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
