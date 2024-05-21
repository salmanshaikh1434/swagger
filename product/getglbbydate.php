<?php
header("Access-Control_allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/spiritsglb.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsglb($db);
$date = isset($_GET['date']) ? $_GET['date'] : die();
$department = isset($_GET['department']) ? $_GET['department'] : die();
$store = isset($_GET['store']) ? $_GET['store'] : die();

$stmt = $product->getglbbydate($department, $date, $store);
$num = $stmt->rowCount();

if ($num > 0) {

	$products_arr = array();
	$products_arr["records"] = array();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		extract($row);

		$product_item = array(
			"glaccount" => $glaccount,
			"unid" => $unid,
			"date" => $date,
			"store" => $store,
			"department" => $department,
			"edate" => $edate,
			"lamount" => $lamount,
			"ramount" => $ramount,
			"balance" => $balance,
			"records" => $records,
			"freeze" => $freeze,
			"who" => $who,
			"transact" => $transact,
			"consol" => $consol,
			"sent" => $sent,
			"gosent" => $gosent,
			"lreg" => $lreg,
			"lstore" => $lstore,
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