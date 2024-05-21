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
$newvalue = 0;
$product = new spiritsany($db);




if(isset($_GET["tcolumn"])){
	$tcolumn =  $_GET["tcolumn"];
}else{
	echo json_encode(array('message'=> "tcolumn not specified"));
	return;
}

if(isset($_GET["table"])){
	$table = $_GET["table"];
}else{
	echo json_encode(array('message'=> "table not specified"));
	return;
}

if(isset($_GET["store"])){
	$store = $_GET["store"];
}else{
	echo json_encode(array('message'=> "store not specified"));
	return;
}




$stmt = $product->getlastrecord($tcolumn,$table,$store);

if (!empty($stmt)) {
    $records['lastrecord'] = $stmt;
	http_response_code(200);
	echo json_encode($records);
} else {
	http_response_code(404);
	echo json_encode(
		array("message" => "NOT FOUND.")
	);
}
