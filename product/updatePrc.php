<?php	header("Access-Control-Allow-Origin: *");	header("Content-Type: application/json; charset=UTF-8");	header("Access-Control-Allow-Methods: POST");	header("Access-Control-Max-Age: 3600");	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");	include_once '../config/database.php';	include_once '../objects/spiritsprc.php';	$database = new Database();	$db = $database->getConnection();	$spiritsUPDB = new spiritsprc($db);	$data = json_decode(file_get_contents("php://input"));		$spiritsUPDB->sku = $data->sku;		$spiritsUPDB->level = $data->level;		$spiritsUPDB->qty = $data->qty;		$spiritsUPDB->price = $data->price;		$spiritsUPDB->promo = $data->promo;		$spiritsUPDB->onsale = $data->onsale;		$spiritsUPDB->labels = $data->labels;		$spiritsUPDB->store = $data->store;		$spiritsUPDB->who = $data->who;		$spiritsUPDB->dcode = $data->dcode;		$spiritsUPDB->sale = $data->sale;		$spiritsUPDB->sent = $data->sent;		$spiritsUPDB->gosent = $data->gosent;		$spiritsUPDB->lreg= $data->lreg;		$spiritsUPDB->lstore= $data->lstore;		$spiritsUPDB->isdel = $data->isdel;	$spiritsRTN = $spiritsUPDB->updatePrc();	if($spiritsRTN=='OK'){	    http_response_code(200);	    echo json_encode(array("message" => "UPDATED.."));	}	else{   		http_response_code(503);		echo json_encode(array("message" => "ERROR UPDATING!!"));    	echo json_encode(array("error" =>$spiritsRTN));	}?>