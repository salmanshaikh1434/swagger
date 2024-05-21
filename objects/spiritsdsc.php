<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class spiritsdsc{
	private $conn;
	protected $key = '0987654321!@#$';


	public function __construct($db){
		$this->conn = $db;
	}
		/**
	 * @OA\Get(
	 *   tags={"readDsc"},
	 *   path="/apidb/product/readDsc.php",
	 *   summary="Read attribute data by dcode",
	 *   @OA\Parameter(
	 *     name="dcode", 
	 *     in="query", 
	 *     required=true, 
	 *     description="Read data  by dcode",
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

	function readDsc($getdcode){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from dsc where dsc.dcode = '$getdcode' and isdel = 0";
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
	 *   tags={"getUpdatedDsc"},
	 *   path="/apidb/product/getUpdatedDsc.php",
	 *   summary="updated attribute data by dcode",
	 *   @OA\Parameter(
	 *     name="dcode", 
	 *     in="query", 
	 *     required=true, 
	 *     description="updated data ",
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

	function getUpdatedDsc($getTstamp,$startingRecord,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from dsc where tstamp > '$thisDate' LIMIT ?,?";
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
	 *   tags={"getDsc"},
	 *   path="/apidb/product/getDsc.php",
	 *   summary="get attribute data by dcode",
	 *   @OA\Parameter(
	 *     name="dcode", 
	 *     in="query", 
	 *     required=false, 
	 *     description="getdata  by dcode",
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
	function getDsc($getdcode,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
			$query = "select * from dsc where isdel = 0 order by dcode";
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
 *   path="/apidb/product/updateDsc.php",
 *   summary="Bulk update deals",
 *   tags={"updateDsc"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         type="array",
 *         @OA\Items(
 *           @OA\Property(
 *             property="dcode",
 *             type="string",
 *             example="000"
 *           ),
 *           @OA\Property(
 *             property="chain",
 *             type="string",
 *             example=""
 *           ),
 *           @OA\Property(
 *             property="descript",
 *             type="string",
 *             example="Mixed Case"
 *           ),
 *           @OA\Property(
 *             property="mix",
 *             type="string",
 *             example="1"
 *           ),
 *           @OA\Property(
 *             property="match",
 *             type="string",
 *             example="0"
 *           ),
 *           @OA\Property(
 *             property="qty",
 *             type="string",
 *             example="1"
 *           ),
 *           @OA\Property(
 *             property="qtype",
 *             type="string",
 *             example="C"
 *           ),
 *           @OA\Property(
 *             property="level1disc",
 *             type="string",
 *             example="0"
 *           ),
 *           @OA\Property(
 *             property="level2disc",
 *             type="string",
 *             example=""
 *           ),
 *           @OA\Property(
 *             property="level3disc",
 *             type="string",
 *             example=""
 *           ),
 *           @OA\Property(
 *             property="level4disc",
 *             type="string",
 *             example=""
 *           ),
 *           @OA\Property(
 *             property="level5disc",
 *             type="string",
 *             example=""
 *           ),
 *           @OA\Property(
 *             property="additive",
 *             type="string",
 *             example="0"
 *           ),
 *           @OA\Property(
 *             property="freesku",
 *             type="string",
 *             example="0"
 *           ),
 *           @OA\Property(
 *             property="freeqty",
 *             type="string",
 *             example="0"
 *           ),
 *           @OA\Property(
 *             property="promo",
 *             type="string",
 *             example=""
 *           ),
 *           @OA\Property(
 *             property="onsale",
 *             type="string",
 *             example="0"
 *           ),
 *           @OA\Property(
 *             property="who",
 *             type="string",
 *             example="asi"
 *           ),
 *           @OA\Property(
 *             property="override",
 *             type="string",
 *             example="0"
 *           ),
 *           @OA\Property(
 *             property="level6disc",
 *             type="string",
 *             example=""
 *           ),
 *           @OA\Property(
 *             property="level7disc",
 *             type="string",
 *             example=""
 *           ),
 *           @OA\Property(
 *             property="level8disc",
 *             type="string",
 *             example=""
 *           ),
 *           @OA\Property(
 *             property="sent",
 *             type="string",
 *             example="0"
 *           ),
 *           @OA\Property(
 *             property="lreg",
 *             type="string",
 *             example="99"
 *           ),
 *           @OA\Property(
 *             property="lstore",
 *             type="string",
 *             example="1"
 *           ),
 *           @OA\Property(
 *             property="isdel",
 *             type="string",
 *             example="0"
 *           )
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


	function updateDsc(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "INSERT INTO dsc (dcode,chain,descript,mix,`match`,qty,qtype,level1disc,level2disc,level3disc,level4disc,level5disc,additive,freesku,freeqty,promo,onsale,who,override,level6disc,level7disc,level8disc,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:dcode,:chain,:descript,:mix,:match,:qty,:qtype,:level1disc,:level2disc,:level3disc,:level4disc,:level5disc,:additive,:freesku,:freeqty,:promo,:onsale,:who,:override,:level6disc,:level7disc,:level8disc,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		chain = :chain,
		descript = :descript,
		mix = :mix,
		`match` = :match,
		qty = :qty,
		qtype = :qtype,
		level1disc = :level1disc,
		level2disc = :level2disc,
		level3disc = :level3disc,
		level4disc = :level4disc,
		level5disc = :level5disc,
		additive = :additive,
		freesku = :freesku,
		freeqty = :freeqty,
		promo = :promo,
		onsale = :onsale,
		who = :who,
		override = :override,
		level6disc = :level6disc,
		level7disc = :level7disc,
		level8disc = :level8disc,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->dcode=strip_tags($this->dcode);
		$this->chain=strip_tags($this->chain);
		$this->descript=strip_tags($this->descript);
		$this->mix=strip_tags($this->mix);
		$this->match=strip_tags($this->match);
		$this->qty=strip_tags($this->qty);
		$this->qtype=strip_tags($this->qtype);
		$this->level1disc=strip_tags($this->level1disc);
		$this->level2disc=strip_tags($this->level2disc);
		$this->level3disc=strip_tags($this->level3disc);
		$this->level4disc=strip_tags($this->level4disc);
		$this->level5disc=strip_tags($this->level5disc);
		$this->additive=strip_tags($this->additive);
		$this->freesku=strip_tags($this->freesku);
		$this->freeqty=strip_tags($this->freeqty);
		$this->promo=strip_tags($this->promo);
		$this->onsale=strip_tags($this->onsale);
		$this->who=strip_tags($this->who);
		$this->override=strip_tags($this->override);
		$this->level6disc=strip_tags($this->level6disc);
		$this->level7disc=strip_tags($this->level7disc);
		$this->level8disc=strip_tags($this->level8disc);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':dcode', $this->dcode);
		$stmt->bindParam(':chain', $this->chain);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':mix', $this->mix);
		$stmt->bindParam(':match', $this->match);
		$stmt->bindParam(':qty', $this->qty);
		$stmt->bindParam(':qtype', $this->qtype);
		$stmt->bindParam(':level1disc', $this->level1disc);
		$stmt->bindParam(':level2disc', $this->level2disc);
		$stmt->bindParam(':level3disc', $this->level3disc);
		$stmt->bindParam(':level4disc', $this->level4disc);
		$stmt->bindParam(':level5disc', $this->level5disc);
		$stmt->bindParam(':additive', $this->additive);
		$stmt->bindParam(':freesku', $this->freesku);
		$stmt->bindParam(':freeqty', $this->freeqty);
		$stmt->bindParam(':promo', $this->promo);
		$stmt->bindParam(':onsale', $this->onsale);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':override', $this->override);
		$stmt->bindParam(':level6disc', $this->level6disc);
		$stmt->bindParam(':level7disc', $this->level7disc);
		$stmt->bindParam(':level8disc', $this->level8disc);
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
