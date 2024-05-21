<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritsemail.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritsemail($db);


	$data = json_decode(file_get_contents("php://input"));

		$spiritsUPDB->id = $data->id;
		$spiritsUPDB->from = $data->from;
		$spiritsUPDB->to = $data->to;
		$spiritsUPDB->store = $data->store;
		$spiritsUPDB->subject = $data->subject;
		$spiritsUPDB->content = $data->content;
		$spiritsUPDB->attach = $data->attach;
		$spiritsUPDB->files = $data->files;
		$spiritsUPDB->blank = $data->blank;
		$spiritsUPDB->flag = $data->flag;
		$spiritsUPDB->toid = $data->toid;
		$spiritsUPDB->fromid = $data->fromid;
		$spiritsUPDB->new = $data->new;
		$spiritsUPDB->sent = $data->sent;
		$spiritsUPDB->lreg= $data->lreg;
		$spiritsUPDB->lstore= $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;

	$spiritsRTN = $spiritsUPDB->updateEmail();
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
