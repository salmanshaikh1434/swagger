<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritsdsc.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritsdsc($db);

	$data = json_decode(file_get_contents("php://input"));

		$spiritsUPDB->dcode = $data->dcode;
		$spiritsUPDB->chain = $data->chain;
		$spiritsUPDB->descript = $data->descript;
		$spiritsUPDB->mix = $data->mix;
		$spiritsUPDB->match = $data->match;
		$spiritsUPDB->qty = $data->qty;
		$spiritsUPDB->qtype = $data->qtype;
		$spiritsUPDB->level1disc = $data->level1disc;
		$spiritsUPDB->level2disc = $data->level2disc;
		$spiritsUPDB->level3disc = $data->level3disc;
		$spiritsUPDB->level4disc = $data->level4disc;
		$spiritsUPDB->level5disc = $data->level5disc;
		$spiritsUPDB->additive = $data->additive;
		$spiritsUPDB->freesku = $data->freesku;
		$spiritsUPDB->freeqty = $data->freeqty;
		$spiritsUPDB->promo = $data->promo;
		$spiritsUPDB->onsale = $data->onsale;
		$spiritsUPDB->who = $data->who;
		$spiritsUPDB->override = $data->override;
		$spiritsUPDB->level6disc = $data->level6disc;
		$spiritsUPDB->level7disc = $data->level7disc;
		$spiritsUPDB->level8disc = $data->level8disc;
		$spiritsUPDB->sent = $data->sent;
		$spiritsUPDB->lreg= $data->lreg;
		$spiritsUPDB->lstore= $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;

	$spiritsRTN = $spiritsUPDB->updateDsc();
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
