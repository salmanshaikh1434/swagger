<?php
class spiritstrm{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readTrm($getterms){
		$query = "select * from trm where terms = $getterms and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedTrm($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from trm where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getTrm($getterms,$records_per_page){
			$query = "select * from trm where isdel = 0";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateTrm(){
		$query = "INSERT INTO trm (terms,descript,priority,invoice,credit,purchase,vcredit,netdays,billby,dueday1,dueday2,who,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:terms,:descript,:priority,:invoice,:credit,:purchase,:vcredit,:netdays,:billby,:dueday1,:dueday2,:who,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		terms = :terms,
		descript = :descript,
		priority = :priority,
		invoice = :invoice,
		credit = :credit,
		purchase = :purchase,
		vcredit = :vcredit,
		netdays = :netdays,
		billby = :billby,
		dueday1 = :dueday1,
		dueday2 = :dueday2,
		who = :who,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->terms=strip_tags($this->terms);
		$this->descript=strip_tags($this->descript);
		$this->priority=strip_tags($this->priority);
		$this->invoice=strip_tags($this->invoice);
		$this->credit=strip_tags($this->credit);
		$this->purchase=strip_tags($this->purchase);
		$this->vcredit=strip_tags($this->vcredit);
		$this->netdays=strip_tags($this->netdays);
		$this->billby=strip_tags($this->billby);
		$this->dueday1=strip_tags($this->dueday1);
		$this->dueday2=strip_tags($this->dueday2);
		$this->who=strip_tags($this->who);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':terms', $this->terms);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':priority', $this->priority);
		$stmt->bindParam(':invoice', $this->invoice);
		$stmt->bindParam(':credit', $this->credit);
		$stmt->bindParam(':purchase', $this->purchase);
		$stmt->bindParam(':vcredit', $this->vcredit);
		$stmt->bindParam(':netdays', $this->netdays);
		$stmt->bindParam(':billby', $this->billby);
		$stmt->bindParam(':dueday1', $this->dueday1);
		$stmt->bindParam(':dueday2', $this->dueday2);
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
