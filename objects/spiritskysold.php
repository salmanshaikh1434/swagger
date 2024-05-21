<?php
class spiritskys{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readKys($getkey){
		$query = "select * from kys where kys.key = $getkey and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedKys($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from kys where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getKys($getkey,$records_per_page){
			$query = "select * from kys where isdel = 0 order by `key`";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateKys(){
		$query = "INSERT INTO kys (keyboard,page,`key`,keyname,cat,receipts,customer,function,`change`,credit,balance,active,security,who,catname,keyorder,tstamp,isdel,lreg,lstore)
			VALUES 
		(:keyboard,:page,:key,:keyname,:cat,:receipts,:customer,:function,:change,:credit,:balance,:active,:security,:who,:catname,:keyorder,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		page = :page,
		cat = :cat,
		receipts = :receipts,
		customer = :customer,
		function = :function,
		`change` = :change,
		credit = :credit,
		balance = :balance,
		active = :active,
		security = :security,
		who = :who,
		catname = :catname,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->keyboard=strip_tags($this->keyboard);
		$this->page=strip_tags($this->page);
		$this->key=strip_tags($this->key);
		$this->keyname=strip_tags($this->keyname);
		$this->cat=strip_tags($this->cat);
		$this->receipts=strip_tags($this->receipts);
		$this->customer=strip_tags($this->customer);
		$this->function=strip_tags($this->function);
		$this->change=strip_tags($this->change);
		$this->credit=strip_tags($this->credit);
		$this->balance=strip_tags($this->balance);
		$this->active=strip_tags($this->active);
		$this->security=strip_tags($this->security);
		$this->who=strip_tags($this->who);
		$this->catname=strip_tags($this->catname);
		$this->keyorder=strip_tags($this->keyorder);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':keyboard', $this->keyboard);
		$stmt->bindParam(':page', $this->page);
		$stmt->bindParam(':key', $this->key);
		$stmt->bindParam(':keyname', $this->keyname);
		$stmt->bindParam(':cat', $this->cat);
		$stmt->bindParam(':receipts', $this->receipts);
		$stmt->bindParam(':customer', $this->customer);
		$stmt->bindParam(':function', $this->function);
		$stmt->bindParam(':change', $this->change);
		$stmt->bindParam(':credit', $this->credit);
		$stmt->bindParam(':balance', $this->balance);
		$stmt->bindParam(':active', $this->active);
		$stmt->bindParam(':security', $this->security);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':catname', $this->catname);
		$stmt->bindParam(':keyorder', $this->keyorder);
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
