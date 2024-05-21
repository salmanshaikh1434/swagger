<?php	header("Access-Control-Allow-Origin: *");	header("Content-Type: application/json; charset=UTF-8");	header("Access-Control-Allow-Methods: POST");	header("Access-Control-Max-Age: 3600");	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");	include_once '../config/database.php';	include_once '../objects/spiritstyp.php';	$database = new Database();	$db = $database->getConnection();	$spiritsUPDB = new spiritstyp($db);	$data = json_decode(file_get_contents("php://input"));		$spiritsUPDB->type = $data->type;		$spiritsUPDB->name = $data->name;		$spiritsUPDB->scat1 = $data->scat1;		$spiritsUPDB->scat2 = $data->scat2;		$spiritsUPDB->unit_case = $data->unit_case;		$spiritsUPDB->suprof = $data->suprof;		$spiritsUPDB->scprof = $data->scprof;		$spiritsUPDB->sweeks = $data->sweeks;		$spiritsUPDB->smin = $data->smin;		$spiritsUPDB->sord = $data->sord;		$spiritsUPDB->disc = $data->disc;		$spiritsUPDB->ml1 = $data->ml1;		$spiritsUPDB->uprof1 = $data->uprof1;		$spiritsUPDB->cprof1 = $data->cprof1;		$spiritsUPDB->weeks1 = $data->weeks1;		$spiritsUPDB->disc1 = $data->disc1;		$spiritsUPDB->ml2 = $data->ml2;		$spiritsUPDB->uprof2 = $data->uprof2;		$spiritsUPDB->cprof2 = $data->cprof2;		$spiritsUPDB->disc2 = $data->disc2;		$spiritsUPDB->weeks2 = $data->weeks2;		$spiritsUPDB->ml3 = $data->ml3;		$spiritsUPDB->uprof3 = $data->uprof3;		$spiritsUPDB->cprof3 = $data->cprof3;		$spiritsUPDB->weeks3 = $data->weeks3;		$spiritsUPDB->disc3 = $data->disc3;		$spiritsUPDB->ml4 = $data->ml4;		$spiritsUPDB->uprof4 = $data->uprof4;		$spiritsUPDB->cprof4 = $data->cprof4;		$spiritsUPDB->weeks4 = $data->weeks4;		$spiritsUPDB->disc4 = $data->disc4;		$spiritsUPDB->ml5 = $data->ml5;		$spiritsUPDB->uprof5 = $data->uprof5;		$spiritsUPDB->cprof5 = $data->cprof5;		$spiritsUPDB->weeks5 = $data->weeks5;		$spiritsUPDB->disc5 = $data->disc5;		$spiritsUPDB->ml6 = $data->ml6;		$spiritsUPDB->uprof6 = $data->uprof6;		$spiritsUPDB->cprof6 = $data->cprof6;		$spiritsUPDB->weeks6 = $data->weeks6;		$spiritsUPDB->disc6 = $data->disc6;		$spiritsUPDB->ml7 = $data->ml7;		$spiritsUPDB->uprof7 = $data->uprof7;		$spiritsUPDB->cprof7 = $data->cprof7;		$spiritsUPDB->weeks7 = $data->weeks7;		$spiritsUPDB->disc7 = $data->disc7;		$spiritsUPDB->ml8 = $data->ml8;		$spiritsUPDB->uprof8 = $data->uprof8;		$spiritsUPDB->cprof8 = $data->cprof8;		$spiritsUPDB->weeks8 = $data->weeks8;		$spiritsUPDB->disc8 = $data->disc8;		$spiritsUPDB->who = $data->who;		$spiritsUPDB->fson = $data->fson;		$spiritsUPDB->webupdate = $data->webupdate;		$spiritsUPDB->sent = $data->sent;		$spiritsUPDB->typenum = $data->typenum;		$spiritsUPDB->uvinseas = $data->uvinseas;		$spiritsUPDB->browseqty = $data->browseqty;		$spiritsUPDB->outofstock = $data->outofstock;		$spiritsUPDB->lreg= $data->lreg;		$spiritsUPDB->lstore= $data->lstore;		$spiritsUPDB->isdel = $data->isdel;	$spiritsRTN = $spiritsUPDB->updateTyp();	if($spiritsRTN=='OK'){	    http_response_code(200);	    echo json_encode(array("message" => "UPDATED.."));	}	else{   		http_response_code(503);		echo json_encode(array("message" => "ERROR UPDATING!!"));    	echo json_encode(array("error" =>$spiritsRTN));	}?>