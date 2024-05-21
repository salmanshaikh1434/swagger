<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsdlh.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsDlh($db);
$getdealnum = isset($_GET["dealnum"]) ? $_GET["dealnum"] : 0;

$stmt = $product->getDlh($getdealnum,$records_per_page);
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
		"dealnum" => $dealnum,
		"vendor" => $vendor,
		"vcode" => $vcode,
		"venddeal" => $venddeal,
		"descript" => $descript,
		"startdate" => $startdate,
		"stopdate" => $stopdate,
		"qty1" => $qty1,
		"qty2" => $qty2,
		"qty3" => $qty3,
		"qty4" => $qty4,
		"qty5" => $qty5,
		"invoiclevl" => $invoiclevl,
		"accumlevl" => $accumlevl,
		"qtytodate" => $qtytodate,
		"qtyonorder" => $qtyonorder,
		"security" => $security,
		"stores" => $stores,
		"who" => $who,
		"memo" => $memo,
		"activlevel" => $activlevel,
		"accumulate" => $accumulate,
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
