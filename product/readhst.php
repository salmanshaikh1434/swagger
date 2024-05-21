<?php
header("Access-Control_allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/spiritshst.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritshst($db);
$getSku=isset($_GET['sku']) ? $_GET['sku'] : die();
$getTstamp=isset($_GET['hstdate']) ? $_GET['hstdate'] : '19000101';
$getStore=isset($_GET['store']) ? $_GET['store'] : 0;

$stmt = $product->readhst($getSku,$getTstamp,$getStore);
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
			"sku" => $sku,
			"date" => $date,
			"edate" => $edate,
			"qty" => $qty,
			"price" => $price,
			"cost" => $cost,
			"promo" => $promo,
			"store" => $store,
			"pack" => $pack
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