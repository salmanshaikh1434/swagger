<?php
class spiritstyp{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readTyp($gettype){
		$query = "select * from typ where typ.type = $gettype and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedTyp($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from typ where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getTyp($gettype,$records_per_page){
			$query = "select * from typ where isdel = 0";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateTyp(){
		$query = "INSERT INTO typ (type,name,scat1,scat2,unit_case,suprof,scprof,sweeks,smin,sord,disc,ml1,uprof1,cprof1,weeks1,disc1,ml2,uprof2,cprof2,disc2,weeks2,ml3,uprof3,cprof3,weeks3,disc3,ml4,uprof4,cprof4,weeks4,disc4,ml5,uprof5,cprof5,weeks5,disc5,ml6,uprof6,cprof6,weeks6,disc6,ml7,uprof7,cprof7,weeks7,disc7,ml8,uprof8,cprof8,weeks8,disc8,who,fson,webupdate,sent,typenum,uvinseas,browseqty,outofstock,tstamp,isdel,lreg,lstore)
			VALUES 
		(:type,:name,:scat1,:scat2,:unit_case,:suprof,:scprof,:sweeks,:smin,:sord,:disc,:ml1,:uprof1,:cprof1,:weeks1,:disc1,:ml2,:uprof2,:cprof2,:disc2,:weeks2,:ml3,:uprof3,:cprof3,:weeks3,:disc3,:ml4,:uprof4,:cprof4,:weeks4,:disc4,:ml5,:uprof5,:cprof5,:weeks5,:disc5,:ml6,:uprof6,:cprof6,:weeks6,:disc6,:ml7,:uprof7,:cprof7,:weeks7,:disc7,:ml8,:uprof8,:cprof8,:weeks8,:disc8,:who,:fson,:webupdate,:sent,:typenum,:uvinseas,:browseqty,:outofstock,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		type=:type,
		name=:name,
		scat1=:scat1,
		scat2=:scat2,
		unit_case=:unit_case,
		suprof=:suprof,
		scprof=:scprof,
		sweeks=:sweeks,
		smin=:smin,
		sord=:sord,
		disc=:disc,
		ml1=:ml1,
		uprof1=:uprof1,
		cprof1=:cprof1,
		weeks1=:weeks1,
		disc1=:disc1,
		ml2=:ml2,
		uprof2=:uprof2,
		cprof2=:cprof2,
		disc2=:disc2,
		weeks2=:weeks2,
		ml3=:ml3,
		uprof3=:uprof3,
		cprof3=:cprof3,
		weeks3=:weeks3,
		disc3=:disc3,
		ml4=:ml4,
		uprof4=:uprof4,
		cprof4=:cprof4,
		weeks4=:weeks4,
		disc4=:disc4,
		ml5=:ml5,
		uprof5=:uprof5,
		cprof5=:cprof5,
		weeks5=:weeks5,
		disc5=:disc5,
		ml6=:ml6,
		uprof6=:uprof6,
		cprof6=:cprof6,
		weeks6=:weeks6,
		disc6=:disc6,
		ml7=:ml7,
		uprof7=:uprof7,
		cprof7=:cprof7,
		weeks7=:weeks7,
		disc7=:disc7,
		ml8=:ml8,
		uprof8=:uprof8,
		cprof8=:cprof8,
		weeks8=:weeks8,
		disc8=:disc8,
		who=:who,
		fson=:fson,
		webupdate=:webupdate,
		sent=:sent,
		typenum=:typenum,
		uvinseas=:uvinseas,
		browseqty=:browseqty,
		outofstock=:outofstock,
		tstamp = now(),
		isdel = :isdel,
		lreg=:lreg,
		lstore=:lstore";
		

		$stmt = $this->conn->prepare($query);

		$this->type=strip_tags($this->type);
		$this->name=strip_tags($this->name);
		$this->scat1=strip_tags($this->scat1);
		$this->scat2=strip_tags($this->scat2);
		$this->unit_case=strip_tags($this->unit_case);
		$this->suprof=strip_tags($this->suprof);
		$this->scprof=strip_tags($this->scprof);
		$this->sweeks=strip_tags($this->sweeks);
		$this->smin=strip_tags($this->smin);
		$this->sord=strip_tags($this->sord);
		$this->disc=strip_tags($this->disc);
		$this->ml1=strip_tags($this->ml1);
		$this->uprof1=strip_tags($this->uprof1);
		$this->cprof1=strip_tags($this->cprof1);
		$this->weeks1=strip_tags($this->weeks1);
		$this->disc1=strip_tags($this->disc1);
		$this->ml2=strip_tags($this->ml2);
		$this->uprof2=strip_tags($this->uprof2);
		$this->cprof2=strip_tags($this->cprof2);
		$this->disc2=strip_tags($this->disc2);
		$this->weeks2=strip_tags($this->weeks2);
		$this->ml3=strip_tags($this->ml3);
		$this->uprof3=strip_tags($this->uprof3);
		$this->cprof3=strip_tags($this->cprof3);
		$this->weeks3=strip_tags($this->weeks3);
		$this->disc3=strip_tags($this->disc3);
		$this->ml4=strip_tags($this->ml4);
		$this->uprof4=strip_tags($this->uprof4);
		$this->cprof4=strip_tags($this->cprof4);
		$this->weeks4=strip_tags($this->weeks4);
		$this->disc4=strip_tags($this->disc4);
		$this->ml5=strip_tags($this->ml5);
		$this->uprof5=strip_tags($this->uprof5);
		$this->cprof5=strip_tags($this->cprof5);
		$this->weeks5=strip_tags($this->weeks5);
		$this->disc5=strip_tags($this->disc5);
		$this->ml6=strip_tags($this->ml6);
		$this->uprof6=strip_tags($this->uprof6);
		$this->cprof6=strip_tags($this->cprof6);
		$this->weeks6=strip_tags($this->weeks6);
		$this->disc6=strip_tags($this->disc6);
		$this->ml7=strip_tags($this->ml7);
		$this->uprof7=strip_tags($this->uprof7);
		$this->cprof7=strip_tags($this->cprof7);
		$this->weeks7=strip_tags($this->weeks7);
		$this->disc7=strip_tags($this->disc7);
		$this->ml8=strip_tags($this->ml8);
		$this->uprof8=strip_tags($this->uprof8);
		$this->cprof8=strip_tags($this->cprof8);
		$this->weeks8=strip_tags($this->weeks8);
		$this->disc8=strip_tags($this->disc8);
		$this->who=strip_tags($this->who);
		$this->fson=strip_tags($this->fson);
		$this->webupdate=strip_tags($this->webupdate);
		$this->sent=strip_tags($this->sent);
		$this->typenum=strip_tags($this->typenum);
		$this->uvinseas=strip_tags($this->uvinseas);
		$this->browseqty=strip_tags($this->browseqty);
		$this->outofstock=strip_tags($this->outofstock);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);
		$stmt->bindParam(':type', $this->type);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':scat1', $this->scat1);
		$stmt->bindParam(':scat2', $this->scat2);
		$stmt->bindParam(':unit_case', $this->unit_case);
		$stmt->bindParam(':suprof', $this->suprof);
		$stmt->bindParam(':scprof', $this->scprof);
		$stmt->bindParam(':sweeks', $this->sweeks);
		$stmt->bindParam(':smin', $this->smin);
		$stmt->bindParam(':sord', $this->sord);
		$stmt->bindParam(':disc', $this->disc);
		$stmt->bindParam(':ml1', $this->ml1);
		$stmt->bindParam(':uprof1', $this->uprof1);
		$stmt->bindParam(':cprof1', $this->cprof1);
		$stmt->bindParam(':weeks1', $this->weeks1);
		$stmt->bindParam(':disc1', $this->disc1);
		$stmt->bindParam(':ml2', $this->ml2);
		$stmt->bindParam(':uprof2', $this->uprof2);
		$stmt->bindParam(':cprof2', $this->cprof2);
		$stmt->bindParam(':disc2', $this->disc2);
		$stmt->bindParam(':weeks2', $this->weeks2);
		$stmt->bindParam(':ml3', $this->ml3);
		$stmt->bindParam(':uprof3', $this->uprof3);
		$stmt->bindParam(':cprof3', $this->cprof3);
		$stmt->bindParam(':weeks3', $this->weeks3);
		$stmt->bindParam(':disc3', $this->disc3);
		$stmt->bindParam(':ml4', $this->ml4);
		$stmt->bindParam(':uprof4', $this->uprof4);
		$stmt->bindParam(':cprof4', $this->cprof4);
		$stmt->bindParam(':weeks4', $this->weeks4);
		$stmt->bindParam(':disc4', $this->disc4);
		$stmt->bindParam(':ml5', $this->ml5);
		$stmt->bindParam(':uprof5', $this->uprof5);
		$stmt->bindParam(':cprof5', $this->cprof5);
		$stmt->bindParam(':weeks5', $this->weeks5);
		$stmt->bindParam(':disc5', $this->disc5);
		$stmt->bindParam(':ml6', $this->ml6);
		$stmt->bindParam(':uprof6', $this->uprof6);
		$stmt->bindParam(':cprof6', $this->cprof6);
		$stmt->bindParam(':weeks6', $this->weeks6);
		$stmt->bindParam(':disc6', $this->disc6);
		$stmt->bindParam(':ml7', $this->ml7);
		$stmt->bindParam(':uprof7', $this->uprof7);
		$stmt->bindParam(':cprof7', $this->cprof7);
		$stmt->bindParam(':weeks7', $this->weeks7);
		$stmt->bindParam(':disc7', $this->disc7);
		$stmt->bindParam(':ml8', $this->ml8);
		$stmt->bindParam(':uprof8', $this->uprof8);
		$stmt->bindParam(':cprof8', $this->cprof8);
		$stmt->bindParam(':weeks8', $this->weeks8);
		$stmt->bindParam(':disc8', $this->disc8);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':fson', $this->fson);
		$stmt->bindParam(':webupdate', $this->webupdate);
		$stmt->bindParam(':sent', $this->sent);
		$stmt->bindParam(':typenum', $this->typenum);
		$stmt->bindParam(':uvinseas', $this->uvinseas);
		$stmt->bindParam(':browseqty', $this->browseqty);
		$stmt->bindParam(':outofstock', $this->outofstock);
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
