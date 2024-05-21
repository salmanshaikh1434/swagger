<?php
class spiritsglrpt{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function getUpdatedGlrpt($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from glrpt where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getGlrpt($get,$records_per_page){
			$query = "select * from glrpt where isdel = 0 order by  LIMIT ?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);	
			$stmt->execute();
		return $stmt;
	}

	function updateGlrpt(){
		$query = "INSERT INTO glrpt (rname,porb,sequence,glaccount,grouplevel,descript,print,indent,underline,skipline,security,who,tstamp,isdel,lreg,lstore)
			VALUES 
		(:rname,:porb,:sequence,:glaccount,:grouplevel,:descript,:print,:indent,:underline,:skipline,:security,:who,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		porb = :porb,
		sequence = :sequence,
		glaccount = :glaccount,
		grouplevel = :grouplevel,
		descript = :descript,
		print = :print,
		indent = :indent,
		underline = :underline,
		skipline = :skipline,
		security = :security,
		who = :who,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->rname=strip_tags($this->rname);
		$this->porb=strip_tags($this->porb);
		$this->sequence=strip_tags($this->sequence);
		$this->glaccount=strip_tags($this->glaccount);
		$this->grouplevel=strip_tags($this->grouplevel);
		$this->descript=strip_tags($this->descript);
		$this->print=strip_tags($this->print);
		$this->indent=strip_tags($this->indent);
		$this->underline=strip_tags($this->underline);
		$this->skipline=strip_tags($this->skipline);
		$this->security=strip_tags($this->security);
		$this->who=strip_tags($this->who);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':rname', $this->rname);
		$stmt->bindParam(':porb', $this->porb);
		$stmt->bindParam(':sequence', $this->sequence);
		$stmt->bindParam(':glaccount', $this->glaccount);
		$stmt->bindParam(':grouplevel', $this->grouplevel);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':print', $this->print);
		$stmt->bindParam(':indent', $this->indent);
		$stmt->bindParam(':underline', $this->underline);
		$stmt->bindParam(':skipline', $this->skipline);
		$stmt->bindParam(':security', $this->security);
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
	}
}
		
?>
