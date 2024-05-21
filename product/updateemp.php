<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritsemp.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritsemp($db);

	$data = json_decode(file_get_contents("php://input"));

		$spiritsUPDB->id = $data->id;
		$spiritsUPDB->uid = $data->uid;
		$spiritsUPDB->last_name = $data->last_name;
		$spiritsUPDB->first_name = $data->first_name;
		$spiritsUPDB->store = $data->store;
		$spiritsUPDB->title = $data->title;
		$spiritsUPDB->street1 = $data->street1;
		$spiritsUPDB->street2 = $data->street2;
		$spiritsUPDB->city = $data->city;
		$spiritsUPDB->state = $data->state;
		$spiritsUPDB->zip = $data->zip;
		$spiritsUPDB->homephone = $data->homephone;
		$spiritsUPDB->workphone = $data->workphone;
		$spiritsUPDB->carphone = $data->carphone;
		$spiritsUPDB->fax = $data->fax;
		$spiritsUPDB->password = $data->password;
		$spiritsUPDB->security = $data->security;
		$spiritsUPDB->poslevel = $data->poslevel;
		$spiritsUPDB->invlevel = $data->invlevel;
		$spiritsUPDB->actlevel = $data->actlevel;
		$spiritsUPDB->admlevel = $data->admlevel;
		$spiritsUPDB->hire_date = $data->hire_date;
		$spiritsUPDB->birth_date = $data->birth_date;
		$spiritsUPDB->last_raise = $data->last_raise;
		$spiritsUPDB->ssn = $data->ssn;
		//$spiritsUPDB->photo = $data->photo;
		$spiritsUPDB->notes = $data->notes;
		$spiritsUPDB->who = $data->who;
		$spiritsUPDB->lastlogin = $data->lastlogin;
		$spiritsUPDB->payrate = $data->payrate;
		$spiritsUPDB->terminate = $data->terminate;
		$spiritsUPDB->eserver = $data->eserver;
		$spiritsUPDB->euser = $data->euser;
		$spiritsUPDB->epass = $data->epass;
		$spiritsUPDB->port = $data->port;
		$spiritsUPDB->ssl = $data->ssl;
		$spiritsUPDB->auth = $data->auth;
		$spiritsUPDB->from = $data->from;
		$spiritsUPDB->sent = $data->sent;
		$spiritsUPDB->email = $data->email;
		$spiritsUPDB->cardnum = $data->cardnum;
		$spiritsUPDB->memo = $data->memo;
		$spiritsUPDB->pws = $data->pws;
		$spiritsUPDB->lreg= $data->lreg;
		$spiritsUPDB->lstore= $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;

	$spiritsRTN = $spiritsUPDB->updateEmp();
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
