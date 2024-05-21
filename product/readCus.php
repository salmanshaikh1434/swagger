<?php
	header("Access-Control_allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	include_once '../config/core.php';
	include_once '../shared/utilities.php';
	include_once '../config/database.php';
	include_once '../objects/spiritscus.php';

	$database = new Database();
	$db = $database->getConnection();

	$product = new spiritsCus($db);
	$getCus=isset($_GET['customer']) ? $_GET['customer'] : die();

	$stmt = $product->readCus($getCus);
	if ($stmt == false) {
		echo json_encode(
			array("message" => "Unauthorised request.")
		);
		exit;
	}
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
		"webcustid" => $webcustid,
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
?>