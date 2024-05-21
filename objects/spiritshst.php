<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class spiritshst{
	private $conn;
	protected $key = '0987654321!@#$';

	
    public function __construct($db){
        $this->conn = $db;
    }
	/**
	 * @OA\Get(
	 *   tags={"readhst"},
	 *   path="/apidb/product/readhst.php",
	 *   summary="get attribute data by sku",
	 *   @OA\Parameter(
	 *     name="sku", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata  by sku",
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
	function readhst($getSku,$getTstamp,$getStore){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
	$thisDate = date('Y-m-d', strtotime($getTstamp));
	if($getStore>0){
		$query = "select sku,date,edate,qty,price,cost,promo,store,pack from hst where sku = $getSku and date >= '$thisDate' and store = $getStore";
	}else{
		$query = "select sku,date,edate,qty,price,cost,promo,store,pack from hst where sku = $getSku and date >= '$thisDate'";
	}
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
	 *   tags={"getUpdatedHst"},
	 *   path="/apidb/product/getUpdatedHst.php",
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
	function getUpdatedHst($getTstamp,$getPage,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
			$thisTstamp = date('Y-m-d H:i:s', strtotime($getTstamp));
			$thisPageLimit = ($getPage*$records_per_page);
			$query = "select * from hst where tstamp > '$thisTstamp' order by tstamp LIMIT ?,?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $thisPageLimit, PDO::PARAM_INT);
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

	// created this new function as it does not exist by salman on 24/03/2023
	/**
	 * @OA\Get(
	 *   tags={"getHst"},
	 *   path="/apidb/product/getHst.php",
	 *   summary="get attribute data by sku",
	 *   @OA\Parameter(
	 *     name="sku", 
	 *     in="query", 
	 *     required=false, 
	 *     description="getdata  by sku",
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
	function getHst($getdate, $records_per_page)
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from hst where hst.date >= '$getdate' and isdel = 0 limit ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindparam(1, $records_per_page, PDO::PARAM_INT);	
		$stmt->execute();
		return $stmt;
	} else {
		return false;
	}
} else {
	return false;
}
	}


	function getHstPage($getPage, $records_per_page)
	{
	
		$query = "select * from hst where isdel = 0 order by tstamp LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $getPage, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);	
		$stmt->execute();
		return $stmt;

	}
	
		function getRecCountHST($getTstamp,$getLreg){
		$thisTstamp = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "SELECT COUNT(*) as total_rows FROM hst where tstamp > '$thisTstamp'";
		$stmt = $this->conn->prepare($query );
		$stmt->execute();
		return $stmt;

	}
/**
	 * @OA\Get(
	 *   tags={"readHstSum"},
	 *   path="/apidb/product/readHstSum.php",
	 *   summary="get attribute data by sku",
	 *   @OA\Parameter(
	 *     name="sku", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata  by sku",
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
	function readHstSum($getSku,$getStore){		
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from hstsum where sku = $getSku and store = $getStore";
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
 *   path="/apidb/product/updateHst.php",
 *   summary="Update item details",
 *   tags={"updateHst"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="sku",
 *           type="string",
 *           example="10004"
 *         ),
 *         @OA\Property(
 *           property="date",
 *           type="string",
 *           format="date",
 *           example="2023-01-23"
 *         ),
 *         @OA\Property(
 *           property="edate",
 *           type="string",
 *           format="date",
 *           example="0000-00-00"
 *         ),
 *         @OA\Property(
 *           property="qty",
 *           type="string",
 *           example="3"
 *         ),
 *         @OA\Property(
 *           property="price",
 *           type="string",
 *           example="2.99"
 *         ),
 *         @OA\Property(
 *           property="cost",
 *           type="string",
 *           example="1.83"
 *         ),
 *         @OA\Property(
 *           property="promo",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="store",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="pack",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="who",
 *           type="string",
 *           example="pos"
 *         ),
 *         @OA\Property(
 *           property="lvl1qty",
 *           type="string",
 *           example="3"
 *         ),
 *         @OA\Property(
 *           property="lvl1price",
 *           type="string",
 *           example="2.99"
 *         ),
 *         @OA\Property(
 *           property="lvl1cost",
 *           type="string",
 *           example="1.83"
 *         ),
 *         @OA\Property(
 *           property="lvl2qty",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="lvl2price",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="lvl2cost",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="lvl3qty",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="lvl3price",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="lvl3cost",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="lvl4qty",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="lvl4price",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="lvl4cost",
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
 *           property="tstamp",
 *           type="string",
 *           format="date-time",
 *           example="2024-02-04 23:23:50"
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

	function updateHst(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "INSERT INTO hst (sku,date,qty,price,cost,promo,store,pack,who,tstamp,lvl1qty,lvl1price,lvl1cost,lvl2qty,lvl2price,lvl2cost,lvl3qty,lvl3price,lvl3cost,lvl4qty,lvl4price,lvl4cost,sent,isdel,lreg,lstore)
			VALUES 
		(:sku,:date,:qty,:price,:cost,:promo,:store,:pack,:who,now(),:lvl1qty,:lvl1price,:lvl1cost,:lvl2qty,:lvl2price,:lvl2cost,:lvl3qty,:lvl3price,:lvl3cost,:lvl4qty,:lvl4price,:lvl4cost,:sent,0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		qty = qty + :qty, 
		price = price + :price,
		cost = cost + :cost,
		who = :who,
		tstamp = now(),
		lvl1qty = lvl1qty+:lvl1qty,
		lvl1price = lvl1price+:lvl1price,
		lvl1cost = lvl1cost+:lvl1cost,
		lvl2qty= lvl2qty+:lvl2qty,
		lvl2price= lvl2price+:lvl2price,
		lvl2cost= lvl2cost+:lvl2cost,
		lvl3qty= lvl3qty+:lvl3qty,
		lvl3price= lvl3price+:lvl3price,
		lvl3cost= lvl3cost+:lvl3cost,
		lvl4qty= lvl4qty+:lvl4qty,
		lvl4price= lvl4price+:lvl4price,
		lvl4cost= lvl4cost+:lvl4cost,
		sent = :sent,
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->sku=strip_tags($this->sku);
		$this->date=strip_tags($this->date);
		$this->qty=strip_tags($this->qty);
		$this->price=strip_tags($this->price);
		$this->cost=strip_tags($this->cost);
		$this->promo=strip_tags($this->promo);
		$this->store=strip_tags($this->store);
		$this->pack=strip_tags($this->pack);
		$this->who=strip_tags($this->who);
		$this->lvl1qty=strip_tags($this->lvl1qty);
		$this->lvl1price=strip_tags($this->lvl1price);
		$this->lvl1cost=strip_tags($this->lvl1cost);
		$this->lvl2qty=strip_tags($this->lvl2qty);
		$this->lvl2price=strip_tags($this->lvl2price);
		$this->lvl2cost=strip_tags($this->lvl2cost);
		$this->lvl3qty=strip_tags($this->lvl3qty);
		$this->lvl3price=strip_tags($this->lvl3price);
		$this->lvl3cost=strip_tags($this->lvl3cost);
		$this->lvl4qty=strip_tags($this->lvl4qty);
		$this->lvl4price=strip_tags($this->lvl4price);
		$this->lvl4cost=strip_tags($this->lvl4cost);
		$this->who=strip_tags($this->who);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);
		
		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':date', $this->date);
		$stmt->bindParam(':qty', $this->qty);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':cost', $this->cost);
		$stmt->bindParam(':promo', $this->promo);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':pack', $this->pack);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':lvl1qty', $this->lvl1qty);
		$stmt->bindParam(':lvl1price', $this->lvl1price);
		$stmt->bindParam(':lvl1cost', $this->lvl1cost);
		$stmt->bindParam(':lvl2qty', $this->lvl2qty);
		$stmt->bindParam(':lvl2price', $this->lvl2price);
		$stmt->bindParam(':lvl2cost', $this->lvl2cost);
		$stmt->bindParam(':lvl3qty', $this->lvl3qty);
		$stmt->bindParam(':lvl3price', $this->lvl3price);
		$stmt->bindParam(':lvl3cost', $this->lvl3cost);
		$stmt->bindParam(':lvl4qty', $this->lvl4qty);
		$stmt->bindParam(':lvl4price', $this->lvl4price);
		$stmt->bindParam(':lvl4cost', $this->lvl4cost);
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