<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsripmfgd.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsripmfgd($db);

$getTstamp=isset($_GET['tstamp']) ? $_GET['tstamp'] : die();

$stmt = $product->getUpdatedRipmfgd($getTstamp,$startingRecord,$records_per_page);
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"bdnumber" => $bdnumber,
		"store" => $store,
		"ponumber" => $ponumber,
		"line" => $line,
		"sku" => $sku,
		"vid" => $vid,
		"name" => $name,
		"sname" => $sname,
		"pack" => $pack,
		"oqty" => $oqty,
		"coqty" => $coqty,
		"amount" => $amount,
		"orddate" => $orddate,
		"recdate" => $recdate,
		"rec" => $rec,
		"bdorrips" => $bdorrips,
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
