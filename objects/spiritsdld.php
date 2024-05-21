<?php
class spiritsdld{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readDld($getdealnum){
		$query = "select * from dld where dld.dealnum = $getdealnum and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedDld($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from dld where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getDld($getdealnum,$records_per_page){
			$query = "select * from DLD where dld.dealnum > $getdealnum and isdel = 0 order by dealnum LIMIT ?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);	
			$stmt->execute();
		return $stmt;
	}

	function updateDld(){
		$query = "INSERT INTO dld (dealnum,line,sku,name,sname,pack,ml,vendor,vcode,vid,startdate,stopdate,frontline,disc1,disc2,disc3,disc4,disc5,invoiclevl,accumlevl,qtytodate,qtyonorder,security,stores,who,activlevel,tstamp,isdel,lreg,lstore)
			VALUES 
		(:dealnum,:line,:sku,:name,:sname,:pack,:ml,:vendor,:vcode,:vid,:startdate,:stopdate,:frontline,:disc1,:disc2,:disc3,:disc4,:disc5,:invoiclevl,:accumlevl,:qtytodate,:qtyonorder,:security,:stores,:who,:activlevel,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		line = :line,
		sku = :sku,
		name = :name,
		sname = :sname,
		pack = :pack,
		ml = :ml,
		vendor = :vendor,
		vcode = :vcode,
		vid = :vid,
		startdate = :startdate,
		stopdate = :stopdate,
		frontline = :frontline,
		disc1 = :disc1,
		disc2 = :disc2,
		disc3 = :disc3,
		disc4 = :disc4,
		disc5 = :disc5,
		invoiclevl = :invoiclevl,
		accumlevl = :accumlevl,
		qtytodate = :qtytodate,
		qtyonorder = :qtyonorder,
		security = :security,
		stores = :stores,
		who = :who,
		activlevel = :activlevel,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->dealnum=strip_tags($this->dealnum);
		$this->line=strip_tags($this->line);
		$this->sku=strip_tags($this->sku);
		$this->name=strip_tags($this->name);
		$this->sname=strip_tags($this->sname);
		$this->pack=strip_tags($this->pack);
		$this->ml=strip_tags($this->ml);
		$this->vendor=strip_tags($this->vendor);
		$this->vcode=strip_tags($this->vcode);
		$this->vid=strip_tags($this->vid);
		$this->startdate=strip_tags($this->startdate);
		$this->stopdate=strip_tags($this->stopdate);
		$this->frontline=strip_tags($this->frontline);
		$this->disc1=strip_tags($this->disc1);
		$this->disc2=strip_tags($this->disc2);
		$this->disc3=strip_tags($this->disc3);
		$this->disc4=strip_tags($this->disc4);
		$this->disc5=strip_tags($this->disc5);
		$this->invoiclevl=strip_tags($this->invoiclevl);
		$this->accumlevl=strip_tags($this->accumlevl);
		$this->qtytodate=strip_tags($this->qtytodate);
		$this->qtyonorder=strip_tags($this->qtyonorder);
		$this->security=strip_tags($this->security);
		$this->stores=strip_tags($this->stores);
		$this->who=strip_tags($this->who);
		$this->activlevel=strip_tags($this->activlevel);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':dealnum', $this->dealnum);
		$stmt->bindParam(':line', $this->line);
		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':sname', $this->sname);
		$stmt->bindParam(':pack', $this->pack);
		$stmt->bindParam(':ml', $this->ml);
		$stmt->bindParam(':vendor', $this->vendor);
		$stmt->bindParam(':vcode', $this->vcode);
		$stmt->bindParam(':vid', $this->vid);
		$stmt->bindParam(':startdate', $this->startdate);
		$stmt->bindParam(':stopdate', $this->stopdate);
		$stmt->bindParam(':frontline', $this->frontline);
		$stmt->bindParam(':disc1', $this->disc1);
		$stmt->bindParam(':disc2', $this->disc2);
		$stmt->bindParam(':disc3', $this->disc3);
		$stmt->bindParam(':disc4', $this->disc4);
		$stmt->bindParam(':disc5', $this->disc5);
		$stmt->bindParam(':invoiclevl', $this->invoiclevl);
		$stmt->bindParam(':accumlevl', $this->accumlevl);
		$stmt->bindParam(':qtytodate', $this->qtytodate);
		$stmt->bindParam(':qtyonorder', $this->qtyonorder);
		$stmt->bindParam(':security', $this->security);
		$stmt->bindParam(':stores', $this->stores);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':activlevel', $this->activlevel);
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
