<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritsdlh.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritsdlh($db);

	$data = json_decode(file_get_contents("php://input"));

		$spiritsUPDB->dealnum = $data->dealnum;
		$spiritsUPDB->vendor = $data->vendor;
		$spiritsUPDB->vcode = $data->vcode;
		$spiritsUPDB->venddeal = $data->venddeal;
		$spiritsUPDB->descript = $data->descript;
		$spiritsUPDB->startdate = $data->startdate;
		$spiritsUPDB->stopdate = $data->stopdate;
		$spiritsUPDB->qty1 = $data->qty1;
		$spiritsUPDB->qty2 = $data->qty2;
		$spiritsUPDB->qty3 = $data->qty3;
		$spiritsUPDB->qty4 = $data->qty4;
		$spiritsUPDB->qty5 = $data->qty5;
		$spiritsUPDB->invoiclevl = $data->invoiclevl;
		$spiritsUPDB->accumlevl = $data->accumlevl;
		$spiritsUPDB->qtytodate = $data->qtytodate;
		$spiritsUPDB->qtyonorder = $data->qtyonorder;
		$spiritsUPDB->security = $data->security;
		$spiritsUPDB->stores = $data->stores;
		$spiritsUPDB->who = $data->who;
		$spiritsUPDB->memo = $data->memo;
		$spiritsUPDB->activlevel = $data->activlevel;
		$spiritsUPDB->accumulate = $data->accumulate;
		$spiritsUPDB->sent = $data->sent;
		$spiritsUPDB->lreg= $data->lreg;
		$spiritsUPDB->lstore= $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;

	$spiritsRTN = $spiritsUPDB->updateDlh();
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
