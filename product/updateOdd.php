<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritsodd.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritsodd($db);
// rename $odd to $data and removed foreach as it in not required here by salman
	$data = json_decode(file_get_contents("php://input"));

	
		$spiritsUPDB->order = $data->order;
		$spiritsUPDB->store = $data->store;
		$spiritsUPDB->line = $data->line;
		$spiritsUPDB->sku = $data->sku;
		$spiritsUPDB->status = $data->status;
		$spiritsUPDB->customer = $data->customer;
		$spiritsUPDB->orddate = $data->orddate;
		$spiritsUPDB->agedate = $data->agedate;
		$spiritsUPDB->qty = $data->qty;
		$spiritsUPDB->pack = $data->pack;
		$spiritsUPDB->descript = $data->descript;
		$spiritsUPDB->price = $data->price;
		$spiritsUPDB->cost = $data->cost;
		$spiritsUPDB->discount = $data->discount;
		$spiritsUPDB->promo = $data->promo;
		$spiritsUPDB->dflag = $data->dflag;
		$spiritsUPDB->dclass = $data->dclass;
		$spiritsUPDB->damount = $data->damount;
		$spiritsUPDB->taxlevel = $data->taxlevel;
		$spiritsUPDB->surcharge = $data->surcharge;
		$spiritsUPDB->cat = $data->cat;
		$spiritsUPDB->location = $data->location;
		$spiritsUPDB->dml = $data->dml;
		$spiritsUPDB->cpack = $data->cpack;
		$spiritsUPDB->onsale = $data->onsale;
		$spiritsUPDB->freeze = $data->freeze;
		$spiritsUPDB->memo = $data->memo;
		$spiritsUPDB->bqty = $data->bqty;
		$spiritsUPDB->extax = $data->extax;
		$spiritsUPDB->lreg= $data->lreg;
		$spiritsUPDB->lstore= $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;

	$spiritsRTN = $spiritsUPDB->updateOdd();
	if($spiritsRTN=='OK'){
	    http_response_code(200);
	    echo json_encode(array("message" => "ORDER UPDATED.."));
	}
	else{
   		http_response_code(503);
		echo json_encode(array("message" => "ERROR UPDATING!!"));
    	echo json_encode(array("error" =>$spiritsRTN));
	}
	
?>
