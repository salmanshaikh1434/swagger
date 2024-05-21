<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsodd.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsodd($db);
$getOrder = isset($_GET["order"]) ? $_GET["order"] : 0;
$getStore = isset($_GET["store"]) ? $_GET["store"] : 0;

// added by salman to resolve rptsync issue
if(isset($_GET["page"])){
	$stmt = $product->getOddPage($startingRecord,$records_per_page);
}else{
	$stmt = $product->getOdd($getOrder,$getStore);
}
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"order" => $order,
		"store" => $store,
		"line" => $line,
		"sku" => $sku,
		"status" => $status,
		"customer" => $customer,
		"orddate" => $orddate,
		"agedate" => $agedate,
		"qty" => $qty,
		"pack" => $pack,
		"descript" => $descript,
		"price" => $price,
		"cost" => $cost,
		"discount" => $discount,
		"promo" => $promo,
		"dflag" => $dflag,
		"dclass" => $dclass,
		"damount" => $damount,
		"taxlevel" => $taxlevel,
		"surcharge" => $surcharge,
		"cat" => $cat,
		"location" => $location,
		"dml" => $dml,
		"cpack" => $cpack,
		"onsale" => $onsale,
		"freeze" => $freeze,
		"memo" => $memo,
		"bqty" => $bqty,
		"extax" => $extax,
		"lreg" => $lreg,
		"lstore" => $lstore,
                "tstamp"=> $tstamp,
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