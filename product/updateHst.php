<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritshst.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritshst($db);
	$data = json_decode(file_get_contents("php://input"));

	$spiritsUPDB->sku = $data->sku;
	$spiritsUPDB->date = $data->date;
	$spiritsUPDB->qty = $data->qty;
	$spiritsUPDB->price = $data->price;
	$spiritsUPDB->cost = $data->cost;
	$spiritsUPDB->promo = $data->promo;
	$spiritsUPDB->store = $data->store;
	$spiritsUPDB->pack = $data->pack;
	$spiritsUPDB->who = $data->who;
	$spiritsUPDB->sent = $data->sent;
	$spiritsUPDB->lstore = $data->lstore;
	$spiritsUPDB->lreg = $data->lreg;
	$spiritsUPDB->isdel = $data->isdel;

		if ($data->lvlqty == '1'){
						$spiritsUPDB->lvl1qty = $data->qty;
						$spiritsUPDB->lvl1price = $data->price;
						$spiritsUPDB->lvl1cost = $data->cost;
						$spiritsUPDB->lvl2qty=0;
						$spiritsUPDB->lvl2price=0.00;
						$spiritsUPDB->lvl2cost=0.00;
						$spiritsUPDB->lvl3qty=0;
						$spiritsUPDB->lvl3price=0.00;
						$spiritsUPDB->lvl3cost=0.00;
						$spiritsUPDB->lvl4qty=0;
						$spiritsUPDB->lvl4price=0.00;
						$spiritsUPDB->lvl4cost=0.00;
		}elseif($data->lvlqty == '2'){
						$spiritsUPDB->lvl1qty=0;
						$spiritsUPDB->lvl1price=0.00;
						$spiritsUPDB->lvl1cost=0.00;
						$spiritsUPDB->lvl2qty = $data->qty;
						$spiritsUPDB->lvl2price = $data->price;
						$spiritsUPDB->lvl2cost = $data->cost;
						$spiritsUPDB->lvl3qty=0;
						$spiritsUPDB->lvl3price=0.00;
						$spiritsUPDB->lvl3cost=0.00;
						$spiritsUPDB->lvl4qty=0;
						$spiritsUPDB->lvl4price=0.00;
						$spiritsUPDB->lvl4cost=0.00;
		}elseif($data->lvlqty == '3'){
						$spiritsUPDB->lvl1qty=0;
						$spiritsUPDB->lvl1price=0.00;
						$spiritsUPDB->lvl1cost=0.00;
						$spiritsUPDB->lvl2qty=0;
						$spiritsUPDB->lvl2price=0.00;
						$spiritsUPDB->lvl2cost=0.00;
						$spiritsUPDB->lvl3qty = $data->qty;
						$spiritsUPDB->lvl3price = $data->price;
						$spiritsUPDB->lvl3cost = $data->cost;
						$spiritsUPDB->lvl4qty=0;
						$spiritsUPDB->lvl4price=0.00;
						$spiritsUPDB->lvl4cost=0.00;
		}elseif($data->lvlqty == '4'){
						$spiritsUPDB->lvl1qty=0;
						$spiritsUPDB->lvl1price=0.00;
						$spiritsUPDB->lvl1cost=0.00;
						$spiritsUPDB->lvl2qty=0;
						$spiritsUPDB->lvl2price=0.00;
						$spiritsUPDB->lvl2cost=0.00;
						$spiritsUPDB->lvl3qty=0;
						$spiritsUPDB->lvl3price=0.00;
						$spiritsUPDB->lvl3cost=0.00;
						$spiritsUPDB->lvl4qty = $data->qty;
						$spiritsUPDB->lvl4price = $data->price;
						$spiritsUPDB->lvl4cost = $data->cost;
		} else {
						$spiritsUPDB->lvl1qty = 0;
						$spiritsUPDB->lvl1price = 0.00;
						$spiritsUPDB->lvl1cost = 0.00;
						$spiritsUPDB->lvl2qty = 0;
						$spiritsUPDB->lvl2price = 0.00;
						$spiritsUPDB->lvl2cost = 0.00;
						$spiritsUPDB->lvl3qty = 0;
						$spiritsUPDB->lvl3price = 0.00;
						$spiritsUPDB->lvl3cost = 0.00;
						$spiritsUPDB->lvl4qty = 0;
						$spiritsUPDB->lvl4price = 0.00;
						$spiritsUPDB->lvl4cost = 0.00;
	
		}

	$spiritsRTN = $spiritsUPDB->updateHST();
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

