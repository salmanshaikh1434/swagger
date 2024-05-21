<?php
class spiritsreports{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readReports($getcrepname){
		$query = "select * from reports where reports.crepname = $getcrepname and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedReports($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from reports where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getReports($getcrepname,$records_per_page){
			$query = "select * from reports where isdel = 0";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateReports(){
		$query = "INSERT INTO reports (crepname,creptype,cappname,crptname,rundate,runwho,class,level,gph,criteria,mquery,who,parent,`key`,image,descript,editable,tstamp,isdel,lreg,lstore)
			VALUES 
		(:crepname,:creptype,:cappname,:crptname,:rundate,:runwho,:class,:level,:gph,:criteria,:mquery,:who,:parent,:key,:image,:descript,:editable,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		creptype = :creptype,
		cappname = :cappname,
		crptname = :crptname,
		rundate = :rundate,
		runwho = :runwho,
		class = :class,
		level = :level,
		gph = :gph,
		criteria = :criteria,
		mquery = :mquery,
		who = :who,
		parent = :parent,
		`key` = :key,
		image = :image,
		descript = :descript,
		editable = :editable,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->crepname=strip_tags($this->crepname);
		$this->creptype=strip_tags($this->creptype);
		$this->cappname=strip_tags($this->cappname);
		$this->crptname=strip_tags($this->crptname);
		$this->rundate=strip_tags($this->rundate);
		$this->runwho=strip_tags($this->runwho);
		$this->class=strip_tags($this->class);
		$this->level=strip_tags($this->level);
		$this->gph=strip_tags($this->gph);
		$this->criteria=strip_tags($this->criteria);
		$this->mquery=strip_tags($this->mquery);
		$this->who=strip_tags($this->who);
		$this->parent=strip_tags($this->parent);
		$this->key=strip_tags($this->key);
		$this->image=strip_tags($this->image);
		$this->descript=strip_tags($this->descript);
		$this->editable=strip_tags($this->editable);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':crepname', $this->crepname);
		$stmt->bindParam(':creptype', $this->creptype);
		$stmt->bindParam(':cappname', $this->cappname);
		$stmt->bindParam(':crptname', $this->crptname);
		$stmt->bindParam(':rundate', $this->rundate);
		$stmt->bindParam(':runwho', $this->runwho);
		$stmt->bindParam(':class', $this->class);
		$stmt->bindParam(':level', $this->level);
		$stmt->bindParam(':gph', $this->gph);
		$stmt->bindParam(':criteria', $this->criteria);
		$stmt->bindParam(':mquery', $this->mquery);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':parent', $this->parent);
		$stmt->bindParam(':key', $this->key);
		$stmt->bindParam(':image', $this->image);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':editable', $this->editable);
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
