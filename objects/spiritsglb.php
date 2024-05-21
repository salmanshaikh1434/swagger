<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class spiritsglb
{
	private $conn;
	protected $key = '0987654321!@#$';


	public function __construct($db)
	{
		$this->conn = $db;
	}
/**
	 * @OA\Get(
	 *   tags={"readGlb"},
	 *   path="/apidb/product/readGlb.php",
	 *   summary="get attribute data by glaccount",
	 *   @OA\Parameter(
	 *     name="glaccount", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata  by glaccount",
	 *     @OA\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found"),
	 *   security={ {"bearerToken": {}}}
	 * )
	 */
	function readGlb($getglaccount)
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from glb where glb.glaccount = '$getglaccount' and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	} else {
		return false;
	}
} else {
	return false;
}
	}
	
	function getglbbydate($department, $date, $store)
	{
		$query = "select * from glb where glb.date=$date and glb.department= $department and glb.store = $store and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}
/**
	 * @OA\Get(
	 *   tags={"getUpdatedGlb"},
	 *   path="/apidb/product/getUpdatedGlb.php",
	 *   summary="get attribute data by tstamp",
	 *   @OA\Parameter(
	 *     name="tstamp", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata  by tstamp",
	 *     @OA\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found"),
	 *   security={ {"bearerToken": {}}}
	 * )
	 */
	function getUpdatedGlb($gettstamp, $startingrecord, $records_per_page)
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$thisdate = date('Y-m-d H:i:s', strtotime($gettstamp));
		$query = "select * from glb where tstamp > '$thisdate' order by tstamp limit ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindparam(1, $startingrecord, PDO::PARAM_INT);
		$stmt->bindparam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	} else {
		return false;
	}
} else {
	return false;
}
	}


	function getUpdatedGlbReconsile($getDate, $register, $store, $startingrecord, $records_per_page)
	{

		$query = "select * from glb where `date` = '$getDate' AND `lreg`='$register' AND `store` = '$store'  order by tstamp limit ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindparam(1, $startingrecord, PDO::PARAM_INT);
		$stmt->bindparam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}
/**
	 * @OA\Get(
	 *   tags={"getUpdatedGlbByDate"},
	 *   path="/apidb/product/getUpdatedGlbByDate.php",
	 *   summary="get attribute data by date",
	 *   @OA\Parameter(
	 *     name="date", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata  by date",
	 *     @OA\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found"),
	 *   security={ {"bearerToken": {}}}
	 * )
	 */
	function getUpdatedGlbByDate($getDate, $startingrecord, $records_per_page)
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {

		$query = "select * from glb where `date` = '$getDate'  order by tstamp limit ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindparam(1, $startingrecord, PDO::PARAM_INT);
		$stmt->bindparam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	} else {
		return false;
	}
} else {
	return false;
}
	}
