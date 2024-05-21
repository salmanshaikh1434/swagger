<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/spiritsupc.php';

$database = new Database();
$db = $database->getConnection();

$spiritsUPDB = new spiritsupc($db);

$data = json_decode(file_get_contents("php://input"));

$spiritsUPDB->upc = $data->upc;
$spiritsUPDB->level = $data->level;
$spiritsUPDB->last = $data->last;
$spiritsUPDB->sku = $data->sku;
$spiritsUPDB->who = $data->who;
$spiritsUPDB->sent = $data->sent;
$spiritsUPDB->gosent = $data->gosent;
$spiritsUPDB->lreg = $data->lreg;
$spiritsUPDB->lstore = $data->lstore;
$spiritsUPDB->isdel = $data->isdel;
$getupc1 = $spiritsUPDB->getupc1();
$num = $getupc1->rowCount();

if ($num > 0) {
	$spiritsRTN1 = $spiritsUPDB->updatesdateUpc1();
	if ($spiritsRTN1 == 'OK') {
		http_response_code(200);
		echo json_encode(array("message" => "UPDATED.."));
	} else {
		http_response_code(503);
		echo json_encode(array("message" => "ERROR UPDATING!!"));
		echo json_encode(array("error" => $spiritsRTN1));
	}
} else {
	$spiritsRTN = $spiritsUPDB->updateUpc();
	if ($spiritsRTN == 'OK') {
		http_response_code(200);
		echo json_encode(array("message" => "INSERTED.."));
	} else {
		http_response_code(503);
		echo json_encode(array("message" => "ERROR UPDATING!!"));
		echo json_encode(array("error" => $spiritsRTN));
	}
}

?>