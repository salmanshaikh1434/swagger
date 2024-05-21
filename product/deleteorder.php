<?php
header("Access-Control_allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/spiritspoh.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritspoh($db);
$getOrder=isset($_GET['order']) ? $_GET['order'] : '1';

$stmt = $product->deleteorder($getOrder);
$num = $stmt->rowCount();

if($num>0){
    http_response_code(200);
    echo json_encode(array("message" => "SUCCESSFUL."));
}else{
	http_response_code(404);
	echo json_encode(array("message" => "NOT FOUND."));
}
?>