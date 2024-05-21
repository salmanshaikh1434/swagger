<?php
class spiritsnewupc{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readNewupc($getupc){
		$query = "select * from newupc where newupc.upc = $getupc and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedNewupc($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from newupc where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getNewupc($getupc,$records_per_page){
			$query = "select * from newupc where isdel = 0";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateNewupc(){
		$query = "INSERT INTO newupc (upc,price,descr,cat,qty,hits,who,salenumber,ddate,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:upc,:price,:descr,:cat,:qty,:hits,:who,:salenumber,:ddate,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		price = :price,
		descr = :descr,
		cat = :cat,
		qty = :qty,
		hits = :hits,
		who = :who,
		salenumber = :salenumber,
		ddate = :ddate,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->upc=strip_tags($this->upc);
		$this->price=strip_tags($this->price);
		$this->descr=strip_tags($this->descr);
		$this->cat=strip_tags($this->cat);
		$this->qty=strip_tags($this->qty);
		$this->hits=strip_tags($this->hits);
		$this->who=strip_tags($this->who);
		$this->salenumber=strip_tags($this->salenumber);
		$this->ddate=strip_tags($this->ddate);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':upc', $this->upc);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':descr', $this->descr);
		$stmt->bindParam(':cat', $this->cat);
		$stmt->bindParam(':qty', $this->qty);
		$stmt->bindParam(':hits', $this->hits);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':salenumber', $this->salenumber);
		$stmt->bindParam(':ddate', $this->ddate);
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
