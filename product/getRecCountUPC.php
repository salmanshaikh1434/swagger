<?php
header("Access-Control_allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/spiritsupc.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsupc($db);
$getSku=isset($_GET['sku']) ? $_GET['sku'] : die();
$getUpc=isset($_GET['upc']) ? $_GET['upc'] : die();

$stmt = $product->readUpc($getSku,$getUpc);
$num = $stmt->rowCount();

if($num>0){
  
    $products_arr=array();
    $products_arr["records"]=array();
	
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);
        
		$product_item=array(
			"upc" => $upc,
			"level" => $level,				
			"who" => $who,
			"last" => $last,
			"sku" => $sku,
			"isdel" => $isdel,
			"lreg" => $lreg,
			"tstamp" =>  $tstamp
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