/**
	 * @OA\Get(
	 *   tags={"getGlb"},
	 *   path="/apidb/product/getGlb.php",
	 *   summary="get attribute data by date",
	 *   @OA\Parameter(
	 *     name="date", 
	 *     in="query", 
	 *     required=false, 
	 *     description="getdata  by date",
	 *     @OA\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found"),
	 *   security={ {"bearerToken": {}}}
	 * )
	 */
	function getGlb($getPage, $records_per_page)
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from glb where isdel = 0 order by tstamp LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $getPage, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	} else {
		return false;
	}
} else {
	return false;
}
	}

	/**
 * @OA\Post(
 *   path="/apidb/products/updateGlb.php",
 *   summary="Update Glb",
 *   tags={"Update Glb"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="glaccount",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="unid",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="date",
 *           type="string",
 *           example="2022-08-06"
 *         ),
 *         @OA\Property(
 *           property="store",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="department",
 *           type="string",
 *           example="120"
 *         ),
 *         @OA\Property(
 *           property="edate",
 *           type="string",
 *           example="0000-00-00"
 *         ),
 *         @OA\Property(
 *           property="lamount",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="ramount",
 *           type="string",
 *           example="29.99"
 *         ),
 *         @OA\Property(
 *           property="balance",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="records",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="freeze",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="who",
 *           type="string",
 *           example="GGP"
 *         ),
 *         @OA\Property(
 *           property="transact",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="consol",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="sent",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="gosent",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="lreg",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="tstamp",
 *           type="string",
 *           example="2024-04-22 13:02:40"
 *         ),
 *         @OA\Property(
 *           property="lstore",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="isdel",
 *           type="string",
 *           example="0"
 *         )
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="OK"
 *   ),
 *   @OA\Response(
 *     response=401,
 *     description="Unauthorized"
 *   ),
 *   @OA\Response(
 *     response=404,
 *     description="Not Found"
 *   ),
 *   security={ {"bearerToken": {}} }
 * )
 */


	function updateGlb()
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {

		$check_query = "SELECT count(*) FROM glb WHERE glaccount = :glaccount AND date = :date AND store = :store AND department = :department AND freeze = 0";
		$ch = $this->conn->prepare($check_query);

		$ch->bindParam(':glaccount', $this->glaccount);
		$ch->bindParam(':date', $this->date);
		$ch->bindParam(':store', $this->store);
		$ch->bindParam(':department', $this->department);

		$ch->execute();
		$count = $ch->fetchColumn();

		if ($count > 0) {

			$query = "UPDATE glb SET glaccount =:glaccount,`date`=:date,`store`=:store,`department`=:department,edate = :edate, lamount = lamount + :lamount, ramount = ramount + :ramount, balance = balance + :balance, records = records + :records  , freeze = :freeze, who = :who, tstamp = now(), isdel = :isdel, lreg = :lreg, lstore = :lstore WHERE glaccount = :glaccount AND date = :date AND store = :store AND department = :department";
			$stmt = $this->conn->prepare($query);
		} else {
			$query = "insert into glb (glaccount,date,store,department,edate,lamount,ramount,balance,records,freeze,who,transact,tstamp,isdel,lreg,lstore)
			values 
			(:glaccount,:date,:store,:department,:edate,:lamount,:ramount,:balance,:records,:freeze,:who,:transact,now(),:isdel,:lreg,:lstore)";
			$stmt = $this->conn->prepare($query);
			$this->transact = strip_tags($this->transact);
			$stmt->bindparam(':transact', $this->transact);
		}



		$this->glaccount = strip_tags($this->glaccount);
		$this->date = strip_tags($this->date);
		$this->store = strip_tags($this->store);
		$this->department = strip_tags($this->department);
		$this->edate = strip_tags($this->edate);
		$this->lamount = strip_tags($this->lamount);
		$this->ramount = strip_tags($this->ramount);
		$this->balance = strip_tags($this->balance);
		$this->records = strip_tags($this->records);
		$this->freeze = strip_tags($this->freeze);
		$this->who = strip_tags($this->who);
		$this->lreg = strip_tags($this->lreg);
		$this->lstore = strip_tags($this->lstore);
		$this->isdel = strip_tags($this->isdel);

		$stmt->bindparam(':glaccount', $this->glaccount);
		$stmt->bindparam(':date', $this->date);
		$stmt->bindparam(':store', $this->store);
		$stmt->bindparam(':department', $this->department);
		$stmt->bindparam(':edate', $this->edate);
		$stmt->bindparam(':lamount', $this->lamount);
		$stmt->bindparam(':ramount', $this->ramount);
		$stmt->bindparam(':balance', $this->balance);
		$stmt->bindparam(':records', $this->records);
		$stmt->bindparam(':freeze', $this->freeze);
		$stmt->bindparam(':who', $this->who);
		$stmt->bindparam(':lreg', $this->lreg);
		$stmt->bindparam(':lstore', $this->lstore);
		$stmt->bindparam(':isdel', $this->isdel);


		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmterror = $stmt->errorinfo();
			return $stmterror;
		}
	} else {
		return false;
	}
} else {
	return false;
}
	}

	public function addreconcileglb($bulk)
	{
		foreach ($bulk->glb as $data) {
			try {
				if ($data->unid == 0) {
					$query = "INSERT INTO glb (`glaccount`, `date`, `store`, `department`, `edate`, `lamount`, `ramount`, `balance`, `records`, `freeze`, `who`, `transact`, `consol`, `sent`, `tstamp`, `isdel`, `lreg`, `lstore`) VALUES (:glaccount, :date, :store, :department, :edate, :lamount, :ramount, :balance, :records, :freeze, :who, :transact, :consol, :sent, now(), :isdel, :lreg, :lstore)";
					$stmt = $this->conn->prepare($query);
				} else {
					$query = "UPDATE glb SET glaccount = :glaccount, `date` = :date, `store` = :store, `department` = :department, edate = :edate, lamount = :lamount, ramount = :ramount, balance = :balance, records = :records, freeze = :freeze, who = :who, transact = :transact, consol = :consol, sent = :sent, tstamp = now(), isdel = :isdel, lreg = :lreg, lstore = :lstore WHERE unid = :unid";
					$stmt = $this->conn->prepare($query);
					$stmt->bindParam(':unid', $data->unid);
				}
				$stmt->bindParam(':glaccount', $data->glaccount);
				$stmt->bindParam(':date', $data->date);
				$stmt->bindParam(':store', $data->store);
				$stmt->bindParam(':department', $data->department);
				$stmt->bindParam(':edate', $data->edate);
				$stmt->bindParam(':lamount', $data->lamount);
				$stmt->bindParam(':ramount', $data->ramount);
				$stmt->bindParam(':balance', $data->balance);
				$stmt->bindParam(':records', $data->records);
				$stmt->bindParam(':freeze', $data->freeze);
				$stmt->bindParam(':who', $data->who);
				$stmt->bindParam(':transact', $data->transact);
				$stmt->bindParam(':consol', $data->consol);
				$stmt->bindParam(':sent', $data->sent);
				$stmt->bindParam(':isdel', $data->isdel);
				$stmt->bindParam(':lreg', $data->lreg);
				$stmt->bindParam(':lstore', $data->lstore);
				$stmt->execute();

			} catch (PDOException $e) {
				$message = $e->getMessage();
				return "ERROR UPDATING!!: " . $message;
			}
		}
		return "OK";
	}
}


?>