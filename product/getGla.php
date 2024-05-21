<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsgla.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsGla($db);
$getglaccount = isset($_GET["glaccount"]) ? $_GET["glaccount"] : 0;

$stmt = $product->getGla($getglaccount,$records_per_page);
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
		"sequence" => $sequence,
		"type" => $type,
		"glaccount" => $glaccount,
		"short" => $short,
		"descript" => $descript,
		"balance" => $balance,
		"lastcheck" => $lastcheck,
		"who" => $who,
		"tstamp" =>$tstamp, //added timestamp to resolve gla conversion issue by salman on 23/03/2023
		"qbooks" => $qbooks,
		"qbooksac" => $qbooksac,
		"skipstat" => $skipstat,
		"sent" => $sent,
		"lreg" => $lreg,
		"lstore" => $lstore,
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
