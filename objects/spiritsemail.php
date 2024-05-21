<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class spiritsemail{
	private $conn;
	protected $key = '0987654321!@#$';

	public function __construct($db){
		$this->conn = $db;
	}
	/**
	 * @OA\Get(
	 *   tags={"readEmail"},
	 *   path="/apidb/product/readEmail.php",
	 *   summary="get attribute data by id",
	 *   @OA\Parameter(
	 *     name="id", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata  by id",
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
	function readEmail($getid){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from email where email.id = $getid and isdel = 0";
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
	 *   tags={"getUpdatedEmail"},
	 *   path="/apidb/product/getUpdatedEmail.php",
	 *   summary="get attribute data by getTstamp",
	 *   @OA\Parameter(
	 *     name="getTstamp", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata  by getTstamp",
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

	function getUpdatedEmail($getTstamp,$startingRecord,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from email where tstamp > '$thisDate' LIMIT ?,?";
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
	 *   tags={"getEmail"},
	 *   path="/apidb/product/getEmail.php",
	 *   summary="get attribute data by id",
	 *   @OA\Parameter(
	 *     name="id", 
	 *     in="query", 
	 *     required=false, 
	 *     description="getdata  by id",
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

	function getEmail($getid,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
			$query = "select * from email where isdel = 0 order by id";
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
	// resolve the sql syntax error PDO::EXCEPTION By Salman

	/**
 * @OA\Post(
 *   path="/apidb/product/updateEmail.php",
 *   summary="updateEmail",
 *   tags={"updateEmail"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="id",
 *           type="string",
 *           example="101"
 *         ),
 *         @OA\Property(
 *           property="from",
 *           type="string",
 *           example="GAURAV PATEL"
 *         ),
 *         @OA\Property(
 *           property="to",
 *           type="string",
 *           example="ALL EMPLOYEES"
 *         ),
 *         @OA\Property(
 *           property="store",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="subject",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="content",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="attach",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="files",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="blank",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="flag",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="toid",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="fromid",
 *           type="string",
 *           example="120"
 *         ),
 *         @OA\Property(
 *           property="new",
 *           type="string",
 *           example="1"
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

	function updateEmail(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "INSERT INTO email (`id`,`from`,`to`,`store`,`subject`,`content`,`attach`,`files`,`blank`,`flag`,`toid`,`fromid`,`new`,`sent`,`tstamp`,`isdel`,`lreg`,`lstore`)
			VALUES 
		(:id,:from,:to,:store,:subject,:content,:attach,:files,:blank,:flag,:toid,:fromid,:new,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`from` = :from,
		`to` = :to,
		`store` = :store,
		`subject` = :subject,
		`content` = :content,
		`attach` = :attach,
		`files` = :files,
		`blank` = :blank,
		`flag` = :flag,
		`toid` = :toid,
		`fromid` = :fromid,
		`new` = :new,
		`sent` = :sent,
		`tstamp` = NOW(),
		`lstore`= :lstore,
		`lreg`= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->id=strip_tags($this->id);
		$this->from=strip_tags($this->from);
		$this->to=strip_tags($this->to);
		$this->store=strip_tags($this->store);
		$this->subject=strip_tags($this->subject);
		$this->content=strip_tags($this->content);
		$this->attach=strip_tags($this->attach);
		$this->files=strip_tags($this->files);
		$this->blank=strip_tags($this->blank);
		$this->flag=strip_tags($this->flag);
		$this->toid=strip_tags($this->toid);
		$this->fromid=strip_tags($this->fromid);
		$this->new=strip_tags($this->new);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':from', $this->from);
		$stmt->bindParam(':to', $this->to);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':subject', $this->subject);
		$stmt->bindParam(':content', $this->content);
		$stmt->bindParam(':attach', $this->attach);
		$stmt->bindParam(':files', $this->files);
		$stmt->bindParam(':blank', $this->blank);
		$stmt->bindParam(':flag', $this->flag);
		$stmt->bindParam(':toid', $this->toid);
		$stmt->bindParam(':fromid', $this->fromid);
		$stmt->bindParam(':new', $this->new);
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
