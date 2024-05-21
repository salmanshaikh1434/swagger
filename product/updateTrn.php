<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritstrn.php';
	include_once '../objects/spiritsany.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritstrn($db);
	$spiritsANY = new spiritsany($db);

	$data = json_decode(file_get_contents("php://input"));

		$getStore = $data->store;
		if(empty($getStore)){
			$getStore = 1;
		}

		if($data->source == 'pos'){
			$nextTransact = $spiritsANY->getlastrecord('transact','trn',$getStore);
		}

		
		$spiritsUPDB->source = $data->source;
		$spiritsUPDB->account = $data->account;
		$spiritsUPDB->tdate = $data->tdate;
		$spiritsUPDB->adate = $data->adate;
		$spiritsUPDB->transact = isset($nextTransact) ? $nextTransact : $data->transact;
		$spiritsUPDB->document = $data->document;
		$spiritsUPDB->type = $data->type;
		$spiritsUPDB->lamount = $data->lamount;
		$spiritsUPDB->ramount = $data->ramount;
		$spiritsUPDB->balance = $data->balance;
		$spiritsUPDB->checkno = $data->checkno;
		$spiritsUPDB->clear = $data->clear;
		$spiritsUPDB->status = $data->status;
		$spiritsUPDB->excode = $data->excode;
		$spiritsUPDB->store = $data->store;
		$spiritsUPDB->department = $data->department;
		$spiritsUPDB->glaccount = $data->glaccount;
		$spiritsUPDB->who = $data->who;
		$spiritsUPDB->skipstat = $data->skipstat;
		$spiritsUPDB->memo = $data->memo;
		$spiritsUPDB->sent = $data->sent;
		$spiritsUPDB->lreg= $data->lreg;
		$spiritsUPDB->lstore= $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;
		//$spiritsUPDB->register = $data->register;

	$spiritsRTN = $spiritsUPDB->updateTrn();
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