<?php
class spiritsprc
{
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	function readPrc($getsku)
	{
		$query = "select * from prc where prc.sku = $getsku and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedPrc($getTstamp, $startingRecord, $records_per_page)
	{
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from prc where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getPrc($getsku, $records_per_page)
	{
		$query = "select * from prc where prc.sku >= $getsku and isdel = 0 order by sku LIMIT ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function updatePrc()
	{
		/*$price = strip_tags($this->price);
			  $query1= "SELECT count(*) from prc  where price = '$price'";
			  $stmt1 =  $this->conn->prepare($query1);
			  $stmt1->execute();
			  $count = $stmt1->fetchColumn();
			   if ($count > 0) {
				   exit;
			   }*/

		$query = "INSERT INTO prc (sku,level,qty,price,promo,onsale,labels,store,who,dcode,sale,sent,gosent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:sku,:level,:qty,:price,:promo,:onsale,:labels,:store,:who,:dcode,:sale,:sent,:gosent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		level = :level,
		qty = :qty,
		price = :price,
		promo = :promo,
		onsale = :onsale,
		labels = :labels,
		store = :store,
		who = :who,
		dcode = :dcode,
		sale = :sale,
		sent = :sent,
		gosent = :gosent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->sku = strip_tags($this->sku);
		$this->level = strip_tags($this->level);
		$this->qty = strip_tags($this->qty);
		$this->price = strip_tags($this->price);
		$this->promo = strip_tags($this->promo);
		$this->onsale = strip_tags($this->onsale);
		$this->labels = strip_tags($this->labels);
		$this->store = strip_tags($this->store);
		$this->who = strip_tags($this->who);
		$this->dcode = strip_tags($this->dcode);
		$this->sale = strip_tags($this->sale);
		$this->sent = strip_tags($this->sent);
		$this->gosent = strip_tags($this->gosent);
		$this->lreg = strip_tags($this->lreg);
		$this->lstore = strip_tags($this->lstore);
		$this->isdel = strip_tags($this->isdel);

		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':level', $this->level);
		$stmt->bindParam(':qty', $this->qty);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':promo', $this->promo);
		$stmt->bindParam(':onsale', $this->onsale);
		$stmt->bindParam(':labels', $this->labels);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':dcode', $this->dcode);
		$stmt->bindParam(':sale', $this->sale);
		$stmt->bindParam(':sent', $this->sent);
		$stmt->bindParam(':gosent', $this->gosent);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':isdel', $this->isdel);


		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}
}

?>