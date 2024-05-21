<?php
error_reporting(E_ALL);
ini_set('display_error', 1);
require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class spiritsdep{
	private $conn;
	protected $key = '0987654321!@#$';

	public function __construct($db){
		$this->conn = $db;
	}
 /**
	 * @OA\Get(
	 *   tags={"readDep"},
	 *   path="/apidb/product/readDep.php",
	 *   summary="Get Department",
	 *   @OA\Parameter(
	 *     name="depos", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata by Dept",
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
	function readDep($getdepos){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from dep where dep.depos = '$getdepos' and isdel = 0";
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
	 *   tags={"getUpdatedDep"},
	 *   path="/apidb/product/getUpdatedDep.php",
	 *   summary="get attribute data by Tstamp",
	 *   @OA\Parameter(
	 *     name="tstamp", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getTstamp item to get",
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

	function getUpdatedDep($getTstamp,$startingRecord,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from dep where tstamp > '$thisDate' LIMIT ?,?";
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
	 *   tags={"getDep"},
	 *   path="/apidb/product/getDep.php",
	 *   summary="Get Department",
	 *   @OA\Parameter(
	 *     name="depos", 
	 *     in="query", 
	 *     required=false, 
	 *     description="getdata by Dept",
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

	function getDep($getdepos,$records_per_page){

		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {	
					$query = "select * from dep where isdel = 0 order by depos";
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
 *   path="/apidb/product/updateDep.php",
 *   summary="Update Dep",
 *   tags={"update Dep"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="depos",
 *           type="string",
 *           example="D01"
 *         ),
 *         @OA\Property(
 *           property="unit",
 *           type="string",
 *           example="0.05"
 *         ),
 *         @OA\Property(
 *           property="case",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="scat",
 *           type="string",
 *           example="90"
 *         ),
 *         @OA\Property(
 *           property="rcat",
 *           type="string",
 *           example="91"
 *         ),
 *         @OA\Property(
 *           property="who",
 *           type="string",
 *           example="GGP"
 *         ),
 *         @OA\Property(
 *           property="sent",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="lreg",
 *           type="string",
 *           example="99"
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
 *         ),
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
 *   security={ {"bearerToken": {}}}
 * )
 */
	function updateDep(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "INSERT INTO dep (depos,unit,`case`,scat,rcat,who,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:depos,:unit,:case,:scat,:rcat,:who,:sent,now(),:isdel,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		unit = :unit,
		`case` = :case,
		scat = :scat,
		rcat = :rcat,
		who = :who,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->depos=strip_tags($this->depos);
		$this->unit=strip_tags($this->unit);
		$this->case=strip_tags($this->case);
		$this->scat=strip_tags($this->scat);
		$this->rcat=strip_tags($this->rcat);
		$this->who=strip_tags($this->who);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':depos', $this->depos);
		$stmt->bindParam(':unit', $this->unit);
		$stmt->bindParam(':case', $this->case);
		$stmt->bindParam(':scat', $this->scat);
		$stmt->bindParam(':rcat', $this->rcat);
		$stmt->bindParam(':who', $this->who);
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
