<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/spiritsavgcost.php';

$database = new Database();
$db = $database->getConnection();

$spiritsUPDB = new spiritsavgcost($db);

$data = json_decode(file_get_contents("php://input"));

$spiritsUPDB->sku = $data->sku;
$spiritsUPDB->store = $data->store;
$spiritsUPDB->oldcost = $data->oldcost;
$spiritsUPDB->newcost = $data->newcost;
$spiritsUPDB->who = $data->who;
$spiritsUPDB->type = $data->type;
$spiritsUPDB->number = $data->number;
$spiritsUPDB->costype = $data->costype;
$spiritsUPDB->posted = $data->posted;
$spiritsUPDB->sent = $data->sent;
$spiritsUPDB->lreg = $data->lreg;
$spiritsUPDB->lstore = $data->lstore;
$spiritsUPDB->isdel = $data->isdel;

$spiritsRTN = $spiritsUPDB->updateAvgcost();
if ($spiritsRTN == false) {
	echo json_encode(
		array("message" => "Unauthorised request.")
	);
	exit;
}
if ($spiritsRTN == 'OK') {
	http_response_code(200);
	echo json_encode(array("message" => "UPDATED.."));
} else {
	http_response_code(503);
	echo json_encode(array("message" => "ERROR UPDATING!!"));
	echo json_encode(array("error" => $spiritsRTN));
}
?>