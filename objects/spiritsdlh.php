<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class spiritsdlh{
	private $conn;
	protected $key = '0987654321!@#$';

	public function __construct($db){
		$this->conn = $db;
	}
			/**
	 * @OA\Get(
	 *   tags={"readDlh"},
	 *   path="/apidb/product/readDlh.php",
	 *   summary="read attribute data by dealnum",
	 *   @OA\Parameter(
	 *     name="dealnum", 
	 *     in="query", 
	 *     required=true, 
	 *     description="readdata by dealnum",
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

	function readDlh($getdealnum){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from dlh where dlh.dealnum = '$getdealnum' and isdel = 0";
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
	 *   tags={"getUpdatedDlh"},
	 *   path="/apidb/product/getUpdatedDlh.php",
	 *   summary="Update attribute data by getTstamp",
	 *   @OA\Parameter(
	 *     name="getTstamp", 
	 *     in="query", 
	 *     required=true, 
	 *     description="Update by getTstamp",
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
	
	function getUpdatedDlh($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from dlh where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
		
		
	}
		/**
	 * @OA\Get(
	 *   tags={"getDlh"},
	 *   path="/apidb/product/getDlh.php",
	 *   summary="get attribute data by dealnum",
	 *   @OA\Parameter(
	 *     name="Dlh", 
	 *     in="query", 
	 *     required=false, 
	 *     description="getdata by dealnum",
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
	function getDlh($getdealnum,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
			$query = "select * from dlh where dlh.dealnum > $getdealnum and isdel = 0 order by dealnum LIMIT ?";
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
 *   path="/apidb/product/updateDlh.php",
 *   summary="Update deal",
 *   tags={"updateDlh"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="dealnum",
 *           type="string",
 *           example="2"
 *         ),
 *         @OA\Property(
 *           property="vendor",
 *           type="string",
 *           example="624"
 *         ),
 *         @OA\Property(
 *           property="vcode",
 *           type="string",
 *           example="RUBYW"
 *         ),
 *         @OA\Property(
 *           property="venddeal",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="descript",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="startdate",
 *           type="string",
 *           example="0000-00-00"
 *         ),
 *         @OA\Property(
 *           property="stopdate",
 *           type="string",
 *           example="0000-00-00"
 *         ),
 *         @OA\Property(
 *           property="qty1",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="qty2",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="qty3",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="qty4",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="qty5",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="invoiclevl",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="accumlevl",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="qtytodate",
 *           type="string",
 *           example="0.00"
 *         ),
 *         @OA\Property(
 *           property="qtyonorder",
 *           type="string",
 *           example="0.00"
 *         ),
 *         @OA\Property(
 *           property="security",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="stores",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="who",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="memo",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="activlevel",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="accumulate",
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
 *   security={ {"bearerToken": {}} }
 * )
 */


	function updateDlh(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "INSERT INTO dlh (dealnum,vendor,vcode,venddeal,descript,startdate,stopdate,qty1,qty2,qty3,qty4,qty5,invoiclevl,accumlevl,qtytodate,qtyonorder,security,stores,who,memo,activlevel,accumulate,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:dealnum,:vendor,:vcode,:venddeal,:descript,:startdate,:stopdate,:qty1,:qty2,:qty3,:qty4,:qty5,:invoiclevl,:accumlevl,:qtytodate,:qtyonorder,:security,:stores,:who,:memo,:activlevel,:accumulate,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		vendor = :vendor,
		vcode = :vcode,
		venddeal = :venddeal,
		descript = :descript,
		startdate = :startdate,
		stopdate = :stopdate,
		qty1 = :qty1,
		qty2 = :qty2,
		qty3 = :qty3,
		qty4 = :qty4,
		qty5 = :qty5,
		invoiclevl = :invoiclevl,
		accumlevl = :accumlevl,
		qtytodate = :qtytodate,
		qtyonorder = :qtyonorder,
		security = :security,
		stores = :stores,
		who = :who,
		memo = :memo,
		activlevel = :activlevel,
		accumulate = :accumulate,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->dealnum=strip_tags($this->dealnum);
		$this->vendor=strip_tags($this->vendor);
		$this->vcode=strip_tags($this->vcode);
		$this->venddeal=strip_tags($this->venddeal);
		$this->descript=strip_tags($this->descript);
		$this->startdate=strip_tags($this->startdate);
		$this->stopdate=strip_tags($this->stopdate);
		$this->qty1=strip_tags($this->qty1);
		$this->qty2=strip_tags($this->qty2);
		$this->qty3=strip_tags($this->qty3);
		$this->qty4=strip_tags($this->qty4);
		$this->qty5=strip_tags($this->qty5);
		$this->invoiclevl=strip_tags($this->invoiclevl);
		$this->accumlevl=strip_tags($this->accumlevl);
		$this->qtytodate=strip_tags($this->qtytodate);
		$this->qtyonorder=strip_tags($this->qtyonorder);
		$this->security=strip_tags($this->security);
		$this->stores=strip_tags($this->stores);
		$this->who=strip_tags($this->who);
		$this->memo=strip_tags($this->memo);
		$this->activlevel=strip_tags($this->activlevel);
		$this->accumulate=strip_tags($this->accumulate);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':dealnum', $this->dealnum);
		$stmt->bindParam(':vendor', $this->vendor);
		$stmt->bindParam(':vcode', $this->vcode);
		$stmt->bindParam(':venddeal', $this->venddeal);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':startdate', $this->startdate);
		$stmt->bindParam(':stopdate', $this->stopdate);
		$stmt->bindParam(':qty1', $this->qty1);
		$stmt->bindParam(':qty2', $this->qty2);
		$stmt->bindParam(':qty3', $this->qty3);
		$stmt->bindParam(':qty4', $this->qty4);
		$stmt->bindParam(':qty5', $this->qty5);
		$stmt->bindParam(':invoiclevl', $this->invoiclevl);
		$stmt->bindParam(':accumlevl', $this->accumlevl);
		$stmt->bindParam(':qtytodate', $this->qtytodate);
		$stmt->bindParam(':qtyonorder', $this->qtyonorder);
		$stmt->bindParam(':security', $this->security);
		$stmt->bindParam(':stores', $this->stores);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':activlevel', $this->activlevel);
		$stmt->bindParam(':accumulate', $this->accumulate);
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
