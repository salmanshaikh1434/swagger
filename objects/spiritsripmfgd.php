<?php
class spiritsripmfgd{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function getUpdatedRipmfgd($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from ripmfgd where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getRipmfgd($get,$records_per_page){
		/* changed by salman to resolve sql syntax error
			$query = "select * from ripmfgd where ripmfgd. and isdel = 0 order by  LIMIT ?"; */
			$query = "select * from ripmfgd where isdel = 0  LIMIT ?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);	
			$stmt->execute();
		return $stmt;
	}

	function updateRipmfgd(){
		$query = "INSERT INTO ripmfgd (bdnumber,store,ponumber,line,sku,vid,name,sname,pack,oqty,coqty,amount,orddate,recdate,rec,bdorrips,tstamp,isdel,lreg,lstore)
			VALUES 
		(:bdnumber,:store,:ponumber,:line,:sku,:vid,:name,:sname,:pack,:oqty,:coqty,:amount,:orddate,:recdate,:rec,:bdorrips,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		bdnumber = :bdnumber,
		store = :store,
		ponumber = :ponumber,
		line = :line,
		sku = :sku,
		vid = :vid,
		name = :name,
		sname = :sname,
		pack = :pack,
		oqty = :oqty,
		coqty = :coqty,
		amount = :amount,
		orddate = :orddate,
		recdate = :recdate,
		rec = :rec,
		bdorrips = :bdorrips,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->bdnumber=strip_tags($this->bdnumber);
		$this->store=strip_tags($this->store);
		$this->ponumber=strip_tags($this->ponumber);
		$this->line=strip_tags($this->line);
		$this->sku=strip_tags($this->sku);
		$this->vid=strip_tags($this->vid);
		$this->name=strip_tags($this->name);
		$this->sname=strip_tags($this->sname);
		$this->pack=strip_tags($this->pack);
		$this->oqty=strip_tags($this->oqty);
		$this->coqty=strip_tags($this->coqty);
		$this->amount=strip_tags($this->amount);
		$this->orddate=strip_tags($this->orddate);
		$this->recdate=strip_tags($this->recdate);
		$this->rec=strip_tags($this->rec);
		$this->bdorrips=strip_tags($this->bdorrips);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':bdnumber', $this->bdnumber);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':ponumber', $this->ponumber);
		$stmt->bindParam(':line', $this->line);
		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':vid', $this->vid);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':sname', $this->sname);
		$stmt->bindParam(':pack', $this->pack);
		$stmt->bindParam(':oqty', $this->oqty);
		$stmt->bindParam(':coqty', $this->coqty);
		$stmt->bindParam(':amount', $this->amount);
		$stmt->bindParam(':orddate', $this->orddate);
		$stmt->bindParam(':recdate', $this->recdate);
		$stmt->bindParam(':rec', $this->rec);
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
		
?>
