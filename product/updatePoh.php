<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/spiritspoh.php';

$database = new Database();
$db = $database->getConnection();
  
$spiritsUPDB = new spiritspoh($db);

$data = json_decode(file_get_contents("php://input"));
  
$spiritsUPDB->order = $data->order;
$spiritsUPDB->store = $data->store;
$spiritsUPDB->vendor = $data->vendor;
$spiritsUPDB->vcode = $data->vcode;
$spiritsUPDB->pay_vendor = $data->pay_vendor;
$spiritsUPDB->contact = $data->contact;
$spiritsUPDB->phone = $data->phone;
$spiritsUPDB->status = $data->status;
$spiritsUPDB->orddate = $data->orddate;
$spiritsUPDB->promdate = $data->promdate;
$spiritsUPDB->rcvdate = $data->rcvdate;
$spiritsUPDB->agedate = $data->agedate;
$spiritsUPDB->whoreq = $data->whoreq;
$spiritsUPDB->whoord = $data->whoord;
$spiritsUPDB->whorcv = $data->whorcv;
$spiritsUPDB->terms = $data->terms;
$spiritsUPDB->shipvia = $data->shipvia;
$spiritsUPDB->customer = $data->customer;
$spiritsUPDB->taxcode = $data->taxcode;
$spiritsUPDB->total = $data->total;
$spiritsUPDB->lastline = $data->lastline;
$spiritsUPDB->transact = $data->transact;
$spiritsUPDB->lstore = $data->lstore;
$spiritsUPDB->lreg = $data->lreg;
$spiritsUPDB->who = $data->who;
$spiritsUPDB->memo = $data->memo;
$spiritsUPDB->discounts = $data->discounts;
$spiritsUPDB->tax = $data->tax;
$spiritsUPDB->newdeposit = $data->newdeposit;
$spiritsUPDB->rtndeposit = $data->rtndeposit;
$spiritsUPDB->freight = $data->freight;
$spiritsUPDB->salesman = $data->salesman;
$spiritsUPDB->transfer = $data->transfer;
$spiritsUPDB->includedep = $data->includedep;
$spiritsUPDB->invoicenbr = $data->invoicenbr;
$spiritsUPDB->repost = $data->repost;
$spiritsUPDB->postcost = $data->postcost;
$spiritsUPDB->bdrips = $data->bdrips;
$spiritsUPDB->sent = $data->sent;
$spiritsUPDB->applytax = $data->applytax;
$spiritsUPDB->applycred = $data->applycred;
$spiritsUPDB->applyship = $data->applyship;
$spiritsUPDB->applybdrip = $data->applybdrip;
$spiritsUPDB->approved = $data->approved;
$spiritsUPDB->cstore = $data->cstore;
$spiritsUPDB->isdel = $data->isdel;
  
$spiritsRTN = $spiritsUPDB->updatePOH();
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