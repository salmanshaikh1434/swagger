<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsany.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsany($db);
$query = isset($_GET["query"]) ? $_GET["query"] : '';

if(!empty($query)){
$stmt = $product->getbyquery($query);
$num = $stmt->rowCount();

if($num>0){

 
    $new_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		$array[] = $row;

        array_push($new_arr["records"], $array);
    }
		http_response_code(200);
		echo json_encode($new_arr);
	}else{
		http_response_code(404);
		echo json_encode(
		array("message" => "NOT FOUND.")
	);
}
}else{
    echo json_encode(
		array("message" => "Empty Query.")
	);
}
