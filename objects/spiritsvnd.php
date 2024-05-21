<?php
class spiritsvnd{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readVnd($getvendor){
		$query = "select * from vnd where vnd.vendor = $getvendor and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedVnd($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from vnd where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getVnd($getvendor,$records_per_page){
			$query = "select * from vnd where vnd.vendor > $getvendor and isdel = 0 order by vendor";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateVnd(){
		$query = "INSERT INTO vnd (vendor,firstname,lastname,vcode,street1,street2,city,state,zip,contact,phone,fax,modem,startdate,taxcode,terms,shipvia,crdlimit,balance,who,memo,includedep,sent,email,useware,inactive,gosent,taxable,tstamp,isdel,lreg,lstore)
			VALUES 
		(:vendor,:firstname,:lastname,:vcode,:street1,:street2,:city,:state,:zip,:contact,:phone,:fax,:modem,:startdate,:taxcode,:terms,:shipvia,:crdlimit,:balance,:who,:memo,:includedep,:sent,:email,:useware,:inactive,:gosent,:taxable,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		firstname = :firstname,
		lastname = :lastname,
		vcode = :vcode,
		street1 = :street1,
		street2 = :street2,
		city = :city,
		state = :state,
		zip = :zip,
		contact = :contact,
		phone = :phone,
		fax = :fax,
		modem = :modem,
		startdate = :startdate,
		taxcode = :taxcode,
		terms = :terms,
		shipvia = :shipvia,
		crdlimit = :crdlimit,
		balance = :balance,
		who = :who,
		memo = :memo,
		includedep = :includedep,
		sent = :sent,
		email = :email,
		useware = :useware,
		inactive = :inactive,
		gosent = :gosent,
		taxable = :taxable,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		qbooks= :qbooks,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->vendor=strip_tags($this->vendor);
		$this->firstname=strip_tags($this->firstname);
		$this->lastname=strip_tags($this->lastname);
		$this->vcode=strip_tags($this->vcode);
		$this->street1=strip_tags($this->street1);
		$this->street2=strip_tags($this->street2);
		$this->city=strip_tags($this->city);
		$this->state=strip_tags($this->state);
		$this->zip=strip_tags($this->zip);
		$this->contact=strip_tags($this->contact);
		$this->phone=strip_tags($this->phone);
		$this->fax=strip_tags($this->fax);
		$this->modem=strip_tags($this->modem);
		$this->startdate=strip_tags($this->startdate);
		$this->taxcode=strip_tags($this->taxcode);
		$this->terms=strip_tags($this->terms);
		$this->shipvia=strip_tags($this->shipvia);
		$this->crdlimit=strip_tags($this->crdlimit);
		$this->balance=strip_tags($this->balance);
		$this->who=strip_tags($this->who);
		$this->memo=strip_tags($this->memo);
		$this->includedep=strip_tags($this->includedep);
		$this->sent=strip_tags($this->sent);
		$this->email=strip_tags($this->email);
		$this->useware=strip_tags($this->useware);
		$this->inactive=strip_tags($this->inactive);
		$this->gosent=strip_tags($this->gosent);
		$this->taxable=strip_tags($this->taxable);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);
		$this->qbooks=strip_tags($this->qbooks);

		$stmt->bindParam(':vendor', $this->vendor);
		$stmt->bindParam(':firstname', $this->firstname);
		$stmt->bindParam(':lastname', $this->lastname);
		$stmt->bindParam(':vcode', $this->vcode);
		$stmt->bindParam(':street1', $this->street1);
		$stmt->bindParam(':street2', $this->street2);
		$stmt->bindParam(':city', $this->city);
		$stmt->bindParam(':state', $this->state);
		$stmt->bindParam(':zip', $this->zip);
		$stmt->bindParam(':contact', $this->contact);
		$stmt->bindParam(':phone', $this->phone);
		$stmt->bindParam(':fax', $this->fax);
		$stmt->bindParam(':modem', $this->modem);
		$stmt->bindParam(':startdate', $this->startdate);
		$stmt->bindParam(':taxcode', $this->taxcode);
		$stmt->bindParam(':terms', $this->terms);
		$stmt->bindParam(':shipvia', $this->shipvia);
		$stmt->bindParam(':crdlimit', $this->crdlimit);
		$stmt->bindParam(':balance', $this->balance);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':includedep', $this->includedep);
		$stmt->bindParam(':sent', $this->sent);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':useware', $this->useware);
		$stmt->bindParam(':inactive', $this->inactive);
		$stmt->bindParam(':gosent', $this->gosent);
		$stmt->bindParam(':taxable', $this->taxable);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':isdel', $this->isdel);
		$stmt->bindParam(':qbooks', $this->qbooks);

		if($stmt->execute()){	
			return 'OK';
		}else{
			$stmtError = $stmt->errorInfo();
		return $stmtError;
		}
	}
}
		
?>
