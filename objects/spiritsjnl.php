<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class spiritsjnl{
	private $conn;
	protected $key = '0987654321!@#$';


	public function __construct($db){
		$this->conn = $db;
	}
/**
	 * @OA\Get(
	 *   tags={"readJnl"},
	 *   path="/apidb/product/readJnl.php",
	 *   summary="get attribute data by store",
	 *   @OA\Parameter(
	 *     name="store", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata  by store",
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
	function readJnl($getstore,$getsale,$getline){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from jnl where jnl.store = '$getstore' and isdel = 0";
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
	 *   tags={"getUpdatedJnl"},
	 *   path="/apidb/product/getUpdatedJnl.php",
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

	function getUpdatedJnl($getTstamp,$startingRecord,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		//$query = "select * from jnl where date > '$thisDate' LIMIT ?,?";
        $query = "select * from jnl where tstamp > '$thisDate' order by tstamp LIMIT ?,?";
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
	 *   tags={"getJnl"},
	 *   path="/apidb/product/getJnl.php",
	 *   summary="get attribute data by store",
	 *   @OA\Parameter(
	 *     name="store", 
	 *     in="query", 
	 *     required=false, 
	 *     description="getdata  by store",
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
	function getJnl($getPage,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
			// $thisPageLimit = ($getPage*$records_per_page);
			$query = "select * from jnl where isdel = 0 order by tstamp LIMIT ?,?";
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

	function getJnlbydate( $datestart ,$dateend){
		$datestart =  date('Y-m-d',strtotime($datestart));
		$dateend = date('Y-m-d',strtotime($dateend));
	        $query = "select * from jnl where `date` between ? and ?";
		$stmt = $this->conn->prepare($query); 
		$stmt->bindParam(1, $datestart, PDO::PARAM_STR);
		$stmt->bindParam(2, $dateend, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt;
	}
	
	function readJnlUpdate($getSale,$getStore){
			$query = "select * from jnl where isdel = 0 and sale = $getSale and store = $getStore";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}
	function readJnlReturn($getReference){
		$query = "select * from jnl where sale in (select sale from jnh where reference = $getReference)";
		$stmt = $this->conn->prepare($query); 
		$stmt->execute();
		return $stmt;
	}
	/**
 * @OA\Post(
 *   path="/apidb/product/updateJnl.php",
 *   summary="Update sale details",
 *   tags={"updateJnl"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="store",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="sale",
 *           type="string",
 *           example="99000002"
 *         ),
 *         @OA\Property(
 *           property="line",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="qty",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="pack",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="sku",
 *           type="string",
 *           example="10336"
 *         ),
 *         @OA\Property(
 *           property="descript",
 *           type="string",
 *           example="5.0 O LAYS - DORITOS - SPICY SWEET C"
 *         ),
 *         @OA\Property(
 *           property="price",
 *           type="string",
 *           example="2.19"
 *         ),
 *         @OA\Property(
 *           property="cost",
 *           type="string",
 *           example="1.53"
 *         ),
 *         @OA\Property(
 *           property="discount",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="dclass",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="promo",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="cat",
 *           type="string",
 *           example="190"
 *         ),
 *         @OA\Property(
 *           property="location",
 *           type="string",
 *           example="B"
 *         ),
 *         @OA\Property(
 *           property="rflag",
 *           type="string",
 *           example="9"
 *         ),
 *         @OA\Property(
 *           property="upc",
 *           type="string",
 *           example="028400325080"
 *         ),
 *         @OA\Property(
 *           property="boss",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="memo",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="date",
 *           type="string",
 *           format="date",
 *           example="2022-07-05"
 *         ),
 *         @OA\Property(
 *           property="prclevel",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="fspoints",
 *           type="string",
 *           example="0.00"
 *         ),
 *         @OA\Property(
 *           property="rtnqty",
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
 *           example="2022-07-05 15:05:17"
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


	function updateJnl(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "INSERT INTO jnl (store,sale,line,qty,pack,sku,descript,price,cost,discount,dclass,promo,cat,location,rflag,upc,boss,memo,date,prclevel,fspoints,rtnqty,isdel,lreg,lstore,tstamp)
			VALUES 
		(:store,:sale,:line,:qty,:pack,:sku,:descript,:price,:cost,:discount,:dclass,:promo,:cat,:location,:rflag,:upc,:boss,:memo,:date,:prclevel,:fspoints,:rtnqty,0,:lreg,:lstore,now())
		ON DUPLICATE KEY UPDATE
		qty = :qty,
		pack = :pack,
		sku = :sku,
		descript = :descript,
		price = :price,
		cost = :cost,
		discount = :discount,
		dclass = :dclass,
		promo = :promo,
		cat = :cat,
		location = :location,
		rflag = :rflag,
		upc = :upc,
		boss = :boss,
		memo = :memo,
		tstamp = NOW(),
		date = :date,
		prclevel = :prclevel,
		fspoints = :fspoints,
		rtnqty = :rtnqty,
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->store=strip_tags($this->store);
		$this->sale=strip_tags($this->sale);
		$this->line=strip_tags($this->line);
		$this->qty=strip_tags($this->qty);
		$this->pack=strip_tags($this->pack);
		$this->sku=strip_tags($this->sku);
		$this->descript=strip_tags($this->descript);
		$this->price=strip_tags($this->price);
		$this->cost=strip_tags($this->cost);
		$this->discount=strip_tags($this->discount);
		$this->dclass=strip_tags($this->dclass);
		$this->promo=strip_tags($this->promo);
		$this->cat=strip_tags($this->cat);
		$this->location=strip_tags($this->location);
		$this->rflag=strip_tags($this->rflag);
		$this->upc=strip_tags($this->upc);
		$this->boss=strip_tags($this->boss);
		$this->memo=strip_tags($this->memo);
		$this->date=strip_tags($this->date);
		$this->prclevel=strip_tags($this->prclevel);
		$this->fspoints=strip_tags($this->fspoints);
		$this->rtnqty=strip_tags($this->rtnqty);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':sale', $this->sale);
		$stmt->bindParam(':line', $this->line);
		$stmt->bindParam(':qty', $this->qty);
		$stmt->bindParam(':pack', $this->pack);
		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':cost', $this->cost);
		$stmt->bindParam(':discount', $this->discount);
		$stmt->bindParam(':dclass', $this->dclass);
		$stmt->bindParam(':promo', $this->promo);
		$stmt->bindParam(':cat', $this->cat);
		$stmt->bindParam(':location', $this->location);
		$stmt->bindParam(':rflag', $this->rflag);
		$stmt->bindParam(':upc', $this->upc);
		$stmt->bindParam(':boss', $this->boss);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':date', $this->date);
		$stmt->bindParam(':prclevel', $this->prclevel);
		$stmt->bindParam(':fspoints', $this->fspoints);
		$stmt->bindParam(':rtnqty', $this->rtnqty);
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