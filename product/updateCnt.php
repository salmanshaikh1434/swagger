<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritscnt.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritscnt($db);

	$data = json_decode(file_get_contents("php://input"));

		$spiritsUPDB->code = $data->code;
		$spiritsUPDB->seq = $data->seq;
		$spiritsUPDB->question = $data->question;
		$spiritsUPDB->data = $data->data;
		$spiritsUPDB->memvar = $data->memvar;
		$spiritsUPDB->updatereg = $data->updatereg;
		$spiritsUPDB->who = $data->who;
		$spiritsUPDB->memo = $data->memo;
		$spiritsUPDB->lreg= $data->lreg;
		$spiritsUPDB->lstore= $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;

	$spiritsRTN = $spiritsUPDB->updateCnt();
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
