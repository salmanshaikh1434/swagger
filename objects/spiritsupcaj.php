<?php
class spiritsupc{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readUpc($getupc){
		$query = "select * from upc where upc.upc = $getupc and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedUpc($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from upc where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getUpc($getsku,$records_per_page){
			$query = "select * from upc where upc.sku = $getsku and isdel = 0 order by sku LIMIT ?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);	
			$stmt->execute();
			
		return $stmt;
	}


			function getupc1(){
			$query = "select * from upc where upc.sku =$this->sku and upc.upc =$this->upc";
			$stmt = $this->conn->prepare($query); 
			
			$u=$stmt->execute();
			
		return $stmt;
	}
	
	function updatesdateUpc(){
			$query = "update upc set `last` = :last,tstamp = now(),lstore =:lstore,lreg= :lreg,who = :who, isdel = 0 where sku = :sku and upc = :upc and :last > `last`";
			$stmt = $this->conn->prepare($query); 
			$this->upc=strip_tags($this->upc);
			$this->last=strip_tags($this->last);
			$this->sku=strip_tags($this->sku);
			$this->who=strip_tags($this->who);
			$this->lreg=strip_tags($this->lreg);
			$this->lstore=strip_tags($this->lstore);
			$stmt->bindParam(':upc', $this->upc);
			$stmt->bindParam(':last', $this->last);
			$stmt->bindParam(':sku', $this->sku);
			$stmt->bindParam(':who', $this->who);
			$stmt->bindParam(':lreg', $this->lreg);
			$stmt->bindParam(':lstore', $this->lstore);
			if($stmt->execute()){	
				return 'OK';
			}else{
				$stmtError = $stmt->errorInfo();
			return $stmtError;
			}
		return $stmt;
	}

	//by sumeeth for update
	function updatesdateUpc1(){

			$query = "update upc set `last` = :last,tstamp = now(),lstore =:lstore,lreg= :lreg,who = :who, isdel = :isdel where sku = :sku and upc = :upc";
			$stmt = $this->conn->prepare($query); 
			$this->upc=strip_tags($this->upc);
			$this->last=strip_tags($this->last);
			$this->sku=strip_tags($this->sku);
			$this->who=strip_tags($this->who);
			$this->lreg=strip_tags($this->lreg);
			$this->lstore=strip_tags($this->lstore);
			$this->isdel=strip_tags($this->isdel);
			$stmt->bindParam(':upc', $this->upc);
			$stmt->bindParam(':last', $this->last);
			$stmt->bindParam(':sku', $this->sku);
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
		return $stmt;
	}

	function updateUpc(){

		$query = "INSERT INTO upc (upc,level,last,sku,who,sent,gosent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:upc,:level,:last,:sku,:who,:sent,:gosent,now(),:isdel,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		level = :level,
		last = :last,
		who = :who,
		sent = :sent,
		gosent = :gosent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
	
		$this->upc=strip_tags($this->upc);
		$this->level=strip_tags($this->level);
		$this->last=strip_tags($this->last);
		$this->sku=strip_tags($this->sku);
		$this->who=strip_tags($this->who);
		$this->sent=strip_tags($this->sent);
		$this->gosent=strip_tags($this->gosent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':upc', $this->upc);
		$stmt->bindParam(':level', $this->level);
		$stmt->bindParam(':last', $this->last);
		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':sent', $this->sent);
		$stmt->bindParam(':gosent', $this->gosent);
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
