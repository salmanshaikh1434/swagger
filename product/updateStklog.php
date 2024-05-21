<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/spiritslog.php';

	$database = new Database();
	$db = $database->getConnection();

	$spiritsUPDB = new spiritslog($db);

	$data = json_decode(file_get_contents("php://input"));

    $spiritsUPDB->sku  = $data->sku;
    $spiritsUPDB->store = $data->stor;
    $spiritsUPDB->floor = $data->floor;
    $spiritsUPDB->back = $data->back;
    $spiritsUPDB->shipped = $data->shipped;
    $spiritsUPDB->kits = $data->kits;
    $spiritsUPDB->amount = $data->amount;
    $spiritsUPDB->line = $data->line;
    $spiritsUPDB->number = $data->number;
    $spiritsUPDB->type = $data->type;
    $spiritsUPDB->whochange = $data->whochange;
    $spiritsUPDB->cdate = $data->cdate;
    $spiritsUPDB->stat = $data->stat;
    $spiritsUPDB->mtd_units = $data->mtd_units;
    $spiritsUPDB->weeks = $data->weeks;
    $spiritsUPDB->sdate = $data->sdate;
    $spiritsUPDB->mtd_dol = $data->mtd_dol;
    $spiritsUPDB->mtd_prof = $data->mtd_prof;
    $spiritsUPDB->ytd_units = $data->ytd_units;
    $spiritsUPDB->ytd_dol = $data->ytd_dol;
    $spiritsUPDB->ytd_prof = $data->ytd_prof;
    $spiritsUPDB->acost = $data->acost;
    $spiritsUPDB->lcost = $data->lcost;
    $spiritsUPDB->pvend = $data->pvend;
    $spiritsUPDB->lvend = $data->lvend;
    $spiritsUPDB->pdate = $data->pdate;
    $spiritsUPDB->smin = $data->smin;
    $spiritsUPDB->sord = $data->sord;
    $spiritsUPDB->sweeks = $data->sweeks;
    $spiritsUPDB->freeze_w = $data->freeze_w;
    $spiritsUPDB->shelf = $data->shelf;
    $spiritsUPDB->rshelf = $data->rshelf;
    $spiritsUPDB->sloc = $data->sloc;
    $spiritsUPDB->bloc = $data->bloc;
    $spiritsUPDB->lstore = $data->lstore;
    $spiritsUPDB->who = $data->who;
    $spiritsUPDB->inet = $data->inet;
    $spiritsUPDB->depos = $data->depos;
    $spiritsUPDB->skipstat = $data->skipstat;
    $spiritsUPDB->mincost = $data->mincost;
    $spiritsUPDB->isdel = $data->isdel;

	$spiritsRTN = $spiritsUPDB->updateStklog();
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