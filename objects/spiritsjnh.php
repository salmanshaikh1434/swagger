<?php
use OpenApi\Annotations as OA;


class spiritsjnh
{
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	/**
	 * @OA\Get(
	 * tags={"readjnh"},
	 * path="/apidb/product/readjnh.php",
	 * summary="Summary",
	 * @OA\Parameter(
	 * name="store",
	 * in="query",
	 * required=true,
	 * description="get jnh based store",
	 * @OA\Schema(
	 * type="integer",
	 * )
	 * ),
	 * @OA\Response(response=200, description="OK"),
	 * @OA\Response(response=401, description="Unauthorized"),
	 * @OA\Response(response=404, description="Not Found")
	 * )
	 */
	function readJnh($getstore)
	{
		$query = "select * from jnh where jnh.store = $getstore and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	/**
	 * @OA\Get(
	 *   tags={"getupdatedjnh"},
	 *   path="/apidb/product/getupdatedjnh.php",
	 *   summary="Summary",
	 *   @OA\Parameter(
	 *     name="tstamp", 
	 *     in="query", 
	 *     required=true, 
	 *     description="get inventory based on tstamp",
	 *     @OA\Schema(
	 *       type="string",
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found")
	 * )
	 */

	function getUpdatedJnh($getTstamp, $startingRecord, $records_per_page)
	{
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from jnh where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	/**
	 * @OA\Get(
	 *   tags={"getjnh"},
	 *   path="/apidb/product/getjnh.php",
	 *   summary="Summary",
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found")
	 * )
	 */

	function getJnh($getPage, $records_per_page)
	{
		// $thisPageLimit = ($getPage*$records_per_page);
		$query = "select * from jnh where isdel = 0 order by tstamp LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $getPage, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	/**
	 * @OA\Get(
	 *   tags={"getjnhbydate"},
	 *   path="/apidb/product/getjnhbydate.php",
	 *   summary="Get jnh between dates",
	 *   @OA\Parameter(
	 *     name="from", 
	 *     in="query", 
	 *     required=true, 
	 *     description="Start date",
	 *     @OA\Schema(
	 *       type="string",   
	 *     )
	 *   ),
	 *   @OA\Parameter(
	 *     name="to", 
	 *     in="query", 
	 *     required=true, 
	 *     description="End date",
	 *     @OA\Schema(
	 *       type="string",
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found")
	 * )
	 */

	function getJnhbydate($datestart, $dateend)
	{
		$datestart = date('Y-m-d', strtotime($datestart));
		$dateend = date('Y-m-d', strtotime($dateend));
		$query = "select * from jnh where `date` between ? and ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $datestart, PDO::PARAM_STR);
		$stmt->bindParam(2, $dateend, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt;
	}


	function getJnhDate($getStartDate, $getEndDate, $getStore)
	{
		$thisStartDate = date('Y-m-d H:i:s', strtotime($getStartDate));
		$thisEndDate = date('Y-m-d H:i:s', strtotime($getEndDate));
		$query = "select tstamp,register,cashier,sale,total,store from jnh where isdel = 0 and tstamp >= '$thisStartDate' and tstamp <= '$thisEndDate' and store = $getStore";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getJnhSale($getSale)
	{
		$query = "select tstamp,register,cashier,sale,total,store from jnh where isdel = 0 and sale = $getSale";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getJnhDateReg($getStartDate, $getStore)
	{
		$query = "select `tstamp`,`register`,`cashier`,`sale`,`total`,`customer`,`taxcode`,`order`,`store` from jnh where isdel = 0 and date = $getStartDate and store = $getStore";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getJnhUpdate($getStartDate, $getEndDate, $getStore, $getCashier, $getRegister)
	{
		$thisStartDate = date('Y-m-d H:i:s', strtotime($getStartDate));
		$thisEndDate = date('Y-m-d H:i:s', strtotime($getEndDate));
		if ($getCashier == 0 and $getRegister == 0) {
			$query = "select tstamp,register,cashier,sale,total,store from jnh where isdel = 0 and tstamp >= '$thisStartDate' and tstamp <= '$thisEndDate' and store = $getStore";
		} elseif ($getCashier == 0) {
			$query = "select tstamp,register,cashier,sale,total,store from jnh where isdel = 0 and tstamp >= '$thisStartDate' and tstamp <= '$thisEndDate' and store = $getStore and register = $getRegister";
		} elseif ($getRegister == 0) {
			$query = "select tstamp,register,cashier,sale,total,store from jnh where isdel = 0 and tstamp >= '$thisStartDate' and tstamp <= '$thisEndDate' and store = $getStore and cashier = $getCashier";
		} else {
			$query = "select tstamp,register,cashier,sale,total,store from jnh where isdel = 0 and tstamp >= '$thisStartDate' and tstamp <= '$thisEndDate' and store = $getStore and cashier = $getCashier and register = $getRegister";
		}
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function updateJnh()
	{
		$query = "INSERT INTO jnh (date,store,register,cashier,sale,customer,`order`,taxcode,total,receipts,memo,signature,reference,ackrefno,voided,tstamp,isdel,lreg,lstore)
			VALUES 
		(:date,:store,:register,:cashier,:sale,:customer,:order,:taxcode,:total,:receipts,:memo,:signature,:reference,:ackrefno,:voided,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		date = :date,
		register = :register,
		cashier = :cashier,
		customer = :customer,
		`order` = :order,
		taxcode = :taxcode,
		total = :total,
		receipts = :receipts,
		memo = :memo,
		signature = :signature,
		reference = :reference,
		ackrefno = :ackrefno,
		voided = :voided,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->date = strip_tags($this->date);
		$this->store = strip_tags($this->store);
		$this->register = strip_tags($this->register);
		$this->cashier = strip_tags($this->cashier);
		$this->sale = strip_tags($this->sale);
		$this->customer = strip_tags($this->customer);
		$this->order = strip_tags($this->order);
		$this->taxcode = strip_tags($this->taxcode);
		$this->total = strip_tags($this->total);
		$this->receipts = strip_tags($this->receipts);
		$this->memo = strip_tags($this->memo);
		$this->signature = strip_tags($this->signature);
		$this->reference = strip_tags($this->reference);
		$this->ackrefno = strip_tags($this->ackrefno);
		$this->voided = strip_tags($this->voided);
		$this->lreg = strip_tags($this->lreg);
		$this->lstore = strip_tags($this->lstore);
		$this->isdel = strip_tags($this->isdel);

		$stmt->bindParam(':date', $this->date);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':register', $this->register);
		$stmt->bindParam(':cashier', $this->cashier);
		$stmt->bindParam(':sale', $this->sale);
		$stmt->bindParam(':customer', $this->customer);
		$stmt->bindParam(':order', $this->order);
		$stmt->bindParam(':taxcode', $this->taxcode);
		$stmt->bindParam(':total', $this->total);
		$stmt->bindParam(':receipts', $this->receipts);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':signature', $this->signature);
		$stmt->bindParam(':reference', $this->reference);
		$stmt->bindParam(':ackrefno', $this->ackrefno);
		$stmt->bindParam(':voided', $this->voided);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':isdel', $this->isdel);


		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	function convertJnhStart()
	{
		$stmt = $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $this->conn->beginTransaction();
	}

	function convertJnhBody()
	{
		$query = "INSERT INTO jnh (date,store,register,cashier,sale,customer,`order`,taxcode,total,receipts,memo,signature,reference,ackrefno,voided,tstamp,isdel,lreg,lstore)
			VALUES 
		(:date,:store,:register,:cashier,:sale,:customer,:order,:taxcode,:total,:receipts,:memo,:signature,:reference,:ackrefno,:voided,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		date = :date,
		register = :register,
		cashier = :cashier,
		customer = :customer,
		`order` = :order,
		taxcode = :taxcode,
		total = :total,
		receipts = :receipts,
		memo = :memo,
		signature = :signature,
		reference = :reference,
		ackrefno = :ackrefno,
		voided = :voided,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->date = strip_tags($this->date);
		$this->store = strip_tags($this->store);
		$this->register = strip_tags($this->register);
		$this->cashier = strip_tags($this->cashier);
		$this->sale = strip_tags($this->sale);
		$this->customer = strip_tags($this->customer);
		$this->order = strip_tags($this->order);
		$this->taxcode = strip_tags($this->taxcode);
		$this->total = strip_tags($this->total);
		$this->receipts = strip_tags($this->receipts);
		$this->memo = strip_tags($this->memo);
		$this->signature = strip_tags($this->signature);
		$this->reference = strip_tags($this->reference);
		$this->ackrefno = strip_tags($this->ackrefno);
		$this->voided = strip_tags($this->voided);
		$this->lreg = strip_tags($this->lreg);
		$this->lstore = strip_tags($this->lstore);
		$this->isdel = strip_tags($this->isdel);

		$stmt->bindParam(':date', $this->date);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':register', $this->register);
		$stmt->bindParam(':cashier', $this->cashier);
		$stmt->bindParam(':sale', $this->sale);
		$stmt->bindParam(':customer', $this->customer);
		$stmt->bindParam(':order', $this->order);
		$stmt->bindParam(':taxcode', $this->taxcode);
		$stmt->bindParam(':total', $this->total);
		$stmt->bindParam(':receipts', $this->receipts);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':signature', $this->signature);
		$stmt->bindParam(':reference', $this->reference);
		$stmt->bindParam(':ackrefno', $this->ackrefno);
		$stmt->bindParam(':voided', $this->voided);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':isdel', $this->isdel);

	}

	function convertJnhEnd()
	{
		$stmt = $this->conn->commit();
		echo $stmt;
		/*if($stmt=NULL){	
																																																																  return 'OK';
																																																															  }else{
																																																																  $stmt=$this->conn->rollBack();
																																																																  $stmtError = $stmt->errorInfo();
																																																															  return $stmtError;
																																																															  }*/
	}
}

?>