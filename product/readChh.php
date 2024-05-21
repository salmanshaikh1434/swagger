<?php	header("Access-Control_allow-Origin: *");	header("Content-Type: application/json; charset=UTF-8");	include_once '../config/core.php';	include_once '../shared/utilities.php';	include_once '../config/database.php';	include_once '../objects/spiritschh.php';	$database = new Database();	$db = $database->getConnection();	$product = new spiritsChh($db);	$getSku=isset($_GET['bankacct']) ? $_GET['bankacct'] : die();	$stmt = $product->readChh($getSku);	$num = $stmt->rowCount();	if($num>0){	    $products_arr=array();	    $products_arr["records"]=array();	    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){			extract($row);			$product_item=array(		"dl_state" => $dl_state,		"dl_number" => $dl_number,		"bankacct" => $bankacct,		"acct_name" => $acct_name,		"acct_addr1" => $acct_addr1,		"acct_addr2" => $acct_addr2,		"acct_city" => $acct_city,		"acct_st" => $acct_st,		"acct_zip" => $acct_zip,		"dl_name" => $dl_name,		"dl_addr1" => $dl_addr1,		"dl_addr2" => $dl_addr2,		"dl_city" => $dl_city,		"dl_st" => $dl_st,		"dl_zip" => $dl_zip,		"ssn_taxid" => $ssn_taxid,		"phone1" => $phone1,		"desc1" => $desc1,		"phone2" => $phone2,		"desc2" => $desc2,		"phone3" => $phone3,		"desc3" => $desc3,		"phone4" => $phone4,		"desc4" => $desc4,		"cust_since" => $cust_since,		"lst_chk" => $lst_chk,		"ret_amt" => $ret_amt,		"ret_nbr" => $ret_nbr,		"upd_dte" => $upd_dte,		"status" => $status,		"desc" => $desc,		"dl_exp_dte" => $dl_exp_dte,		"dl_bday" => $dl_bday,		"dl_desc" => $dl_desc,		"dl_sex" => $dl_sex,		"dl_ht" => $dl_ht,		"dl_wt" => $dl_wt,		"dl_hair" => $dl_hair,		"dl_eyes" => $dl_eyes,		"customer" => $customer,		"store" => $store,		"who" => $who,		"memo" => $memo,		"sent" => $sent,		"lreg" => $lreg,		"lstore" => $lstore,		"isdel" => $isdel	       );	        array_push($products_arr["records"], $product_item);	    }	    http_response_code(200);	    echo json_encode($products_arr);	}else{		http_response_code(404);		echo json_encode(			array("message" => "NOT FOUND.")		);	}?>