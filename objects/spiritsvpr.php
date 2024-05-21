<?php
class spiritsvpr{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function getUpdatedVpr($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from vpr where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getVpr($get,$records_per_page){
			$query = "select * from vpr where isdel = 0 order by  LIMIT ?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);	
			$stmt->execute();
		return $stmt;
	}

	function updateVpr(){
		$query = "INSERT INTO vpr (brand,ml,vintage,bestbot,date,pack,vend,vid,upc,frontline,postoff,mixcode,ripcode,qty1,corb1,prc1,qty2,corb2,prc2,qty3,corb3,prc3,qty4,corb4,prc4,qty5,corb5,prc5,qty6,corb6,prc6,tstamp,isdel,lreg,lstore)
			VALUES 
		(:brand,:ml,:vintage,:bestbot,:date,:pack,:vend,:vid,:upc,:frontline,:postoff,:mixcode,:ripcode,:qty1,:corb1,:prc1,:qty2,:corb2,:prc2,:qty3,:corb3,:prc3,:qty4,:corb4,:prc4,:qty5,:corb5,:prc5,:qty6,:corb6,:prc6,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		bestbot = :bestbot,
		date = :date,
		pack = :pack,
		vend = :vend,
		vid = :vid,
		upc = :upc,
		frontline = :frontline,
		postoff = :postoff,
		mixcode = :mixcode,
		ripcode = :ripcode,
		qty1 = :qty1,
		corb1 = :corb1,
		prc1 = :prc1,
		qty2 = :qty2,
		corb2 = :corb2,
		prc2 = :prc2,
		qty3 = :qty3,
		corb3 = :corb3,
		prc3 = :prc3,
		qty4 = :qty4,
		corb4 = :corb4,
		prc4 = :prc4,
		qty5 = :qty5,
		corb5 = :corb5,
		prc5 = :prc5,
		qty6 = :qty6,
		corb6 = :corb6,
		prc6 = :prc6,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->brand=strip_tags($this->brand);
		$this->ml=strip_tags($this->ml);
		$this->vintage=strip_tags($this->vintage);
		$this->bestbot=strip_tags($this->bestbot);
		$this->date=strip_tags($this->date);
		$this->pack=strip_tags($this->pack);
		$this->vend=strip_tags($this->vend);
		$this->vid=strip_tags($this->vid);
		$this->upc=strip_tags($this->upc);
		$this->frontline=strip_tags($this->frontline);
		$this->postoff=strip_tags($this->postoff);
		$this->mixcode=strip_tags($this->mixcode);
		$this->ripcode=strip_tags($this->ripcode);
		$this->qty1=strip_tags($this->qty1);
		$this->corb1=strip_tags($this->corb1);
		$this->prc1=strip_tags($this->prc1);
		$this->qty2=strip_tags($this->qty2);
		$this->corb2=strip_tags($this->corb2);
		$this->prc2=strip_tags($this->prc2);
		$this->qty3=strip_tags($this->qty3);
		$this->corb3=strip_tags($this->corb3);
		$this->prc3=strip_tags($this->prc3);
		$this->qty4=strip_tags($this->qty4);
		$this->corb4=strip_tags($this->corb4);
		$this->prc4=strip_tags($this->prc4);
		$this->qty5=strip_tags($this->qty5);
		$this->corb5=strip_tags($this->corb5);
		$this->prc5=strip_tags($this->prc5);
		$this->qty6=strip_tags($this->qty6);
		$this->corb6=strip_tags($this->corb6);
		$this->prc6=strip_tags($this->prc6);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':brand', $this->brand);
		$stmt->bindParam(':ml', $this->ml);
		$stmt->bindParam(':vintage', $this->vintage);
		$stmt->bindParam(':bestbot', $this->bestbot);
		$stmt->bindParam(':date', $this->date);
		$stmt->bindParam(':pack', $this->pack);
		$stmt->bindParam(':vend', $this->vend);
		$stmt->bindParam(':vid', $this->vid);
		$stmt->bindParam(':upc', $this->upc);
		$stmt->bindParam(':frontline', $this->frontline);
		$stmt->bindParam(':postoff', $this->postoff);
		$stmt->bindParam(':mixcode', $this->mixcode);
		$stmt->bindParam(':ripcode', $this->ripcode);
		$stmt->bindParam(':qty1', $this->qty1);
		$stmt->bindParam(':corb1', $this->corb1);
		$stmt->bindParam(':prc1', $this->prc1);
		$stmt->bindParam(':qty2', $this->qty2);
		$stmt->bindParam(':corb2', $this->corb2);
		$stmt->bindParam(':prc2', $this->prc2);
		$stmt->bindParam(':qty3', $this->qty3);
		$stmt->bindParam(':corb3', $this->corb3);
		$stmt->bindParam(':prc3', $this->prc3);
		$stmt->bindParam(':qty4', $this->qty4);
		$stmt->bindParam(':corb4', $this->corb4);
		$stmt->bindParam(':prc4', $this->prc4);
		$stmt->bindParam(':qty5', $this->qty5);
		$stmt->bindParam(':corb5', $this->corb5);
		$stmt->bindParam(':prc5', $this->prc5);
		$stmt->bindParam(':qty6', $this->qty6);
		$stmt->bindParam(':corb6', $this->corb6);
		$stmt->bindParam(':prc6', $this->prc6);
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
