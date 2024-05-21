<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritsjnl.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritsjnl($db);
	// rename $jnl to $data and removed foreach as it in not required here by salman
	$data = json_decode(file_get_contents("php://input"));
	
	
		$spiritsUPDB->store = $data->store;
		$spiritsUPDB->sale = $data->sale;
		$spiritsUPDB->line = $data->line;
		$spiritsUPDB->qty = $data->qty;
		$spiritsUPDB->pack = $data->pack;
		$spiritsUPDB->sku = $data->sku;
		$spiritsUPDB->descript = $data->descript;
		$spiritsUPDB->price = $data->price;
		$spiritsUPDB->cost = $data->cost;
		$spiritsUPDB->discount = $data->discount;
		$spiritsUPDB->dclass = $data->dclass;
		$spiritsUPDB->promo = $data->promo;
		$spiritsUPDB->cat = $data->cat;
		$spiritsUPDB->location = $data->location;
		$spiritsUPDB->rflag = $data->rflag;
		$spiritsUPDB->upc = $data->upc;
		$spiritsUPDB->boss = $data->boss;
		$spiritsUPDB->memo = $data->memo;
		$spiritsUPDB->date = $data->date;
		$spiritsUPDB->prclevel = $data->prclevel;
		$spiritsUPDB->fspoints = $data->fspoints;
		$spiritsUPDB->rtnqty = $data->rtnqty;
		$spiritsUPDB->updated = $data->updated;
		$spiritsUPDB->hst = $data->hst;
		$spiritsUPDB->glb = $data->glb;
		$spiritsUPDB->stk = $data->stk;
		$spiritsUPDB->lreg= $data->lreg;
		$spiritsUPDB->lstore= $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;

		$spiritsRTN = $spiritsUPDB->updateJnl();
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
