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
$getOrder=isset($_GET['order']) ? $_GET['order'] : null;
$getVendor=isset($_GET['vendor']) ? $_GET['vendor'] : null;
$stmt = $product->getPodVnd($getOrder,$getVendor);
$num = $stmt->rowCount();

if($num>0){
  
    $products_arr=array();
    $products_arr["records"]=array();
	
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);
        
		$product_item=array(
			"sku" => $sku,
			"order" =>$order,
			"name" => $name,
			"cbqty" => $cbqty,
			"cost" => $cost,
			"pack" => $pack,
			"sname" => $sname,
			"vid" => $vid,
			"coqty" => $coqty,
			"line" => $line,
			"deal" => $deal
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