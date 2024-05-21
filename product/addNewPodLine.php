<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/spiritspod.php';

$database = new Database();
$db = $database->getConnection();
  
$spiritsUPDB = new spiritspod($db);

$data = json_decode(file_get_contents("php://input"));
 
	$getStore = $data->store;
	$getOrder = $data->order;
	$stmt = $spiritsUPDB->getLastPod($getStore,$getOrder);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	extract($row);
	if(is_null($linenum)){
		$nextLineNum = 10;
	}else{
		$nextLineNum = $linenum+10;
	}
		$spiritsUPDB->order = $data->order;
		$spiritsUPDB->store = $data->store;
		$spiritsUPDB->line = $nextLineNum;
		$spiritsUPDB->sku = $data->sku;
		$spiritsUPDB->name = $data->name;
		$spiritsUPDB->sname = $data->sname;
		$spiritsUPDB->ml = $data->ml;
		$spiritsUPDB->status = $data->status;
		$spiritsUPDB->vendor = $data->vendor;
		$spiritsUPDB->vcode = $data->vcode;
		$spiritsUPDB->vid = $data->vid;
		$spiritsUPDB->orddate = $data->orddate;
		$spiritsUPDB->rcvdate = $data->rcvdate;
		$spiritsUPDB->oqty = $data->oqty;
		$spiritsUPDB->coqty = $data->coqty;
		$spiritsUPDB->bqty = $data->bqty;
		$spiritsUPDB->cbqty = $data->cbqty;
		$spiritsUPDB->fifo = $data->fifo;
		$spiritsUPDB->cost = $data->cost;
		$spiritsUPDB->unitcost = $data->unitcost;
		$spiritsUPDB->pack = $data->pack;
		$spiritsUPDB->glaccount = $data->glaccount;
		$spiritsUPDB->deal = $data->deal;
		$spiritsUPDB->salesman = $data->salesman;
		$spiritsUPDB->transfer = $data->transfer;
		$spiritsUPDB->sord = $data->sord;
		$spiritsUPDB->creditstat = $data->creditstat;
		$spiritsUPDB->crdpaydate = $data->crdpaydate;
		$spiritsUPDB->who = $data->who;
		$spiritsUPDB->memo = $data->memo;
		$spiritsUPDB->creditdue = $data->creditdue;
		$spiritsUPDB->creditpaid = $data->creditpaid;
		$spiritsUPDB->crdpaynbr = $data->crdpaynbr;
		$spiritsUPDB->deposits = $data->deposits;
		$spiritsUPDB->invoice = $data->invoice;
		$spiritsUPDB->invoicenbr = $data->invoicenbr;
		$spiritsUPDB->upstk = $data->upstk;
		$spiritsUPDB->bdrips = $data->bdrips;
		$spiritsUPDB->adjcost = $data->adjcost;
		$spiritsUPDB->reccoqty = $data->reccoqty;
		$spiritsUPDB->recoqty = $data->recoqty;
		$spiritsUPDB->rips = $data->rips;
		$spiritsUPDB->freight = $data->freight;
		$spiritsUPDB->tax = $data->tax;
		$spiritsUPDB->discounts = $data->discounts;
		$spiritsUPDB->ware = $data->ware;
		$spiritsUPDB->wareoqty = $data->wareoqty;
		$spiritsUPDB->warecoqty = $data->warecoqty;
		$spiritsUPDB->gosent = $data->gosent;
		$spiritsUPDB->lreg = $data->lreg;
		$spiritsUPDB->lstore = $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;
  
		$spiritsRTN = $spiritsUPDB->updatePod();
if($spiritsRTN=='OK'){
	$stmt = $spiritsUPDB->readPodLine($getOrder,$nextLineNum);
	$num = $stmt->rowCount();

	if($num>0){
	  
		$products_arr=array();
		$products_arr["records"]=array();
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

			extract($row);
			
			$product_item=array(
				"order" => $order,
				"store" => $store,
				"line" => $line,
				"sku" => $sku,
				"name" => $name,
				"sname" => $sname,
				"ml" => $ml,
				"status" => $status,
				"vendor" => $vendor,
				"vcode" => $vcode,
				"vid" => $vid,
				"orddate" => $orddate,
				"oqty" => $oqty,
				"coqty" => $coqty,
				"recoqty" => $recoqty,
				"reccoqty" => $reccoqty,
				"cost" => $cost,
				"unitcost" => $unitcost,
				"pack" => $pack,
				"glaccount" => $glaccount,
				"deal" => $deal,
				"salesman" => $salesman,
				"transfer" => $transfer,
				"sord" => $sord,
				"creditstat" => $creditstat,
				"creditdue" => $creditdue,
				"deposits" => $deposits,
				"invoice" => $invoice,
				"who" => $who,
				"invoicenbr" => $invoicenbr,
				"upstk" => $upstk,
				"bdrips" => $bdrips,
				"adjcost" => $adjcost,
				"rips" => $rips,
				"tax" => $tax,
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