<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsdsc.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsDsc($db);
$getdcode = isset($_GET["dcode"]) ? $_GET["dcode"] : 0;

$stmt = $product->getDsc($getdcode,$records_per_page);
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
		"dcode" => $dcode,
		"chain" => $chain,
		"descript" => $descript,
		"mix" => $mix,
		"match" => $match,
		"qty" => $qty,
		"qtype" => $qtype,
		"level1disc" => $level1disc,
		"level2disc" => $level2disc,
		"level3disc" => $level3disc,
		"level4disc" => $level4disc,
		"level5disc" => $level5disc,
		"additive" => $additive,
		"freesku" => $freesku,
		"freeqty" => $freeqty,
		"promo" => $promo,
		"onsale" => $onsale,
		"who" => $who,
		"override" => $override,
		"level6disc" => $level6disc,
		"level7disc" => $level7disc,
		"level8disc" => $level8disc,
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