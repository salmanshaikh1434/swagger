<?php
class spiritsslh{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readSlh($getlistnum){
		$query = "select * from slh where slh.listnum = $getlistnum and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedSlh($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from slh where listnum > 0 and tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}
	
	function getSlhNumbers(){
		$query = "select listnum,listname,descript from slh where isdel = 0 order by listname";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getSlh($getlistnum,$records_per_page){
			$query = "select * from slh where slh.listnum >= $getlistnum and isdel = 0 order by listnum LIMIT ?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);	
			$stmt->execute();
		return $stmt;
	}

	function updateSlh(){
		

		$query = "INSERT INTO slh (listnum,listname,`by`,descript,type,promo,onsale,reprice,store,status,start,stop,cases,sales,profit,who,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:listnum,:listname,:by,:descript,:type,:promo,:onsale,:reprice,:store,:status,:start,:stop,:cases,:sales,:profit,:who,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		listname = :listname,
		`by` = :by,
		descript = :descript,
		type = :type,
		promo = :promo,
		onsale = :onsale,
		reprice = :reprice,
		store = :store,
		status = :status,
		start = :start,
		stop = :stop,
		cases = :cases,
		sales = :sales,
		profit = :profit,
		who = :who,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->listnum=strip_tags($this->listnum);
		$this->listname=strip_tags($this->listname);
		$this->by=strip_tags($this->by);
		$this->descript=strip_tags($this->descript);
		$this->type=strip_tags($this->type);
		$this->promo=strip_tags($this->promo);
		$this->onsale=strip_tags($this->onsale);
		$this->reprice=strip_tags($this->reprice);
		$this->store=strip_tags($this->store);
		$this->status=strip_tags($this->status);
		$this->start=strip_tags($this->start);
		$this->stop=strip_tags($this->stop);
		$this->cases=strip_tags($this->cases);
		$this->sales=strip_tags($this->sales);
		$this->profit=strip_tags($this->profit);
		$this->who=strip_tags($this->who);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':listnum', $this->listnum);
		$stmt->bindParam(':listname', $this->listname);
		$stmt->bindParam(':by', $this->by);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':type', $this->type);
		$stmt->bindParam(':promo', $this->promo);
		$stmt->bindParam(':onsale', $this->onsale);
		$stmt->bindParam(':reprice', $this->reprice);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':start', $this->start);
		$stmt->bindParam(':stop', $this->stop);
		$stmt->bindParam(':cases', $this->cases);
		$stmt->bindParam(':sales', $this->sales);
		$stmt->bindParam(':profit', $this->profit);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':sent', $this->sent);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':isdel', $this->isdel);


		if($stmt->execute()){	
			if($this->isdel == 1){
				$stmt1 = $this->conn->prepare("UPDATE sll SET isdel = 1 WHERE listnum = :listnum");
				$stmt1->bindParam(':listnum', $this->listnum);
				if ($stmt1->execute()) {
					return 'OK';
				} else {
					$stmtError = $stmt->errorInfo();
					return $stmtError;
				}
			}else{
					return 'OK';
				}
			
		}else{
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}
}		
?>
