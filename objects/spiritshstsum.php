<?php
class spiritshstsum{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function getUpdatedHstsum($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from hstsum where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function readHstsum($getSku,$getStore){
			if($getStore==0){
				$query = "select * from hstsum where hstsum.sku = $getSku and isdel = 0 order by year,store";
			}else{
				$query = "select * from hstsum where hstsum.sku = $getSku and isdel = 0 and hstsum.store = $getStore order by year,store";
			}
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateHstsum(){
		$query = "INSERT INTO hstsum (sku,store,year,janqty,jancost,janprice,febqty,febcost,febprice,marqty,marcost,marprice,aprqty,aprcost,aprprice,mayqty,maycost,mayprice,junqty,juncost,junprice,julqty,julcost,julprice,augqty,augcost,augprice,sepqty,sepcost,sepprice,octqty,octcost,octprice,novqty,novcost,novprice,decqty,deccost,decprice,who,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:sku,:store,:year,:janqty,:jancost,:janprice,:febqty,:febcost,:febprice,:marqty,:marcost,:marprice,:aprqty,:aprcost,:aprprice,:mayqty,:maycost,:mayprice,:junqty,:juncost,:junprice,:julqty,:julcost,:julprice,:augqty,:augcost,:augprice,:sepqty,:sepcost,:sepprice,:octqty,:octcost,:octprice,:novqty,:novcost,:novprice,:decqty,:deccost,:decprice,:who,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		janqty = janqty + :janqty,
		jancost = jancost + :jancost,
		janprice = janprice + :janprice,
		febqty = febqty + :febqty,
		febcost = febcost + :febcost,
		febprice =febprice + :febprice,
		marqty =marqty + :marqty,
		marcost =marcost + :marcost,
		marprice =marprice + :marprice,
		aprqty = aprqty + :aprqty,
		aprcost =aprcost + :aprcost,
		aprprice =aprprice+ :aprprice,
		mayqty =mayqty+ :mayqty,
		maycost =maycost+ :maycost,
		mayprice =mayprice+ :mayprice,
		junqty =junqty+ :junqty,
		juncost =juncost+ :juncost,
		junprice =junprice+ :junprice,
		julqty =julqty+ :julqty,
		julcost =julcost+ :julcost,
		julprice =julprice+ :julprice,
		augqty =augqty+ :augqty,
		augcost =augcost+ :augcost,
		augprice =augprice+ :augprice,
		sepqty =sepqty+ :sepqty,
		sepcost =sepcost+ :sepcost,
		sepprice =sepprice+ :sepprice,
		octqty =octqty+ :octqty,
		octcost =octcost+ :octcost,
		octprice =octprice+ :octprice,
		novqty =novqty+ :novqty,
		novcost =novcost+ :novcost,
		novprice =novprice+ :novprice,
		decqty =decqty+ :decqty,
		deccost =deccost+ :deccost,
		decprice =decprice+ :decprice,
		who = :who,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->sku=strip_tags($this->sku);
		$this->store=strip_tags($this->store);
		$this->year=strip_tags($this->year);
		$this->janqty=strip_tags($this->janqty);
		$this->jancost=strip_tags($this->jancost);
		$this->janprice=strip_tags($this->janprice);
		$this->febqty=strip_tags($this->febqty);
		$this->febcost=strip_tags($this->febcost);
		$this->febprice=strip_tags($this->febprice);
		$this->marqty=strip_tags($this->marqty);
		$this->marcost=strip_tags($this->marcost);
		$this->marprice=strip_tags($this->marprice);
		$this->aprqty=strip_tags($this->aprqty);
		$this->aprcost=strip_tags($this->aprcost);
		$this->aprprice=strip_tags($this->aprprice);
		$this->mayqty=strip_tags($this->mayqty);
		$this->maycost=strip_tags($this->maycost);
		$this->mayprice=strip_tags($this->mayprice);
		$this->junqty=strip_tags($this->junqty);
		$this->juncost=strip_tags($this->juncost);
		$this->junprice=strip_tags($this->junprice);
		$this->julqty=strip_tags($this->julqty);
		$this->julcost=strip_tags($this->julcost);
		$this->julprice=strip_tags($this->julprice);
		$this->augqty=strip_tags($this->augqty);
		$this->augcost=strip_tags($this->augcost);
		$this->augprice=strip_tags($this->augprice);
		$this->sepqty=strip_tags($this->sepqty);
		$this->sepcost=strip_tags($this->sepcost);
		$this->sepprice=strip_tags($this->sepprice);
		$this->octqty=strip_tags($this->octqty);
		$this->octcost=strip_tags($this->octcost);
		$this->octprice=strip_tags($this->octprice);
		$this->novqty=strip_tags($this->novqty);
		$this->novcost=strip_tags($this->novcost);
		$this->novprice=strip_tags($this->novprice);
		$this->decqty=strip_tags($this->decqty);
		$this->deccost=strip_tags($this->deccost);
		$this->decprice=strip_tags($this->decprice);
		$this->who=strip_tags($this->who);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':year', $this->year);
		$stmt->bindParam(':janqty', $this->janqty);
		$stmt->bindParam(':jancost', $this->jancost);
		$stmt->bindParam(':janprice', $this->janprice);
		$stmt->bindParam(':febqty', $this->febqty);
		$stmt->bindParam(':febcost', $this->febcost);
		$stmt->bindParam(':febprice', $this->febprice);
		$stmt->bindParam(':marqty', $this->marqty);
		$stmt->bindParam(':marcost', $this->marcost);
		$stmt->bindParam(':marprice', $this->marprice);
		$stmt->bindParam(':aprqty', $this->aprqty);
		$stmt->bindParam(':aprcost', $this->aprcost);
		$stmt->bindParam(':aprprice', $this->aprprice);
		$stmt->bindParam(':mayqty', $this->mayqty);
		$stmt->bindParam(':maycost', $this->maycost);
		$stmt->bindParam(':mayprice', $this->mayprice);
		$stmt->bindParam(':junqty', $this->junqty);
		$stmt->bindParam(':juncost', $this->juncost);
		$stmt->bindParam(':junprice', $this->junprice);
		$stmt->bindParam(':julqty', $this->julqty);
		$stmt->bindParam(':julcost', $this->julcost);
		$stmt->bindParam(':julprice', $this->julprice);
		$stmt->bindParam(':augqty', $this->augqty);
		$stmt->bindParam(':augcost', $this->augcost);
		$stmt->bindParam(':augprice', $this->augprice);
		$stmt->bindParam(':sepqty', $this->sepqty);
		$stmt->bindParam(':sepcost', $this->sepcost);
		$stmt->bindParam(':sepprice', $this->sepprice);
		$stmt->bindParam(':octqty', $this->octqty);
		$stmt->bindParam(':octcost', $this->octcost);
		$stmt->bindParam(':octprice', $this->octprice);
		$stmt->bindParam(':novqty', $this->novqty);
		$stmt->bindParam(':novcost', $this->novcost);
		$stmt->bindParam(':novprice', $this->novprice);
		$stmt->bindParam(':decqty', $this->decqty);
		$stmt->bindParam(':deccost', $this->deccost);
		$stmt->bindParam(':decprice', $this->decprice);
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
