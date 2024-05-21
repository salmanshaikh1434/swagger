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
 
	$getStore = $data->store;
	$stmt = $spiritsUPDB->getLastPoh($getStore);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	extract($row);
	$nextOrderNum = ($ordernum+1);
	
	$spiritsUPDB->order = $nextOrderNum;
	$spiritsUPDB->store = $data->store;
	$spiritsUPDB->vendor = $data->vendor;
	$spiritsUPDB->vcode = $data->vcode;
	$spiritsUPDB->pay_vendor = 0;
	$spiritsUPDB->contact = $data->contact;
	$spiritsUPDB->phone = $data->phone;
	$spiritsUPDB->status = "8";
	$spiritsUPDB->orddate = $data->orddate;
	$spiritsUPDB->promdate = $data->promdate;
	$spiritsUPDB->rcvdate = "";
	$spiritsUPDB->agedate = $data->agedate;
	$spiritsUPDB->whoreq = $data->whoreq;
	$spiritsUPDB->whoord = $data->whoord;
	$spiritsUPDB->whorcv = "";
	$spiritsUPDB->terms = $data->terms;
	$spiritsUPDB->shipvia = $data->shipvia;
	$spiritsUPDB->customer = 0;
	$spiritsUPDB->taxcode = $data->taxcode;
	$spiritsUPDB->total = $data->total;
	$spiritsUPDB->lastline = $data->lastline;
	$spiritsUPDB->transact = 0;
	$spiritsUPDB->lstore = $data->lstore;
	$spiritsUPDB->lreg = $data->lreg;
	$spiritsUPDB->who = $data->who;
	$spiritsUPDB->memo = "";
	$spiritsUPDB->discounts = 0;
	$spiritsUPDB->tax = $data->tax;
	$spiritsUPDB->newdeposit = $data->newdeposit;
	$spiritsUPDB->rtndeposit = 0;
	$spiritsUPDB->freight = 0;
	$spiritsUPDB->salesman = '';
	$spiritsUPDB->transfer = $data->transfer;
	$spiritsUPDB->includedep = $data->includedep;
	$spiritsUPDB->invoicenbr = '';
	$spiritsUPDB->repost = 0;
	$spiritsUPDB->postcost = 0;
	$spiritsUPDB->bdrips = 0;
	$spiritsUPDB->sent = 0;
	$spiritsUPDB->applytax = 0;
	$spiritsUPDB->applycred = 0;
	$spiritsUPDB->applyship = 0;
	$spiritsUPDB->applybdrip = 0;
	$spiritsUPDB->approved = 0;
	$spiritsUPDB->cstore = 0;
	$spiritsUPDB->isdel = 0;
  
$spiritsRTN = $spiritsUPDB->updatePOH();
if($spiritsRTN=='OK'){
	$stmt = $spiritsUPDB->readPoh($nextOrderNum);
	$num = $stmt->rowCount();
	if($num>0){
		$products_arr=array();
		$products_arr["records"]=array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$product_item=array(
				"order" => $order
		   );
			array_push($products_arr["records"], $product_item);
		}
		http_response_code(200);
		echo json_encode($products_arr);
	}else{
		http_response_code(404);
		echo json_encode(
			array("message" => "NOT FOUND.")
		);
	}
}
else{
    http_response_code(503);
	echo json_encode(array("message" => "ERROR UPDATING!!"));
    echo json_encode(array("error" =>$spiritsRTN));
}
?>