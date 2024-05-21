<?php
class spiritsohd{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function getUpdatedOhd($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from ohd where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedOhdReg($getCustomer){
			$query = "SELECT `order`,`store`,`status`,`orddate`,`promdate`,`shipdate`,`invdate`,`total` from ohd where `customer` = $getCustomer AND `isdel`=0";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}

	function readBackCusOhd($getCustomer){
			$query = "SELECT `order`,`status`,`orddate`,`promdate`,`shipdate`,`invdate`,`total`,`store`,`lreg`,`tstamp` from ohd where `customer` = $getCustomer and isdel = 0 order by `status`";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}
		

	function getUpdatedOhdOrder($getOrder,$getStore){
			$query = "SELECT `order`,store,customer,shipto,contact,phone,status,orddate,promdate,shipdate,invdate,agedate,whosold,whoorder,whoship,whoinvoice,terms,shipvia,taxcode,total,
			printmemo,shipmemo,memo from ohd where `order` = $getOrder and ohd.store = $getStore";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;	
		}
    // updated to resolve rptsync issue by salman
	function getOhd($getPage,$records_per_page){
		    $query = "select * from ohd where isdel = 0 order by tstamp LIMIT ?,?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $getPage, PDO::PARAM_INT);
		    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
			$stmt->execute();
		    return $stmt;
	}



	function updateOhd(){
		$query = "INSERT INTO ohd (`order`,store,customer,shipto,contact,phone,status,orddate,promdate,shipdate,invdate,agedate,whosold,whoorder,whoship,whoinvoice,terms,shipvia,taxcode,total,transact,printmemo,who,shipmemo,memo,creditcard,expire,cvv,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:order,:store,:customer,:shipto,:contact,:phone,:status,:orddate,:promdate,:shipdate,:invdate,:agedate,:whosold,:whoorder,:whoship,:whoinvoice,:terms,:shipvia,:taxcode,:total,:transact,:printmemo,:who,:shipmemo,:memo,'','','',:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		customer=:customer,
		shipto=:shipto,
		contact=:contact,
		phone=:phone,
		status=:status,
		-- orddate=:orddate,
		-- promdate=:promdate,
		shipdate=:shipdate,
		invdate=:invdate,
		agedate=:agedate,
		whosold=:whosold,
		whoorder=:whoorder,
		whoship=:whoship,
		whoinvoice=:whoinvoice,
		terms=:terms,
		shipvia=:shipvia,
		taxcode=:taxcode,
		total=:total,
		transact=:transact,
		printmemo=:printmemo,
		who=:who,
		shipmemo=:shipmemo,
		memo=:memo,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->order=strip_tags($this->order);
		$this->store=strip_tags($this->store);
		$this->customer=strip_tags($this->customer);
		$this->shipto=strip_tags($this->shipto);
		$this->contact=strip_tags($this->contact);
		$this->phone=strip_tags($this->phone);
		$this->status=strip_tags($this->status);
		$this->orddate=strip_tags($this->orddate);
		$this->promdate=strip_tags($this->promdate);
		$this->shipdate=strip_tags($this->shipdate);
		$this->invdate=strip_tags($this->invdate);
		$this->agedate=strip_tags($this->agedate);
		$this->whosold=strip_tags($this->whosold);
		$this->whoorder=strip_tags($this->whoorder);
		$this->whoship=strip_tags($this->whoship);
		$this->whoinvoice=strip_tags($this->whoinvoice);
		$this->terms=strip_tags($this->terms);
		$this->shipvia=strip_tags($this->shipvia);
		$this->taxcode=strip_tags($this->taxcode);
		$this->total=strip_tags($this->total);
		$this->transact=strip_tags($this->transact);
		$this->printmemo=strip_tags($this->printmemo);
		$this->who=strip_tags($this->who);
		$this->shipmemo=strip_tags($this->shipmemo);
		$this->memo=strip_tags($this->memo);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':order', $this->order);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':customer', $this->customer);
		$stmt->bindParam(':shipto', $this->shipto);
		$stmt->bindParam(':contact', $this->contact);
		$stmt->bindParam(':phone', $this->phone);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':orddate', $this->orddate);
		$stmt->bindParam(':promdate', $this->promdate);
		$stmt->bindParam(':shipdate', $this->shipdate);
		$stmt->bindParam(':invdate', $this->invdate);
		$stmt->bindParam(':agedate', $this->agedate);
		$stmt->bindParam(':whosold', $this->whosold);
		$stmt->bindParam(':whoorder', $this->whoorder);
		$stmt->bindParam(':whoship', $this->whoship);
		$stmt->bindParam(':whoinvoice', $this->whoinvoice);
		$stmt->bindParam(':terms', $this->terms);
		$stmt->bindParam(':shipvia', $this->shipvia);
		$stmt->bindParam(':taxcode', $this->taxcode);
		$stmt->bindParam(':total', $this->total);
		$stmt->bindParam(':transact', $this->transact);
		$stmt->bindParam(':printmemo', $this->printmemo);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':shipmemo', $this->shipmemo);
		$stmt->bindParam(':memo', $this->memo);
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