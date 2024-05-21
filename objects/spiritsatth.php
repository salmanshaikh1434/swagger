<?php
error_reporting(E_ALL);
ini_set('display_error', 0);


require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class spiritsatth
{
	private $conn;
	protected $key = '0987654321!@#$';

	public function __construct($db)
	{
		$this->conn = $db;
	}
	/**
	 * @OA\Get(
	 *   tags={"readatth"},
	 *   path="/apidb/product/readatth.php",
	 *   summary="read attd data by id",
	 *   @OA\Parameter(
	 *     name="id", 
	 *     in="query", 
	 *     required=true, 
	 *     description="ID item to get",
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
	function readAtth($getid)
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));


			if (isset($decoded->username) && $decoded->username == 'u_asidb') {

				$query = "select * from atth where atth.id = $getid and isdel = 0";
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
	 *   tags={"getupdatedatth"},
	 *   path="/apidb/product/getupdatedatth.php",
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

	function getUpdatedAtth($getTstamp, $startingRecord, $records_per_page)
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));


			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
				$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
				$query = "select * from atth where tstamp > '$thisDate' LIMIT ?,?";
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
	 *     path="/apidb/product/getatth.php",
	 *      tags={"getatth"},
	 * 		summary = "get all atth",
	 *     @OA\Response(response="200", description="An example resource"),
	 *     security={ {"bearerToken": {}}}
	 * )
	 */
	function getAtth($getid, $records_per_page)
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));


			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
				$query = "select * from atth where isdel = 0 order by id";
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
	 *   path="/apidb/product/updateatth.php",
	 *   tags={"updateatth"},
	 *   summary="Update or insert data into 'atth' table",
	 *   description="This endpoint inserts a new record into the 'atth' table if the provided ID does not already exist in the table. If the ID already exists, it updates the existing record.",
	 *   @OA\RequestBody(
	 *     required=true,
	 *     description="Data to be inserted or updated",
	 *     @OA\MediaType(
	 *       mediaType="application/json",
	 *       @OA\Schema(
	 *         type="object",
	 *         @OA\Property(
	 *           property="id",
	 *           type="string",
	 *           description="ID of the record"
	 *         ),
	 *         @OA\Property(
	 *           property="name",
	 *           type="string",
	 *           description="Name of the record"
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
	 *         ),
	 *         @OA\Property(
	 *           property="isdel",
	 *           type="string",
	 *           description="Flag indicating if the record is deleted"
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
	 *    security={ {"bearerToken": {}}}
	 * )
	 */

	function updateAtth()
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));


			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
				$query = "INSERT INTO atth (id,name,tstamp,isdel,lreg,lstore)
			VALUES 
		(:id,:name,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		name = :name,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

				$stmt = $this->conn->prepare($query);
				$this->id = strip_tags($this->id);
				$this->name = strip_tags($this->name);
				$this->lreg = strip_tags($this->lreg);
				$this->lstore = strip_tags($this->lstore);
				$this->isdel = strip_tags($this->isdel);

				$stmt->bindParam(':id', $this->id);
				$stmt->bindParam(':name', $this->name);
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