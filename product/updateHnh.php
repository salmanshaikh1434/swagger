<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritshnh.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritshnh($db);

	$data = json_decode(file_get_contents("php://input"));

		$spiritsUPDB->listnum = $data->listnum;
		$spiritsUPDB->listname = $data->listname;
		$spiritsUPDB->listtype = $data->listtype;
		$spiritsUPDB->descript = $data->descript;
		$spiritsUPDB->store = $data->store;
		$spiritsUPDB->avg_last = $data->avg_last;
		$spiritsUPDB->posted = $data->posted;
		$spiritsUPDB->lastline = $data->lastline;
		$spiritsUPDB->who = $data->who;
		$spiritsUPDB->lreg= $data->lreg;
		$spiritsUPDB->lstore= $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;

	$spiritsRTN = $spiritsUPDB->updateHnh();
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