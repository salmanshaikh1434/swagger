<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritshst.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsHst($db);

$getTstamp=isset($_GET['tstamp']) ? $_GET['tstamp'] : die();

$stmt = $product->getUpdatedHst($getTstamp,$startingRecord,$records_per_page);
if ($stmt == false) {
	echo json_encode(
		array("message" => "Unauthorised request.")
	);
	exit;
}
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"sku" => $sku,
		"date" => $date,
		"edate" => $edate,
		"qty" => $qty,
		"price" => $price,
		"cost" => $cost,
		"promo" => $promo,
		"store" => $store,
		"pack" => $pack,
		"who" => $who,
		"lvl1qty" => $lvl1qty,
		"lvl1price" => $lvl1price,
		"lvl1cost" => $lvl1cost,
		"lvl2qty" => $lvl2qty,
		"lvl2price" => $lvl2price,
		"lvl2cost" => $lvl2cost,
		"lvl3qty" => $lvl3qty,
		"lvl3price" => $lvl3price,
		"lvl3cost" => $lvl3cost,
		"lvl4qty" => $lvl4qty,
		"lvl4price" => $lvl4price,
		"lvl4cost" => $lvl4cost,
		"sent" => $sent,
		"tstamp" => $tstamp,
		"isdel" => $isdel
       );

        array_push($products_arr["records"], $product_item);
    }
		http_response_code(200);
		echo json_encode($products_arr);
	}else{
		http_response_code(404);
		echo json_encode(
		array("message" => "NOT FOUND.")
	);
}
?>
