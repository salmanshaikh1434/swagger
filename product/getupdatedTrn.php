<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritstrn.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritstrn($db);

$getTstamp=isset($_GET['tstamp']) ? $_GET['tstamp'] : die();
// added register column to response by salman on 31jan2024
$stmt = $product->getUpdatedTrn($getTstamp,$startingRecord,$records_per_page);
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"source" => $source,
		"account" => $account,
		"tdate" => $tdate,
		"adate" => $adate,
		"transact" => $transact,
		"document" => $document,
		"type" => $type,
		"lamount" => $lamount,
		"ramount" => $ramount,
		"balance" => $balance,
		"checkno" => $checkno,
		"clear" => $clear,
		"status" => $status,
		"excode" => $excode,
		"store" => $store,
		"department" => $department,
		"glaccount" => $glaccount,
		"who" => $who,
		"skipstat" => $skipstat,
		"memo" => $memo,
		"sent" => $sent,
		"lreg" => $lreg,
		"lstore" => $lstore,
		"tstamp" => $tstamp,
		"register"=>$register,
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