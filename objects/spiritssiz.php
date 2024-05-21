<?php
class spiritssiz{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readSiz($getml){
		$query = "select * from siz where siz.ml = $getml and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedSiz($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from siz where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getSiz($getml,$records_per_page){
			$query = "select * from siz where isdel = 0 order by ml";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateSiz(){
		$query = "INSERT INTO siz (ml,name,pack,oz,who,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:ml,:name,:pack,:oz,:who,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		name = :name,
		pack = :pack,
		oz = :oz,
		who = :who,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->ml=strip_tags($this->ml);
		$this->name=strip_tags($this->name);
		$this->pack=strip_tags($this->pack);
		$this->oz=strip_tags($this->oz);
		$this->who=strip_tags($this->who);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':ml', $this->ml);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':pack', $this->pack);
		$stmt->bindParam(':oz', $this->oz);
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
