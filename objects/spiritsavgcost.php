<?php
error_reporting(E_ALL);
ini_set('display_error', 0);


require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class spiritsavgcost
{
	private $conn;
	protected $key = '0987654321!@#$';

	public function __construct($db)
	{
		$this->conn = $db;
	}

	/**
	 * @OA\Get(
	 *   tags={"getupdatedavgcost"},
	 *   path="/apidb/product/getupdatedavgcost.php",
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

	function getUpdatedAvgcost($getTstamp, $startingRecord, $records_per_page)
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
				$thisDate = date('Y-m-d', strtotime($getTstamp));
				$query = "select * from avgcost where tstamp > '$thisDate' LIMIT ?,?";
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
	 *   tags={"readavgcost"},
	 *   path="/apidb/product/readavgcost.php",
	 *   summary="read avgcost data by id",
	 *   @OA\Parameter(
	 *     name="sku", 
	 *     in="query", 
	 *     required=true, 
	 *     description="sku number",
	 *     @OA\Schema(
	 *       type="integer"
	 *     )
	 *   ),
	 *     @OA\Parameter(
	 *     name="store", 
	 *     in="query", 
	 *     required=true, 
	 *     description="store number",
	 *     @OA\Schema(
	 *       type="integer"
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found"),
	 *   security={ {"bearerToken": {}}}
	 * )
	 */
	function readAvgcost($getSku, $getStore)
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
				if ($getStore > 1) {
					$query = "select * from avgcost where sku = $getSku and isdel = 0 and store = $getStore order by tstamp";
				} else {
					$query = "select * from avgcost where sku = $getSku and isdel = 0 order by tstamp";
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
	 * @OA\Post(
	 *   path="/apidb/product/updateavgcost.php",
	 *   tags={"updateavgcost"},
	 *   summary="Update or insert data into 'avgcost' table",
	 *   description="This endpoint inserts a new record into the 'avgcost' table if the provided SKU and store combination does not already exist in the table. If the combination already exists, it updates the existing record.",
	 *   @OA\RequestBody(
	 *     required=true,
	 *     description="Data to be inserted or updated",
	 *     @OA\MediaType(
	 *       mediaType="application/json",
	 *       @OA\Schema(
	 *         type="object",
	 *         @OA\Property(
	 *           property="sku",
	 *           type="string",
	 *           description="SKU of the product"
	 *         ),
	 *         @OA\Property(
	 *           property="store",
	 *           type="string",
	 *           description="Store identifier"
	 *         ),
	 *         @OA\Property(
	 *           property="oldcost",
	 *           type="string",
	 *           description="Old cost value"
	 *         ),
	 *         @OA\Property(
	 *           property="newcost",
	 *           type="string",
	 *           description="New cost value"
	 *         ),
	 *         @OA\Property(
	 *           property="who",
	 *           type="string",
	 *           description="Identifier of the user who initiated the change"
	 *         ),
	 *         @OA\Property(
	 *           property="type",
	 *           type="string",
	 *           description="Type of change"
	 *         ),
	 *         @OA\Property(
	 *           property="number",
	 *           type="string",
	 *           description="Number of items affected"
	 *         ),
	 *         @OA\Property(
	 *           property="costype",
	 *           type="string",
	 *           description="Cost type"
	 *         ),
	 *         @OA\Property(
	 *           property="posted",
	 *           type="string",
	 *           description="Posted status"
	 *         ),
	 *         @OA\Property(
	 *           property="sent",
	 *           type="string",
	 *           description="Sent status"
	 *         ),
	 *         @OA\Property(
	 *           property="isdel",
	 *           type="string",
	 *           description="Flag indicating if the record is deleted"
	 *         ),
	 *         @OA\Property(
	 *           property="lreg",
	 *           type="string",
	 *           description="Value for 'lreg' column"
	 *         ),
	 *         @OA\Property(
	 *           property="lstore",
	 *           type="string",
	 *           description="Value for 'lstore' column"
	 *         )
	 *       )
	 *     )
	 *   ),
	 *   @OA\Response(
	 *     response=200,
	 *     description="Success message"
	 *   ),
	 *   @OA\Response(
	 *     response=400,
	 *     description="Bad request"
	 *   ),
	 *   security={ {"bearerToken": {}}}
	 * )
	 */


	function updateAvgcost()
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
				$query = "INSERT INTO avgcost (sku,store,oldcost,newcost,who,type,number,costype,posted,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:sku,:store,:oldcost,:newcost,:who,:type,:number,:costype,:posted,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		sku = :sku,
		store = :store,
		oldcost = :oldcost,
		newcost = :newcost,
		who = :who,
		type = :type,
		number = :number,
		costype = :costype,
		posted = :posted,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

				$stmt = $this->conn->prepare($query);
				$this->sku = strip_tags($this->sku);
				$this->store = strip_tags($this->store);
				$this->oldcost = strip_tags($this->oldcost);
				$this->newcost = strip_tags($this->newcost);
				$this->who = strip_tags($this->who);
				$this->type = strip_tags($this->type);
				$this->number = strip_tags($this->number);
				$this->costype = strip_tags($this->costype);
				$this->posted = strip_tags($this->posted);
				$this->sent = strip_tags($this->sent);
				$this->lreg = strip_tags($this->lreg);
				$this->lstore = strip_tags($this->lstore);
				$this->isdel = strip_tags($this->isdel);

				$stmt->bindParam(':sku', $this->sku);
				$stmt->bindParam(':store', $this->store);
				$stmt->bindParam(':oldcost', $this->oldcost);
				$stmt->bindParam(':newcost', $this->newcost);
				$stmt->bindParam(':who', $this->who);
				$stmt->bindParam(':type', $this->type);
				$stmt->bindParam(':number', $this->number);
				$stmt->bindParam(':costype', $this->costype);
				$stmt->bindParam(':posted', $this->posted);
				$stmt->bindParam(':sent', $this->sent);
				$stmt->bindParam(':lreg', $this->lreg);
				$stmt->bindParam(':lstore', $this->lstore);
				$stmt->bindParam(':isdel', $this->isdel);


				if ($stmt->execute()) {
					return 'OK';
				} else {
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