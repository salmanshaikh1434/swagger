<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsodd.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsodd($db);

$getOrder=isset($_GET['order']) ? $_GET['order'] : 0;
$getStore=isset($_GET['store']) ? $_GET['store'] : 1;

$stmt = $product->getUpdatedOddReg($getOrder,$getStore);
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"line" => $line,
		"sku" => $sku,
		"qty" => $qty,
		"pack" => $pack,
		"descript" => $descript,
		"price" => $price,
		"cost" => $cost,
		"discount" => $discount,
		"promo" => $promo
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
