<?php
	header("Access-Control_allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	include_once '../config/core.php';
	include_once '../shared/utilities.php';
	include_once '../config/database.php';
	include_once '../objects/spiritsemp.php';

	$database = new Database();
	$db = $database->getConnection();

	$product = new spiritsEmp($db);
	$getSku=isset($_GET['id']) ? $_GET['id'] : die();

	$stmt = $product->readEmp($getSku);
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
		"id" => $id,
		"uid" => $uid,
		"last_name" => $last_name,
		"first_name" => $first_name,
		"store" => $store,
		"title" => $title,
		"street1" => $street1,
		"street2" => $street2,
		"city" => $city,
		"state" => $state,
		"zip" => $zip,
		"homephone" => $homephone,
		"workphone" => $workphone,
		"carphone" => $carphone,
		"fax" => $fax,
		"password" => $password,
		"security" => $security,
		"poslevel" => $poslevel,
		"invlevel" => $invlevel,
		"actlevel" => $actlevel,
		"admlevel" => $admlevel,
		"hire_date" => $hire_date,
		"birth_date" => $birth_date,
		"last_raise" => $last_raise,
		"ssn" => $ssn,
		//"photo" => $photo,
		"notes" => $notes,
		"who" => $who,
		"lastlogin" => $lastlogin,
		"payrate" => $payrate,
		"terminate" => $terminate,
		"eserver" => $eserver,
		"euser" => $euser,
		"epass" => $epass,
		"port" => $port,
		"ssl" => $ssl,
		"auth" => $auth,
		"from" => $from,
		"sent" => $sent,
		"email" => $email,
		"cardnum" => $cardnum,
		"memo" => $memo,
		"pws" => $pws,
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
