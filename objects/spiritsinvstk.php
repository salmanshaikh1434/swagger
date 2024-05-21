<?php
use OpenApi\Annotations as OA;

class spiritsinvstk
{
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}
	/**
	 * @OA\Get(
	 *   tags={"readinvstk"},
	 *   path="/apidb/product/readinvstk.php",
	 *   summary="Summary",
	 *   @OA\Parameter(
	 *     name="sku", 
	 *     in="query", 
	 *     required=true, 
	 *     description="get data based on sku",
	 *     @OA\Schema(
	 *       type="integer",
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found")
	 * )
	 */
	function readInvstk($getsku)
	{
		$query = "select * from invstk where invstk.sku = $getsku and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	/**
	 * @OA\Get(
	 *   tags={"getupdaedinvstk"},
	 *   path="/apidb/product/getupdatedinvstk.php",
	 *   summary="Summary",
	 *   @OA\Parameter(
	 *     name="tstamp", 
	 *     in="query", 
	 *     required=true, 
	 *     description="get data based on tstamp",
	 *     @OA\Schema(
	 *       type="string",
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found")
	 * )
	 */

	function getUpdatedInvStk($getTstamp, $startingRecord, $records_per_page)
	{
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from invstk where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	/**
	 * @OA\Get(
	 *   tags={"getinvstk"},
	 *   path="/apidb/product/getinvstk.php",
	 *   summary="Summary",
	 *   @OA\Parameter(
	 *     name="sku", 
	 *     in="query", 
	 *     required=true, 
	 *     description="get data based on sku",
	 *     @OA\Schema(
	 *       type="integer",
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found")
	 * )
	 */

	function getInvstk($getsku, $records_per_page)
	{
		$query = "select * from invstk where invstk.sku > $getsku and isdel = 0 order by sku LIMIT ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

}
?>