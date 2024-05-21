<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/spiritscus.php';

$database = new Database();
$db = $database->getConnection();
  
$spiritsUPDB = new spiritscus($db);

$data = json_decode(file_get_contents("php://input"));
 
	$getStore = $data->store;
	$stmt = $spiritsUPDB->getLastCus($getStore);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	extract($row);
	$nextCusNum = ($cusnum+1);
	
		$spiritsUPDB->customer = $nextCusNum;
		$spiritsUPDB->firstname = $data->firstname;
		$spiritsUPDB->lastname = $data->lastname;
		$spiritsUPDB->status = $data->status;
		$spiritsUPDB->street1 = $data->street1;
		$spiritsUPDB->street2 = $data->street2;
		$spiritsUPDB->city = $data->city;
		$spiritsUPDB->state = $data->state;
		$spiritsUPDB->zip = $data->zip;
		$spiritsUPDB->contact = $data->contact;
		$spiritsUPDB->phone = $data->phone;
		$spiritsUPDB->fax = $data->fax;
		$spiritsUPDB->modem = $data->modem;
		$spiritsUPDB->startdate = date("Y-m-d");
		$spiritsUPDB->taxcode = $data->taxcode;
		$spiritsUPDB->terms = $data->terms;
		$spiritsUPDB->shipvia = $data->shipvia;
		$spiritsUPDB->statement = $data->statement;
		$spiritsUPDB->crdlimit = $data->crdlimit;
		$spiritsUPDB->balance = $data->balance;
		$spiritsUPDB->store = $data->store;
		$spiritsUPDB->salesper = $data->salesper;
		$spiritsUPDB->clubcard = $data->clubcard;
		$spiritsUPDB->clublist = $data->clublist;
		$spiritsUPDB->clubdisc = $data->clubdisc;
		$spiritsUPDB->altid = $data->altid;
		$spiritsUPDB->types = $data->types;
		$spiritsUPDB->department = $data->department;
		$spiritsUPDB->who = $data->who;
		$spiritsUPDB->memo = $data->memo;
		$spiritsUPDB->storelevel = $data->storelevel;
		$spiritsUPDB->billto = $data->billto;
		$spiritsUPDB->wslicense = $data->wslicense;
		$spiritsUPDB->wsexpire = $data->wsexpire;
		$spiritsUPDB->wetdry = $data->wetdry;
		$spiritsUPDB->taxid = $data->taxid;
		$spiritsUPDB->invoicemsg = $data->invoicemsg;
		$spiritsUPDB->statementm = $data->statementm;
		$spiritsUPDB->territory = $data->territory;
		$spiritsUPDB->filter = $data->filter;
		$spiritsUPDB->email = $data->email;
		$spiritsUPDB->sflag = $data->sflag;
		$spiritsUPDB->fcflag = $data->fcflag;
		$spiritsUPDB->printbal = $data->printbal;
		$spiritsUPDB->cdate = $data->cdate;
		$spiritsUPDB->scldate = $data->scldate;
		$spiritsUPDB->fson = $data->fson;
		$spiritsUPDB->fscpts = $data->fscpts;
		$spiritsUPDB->fstpts = $data->fstpts;
		$spiritsUPDB->fsdlrval = $data->fsdlrval;
		$spiritsUPDB->fsdlrcrdts = $data->fsdlrcrdts;
		$spiritsUPDB->creditcard = $data->creditcard;
		$spiritsUPDB->expire = $data->expire;
		$spiritsUPDB->cvv = $data->cvv;
		$spiritsUPDB->sent = $data->sent;
		$spiritsUPDB->wphone = $data->wphone;
		$spiritsUPDB->fsfactor = $data->fsfactor;
		$spiritsUPDB->lreg= $data->lreg;
		$spiritsUPDB->lstore= $data->lstore;
		$spiritsUPDB->isdel = $data->isdel;
  
$spiritsRTN = $spiritsUPDB->updateCus();
if($spiritsRTN=='OK'){
	$stmt = $spiritsUPDB->readCus($nextCusNum);
	$num = $stmt->rowCount();

	if($num>0){
	  
		$products_arr=array();
		$products_arr["records"]=array();
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

			extract($row);
			
			$product_item=array(
				"customer" => $customer,
				"firstname" => $firstname,
				"lastname" => $lastname,
				"status" => $status,
				"street1" => $street1,
				"street2" => $street2,
				"city" => $city,
				"state" => $state,
				"zip" => $zip,
				"contact" => $contact,
				"phone" => $phone,
				"fax" => $fax,
				"modem" => $modem,
				"startdate" => $startdate,
				"taxcode" => $taxcode,
				"terms" => $terms,
				"shipvia" => $shipvia,
				"statement" => $statement,
				"crdlimit" => $crdlimit,
				"balance" => $balance,
				"store" => $store,
				"salesper" => $salesper,
				"clubcard" => $clubcard,
				"clublist" => $clublist,
				"clubdisc" => $clubdisc,
				"altid" => $altid,
				"types" => $types,
				"department" => $department,
				"who" => $who,
				"memo" => $memo,
				"storelevel" => $storelevel,
				"billto" => $billto,
				"wslicense" => $wslicense,
				"wsexpire" => $wsexpire,
				"wetdry" => $wetdry,
				"taxid" => $taxid,
				"invoicemsg" => $invoicemsg,
				"statementm" => $statementm,
				"territory" => $territory,
				"filter" => $filter,
				"email" => $email,
				"sflag" => $sflag,
				"fcflag" => $fcflag,
				"printbal" => $printbal,
				"cdate" => $cdate,
				"scldate" => $scldate,
				"fson" => $fson,
				"fscpts" => $fscpts,
				"fstpts" => $fstpts,
				"fsdlrval" => $fsdlrval,
				"fsdlrcrdts" => $fsdlrcrdts,
				"creditcard" => $creditcard,
				"expire" => $expire,
				"cvv" => $cvv,
				"sent" => $sent,
				"wphone" => $wphone,
				"fsfactor" => $fsfactor,
				"lreg" => $lreg,
				"lstore" => $lstore,
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