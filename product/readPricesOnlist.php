<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritssll.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsSll($db);
$getsku = isset($_GET["sku"]) ? $_GET["sku"] : 0;

$stmt = $product->readPricesOnlist($getsku);
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"listnum" => $listnum,
		"line" => $line,
		"listname" => $listname,
		"store" => $store,
		"level" => $level,
		"qty" => $qty,
		"price" => $price,
		"onsale" => $onsale,
		"start" => $start,
		"stop" => $stop,
		"type" => $type
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
