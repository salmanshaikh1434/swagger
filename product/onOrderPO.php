<?php
header("Access-Control_allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/spiritspod.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritspod($db);
$getStore=isset($_GET['store']) ? $_GET['store'] : '1';
$getSku=isset($_GET['sku']) ? $_GET['sku'] : '0';

$stmt = $product->onOrderPo($getStore,$getSku);
$num = $stmt->rowCount();
if($num>0){
    $products_arr=array();
    $products_arr["records"]=array();
	
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);
        
		$product_item=array(
			"onorder" => $onorder
       );
  
        array_push($products_arr["records"], $product_item);
    }
  
    http_response_code(200);
    echo json_encode($products_arr);
}else{
	http_response_code(404);
	echo json_encode(array("message" => "NOT FOUND."));
}
?>