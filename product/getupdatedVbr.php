<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsvbr.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsvbr($db);

$getTstamp=isset($_GET['tstamp']) ? $_GET['tstamp'] : die();

$stmt = $product->getUpdatedVbr($getTstamp,$startingRecord,$records_per_page);
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"vtype" => $vtype,
		"brand" => $brand,
		"ml" => $ml,
		"vintage" => $vintage,
		"sname" => $sname,
		"descript" => $descript,
		"bestbot1" => $bestbot1,
		"bestvend1" => $bestvend1,
		"bestbot2" => $bestbot2,
		"bestvend2" => $bestvend2,
		"updown" => $updown,
		"proof" => $proof,
		"firstdate" => $firstdate,
		"lastdate" => $lastdate,
		"sku" => $sku,
		"vendors" => $vendors,
		"clearflag" => $clearflag,
		"dummy" => $dummy,
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
