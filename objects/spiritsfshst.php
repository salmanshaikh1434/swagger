<?php
class spiritsfshst
{
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	function readFshst($getCustomer)
	{
		$query = "select * from fshst where fshst.custid=$getCustomer and isdel = 0 order by date";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedFshst($getTstamp, $startingRecord, $records_per_page)
	{
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from fshst where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedFshstReg($getCustomer)
	{
		$query = "select date,storeno as store,saleno as sale,credorpts,dcredits as points,dcredits as credits from fshst where fshst.custid=$getCustomer and isdel = 0 order by date";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function updateFS($thisCredorpts)
	{
		if ($thisCredorpts == '0') {
			$query = "insert into fshst (date,storeno,saleno,custid,dcredits,who,tstamp,lstore,lreg,timestamp,credorpts,sent,type,olddcredit,newdcredit) 
					select :date,:storeno,:saleno,:custid,:dcredits,:who,NOW(),:lstore,:lreg,NOW(),:credorpts,:sent,:type,cus.fsdlrcrdts,cus.fsdlrcrdts+:dcredits from cus where cus.customer = :custid";
		} else {
			$query = "insert into fshst (date,storeno,saleno,custid,dcredits,who,tstamp,lstore,lreg,timestamp,credorpts,sent,type,olddcredit,newdcredit)
				 select :date,:storeno,:saleno,:custid,:dcredits,:who,NOW(),:lstore,:lreg,NOW(),:credorpts,:sent,:type,cus.fsdlrcrdts,cus.fsdlrcrdts+:dcredits from cus where cus.customer = :custid";
		}

		$stmt = $this->conn->prepare($query);
		$this->date = strip_tags($this->date);
		$this->dcredits = strip_tags($this->dcredits);
		$this->credorpts = strip_tags($this->credorpts);
		$this->storeno = strip_tags($this->storeno);
		$this->saleno = strip_tags($this->saleno);
		$this->lreg = strip_tags($this->lreg);
		$this->lstore = strip_tags($this->lstore);
		$this->custid = strip_tags($this->custid);
		$this->sent = strip_tags($this->sent);
		$this->type = strip_tags($this->type);
		$this->who = strip_tags($this->who);
		$this->saletotal = strip_tags($this->saletotal);

		$stmt->bindParam(':date', $this->date);
		$stmt->bindParam(':dcredits', $this->dcredits);
		$stmt->bindParam(':credorpts', $this->credorpts);
		$stmt->bindParam(':storeno', $this->storeno);
		$stmt->bindParam(':saleno', $this->saleno);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':custid', $this->custid);
		$stmt->bindParam(':sent', $this->sent);
		$stmt->bindParam(':type', $this->type);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':saletotal', $this->saletotal);

		if ($stmt->execute()) {
			if ($thisCredorpts == '0') {
				$query = "update cus set cus.fsdlrcrdts = cus.fsdlrcrdts + :dcredits,cus.FSDLRVAL = cus.fsdlrcrdts + :saletotal,cus.who = :who, cus.tstamp = now() where cus.customer = :custid";
			} else {
				$query = "update cus set cus.fscpts = cus.fscpts + :dcredits,cus.fstpts = cus.fstpts + :dcredits,cus.FSDLRVAL = cus.fsdlrcrdts + :saletotal, cus.who = :who, cus.tstamp = now() where cus.customer = :custid";
			}

			$stmt = $this->conn->prepare($query);
			$this->dcredits = strip_tags($this->dcredits);
			$this->custid = strip_tags($this->custid);
			$this->who = strip_tags($this->who);
			$this->saletotal = strip_tags($this->saletotal);

			$stmt->bindParam(':dcredits', $this->dcredits);
			$stmt->bindParam(':custid', $this->custid);
			$stmt->bindParam(':who', $this->who);
			$stmt->bindParam(':saletotal', $this->saletotal);

			if ($stmt->execute()) {
				return 'OK';
			} else {
				$stmtError = $stmt->errorInfo();
				return $stmtError;
			}
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}
	// function created by salman shaikh 
	function updateFshst()
	{
		$insertquery = "INSERT INTO fshst (`date` ,`storeno`,`saleno`,`custid`,`dcredits`,`who`,`timestamp`,`credorpts`,`sent`,`type`,`olddcredit`,`newdcredit`,`lreg`,`lstore`,`isdel`) values 
		(:date ,:storeno,:saleno,:custid,:dcredits,:who,:timestamp,:credorpts,:sent,:type,:olddcredit,:newdcredit,:lreg,:lstore,:isdel)";

		$insertstmt = $this->conn->prepare($insertquery);

		$this->storeno = strip_tags($this->storeno);
		$this->saleno = strip_tags($this->saleno);
		$this->custid = strip_tags($this->custid);
		$this->dcredits = strip_tags($this->dcredits);
		$this->who = strip_tags($this->who);
		$this->timestamp = strip_tags($this->timestamp);
		$this->credorpts = strip_tags($this->credorpts);
		$this->sent = strip_tags($this->sent);
		$this->type = strip_tags($this->type);
		$this->olddcredit = strip_tags($this->olddcredit);
		$this->newdcredit = strip_tags($this->newdcredit);
		$this->lreg = strip_tags($this->lreg);
		$this->lstore = strip_tags($this->lstore);
		$this->isdel = strip_tags($this->isdel);

		$insertstmt->bindParam(':date', $this->date);
		$insertstmt->bindParam(':storeno', $this->storeno);
		$insertstmt->bindParam(':saleno', $this->saleno);
		$insertstmt->bindParam(':custid', $this->custid);
		$insertstmt->bindParam(':dcredits', $this->dcredits);
		$insertstmt->bindParam(':who', $this->who);
		$insertstmt->bindParam(':timestamp', $this->timestamp);
		$insertstmt->bindParam(':credorpts', $this->credorpts);
		$insertstmt->bindParam(':sent', $this->sent);
		$insertstmt->bindParam(':type', $this->type);
		$insertstmt->bindParam(':olddcredit', $this->olddcredit);
		$insertstmt->bindParam(':newdcredit', $this->newdcredit);
		$insertstmt->bindParam(':lreg', $this->lreg);
		$insertstmt->bindParam(':lstore', $this->lstore);
		$insertstmt->bindParam(':isdel', $this->isdel);


		if ($insertstmt->execute()) {
			$updatequery = "update cus set 
			cus.fsdlrcrdts = cus.fsdlrcrdts + :dcredits,
			cus.who = :who, 
			cus.tstamp = now() 
			where cus.customer = :custid";

			$stmt = $this->conn->prepare($updatequery);
			$this->dcredits = strip_tags($this->dcredits);
			$this->custid = strip_tags($this->custid);
			$this->who = strip_tags($this->who);
			

			$stmt->bindParam(':dcredits', $this->dcredits);
			$stmt->bindParam(':custid', $this->custid);
			$stmt->bindParam(':who', $this->who);
		
			if ($stmt->execute()) {
				return 'OK';
			} else {
				$stmtError = $stmt->errorInfo();
				return $stmtError;
			}
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}
}
