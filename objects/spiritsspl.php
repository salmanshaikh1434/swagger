<?php
class spiritsspl{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function getUpdatedSpl($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from spl where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getSpl($get,$records_per_page){
			// $query = "select * from spl where spl. and isdel = 0 order by  LIMIT ?";
			// Added tstamp to "order by" and removed spl.  by salman
			$query = "select * from spl where isdel = 0 order by tstamp  LIMIT ?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);	
			$stmt->execute();
			return $stmt;
	}

	function readSplCus($getTransact){
			$query = "select `glaccount`,`store`,`department`,`date`,`amount`,`balance`,`transact`,`note`,`applyto` from spl where spl.transact = $getTransact or spl.applyto = $getTransact and isdel = 0 order by `line`";
			$stmt = $this->conn->prepare($query); 	
			$stmt->execute();
		        return $stmt;
	}

	function updateSpl(){
		$query = "INSERT INTO spl (glaccount,store,department,date,amount,balance,transact,applyto,clear,memo,note,line,source,account,type,document,checkno,who,skipstat,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:glaccount,:store,:department,:date,:amount,:balance,:transact,:applyto,:clear,:memo,:note,:line,:source,:account,:type,:document,:checkno,:who,:skipstat,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		glaccount = :glaccount,
		store = :store,
		department = :department,
		date = :date,
		amount = :amount,
		balance = :balance,
		applyto = :applyto,
		clear = :clear,
		memo = :memo,
		note = :note,
		source = :source,
		account = :account,
		type = :type,
		document = :document,
		checkno = :checkno,
		who = :who,
		skipstat = :skipstat,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->glaccount=strip_tags($this->glaccount);
		$this->store=strip_tags($this->store);
		$this->department=strip_tags($this->department);
		$this->date=strip_tags($this->date);
		$this->amount=strip_tags($this->amount);
		$this->balance=strip_tags($this->balance);
		$this->transact=strip_tags($this->transact);
		$this->applyto=strip_tags($this->applyto);
		$this->clear=strip_tags($this->clear);
		$this->memo=strip_tags($this->memo);
		$this->note=strip_tags($this->note);
		$this->line=strip_tags($this->line);
		$this->source=strip_tags($this->source);
		$this->account=strip_tags($this->account);
		$this->type=strip_tags($this->type);
		$this->document=strip_tags($this->document);
		$this->checkno=strip_tags($this->checkno);
		$this->who=strip_tags($this->who);
		$this->skipstat=strip_tags($this->skipstat);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':glaccount', $this->glaccount);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':department', $this->department);
		$stmt->bindParam(':date', $this->date);
		$stmt->bindParam(':amount', $this->amount);
		$stmt->bindParam(':balance', $this->balance);
		$stmt->bindParam(':transact', $this->transact);
		$stmt->bindParam(':applyto', $this->applyto);
		$stmt->bindParam(':clear', $this->clear);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':note', $this->note);
		$stmt->bindParam(':line', $this->line);
		$stmt->bindParam(':source', $this->source);
		$stmt->bindParam(':account', $this->account);
		$stmt->bindParam(':type', $this->type);
		$stmt->bindParam(':document', $this->document);
		$stmt->bindParam(':checkno', $this->checkno);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':skipstat', $this->skipstat);
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
