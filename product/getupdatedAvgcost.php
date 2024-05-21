<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsavgcost.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsavgcost($db);

$getTstamp = isset($_GET['tstamp']) ? $_GET['tstamp'] : die();

$stmt = $product->getUpdatedAvgcost($getTstamp, $startingRecord, $records_per_page);
if ($stmt == false) {
	echo json_encode(
		array("message" => "Unauthorised request.")
	);
	exit;
}
$num = $stmt->rowCount();

if ($num > 0) {

	$products_arr = array();
	$products_arr["records"] = array();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		extract($row);

		$product_item = array(
			"sku" => $sku,
			"store" => $store,
			"oldcost" => $oldcost,
			"newcost" => $newcost,
			"who" => $who,
			"type" => $type,
			"number" => $number,
			"costype" => $costype,
			"posted" => $posted,
			"sent" => $sent,
			"lreg" => $lreg,
			"lstore" => $lstore,
			"tstamp" => $tstamp,
			"isdel" => $isdel
		);

		array_push($products_arr["records"], $product_item);
	}
	http_response_code(200);
	echo json_encode($products_arr);
} else {
	http_response_code(404);
	echo json_encode(
		array("message" => "NOT FOUND.")
	);
}
?>