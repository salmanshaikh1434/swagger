<?php


error_reporting(E_ALL);
ini_set('display_error', 1);


require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * @OA\Info(title="Spirits Cloud API", version="0.1")
 * *    @OA\SecurityScheme(
 *        type="http",
 *        description="Authorisation with JWT generated tokens",
 *        name="Authorization",
 *        in="header",
 *        scheme="bearer",
 *        bearerFormat="JWT",
 *        securityScheme="bearerToken"
 *    )
 */
class spiritsattd
{
	private $conn;
	protected $key = '0987654321!@#$';

	public function __construct($db)
	{
		$this->conn = $db;
	}

	/**
	 * @OA\Get(
	 *     path="/apidb/product/auth.php",
	 *      tags={"security"},
	 * 		summary = "generates token for validation",
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=404, description="Not Found"),
	 * )
	 */
	public function auth()
	{
		try {

			$issueDate = time();
			$expirationDate = time() * 3600;
			$payload = array(
				"iss" => "http://localhost/apidb",
				"aud" => "http://localhost",
				"iat" => $issueDate,
				"exp" => $expirationDate,
				"username" => 'u_asidb',
			);
			$jwtGeneratedToken = JWT::encode($payload, $this->key, 'HS256');
			return [
				"token" => $jwtGeneratedToken,
				"expires" => $expirationDate,
			];
		} catch (PDOException $e) {
			echo $e->getMessage();
		}


	}

	/**
	 * @OA\Get(
	 *   tags={"readattd"},
	 *   path="/apidb/product/readattd.php",
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
	 *    security={ {"bearerToken": {}}}  
	 * )
	 */


	function readAttd($getid)
	{

		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));


			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
				$query = "select * from attd where attd.id = $getid and isdel = 0";
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
	 *   tags={"getupdatedattd"},
	 *   path="/apidb/product/getupdatedattd.php",
	 *   summary="get attribute data by tstamp",
	 *   @OA\Parameter(
	 *     name="tstamp", 
	 *     in="query", 
	 *     required=true, 
	 *     description="ID item to get",
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

	function getUpdatedAttd($getTstamp, $startingRecord, $records_per_page)
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));


			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
				$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
				$query = "select * from attd where tstamp > '$thisDate' LIMIT ?,?";
				$stmt = $this->conn->prepare($query);
				$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
				$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
				$stmt->execute();
				return $stmt;
			}

		} else {
			return false;
		}

	}
	/**
	 * @OA\Get(
	 *     path="/apidb/product/getattd.php",
	 *      tags={"getattd"},
	 * 		summary = "get all attd",
	 *     @OA\Response(response="200", description="An example resource"),
	 *     security={ {"bearerToken": {}}}
	 * )
	 */
	function getAttd($getid, $records_per_page)
	{
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));


			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
				$query = "select * from attd where isdel = 0 order by id";
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
	 *   path="/apidb/product/updateattd.php",
	 *   summary="Update attd",
	 *   tags={"updateattd"},
	 *   @OA\RequestBody(
	 *     required=true,
	 *     @OA\MediaType(
	 *       mediaType="application/json",
	 *       @OA\Schema(
	 *         @OA\Property(
	 *           property="id",
	 *           type="string",
	 *           example="1"
	 *         ),
	 *         @OA\Property(
	 *           property="data",
	 *           type="string",
	 *           example="Afghanistan"
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
	 *   )
	 * )
	 */



	function updateAttd()
	{

		$query = "INSERT INTO attd (id,data,tstamp,isdel,lreg,lstore)
			VALUES 
		(:id,:data,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		data = :data,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$id = strip_tags($this->id);
		$data = strip_tags($this->data);
		$lreg = strip_tags($this->lreg);
		$lstore = strip_tags($this->lstore);
		$isdel = strip_tags($this->isdel);

		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':data', $data);
		$stmt->bindParam(':lreg', $lreg);
		$stmt->bindParam(':lstore', $lstore);
		$stmt->bindParam(':isdel', $isdel);


		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}


}

?>