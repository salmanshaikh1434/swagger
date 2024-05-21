<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritsmfg.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritsmfg($db);

	$data = json_decode(file_get_contents("php://input"));
    
        $spiritsUPDB->id =  $data->id;
        $spiritsUPDB->name =  $data->name;
        $spiritsUPDB->caseamt =  $data->caseamt;
        $spiritsUPDB->unitamt =  $data->unitamt;
        $spiritsUPDB->lreg =  $data->lreg;
        $spiritsUPDB->isdel =  $data->isdel;
        $spiritsUPDB->lstore =  $data->lstore;

	$spiritsRTN = $spiritsUPDB->updateMfg();
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