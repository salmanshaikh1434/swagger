<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
include_once '../config/database.php';
include_once '../objects/spiritsohd.php';
  
$database = new Database();
$db = $database->getConnection();
 
$spiritsUPDB = new spiritsohd($db);

$data = json_decode(file_get_contents("php://input"));

	$spiritsUPDB->order = $data->order;
	$spiritsUPDB->store = $data->store;
	$spiritsUPDB->customer = $data->customer;
	$spiritsUPDB->shipto = $data->shipto;
	$spiritsUPDB->contact = $data->contact;
	$spiritsUPDB->phone = $data->phone;
	$spiritsUPDB->status = $data->status;
	$spiritsUPDB->orddate = $data->orddate;
	$spiritsUPDB->promdate = $data->promdate;
	$spiritsUPDB->shipdate = $data->shipdate;
	$spiritsUPDB->invdate = $data->invdate;
	$spiritsUPDB->agedate = $data->agedate;
	$spiritsUPDB->whosold = $data->whosold;
	$spiritsUPDB->whoorder = $data->whoorder;
	$spiritsUPDB->whoship = $data->whoship;
	$spiritsUPDB->whoinvoice = $data->whoinvoice;
	$spiritsUPDB->terms = $data->terms;
	$spiritsUPDB->shipvia = $data->shipvia;
	$spiritsUPDB->taxcode = $data->taxcode;
	$spiritsUPDB->total = $data->total;
	$spiritsUPDB->printmemo = $data->printmemo;
	$spiritsUPDB->shipmemo = $data->shipmemo;
	$spiritsUPDB->memo = $data->memo;
	$spiritsUPDB->isdel = $data->isdel;
	$spiritsUPDB->transact = $data->transact;
	$spiritsUPDB->sent = $data->sent;
	$spiritsUPDB->lreg = $data->lreg;
	$spiritsUPDB->lstore = $data->lstore;
	$spiritsUPDB->who = $data->who;
	
$spiritsRTN = $spiritsUPDB->updateohd();
if($spiritsRTN=='OK'){
	http_response_code(200);
	echo json_encode(array("message" => "ORDER UPDATED.."));
}
else{
	http_response_code(503);
	echo json_encode(array("message" => "ERROR UPDATING!!"));
	echo json_encode(array("error" =>$spiritsRTN));
}
 
?>