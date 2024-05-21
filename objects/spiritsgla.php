<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class spiritsgla{
	private $conn;
	protected $key = '0987654321!@#$';


	public function __construct($db){
		$this->conn = $db;
	}
	/**
	 * @OA\Get(
	 *   tags={"readGla"},
	 *   path="/apidb/product/readGla.php",
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
	function readGla($getglaccount){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from gla where gla.glaccount = '$getglaccount' and isdel = 0";
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
	/**
	 * @OA\Get(
	 *   tags={"getUpdatedGla"},
	 *   path="/apidb/product/getUpdatedGla.php",
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

	function getUpdatedGla($getTstamp,$startingRecord,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from gla where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
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
	 * @OA\Get(
	 *   tags={"getGla"},
	 *   path="/apidb/product/getGla.php",
	 *   summary="get attribute data by glaccount",
	 *   @OA\Parameter(
	 *     name="glaccount", 
	 *     in="query", 
	 *     required=false, 
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
	function getGla($getglaccount,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
			$query = "select * from Gla where isdel = 0 order by glaccount";
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
	/**
 * @OA\Post(
 *   path="/apidb/product/updateGla.php",
 *   summary="Update Gla",
 *   tags={"updateGla"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="sequence",
 *           type="string",
 *           example="02920"
 *         ),
 *         @OA\Property(
 *           property="type",
 *           type="string",
 *           example="L"
 *         ),
 *         @OA\Property(
 *           property="glaccount",
 *           type="string",
 *           example="00440"
 *         ),
 *         @OA\Property(
 *           property="short",
 *           type="string",
 *           example="Transfer Hold"
 *         ),
 *         @OA\Property(
 *           property="descript",
 *           type="string",
 *           example="Transfer Holding"
 *         ),
 *         @OA\Property(
 *           property="balance",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="lastcheck",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="who",
 *           type="string",
 *           example="asi"
 *         ),
 *         @OA\Property(
 *           property="tstamp",
 *           type="string",
 *           example="2024-02-04 22:48:17"
 *         ),
 *         @OA\Property(
 *           property="qbooks",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="qbooksac",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="skipstat",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="sent",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="lreg",
 *           type="string",
 *           example="1"
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


	function updateGla(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "insert into gla (sequence,`type`,glaccount,`short`,descript,balance,lastcheck,who,qbooks,qbooksac,skipstat,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:sequence,:type,:glaccount,:short,:descript,:balance,:lastcheck,:who,:qbooks,:qbooksac,:skipstat,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		sequence = :sequence,
		`type` = :type,
		`short` = :short,
		descript = :descript,
		balance = :balance,
		lastcheck = :lastcheck,
		who = :who,
		qbooks = :qbooks,
		qbooksac = :qbooksac,
		skipstat = :skipstat,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->sequence=strip_tags($this->sequence);
		$this->type=strip_tags($this->type);
		$this->glaccount=strip_tags($this->glaccount);
		$this->short=strip_tags($this->short);
		$this->descript=strip_tags($this->descript);
		$this->balance=strip_tags($this->balance); 
		$this->lastcheck=strip_tags($this->lastcheck);
		$this->who=strip_tags($this->who);
		$this->qbooks=strip_tags($this->qbooks);
		$this->qbooksac=strip_tags($this->qbooksac);
		$this->skipstat=strip_tags($this->skipstat);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':sequence', $this->sequence);
		$stmt->bindParam(':type', $this->type);
		$stmt->bindParam(':glaccount', $this->glaccount);
		$stmt->bindParam(':short', $this->short);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':balance', $this->balance);
		$stmt->bindParam(':lastcheck', $this->lastcheck);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':qbooks', $this->qbooks);
		$stmt->bindParam(':qbooksac', $this->qbooksac);
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
	} else {
		return false;
	}
} else {
	return false;
}
	}
}		
?>
