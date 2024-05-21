<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritsjnh.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritsjnh($db);

	$data = json_decode(file_get_contents("php://input"));

		$spiritsUPDB->date = $data->date;
		$spiritsUPDB->store = $data->store;
		$spiritsUPDB->register = $data->register;
		$spiritsUPDB->cashier = $data->cashier;
		$spiritsUPDB->sale = $data->sale;
		$spiritsUPDB->customer = $data->customer;
		$spiritsUPDB->order = $data->order;
		$spiritsUPDB->taxcode = $data->taxcode;
		$spiritsUPDB->total = $data->total;
		$spiritsUPDB->receipts = $data->receipts;
		$spiritsUPDB->memo = $data->memo;
		$spiritsUPDB->signature = $data->signature;
		$spiritsUPDB->reference = $data->reference;
		$spiritsUPDB->ackrefno = $data->ackrefno;
		$spiritsUPDB->voided = $data->voided;
		$spiritsUPDB->updated = $data->updated;
		$spiritsUPDB->lreg= $data->lreg;
		$spiritsUPDB->lstore= $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;

	$spiritsRTN = $spiritsUPDB->updateJnh();
	if($spiritsRTN=='OK'){
	    http_response_code(200);
	    echo json_encode(array("message" => "UPDATED.."));
	}
	else{
   		http_response_code(503);
		echo json_encode(array("message" => "ERROR UPDATING!!"));
    	echo json_encode(array("error" =>$spiritsRTN));
	}
?>
