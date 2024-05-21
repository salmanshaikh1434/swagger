<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsvin.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsVin($db);

$getTstamp=isset($_GET['tstamp']) ? $_GET['tstamp'] : die();

$stmt = $product->getUpdatedVin($getTstamp,$startingRecord,$records_per_page);
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"sku" => $sku,
		"vintage" => $vintage,
		"freeform1" => $freeform1,
		"freeform2" => $freeform2,
		"freeform3" => $freeform3,
		"freeform4" => $freeform4,
		"memo" => $memo,
		"who" => $who,
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
	}else{
		http_response_code(404);
		echo json_encode(
		array("message" => "NOT FOUND.")
	);
}
?>