<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritsspl.php';

	$database = new Database();
	$db = $database->getConnection();
	$spiritsUPDB = new spiritsspl($db);
	$data = json_decode(file_get_contents("php://input"));
	
	if($data->source == 'pos'){
	$stmt = $db->prepare("SELECT `transact` FROM trn where `document` = $data->document");
	$stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $transact = $row['transact'];
	}
	
	

		$spiritsUPDB->glaccount = $data->glaccount;
		$spiritsUPDB->store = $data->store;
		$spiritsUPDB->department = $data->department;
		$spiritsUPDB->date = $data->date;
		$spiritsUPDB->amount = $data->amount;
		$spiritsUPDB->balance = $data->balance;
		$spiritsUPDB->transact = isset($transact) ? $transact : $data->transact;
		$spiritsUPDB->applyto = $data->applyto;
		$spiritsUPDB->clear = $data->clear;
		$spiritsUPDB->memo = $data->memo;
		$spiritsUPDB->note = $data->note;
		$spiritsUPDB->line = $data->line;
		$spiritsUPDB->source = $data->source;
		$spiritsUPDB->account = $data->account;
		$spiritsUPDB->type = $data->type;
		$spiritsUPDB->document = $data->document;
		$spiritsUPDB->checkno = $data->checkno;
		$spiritsUPDB->who = $data->who;
		$spiritsUPDB->skipstat = $data->skipstat;
		$spiritsUPDB->sent = $data->sent;
		$spiritsUPDB->lreg= $data->lreg;
		$spiritsUPDB->lstore= $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;

	$spiritsRTN = $spiritsUPDB->updateSpl();
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