<?php	header("Access-Control-Allow-Origin: *");	header("Content-Type: application/json; charset=UTF-8");	header("Access-Control-Allow-Methods: POST");	header("Access-Control-Max-Age: 3600");	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");	include_once '../config/database.php';	include_once '../objects/spiritskys.php';	$database = new Database();	$db = $database->getConnection();	$spiritsUPDB = new spiritskys($db);	$data = json_decode(file_get_contents("php://input"));		$spiritsUPDB->keyboard = $data->keyboard;		$spiritsUPDB->page = $data->page;		$spiritsUPDB->key = $data->key;		$spiritsUPDB->keyname = $data->keyname;		$spiritsUPDB->cat = $data->cat;		$spiritsUPDB->receipts = $data->receipts;		$spiritsUPDB->customer = $data->customer;		$spiritsUPDB->function = $data->function;		$spiritsUPDB->change = $data->change;		$spiritsUPDB->credit = $data->credit;		$spiritsUPDB->balance = $data->balance;		$spiritsUPDB->active = $data->active;		$spiritsUPDB->security = $data->security;		$spiritsUPDB->who = $data->who;		$spiritsUPDB->catname = $data->catname;		$spiritsUPDB->keyorder = $data->keyorder;		$spiritsUPDB->lreg= $data->lreg;		$spiritsUPDB->lstore= $data->lstore;		$spiritsUPDB->isdel = $data->isdel;	$spiritsRTN = $spiritsUPDB->updateKys();	if($spiritsRTN=='OK'){	    http_response_code(200);	    echo json_encode(array("message" => "UPDATED.."));	}	else{   		http_response_code(503);		echo json_encode(array("message" => "ERROR UPDATING!!"));    	echo json_encode(array("error" =>$spiritsRTN));	}?>