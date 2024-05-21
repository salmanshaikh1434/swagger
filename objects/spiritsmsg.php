<?php
class spiritsmsg{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readMsg($getmnumber){
		$query = "select * from msg where msg.mnumber = $getmnumber and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedMsg($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from msg where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getMsg($getmnumber,$records_per_page){
			$query = "select * from msg where isdel = 0";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateMsg(){
		$query = "INSERT INTO msg (mcode,mnumber,active,mtop,mbottom,who,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:mcode,:mnumber,:active,:mtop,:mbottom,:who,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		mcode = :mcode,
		active = :active,
		mtop = :mtop,
		mbottom = :mbottom,
		who = :who,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->mcode=strip_tags($this->mcode);
		$this->mnumber=strip_tags($this->mnumber);
		$this->active=strip_tags($this->active);
		$this->mtop=strip_tags($this->mtop);
		$this->mbottom=strip_tags($this->mbottom);
		$this->who=strip_tags($this->who);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':mcode', $this->mcode);
		$stmt->bindParam(':mnumber', $this->mnumber);
		$stmt->bindParam(':active', $this->active);
		$stmt->bindParam(':mtop', $this->mtop);
		$stmt->bindParam(':mbottom', $this->mbottom);
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
