<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class spiritscat{
	private $conn;
	protected $key = '0987654321!@#$';


	public function __construct($db){
		$this->conn = $db;
	}
	/**
	 * @OA\Get(
	 *   tags={"readCat"},
	 *   path="/apidb/product/readCat.php",
	 *   summary="get attribute data by cat",
	 *   @OA\Parameter(
	 *     name="cat", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata  by cat",
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

	function readCat($getcat){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from cat where `cat` = '$getcat' and isdel = 0";
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
	 *   tags={"getUpdatedCat"},
	 *   path="/apidb/product/getUpdatedCat.php",
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

	function getUpdatedCat($getTstamp,$startingRecord,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from cat where tstamp > '$thisDate' LIMIT ?,?";
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
	 *   tags={"getCat"},
	 *   path="/apidb/product/getCat.php",
	 *   summary="get attribute data by cat",
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found"),
	 *   security={ {"bearerToken": {}}}
	 * )
	 */

	function getCat(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {

		$query = "select * from cat where isdel = 0 order by cat";
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
 *   path="/apidb/product/updatecat.php",
 *   summary="Update category",
 *   tags={"updatecat"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="cat",
 *           type="string",
 *           example="100"
 *         ),
 *         @OA\Property(
 *           property="name",
 *           type="string",
 *           example="SODA - CHIP - SNACKS"
 *         ),
 *         @OA\Property(
 *           property="seq",
 *           type="string",
 *           example="0192"
 *         ),
 *         @OA\Property(
 *           property="lspace",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="code",
 *           type="string",
 *           example="P"
 *         ),
 *         @OA\Property(
 *           property="cost",
 *           type="string",
 *           example="80.00"
 *         ),
 *         @OA\Property(
 *           property="taxlevel",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="sur",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="disc",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="dbcr",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="cflag",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="income",
 *           type="string",
 *           example="06100"
 *         ),
 *         @OA\Property(
 *           property="cog",
 *           type="string",
 *           example="07100"
 *         ),
 *         @OA\Property(
 *           property="inventory",
 *           type="string",
 *           example="01504"
 *         ),
 *         @OA\Property(
 *           property="discount",
 *           type="string",
 *           example="D0100"
 *         ),
 *         @OA\Property(
 *           property="who",
 *           type="string",
 *           example="S2K"
 *         ),
 *         @OA\Property(
 *           property="wsgroup",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="wscod",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="wsgallons",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="catnum",
 *           type="string",
 *           example="48"
 *         ),
 *         @OA\Property(
 *           property="fson",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="fsfactor",
 *           type="string",
 *           example="0.0"
 *         ),
 *         @OA\Property(
 *           property="datacap",
 *           type="string",
 *           example="ACN"
 *         ),
 *         @OA\Property(
 *           property="sent",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="belowcost",
 *           type="string",
 *           example="1"
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
 * security={ {"bearerToken": {}}}
 * )
 */


	function updateCat(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "INSERT INTO cat (cat,name,seq,lspace,code,cost,taxlevel,sur,disc,dbcr,cflag,income,cog,inventory,discount,who,wsgroup,wscod,wsgallons,catnum,fson,fsfactor,datacap,sent,belowcost,gosent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:cat,:name,:seq,:lspace,:code,:cost,:taxlevel,:sur,:disc,:dbcr,:cflag,:income,:cog,:inventory,:discount,:who,:wsgroup,:wscod,:wsgallons,:catnum,:fson,:fsfactor,:datacap,:sent,:belowcost,:gosent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		name = :name,
		seq = :seq,
		lspace = :lspace,
		code = :code,
		cost = :cost,
		taxlevel = :taxlevel,
		sur = :sur,
		disc = :disc,
		dbcr = :dbcr,
		cflag = :cflag,
		income = :income,
		cog = :cog,
		inventory = :inventory,
		discount = :discount,
		who = :who,
		wsgroup = :wsgroup,
		wscod = :wscod,
		wsgallons = :wsgallons,
		fson = :fson,
		fsfactor = :fsfactor,
		datacap = :datacap,
		sent = :sent,
		belowcost = :belowcost,
		gosent = :gosent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->cat=strip_tags($this->cat);
		$this->name=strip_tags($this->name);
		$this->seq=strip_tags($this->seq);
		$this->lspace=strip_tags($this->lspace);
		$this->code=strip_tags($this->code);
		$this->cost=strip_tags($this->cost);
		$this->taxlevel=strip_tags($this->taxlevel);
		$this->sur=strip_tags($this->sur);
		$this->disc=strip_tags($this->disc);
		$this->dbcr=strip_tags($this->dbcr);
		$this->cflag=strip_tags($this->cflag);
		$this->income=strip_tags($this->income);
		$this->cog=strip_tags($this->cog);
		$this->inventory=strip_tags($this->inventory);
		$this->discount=strip_tags($this->discount);
		$this->who=strip_tags($this->who);
		$this->wsgroup=strip_tags($this->wsgroup);
		$this->wscod=strip_tags($this->wscod);
		$this->wsgallons=strip_tags($this->wsgallons);
		$this->catnum=strip_tags($this->catnum);
		$this->fson=strip_tags($this->fson);
		$this->fsfactor=strip_tags($this->fsfactor);
		$this->datacap=strip_tags($this->datacap);
		$this->sent=strip_tags($this->sent);
		$this->belowcost=strip_tags($this->belowcost);
		$this->gosent=strip_tags($this->gosent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':cat', $this->cat);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':seq', $this->seq);
		$stmt->bindParam(':lspace', $this->lspace);
		$stmt->bindParam(':code', $this->code);
		$stmt->bindParam(':cost', $this->cost);
		$stmt->bindParam(':taxlevel', $this->taxlevel);
		$stmt->bindParam(':sur', $this->sur);
		$stmt->bindParam(':disc', $this->disc);
		$stmt->bindParam(':dbcr', $this->dbcr);
		$stmt->bindParam(':cflag', $this->cflag);
		$stmt->bindParam(':income', $this->income);
		$stmt->bindParam(':cog', $this->cog);
		$stmt->bindParam(':inventory', $this->inventory);
		$stmt->bindParam(':discount', $this->discount);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':wsgroup', $this->wsgroup);
		$stmt->bindParam(':wscod', $this->wscod);
		$stmt->bindParam(':wsgallons', $this->wsgallons);
		$stmt->bindParam(':catnum', $this->catnum);
		$stmt->bindParam(':fson', $this->fson);
		$stmt->bindParam(':fsfactor', $this->fsfactor);
		$stmt->bindParam(':datacap', $this->datacap);
		$stmt->bindParam(':sent', $this->sent);
		$stmt->bindParam(':belowcost', $this->belowcost);
		$stmt->bindParam(':gosent', $this->gosent);
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
