<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritshnd.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritshnd($db);
$getlistnum = isset($_GET["listnum"]) ? $_GET["listnum"] : 0;

$stmt = $product->getHnd($getlistnum,$records_per_page);
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
		"listnum" => $listnum,
		"line" => $line,
		"listname" => $listname,
		"listtype" => $listtype,
		"sku" => $sku,
		"type" => $type,
		"descript" => $descript,
		"sname" => $sname,
		"ml" => $ml,
		"pack" => $pack,
		"ccost" => $ccost,
		"floor" => $floor,
		"back" => $back,
		"shipped" => $shipped,
		"kits" => $kits,
		"posted" => $posted,
		"store" => $store,
		"upc" => $upc,
		"glinv" => $glinv,
		"glexp" => $glexp,
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
