<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritshnd.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritshnd($db);

	$data = json_decode(file_get_contents("php://input"));

		$spiritsUPDB->listnum = $data->listnum;
		$spiritsUPDB->line = $data->line;
		$spiritsUPDB->listname = $data->listname;
		$spiritsUPDB->listtype = $data->listtype;
		$spiritsUPDB->sku = $data->sku;
		$spiritsUPDB->type = $data->type;
		$spiritsUPDB->descript = $data->descript;
		$spiritsUPDB->sname = $data->sname;
		$spiritsUPDB->ml = $data->ml;
		$spiritsUPDB->pack = $data->pack;
		$spiritsUPDB->ccost = $data->ccost;
		$spiritsUPDB->floor = $data->floor;
		$spiritsUPDB->back = $data->back;
		$spiritsUPDB->shipped = $data->shipped;
		$spiritsUPDB->kits = $data->kits;
		$spiritsUPDB->posted = $data->posted;
		$spiritsUPDB->store = $data->store;
		$spiritsUPDB->upc = $data->upc;
		$spiritsUPDB->glinv = $data->glinv;
		$spiritsUPDB->glexp = $data->glexp;
		$spiritsUPDB->lreg= $data->lreg;
		$spiritsUPDB->lstore= $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;

	$spiritsRTN = $spiritsUPDB->updateHnd();
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
