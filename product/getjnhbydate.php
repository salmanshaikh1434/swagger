<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsjnh.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsJnh($db);
$from = isset($_GET["from"]) ? $_GET["from"] : "";
$to = isset($_GET["to"]) ? $_GET["to"] : "";
$stmt = $product->getJnhbydate($from,$to);
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"date" => $date,
		"store" => $store,
		"register" => $register,
		"cashier" => $cashier,
		"sale" => $sale,
		"customer" => $customer,
		"order" => $order,
		"taxcode" => $taxcode,
		"total" => $total,
		"receipts" => $receipts,
		"memo" => $memo,
		"signature" => $signature,
		"reference" => $reference,
		"ackrefno" => $ackrefno,
		"voided" => $voided,
		"lreg" => $lreg,
		"lstore" => $lstore,
		"tstamp"=>$tstamp,
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