<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';

	$database = new Database();
	$db = $database->getConnection();


	$bulk = json_decode(file_get_contents("php://input"));
	$stmt = $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->beginTransaction(); 

	foreach($bulk->records as $data){

		try {
		$query = "INSERT INTO jnh (`date`,`store`,`register`,`cashier`,`sale`,`customer`,`order`,`taxcode`,`total`,`receipts`,`memo`,`signature`,`reference`,`ackrefno`,`voided`,`tstamp`,`isdel`,`lreg`,`lstore`)
			VALUES 
		(:date,:store,:register,:cashier,:sale,:customer,:order,:taxcode,:total,:receipts,:memo,:signature,:reference,:ackrefno,:voided,:tstamp,0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`date` = :date,
		`store` = :store,
		`register` = :register,
		`cashier` = :cashier,
		`sale` = :sale,
		`customer` = :customer,
		`order` = :order,
		`taxcode` = :taxcode,
		`total` = :total,
		`receipts` = :receipts,
		`memo` = :memo,
		`signature` = :signature,
		`reference` = :reference,
		`ackrefno` = :ackrefno,
		`voided` = :voided,
		`tstamp` = :tstamp,
		`lstore` = :lstore,
		`lreg` = :lreg,
		`isdel` = :isdel";

		$stmt = $db->prepare($query);
		$thisdate=strip_tags($data->date);
		$thisstore=strip_tags($data->store);
		$thisregister=strip_tags($data->register);
		$thiscashier=strip_tags($data->cashier);
		$thissale=strip_tags($data->sale);
		$thiscustomer=strip_tags($data->customer);
		$thisorder=strip_tags($data->order);
		$thistaxcode=strip_tags($data->taxcode);
		$thistotal=strip_tags($data->total);
		$thisreceipts=strip_tags($data->receipts);
		$thismemo=strip_tags($data->memo);
		$thissignature=strip_tags($data->signature);
		$thisreference=strip_tags($data->reference);
		$thisackrefno=strip_tags($data->ackrefno);
		$thisvoided=strip_tags($data->voided);
		$thislreg=strip_tags($data->lreg);
		$thislstore=strip_tags($data->lstore);
		$thisisdel=strip_tags($data->isdel);
		$thiststamp=strip_tags($data->tstamp);


		$stmt->bindParam(':date', $thisdate);
		$stmt->bindParam(':store', $thisstore);
		$stmt->bindParam(':register', $thisregister);
		$stmt->bindParam(':cashier', $thiscashier);
		$stmt->bindParam(':sale', $thissale);
		$stmt->bindParam(':customer', $thiscustomer);
		$stmt->bindParam(':order', $thisorder);
		$stmt->bindParam(':taxcode', $thistaxcode);
		$stmt->bindParam(':total', $thistotal);
		$stmt->bindParam(':receipts', $thisreceipts);
		$stmt->bindParam(':memo', $thismemo);
		$stmt->bindParam(':signature', $thissignature);
		$stmt->bindParam(':reference', $thisreference);
		$stmt->bindParam(':ackrefno', $thisackrefno);
		$stmt->bindParam(':voided', $thisvoided);
		$stmt->bindParam(':lreg', $thislreg);
		$stmt->bindParam(':lstore', $thislstore);
		$stmt->bindParam(':isdel', $thisisdel);
		$stmt->bindParam(':tstamp', $thiststamp);

		$stmt->execute();
		} catch (PDOException $e) {
			$message = $e->getMessage();
			echo $message;
		}

		}
		$spiritsEND=$db->commit();
		if($spiritsEND==TRUE){
			http_response_code(200);
			echo json_encode(array("message" => "UPDATED.."));
		}
		else{
			http_response_code(503);
			echo json_encode(array("message" => "ERROR UPDATING!!"));
			echo json_encode(array("error" =>$spiritsEND));
		}
?>