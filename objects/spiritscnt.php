<?php
error_reporting(E_ALL);
ini_set('display_error', 1);
require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class spiritscnt{
	private $conn;
	protected $key = '0987654321!@#$';


	public function __construct($db){
		$this->conn = $db;
	}
	    /**
	 * @OA\Get(
	 *   tags={"getUpdatedCnt"},
	 *   path="/apidb/product/getUpdatedCnt.php",
	 *   summary="read cnt",
	 *   @OA\Parameter(
	 *     name="code", 
	 *     in="query", 
	 *     required=false, 
	 *     description="getdata  by code",
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

	function getUpdatedCnt($getTstamp,$startingRecord,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from cnt where tstamp > '$thisDate' LIMIT ?,?";
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
	 *   tags={"getCnt"},
	 *   path="/apidb/product/getCnt.php",
	 *   summary="read cnt",
	 *   @OA\Parameter(
	 *     name="code", 
	 *     in="query", 
	 *     required=false, 
	 *     description="getdata  by code",
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

	function getCnt($getcode,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
			$query = "select * from cnt where isdel = 0 order by code";
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
	 *   tags={"readcnt"},
	 *   path="/apidb/product/readcnt.php",
	 *   summary="read cnt",
	 *   @OA\Parameter(
	 *     name="code", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata  by code",
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
	function readCnt($getcode){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from cnt where `code` = '$getcode' and isdel = 0";
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
 *   path="/apidb/product/updatecnt.php",
 *   summary="Update  cnt",
 *   tags={"updatecnt"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="code",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="seq",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="question",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="data",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="memvar",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="updatereg",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="who",
 *           type="string",
 *           example="ASI"
 *         ),
 *         @OA\Property(
 *           property="memo",
 *           type="string",
 *           example=""
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

	function updateCnt(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "INSERT INTO cnt (code,seq,question,data,memvar,updatereg,who,memo,tstamp,isdel,lreg,lstore)
			VALUES 
		(:code,:seq,:question,:data,:memvar,:updatereg,:who,:memo,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		seq = :seq,
		question = :question,
		data = :data,
		memvar = :memvar,
		updatereg = :updatereg,
		who = :who,
		memo = :memo,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->code=strip_tags($this->code);
		$this->seq=strip_tags($this->seq);
		$this->question=strip_tags($this->question);
		$this->data=strip_tags($this->data);
		$this->memvar=strip_tags($this->memvar);
		$this->updatereg=strip_tags($this->updatereg);
		$this->who=strip_tags($this->who);
		$this->memo=strip_tags($this->memo);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':code', $this->code);
		$stmt->bindParam(':seq', $this->seq);
		$stmt->bindParam(':question', $this->question);
		$stmt->bindParam(':data', $this->data);
		$stmt->bindParam(':memvar', $this->memvar);
		$stmt->bindParam(':updatereg', $this->updatereg);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':memo', $this->memo);
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
