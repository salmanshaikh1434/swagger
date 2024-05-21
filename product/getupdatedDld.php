<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsdld.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsDld($db);

$getTstamp=isset($_GET['tstamp']) ? $_GET['tstamp'] : die();

$stmt = $product->getUpdatedDld($getTstamp,$startingRecord,$records_per_page);
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"dealnum" => $dealnum,
		"line" => $line,
		"sku" => $sku,
		"name" => $name,
		"sname" => $sname,
		"pack" => $pack,
		"ml" => $ml,
		"vendor" => $vendor,
		"vcode" => $vcode,
		"vid" => $vid,
		"startdate" => $startdate,
		"stopdate" => $stopdate,
		"frontline" => $frontline,
		"disc1" => $disc1,
		"disc2" => $disc2,
		"disc3" => $disc3,
		"disc4" => $disc4,
		"disc5" => $disc5,
		"invoiclevl" => $invoiclevl,
		"accumlevl" => $accumlevl,
		"qtytodate" => $qtytodate,
		"qtyonorder" => $qtyonorder,
		"security" => $security,
		"stores" => $stores,
		"who" => $who,
		"activlevel" => $activlevel,
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