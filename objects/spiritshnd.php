<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class spiritshnd{
	private $conn;
	protected $key = '0987654321!@#$';


	public function __construct($db){
		$this->conn = $db;
	}
		/**
	 * @OA\Get(
	 *   tags={"readHnd"},
	 *   path="/apidb/product/readHnd.php",
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

	function readHnd($getlistnum){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from hnd where hnd.listnum = '$getlistnum' and isdel = 0";
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
	 *   tags={"getUpdatedHnd"},
	 *   path="/apidb/product/getUpdatedHnd.php",
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

	function getUpdatedHnd($getTstamp,$startingRecord,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from hnd where tstamp > '$thisDate' LIMIT ?,?";
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
	 *   tags={"getHnd"},
	 *   path="/apidb/product/getHnd.php",
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
	function getHnd($getlistnum,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
			$query = "select * from hnd where hnd.listnum and isdel = 0 order by listnum LIMIT ?";
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
 *   path="/apidb/product/updateHnd.php",
 *   summary="Update inventory item",
 *   tags={"updateHnd"},
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
 *           property="line",
 *           type="string",
 *           example="1"
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
 *           property="sku",
 *           type="string",
 *           example="10686"
 *         ),
 *         @OA\Property(
 *           property="type",
 *           type="string",
 *           example="1000"
 *         ),
 *         @OA\Property(
 *           property="descript",
 *           type="string",
 *           example="AGALIMA - BLOODY MIX"
 *         ),
 *         @OA\Property(
 *           property="sname",
 *           type="string",
 *           example="1 LT"
 *         ),
 *         @OA\Property(
 *           property="ml",
 *           type="string",
 *           example="1000"
 *         ),
 *         @OA\Property(
 *           property="pack",
 *           type="string",
 *           example="3"
 *         ),
 *         @OA\Property(
 *           property="ccost",
 *           type="string",
 *           example="21.45"
 *         ),
 *         @OA\Property(
 *           property="floor",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="back",
 *           type="string",
 *           example="0/2"
 *         ),
 *         @OA\Property(
 *           property="shipped",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="kits",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="posted",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="store",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="upc",
 *           type="string",
 *           example="070491403352"
 *         ),
 *         @OA\Property(
 *           property="glinv",
 *           type="string",
 *           example="01504"
 *         ),
 *         @OA\Property(
 *           property="glexp",
 *           type="string",
 *           example="07940"
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

	function updateHnd(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "INSERT INTO hnd (listnum,line,listname,listtype,sku,type,descript,sname,ml,pack,ccost,floor,back,shipped,kits,posted,store,upc,glinv,glexp,tstamp,isdel,lreg,lstore)
			VALUES 
		(:listnum,:line,:listname,:listtype,:sku,:type,:descript,:sname,:ml,:pack,:ccost,:floor,:back,:shipped,:kits,:posted,:store,:upc,:glinv,:glexp,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		listtype = :listtype,
		sku = :sku,
		type = :type,
		descript = :descript,
		sname = :sname,
		ml = :ml,
		pack = :pack,
		ccost = :ccost,
		floor = :floor,
		back = :back,
		shipped = :shipped,
		kits = :kits,
		posted = :posted,
		store = :store,
		upc = :upc,
		glinv = :glinv,
		glexp = :glexp,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->listnum=strip_tags($this->listnum);
		$this->line=strip_tags($this->line);
		$this->listname=strip_tags($this->listname);
		$this->listtype=strip_tags($this->listtype);
		$this->sku=strip_tags($this->sku);
		$this->type=strip_tags($this->type);
		$this->descript=strip_tags($this->descript);
		$this->sname=strip_tags($this->sname);
		$this->ml=strip_tags($this->ml);
		$this->pack=strip_tags($this->pack);
		$this->ccost=strip_tags($this->ccost);
		$this->floor=strip_tags($this->floor);
		$this->back=strip_tags($this->back);
		$this->shipped=strip_tags($this->shipped);
		$this->kits=strip_tags($this->kits);
		$this->posted=strip_tags($this->posted);
		$this->store=strip_tags($this->store);
		$this->upc=strip_tags($this->upc);
		$this->glinv=strip_tags($this->glinv);
		$this->glexp=strip_tags($this->glexp);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':listnum', $this->listnum);
		$stmt->bindParam(':line', $this->line);
		$stmt->bindParam(':listname', $this->listname);
		$stmt->bindParam(':listtype', $this->listtype);
		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':type', $this->type);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':sname', $this->sname);
		$stmt->bindParam(':ml', $this->ml);
		$stmt->bindParam(':pack', $this->pack);
		$stmt->bindParam(':ccost', $this->ccost);
		$stmt->bindParam(':floor', $this->floor);
		$stmt->bindParam(':back', $this->back);
		$stmt->bindParam(':shipped', $this->shipped);
		$stmt->bindParam(':kits', $this->kits);
		$stmt->bindParam(':posted', $this->posted);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':upc', $this->upc);
		$stmt->bindParam(':glinv', $this->glinv);
		$stmt->bindParam(':glexp', $this->glexp);
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
