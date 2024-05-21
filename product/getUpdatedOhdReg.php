<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsohd.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsohd($db);

$getCustomer=isset($_GET['customer']) ? $_GET['customer'] : 0;

$stmt = $product->getUpdatedOhdReg($getCustomer);
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"order" => $order,
		"store" => $store,
		"status" => $status,
		"orddate" => $orddate,
		"promdate" => $promdate,
		"shipdate" => $shipdate,
		"invdate" => $invdate,
		"total" => $total
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
