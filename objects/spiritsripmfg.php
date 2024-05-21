<?php
class spiritsripmfg{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function getUpdatedRipmfg($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from ripmfg where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getRipmfg($get,$records_per_page){
			/* changed by salman to resolve sql syntax error
			$query = "select * from ripmfg where ripmfg. and isdel = 0 order by  LIMIT ?";
			*/
			$query = "select * from ripmfg where isdel = 0  LIMIT ?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);	
			$stmt->execute();
		return $stmt;
	}

	function updateRipmfg(){
		$query = "INSERT INTO ripmfg (bdnumber,store,ponumber,invoice,vcode,amount,orddate,recdate,received,bdorrips,tstamp,isdel,lreg,lstore)
			VALUES 
		(:bdnumber,:store,:ponumber,:invoice,:vcode,:amount,:orddate,:recdate,:received,:bdorrips,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		bdnumber = :bdnumber,
		store = :store,
		ponumber = :ponumber,
		invoice = :invoice,
		vcode = :vcode,
		amount = :amount,
		orddate = :orddate,
		recdate = :recdate,
		received = :received,
		bdorrips = :bdorrips,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->bdnumber=strip_tags($this->bdnumber);
		$this->store=strip_tags($this->store);
		$this->ponumber=strip_tags($this->ponumber);
		$this->invoice=strip_tags($this->invoice);
		$this->vcode=strip_tags($this->vcode);
		$this->amount=strip_tags($this->amount);
		$this->orddate=strip_tags($this->orddate);
		$this->recdate=strip_tags($this->recdate);
		$this->received=strip_tags($this->received);
		$this->bdorrips=strip_tags($this->bdorrips);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':bdnumber', $this->bdnumber);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':ponumber', $this->ponumber);
		$stmt->bindParam(':invoice', $this->invoice);
		$stmt->bindParam(':vcode', $this->vcode);
		$stmt->bindParam(':amount', $this->amount);
		$stmt->bindParam(':orddate', $this->orddate);
		$stmt->bindParam(':recdate', $this->recdate);
		$stmt->bindParam(':received', $this->received);
		$stmt->bindParam(':bdorrips', $this->bdorrips);
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
