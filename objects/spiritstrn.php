<?php
class spiritstrn{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function getUpdatedTrn($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from trn where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getTrn($get,$records_per_page){
			// $query = "select * from trn where isdel = 0 order by  LIMIT ?";
			// added tstamp to orderby -by salman
			$query = "select * from trn where isdel = 0 order by tstamp LIMIT ?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);	
			$stmt->execute();
		return $stmt;
	}
	
	function readtrncus($getcustomer){
			$query = "select * from trn where `account` = $getcustomer";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function getlastTransact($getStore,$getRegister){
			$query = "select COALESCE(max(transact),0) as transact from trn where isdel = 0 and store = $getStore and register = $getRegister";
			$stmt = $this->conn->prepare($query); 	
			$stmt->execute();
		return $stmt;
	}

	function updateTrn()
	{
		$query = "INSERT INTO trn (`source`,account,tdate,adate,transact,document,type,lamount,ramount,balance,checkno,clear,status,excode,store,department,glaccount,who,skipstat,memo,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:source,:account,:tdate,:adate,:transact,:document,:type,:lamount,:ramount,:balance,:checkno,:clear,:status,:excode,:store,:department,:glaccount,:who,:skipstat,:memo,:sent,now(),:isdel,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`source` = :source,
		account = :account,
		tdate = :tdate,
		adate = :adate,
		document = :document,
		type = :type,
		lamount = :lamount,
		ramount = :ramount,
		balance = :balance,
		checkno = :checkno,
		clear = :clear,
		status = :status,
		excode = :excode,
		department = :department,
		glaccount = :glaccount,
		who = :who,
		skipstat = :skipstat,
		memo = :memo,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";
		// register = :register";

		$stmt = $this->conn->prepare($query);
		$this->source = strip_tags($this->source);
		$this->account = strip_tags($this->account);
		$this->tdate = strip_tags($this->tdate);
		$this->adate = strip_tags($this->adate);
		$this->transact = strip_tags($this->transact);
		$this->document = strip_tags($this->document);
		$this->type = strip_tags($this->type);
		$this->lamount = strip_tags($this->lamount);
		$this->ramount = strip_tags($this->ramount);
		$this->balance = strip_tags($this->balance);
		$this->checkno = strip_tags($this->checkno);
		$this->clear = strip_tags($this->clear);
		$this->status = strip_tags($this->status);
		$this->excode = strip_tags($this->excode);
		$this->store = strip_tags($this->store);
		$this->department = strip_tags($this->department);
		$this->glaccount = strip_tags($this->glaccount);
		$this->who = strip_tags($this->who);
		$this->skipstat = strip_tags($this->skipstat);
		$this->memo = strip_tags($this->memo);
		$this->sent = strip_tags($this->sent);
		$this->lreg = strip_tags($this->lreg);
		$this->lstore = strip_tags($this->lstore);
		$this->isdel = strip_tags($this->isdel);
		// $this->register = strip_tags($this->register);

		$stmt->bindParam(':source', $this->source);
		$stmt->bindParam(':account', $this->account);
		$stmt->bindParam(':tdate', $this->tdate);
		$stmt->bindParam(':adate', $this->adate);
		$stmt->bindParam(':transact', $this->transact);
		$stmt->bindParam(':document', $this->document);
		$stmt->bindParam(':type', $this->type);
		$stmt->bindParam(':lamount', $this->lamount);
		$stmt->bindParam(':ramount', $this->ramount);
		$stmt->bindParam(':balance', $this->balance);
		$stmt->bindParam(':checkno', $this->checkno);
		$stmt->bindParam(':clear', $this->clear);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':excode', $this->excode);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':department', $this->department);
		$stmt->bindParam(':glaccount', $this->glaccount);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':skipstat', $this->skipstat);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':sent', $this->sent);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':isdel', $this->isdel);
		// $stmt->bindParam(':register', $this->register);

		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	function updateTrnReg(){
		$query = "INSERT INTO trn (`source`,account,tdate,adate,transact,document,type,lamount,ramount,balance,checkno,clear,status,excode,store,department,glaccount,who,skipstat,memo,sent,tstamp,isdel,lreg,lstore,register)
			VALUES 
		(:source,:account,:tdate,:adate,:transact,:document,:type,:lamount,:ramount,:balance,:checkno,:clear,:status,:excode,:store,:department,:glaccount,:who,:skipstat,:memo,:sent,now(),:isdel,:lreg,:lstore,:register)
		ON DUPLICATE KEY UPDATE
		`source` = :source,
		account = :account,
		tdate = :tdate,
		adate = :adate,
		document = :document,
		type = :type,
		lamount = :lamount,
		ramount = :ramount,
		balance = :balance,
		checkno = :checkno,
		clear = :clear,
		status = :status,
		excode = :excode,
		department = :department,
		glaccount = :glaccount,
		who = :who,
		skipstat = :skipstat,
		memo = :memo,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->source=strip_tags($this->source);
		$this->account=strip_tags($this->account);
		$this->tdate=strip_tags($this->tdate);
		$this->adate=strip_tags($this->adate);
		$this->transact=strip_tags($this->transact);
		$this->document=strip_tags($this->document);
		$this->type=strip_tags($this->type);
		$this->lamount=strip_tags($this->lamount);
		$this->ramount=strip_tags($this->ramount);
		$this->balance=strip_tags($this->balance);
		$this->checkno=strip_tags($this->checkno);
		$this->clear=strip_tags($this->clear);
		$this->status=strip_tags($this->status);
		$this->excode=strip_tags($this->excode);
		$this->store=strip_tags($this->store);
		$this->department=strip_tags($this->department);
		$this->glaccount=strip_tags($this->glaccount);
		$this->who=strip_tags($this->who);
		$this->skipstat=strip_tags($this->skipstat);
		$this->memo=strip_tags($this->memo);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);
		$this->register=strip_tags($this->register);

		$stmt->bindParam(':source', $this->source);
		$stmt->bindParam(':account', $this->account);
		$stmt->bindParam(':tdate', $this->tdate);
		$stmt->bindParam(':adate', $this->adate);
		$stmt->bindParam(':transact', $this->transact);
		$stmt->bindParam(':document', $this->document);
		$stmt->bindParam(':type', $this->type);
		$stmt->bindParam(':lamount', $this->lamount);
		$stmt->bindParam(':ramount', $this->ramount);
		$stmt->bindParam(':balance', $this->balance);
		$stmt->bindParam(':checkno', $this->checkno);
		$stmt->bindParam(':clear', $this->clear);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':excode', $this->excode);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':department', $this->department);
		$stmt->bindParam(':glaccount', $this->glaccount);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':skipstat', $this->skipstat);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':sent', $this->sent);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':isdel', $this->isdel);
		$stmt->bindParam(':register', $this->register);

		if($stmt->execute()){
			$query2 = "update cus set `balance` = `balance` + :balance where customer = :account";
			$stmt = $this->conn->prepare($query2);
			$this->account=strip_tags($this->account);
			$this->balance=strip_tags($this->balance);
			
			$stmt->bindParam(':balance', $this->balance);
			$stmt->bindParam(':account', $this->account);
			if($stmt->execute()){
				return 'OK';
			}else{
				$stmtError = $stmt->errorInfo();
				return $stmtError;
			}
		}else{
			$stmtError = $stmt->errorInfo();
		return $stmtError;
		}
	}


}
		
?>
