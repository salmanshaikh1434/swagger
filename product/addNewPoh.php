<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/spiritspoh.php';
include_once '../objects/spiritsany.php';

$database = new Database();
$db = $database->getConnection();
  
$spiritsUPDB = new spiritspoh($db);
$spiritsAny = new spiritsany($db);

$data = json_decode(file_get_contents("php://input"));
 
	$getStore = $data->store;
	if(empty($getStore)){
		$getStore = 1;
	}


	$nextOrderNum = $spiritsAny->getlastrecord('order', 'poh', $getStore);

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
	$spiritsUPDB->total = 0;
	$spiritsUPDB->lastline = 0;
	$spiritsUPDB->transact = 0;
	$spiritsUPDB->lstore = $data->lstore;
	$spiritsUPDB->lreg = $data->lreg;
	$spiritsUPDB->who = $data->who;
	$spiritsUPDB->memo = "";
	$spiritsUPDB->discounts = 0;
	$spiritsUPDB->tax = 0;
	$spiritsUPDB->newdeposit = 0;
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
				"order" => $order,
				"store" => $store,
				"vendor" => $vendor,
				"vcode" => $vcode,
				"pay_vendor" => $pay_vendor,
				"contact" => $contact,
				"phone" => $phone,
				"status" => $status,
				"orddate" => $orddate,
				"promdate" => $promdate,
				"rcvdate" => $rcvdate,
				"agedate" => $agedate,
				"whoreq" => $whoreq,
				"whoord" => $whoord,
				"whorcv" => $whorcv,
				"terms" => $terms,
				"shipvia" => $shipvia,
				"customer" => $customer,
				"taxcode" => $taxcode,
				"total" => $total,
				"lastline" => $lastline,
				"transact" => $transact,
				"lstore" => $lstore,
				"lreg" => $lreg,
				"who" => $who,
				"tstamp" => $tstamp,
				"memo" => $memo,
				"discounts" => $discounts,
				"tax" => $tax,
				"newdeposit" => $newdeposit,
				"rtndeposit" => $rtndeposit,
				"freight" => $freight,
				"salesman" => $salesman,
				"transfer" => $transfer,
				"includedep" => $includedep,
				"invoicenbr" => $invoicenbr,
				"repost" => $repost,
				"postcost" => $postcost,
				"bdrips" => $bdrips,
				"sent" => $sent,
				"applytax" => $applytax,
				"applycred" => $applycred,
				"applyship" => $applyship,
				"applybdrip" => $applybdrip,
				"approved" => $approved,
				"cstore" => $cstore,
				"isdel" => $isdel
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