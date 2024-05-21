<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritsgla.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritsgla($db);

	$data = json_decode(file_get_contents("php://input"));

		$spiritsUPDB->sequence = $data->sequence;
		$spiritsUPDB->type = $data->type;
		$spiritsUPDB->glaccount = $data->glaccount;
		$spiritsUPDB->short = $data->short;
		$spiritsUPDB->descript = $data->descript;
		$spiritsUPDB->balance = $data->balance;
		$spiritsUPDB->lastcheck = $data->lastcheck;
		$spiritsUPDB->who = $data->who;
		$spiritsUPDB->qbooks = $data->qbooks;
		$spiritsUPDB->qbooksac = $data->qbooksac;
		$spiritsUPDB->skipstat = $data->skipstat;
		$spiritsUPDB->sent = $data->sent;
		$spiritsUPDB->lreg= $data->lreg;
		$spiritsUPDB->lstore= $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;

	$spiritsRTN = $spiritsUPDB->updateGla();
	if ($spiritsRTN == false) {
		echo json_encode(
			array("message" => "Unauthorised request.")
		);
		exit;
	}   
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
