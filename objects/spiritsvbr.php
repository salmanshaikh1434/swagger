<?php
class spiritsvbr{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function getUpdatedVbr($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from vbr where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getVbr($get,$records_per_page){
			$query = "select * from vbr where isdel = 0 order by  LIMIT ?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);	
			$stmt->execute();
		return $stmt;
	}

	function updateVbr(){
		$query = "INSERT INTO vbr (vtype,brand,ml,vintage,sname,descript,bestbot1,bestvend1,bestbot2,bestvend2,updown,proof,firstdate,lastdate,sku,vendors,clearflag,dummy,tstamp,isdel,lreg,lstore)
			VALUES 
		(:vtype,:brand,:ml,:vintage,:sname,:descript,:bestbot1,:bestvend1,:bestbot2,:bestvend2,:updown,:proof,:firstdate,:lastdate,:sku,:vendors,:clearflag,:dummy,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		vtype = :vtype,
		sname = :sname,
		descript = :descript,
		bestbot1 = :bestbot1,
		bestvend1 = :bestvend1,
		bestbot2 = :bestbot2,
		bestvend2 = :bestvend2,
		updown = :updown,
		proof = :proof,
		firstdate = :firstdate,
		lastdate = :lastdate,
		sku = :sku,
		vendors = :vendors,
		clearflag = :clearflag,
		dummy = :dummy,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->vtype=strip_tags($this->vtype);
		$this->brand=strip_tags($this->brand);
		$this->ml=strip_tags($this->ml);
		$this->vintage=strip_tags($this->vintage);
		$this->sname=strip_tags($this->sname);
		$this->descript=strip_tags($this->descript);
		$this->bestbot1=strip_tags($this->bestbot1);
		$this->bestvend1=strip_tags($this->bestvend1);
		$this->bestbot2=strip_tags($this->bestbot2);
		$this->bestvend2=strip_tags($this->bestvend2);
		$this->updown=strip_tags($this->updown);
		$this->proof=strip_tags($this->proof);
		$this->firstdate=strip_tags($this->firstdate);
		$this->lastdate=strip_tags($this->lastdate);
		$this->sku=strip_tags($this->sku);
		$this->vendors=strip_tags($this->vendors);
		$this->clearflag=strip_tags($this->clearflag);
		$this->dummy=strip_tags($this->dummy);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':vtype', $this->vtype);
		$stmt->bindParam(':brand', $this->brand);
		$stmt->bindParam(':ml', $this->ml);
		$stmt->bindParam(':vintage', $this->vintage);
		$stmt->bindParam(':sname', $this->sname);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':bestbot1', $this->bestbot1);
		$stmt->bindParam(':bestvend1', $this->bestvend1);
		$stmt->bindParam(':bestbot2', $this->bestbot2);
		$stmt->bindParam(':bestvend2', $this->bestvend2);
		$stmt->bindParam(':updown', $this->updown);
		$stmt->bindParam(':proof', $this->proof);
		$stmt->bindParam(':firstdate', $this->firstdate);
		$stmt->bindParam(':lastdate', $this->lastdate);
		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':vendors', $this->vendors);
		$stmt->bindParam(':clearflag', $this->clearflag);
		$stmt->bindParam(':dummy', $this->dummy);
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
