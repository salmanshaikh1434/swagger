<?php
	header("Access-Control_allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	include_once '../config/core.php';
	include_once '../shared/utilities.php';
	include_once '../config/database.php';
	include_once '../objects/spiritschd.php';

	$database = new Database();
	$db = $database->getConnection();

	$product = new spiritsChd($db);
	$getSku=isset($_GET['bankacct']) ? $_GET['bankacct'] : die();

	$stmt = $product->readChd($getSku);
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
		"dl_state" => $dl_state,
		"dl_number" => $dl_number,
		"bankacct" => $bankacct,
		"chk_nbr" => $chk_nbr,
		"chk_dte" => $chk_dte,
		"chk_amt" => $chk_amt,
		"reason" => $reason,
		"pd_amt" => $pd_amt,
		"cntr" => $cntr,
		"file_loc" => $file_loc,
		"status" => $status,
		"customer" => $customer,
		"store" => $store,
		"who" => $who,
		"memo" => $memo,
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
?>
