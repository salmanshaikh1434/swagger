<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class spiritshnh{
	private $conn;
	protected $key = '0987654321!@#$';


	public function __construct($db){
		$this->conn = $db;
	}
		/**
	 * @OA\Get(
	 *   tags={"readHnh"},
	 *   path="/apidb/product/readHnh.php",
	 *   summary="get attribute data by listnum",
	 *   @OA\Parameter(
	 *     name="listnum", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata  by listnum",
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
	function readHnh($getlistnum){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from hnh where hnh.listnum = $getlistnum and isdel = 0";
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
	 *   tags={"getUpdatedHnh"},
	 *   path="/apidb/product/getUpdatedHnh.php",
	 *   summary="update attribute data by tstamp",
	 *   @OA\Parameter(
	 *     name="listnum", 
	 *     in="query", 
	 *     required=true, 
	 *     description="Updatedata  by tstamp",
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

	function getUpdatedHnh($getTstamp,$startingRecord,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from hnh where tstamp > '$thisDate' LIMIT ?,?";
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
	 *   tags={"getHnh"},
	 *   path="/apidb/product/getHnh.php",
	 *   summary="get attribute data by listnum",
	 *   @OA\Parameter(
	 *     name="listnum", 
	 *     in="query", 
	 *     required=false, 
	 *     description="getdata  by listnum",
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

	function getHnh($getlistnum,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
			$query = "select * from Hnh where hnh.listnum and isdel = 0 order by listnum LIMIT ?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);	
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
 *   path="/apidb/product/updateHnh.php",
 *   summary="Update list",
 *   tags={"updateHnh"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="listnum",
 *           type="string",
 *           example="276"
 *         ),
 *         @OA\Property(
 *           property="listname",
 *           type="string",
 *           example="A-1000"
 *         ),
 *         @OA\Property(
 *           property="listtype",
 *           type="string",
 *           example="A"
 *         ),
 *         @OA\Property(
 *           property="descript",
 *           type="string",
 *           example="Computer Counts - 1000-9999"
 *         ),
 *         @OA\Property(
 *           property="store",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="avg_last",
 *           type="string",
 *           example="A"
 *         ),
 *         @OA\Property(
 *           property="posted",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="lastline",
 *           type="string",
 *           example="3282"
 *         ),
 *         @OA\Property(
 *           property="who",
 *           type="string",
 *           example="GGP"
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

	function updateHnh(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "INSERT INTO hnh (listnum,listname,listtype,descript,store,avg_last,posted,lastline,who,tstamp,isdel,lreg,lstore)
			VALUES 
		(:listnum,:listname,:listtype,:descript,:store,:avg_last,:posted,:lastline,:who,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		listname = :listname,
		listtype = :listtype,
		descript = :descript,
		store = :store,
		avg_last = :avg_last,
		posted = :posted,
		lastline = :lastline,
		who = :who,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->listnum=strip_tags($this->listnum);
		$this->listname=strip_tags($this->listname);
		$this->listtype=strip_tags($this->listtype);
		$this->descript=strip_tags($this->descript);
		$this->store=strip_tags($this->store);
		$this->avg_last=strip_tags($this->avg_last);
		$this->posted=strip_tags($this->posted);
		$this->lastline=strip_tags($this->lastline);
		$this->who=strip_tags($this->who);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':listnum', $this->listnum);
		$stmt->bindParam(':listname', $this->listname);
		$stmt->bindParam(':listtype', $this->listtype);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':avg_last', $this->avg_last);
		$stmt->bindParam(':posted', $this->posted);
		$stmt->bindParam(':lastline', $this->lastline);
		$stmt->bindParam(':who', $this->who);
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
