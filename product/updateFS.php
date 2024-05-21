<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
include_once '../config/database.php';
include_once '../objects/spiritsfshst.php';
  
$database = new Database();
$db = $database->getConnection();
  
$spiritsUPDB = new spiritsfshst($db);

$data = json_decode(file_get_contents("php://input"));
//by sumeeth for solving Undefined property: stdClass warning.
	$spiritsUPDB->date=$data->date;
	$spiritsUPDB->dcredits=isset($data->dcredits)?$data->dcredits:0;
	$spiritsUPDB->credorpts=isset($data->credorpts)?$data->credorpts:0;
	$spiritsUPDB->storeno=isset($data->storeno)?$data->storeno:0;
	$spiritsUPDB->saleno=isset($data->saleno)?$data->saleno:0;
	$spiritsUPDB->lreg=isset($data->lreg)?$data->lreg:0;
	$spiritsUPDB->lstore=isset($data->lstore)?$data->lstore:0;
	$spiritsUPDB->custid=isset($data->custid)?$data->custid:0;
	$spiritsUPDB->sent=isset($data->sent)?$data->sent:0;
	$spiritsUPDB->type=isset($data->type)?$data->type:0;
	$spiritsUPDB->who=isset($data->who)?$data->who:0;
	$spiritsUPDB->saletotal=isset($data->saletotal)?$data->saletotal:0;
	$thisCredType = $data->credorpts;
	
	$spiritsRTN = $spiritsUPDB->updateFS($thisCredType);
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