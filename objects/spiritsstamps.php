<?php
class spiritsstamps{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readStamps($getenumber){
		$query = "select * from stamps where stamps.enumber = $getenumber and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedStamps($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from stamps where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getStamps($getenumber,$records_per_page){
			$query = "select * from stamps where isdel = 0 order by enumber LIMIT ?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);	
			$stmt->execute();
		return $stmt;
	}

	function updateStamps(){
		// $query = "INSERT INTO stamps (series, snumber, enumber, qty, `order`, `store`, customer, invdate, who, memo, `sent`, tstamp, isdel, lreg, lstore)
		// 			VALUES 
		// 				(:series, :snumber, :enumber, :qty, :order_value, :store_value, :customer, :invdate, :who, :memo, :sent_value, NOW(), 0, :lreg, :lstore)
		// 			ON DUPLICATE KEY UPDATE
		// 				series = :series,
		// 				snumber = :snumber,
		// 				enumber = :enumber,
		// 				qty = :qty,
		// 				`order` = :order_value,
		// 				`store` = :store_value,
		// 				customer = :customer,
		// 				invdate = :invdate,
		// 				who = :who,
		// 				memo = :memo,
		// 				`sent` = :sent_value,
		// 				tstamp = NOW(),
		// 				lstore = :lstore,
		// 				lreg = :lreg,
		// 				isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";
		// changed by salman to resolve problem of wrong bindings
		$query = "INSERT INTO stamps (series, snumber, enumber, qty, `order`, `store`, customer, invdate, who, memo, `sent`, tstamp, isdel, lreg, lstore)
		VALUES 
			(:series, :snumber, :enumber, :qty, :order, :store, :customer, :invdate, :who, :memo, :sent, NOW(), 0, :lreg, :lstore)
		ON DUPLICATE KEY UPDATE
			series = :series,
			snumber = :snumber,
			enumber = :enumber,
			qty = :qty,
			`order` = :order,
			`store` = :store,
			customer = :customer,
			invdate = :invdate,
			who = :who,
			memo = :memo,
			`sent` = :sent,
			tstamp = NOW(),
			lstore = :lstore,
			lreg = :lreg,
			isdel = :isdel";


		$stmt = $this->conn->prepare($query);
		$this->series=strip_tags($this->series);
		$this->snumber=strip_tags($this->snumber);
		$this->enumber=strip_tags($this->enumber);
		$this->qty=strip_tags($this->qty);
		$this->order=strip_tags($this->order);
		$this->store=strip_tags($this->store);
		$this->customer=strip_tags($this->customer);
		$this->invdate=strip_tags($this->invdate);
		$this->who=strip_tags($this->who);
		$this->memo=strip_tags($this->memo);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':series', $this->series);
		$stmt->bindParam(':snumber', $this->snumber);
		$stmt->bindParam(':enumber', $this->enumber);
		$stmt->bindParam(':qty', $this->qty);
		$stmt->bindParam(':order', $this->order);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':customer', $this->customer);
		$stmt->bindParam(':invdate', $this->invdate);
		$stmt->bindParam(':who', $this->who);
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
