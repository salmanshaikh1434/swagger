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
		$query = "INSERT INTO ohd (`order`,`store`,`customer`,`shipto`,`contact`,`phone`,`status`,`orddate`,`promdate`,`shipdate`,`invdate`,`agedate`,`whosold`,`whoorder`,`whoship`,`whoinvoice`,`terms`,`shipvia`,`taxcode`,`total`,`transact`,`printmemo`,`who`,`shipmemo`,`memo`,`creditcard`,`expire`,`cvv`,`sent`,`tstamp`,`isdel`,`lreg`,`lstore`)
			VALUES 
		(:order,:store,:customer,:shipto,:contact,:phone,:status,:orddate,:promdate,:shipdate,:invdate,:agedate,:whosold,:whoorder,:whoship,:whoinvoice,:terms,:shipvia,:taxcode,:total,:transact,:printmemo,:who,:shipmemo,:memo,:creditcard,:expire,:cvv,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`order` = :order,
		`store` = :store,
		`customer` = :customer,
		`shipto` = :shipto,
		`contact` = :contact,
		`phone` = :phone,
		`status` = :status,
		`orddate` = :orddate,
		`promdate` = :promdate,
		`shipdate` = :shipdate,
		`invdate` = :invdate,
		`agedate` = :agedate,
		`whosold` = :whosold,
		`whoorder` = :whoorder,
		`whoship` = :whoship,
		`whoinvoice` = :whoinvoice,
		`terms` = :terms,
		`shipvia` = :shipvia,
		`taxcode` = :taxcode,
		`total` = :total,
		`transact` = :transact,
		`printmemo` = :printmemo,
		`who` = :who,
		`shipmemo` = :shipmemo,
		`memo` = :memo,
		`creditcard` = :creditcard,
		`expire` = :expire,
		`cvv` = :cvv,
		`sent` = :sent,
		`tstamp` = NOW(),
		`lstore` = :lstore,
		`lreg` = :lreg";
		// `isdel` = :isdel";

		$stmt = $db->prepare($query);
		$thisorder=strip_tags($data->order);
		$thisstore=strip_tags($data->store);
		$thiscustomer=strip_tags($data->customer);
		$thisshipto=strip_tags($data->shipto);
		$thiscontact=strip_tags($data->contact);
		$thisphone=strip_tags($data->phone);
		$thisstatus=strip_tags($data->status);
		$thisorddate=strip_tags($data->orddate);
		$thispromdate=strip_tags($data->promdate);
		$thisshipdate=strip_tags($data->shipdate);
		$thisinvdate=strip_tags($data->invdate);
		$thisagedate=strip_tags($data->agedate);
		$thiswhosold=strip_tags($data->whosold);
		$thiswhoorder=strip_tags($data->whoorder);
		$thiswhoship=strip_tags($data->whoship);
		$thiswhoinvoice=strip_tags($data->whoinvoice);
		$thisterms=strip_tags($data->terms);
		$thisshipvia=strip_tags($data->shipvia);
		$thistaxcode=strip_tags($data->taxcode);
		$thistotal=strip_tags($data->total);
		$thistransact=strip_tags($data->transact);
		$thisprintmemo=strip_tags($data->printmemo);
		$thiswho=strip_tags($data->who);
		$thisshipmemo=strip_tags($data->shipmemo);
		$thismemo=strip_tags($data->memo);
		$thiscreditcard=strip_tags($data->creditcard);
		$thisexpire=strip_tags($data->expire);
		$thiscvv=strip_tags($data->cvv);
		$thissent=strip_tags($data->sent);
		$thislreg=strip_tags($data->lreg);
		$thislstore=strip_tags($data->lstore);
		// $thisisdel=strip_tags($data->isdel);
		// $thiststamp=strip_tags($data->tstamp);


		$stmt->bindParam(':order', $thisorder);
		$stmt->bindParam(':store', $thisstore);
		$stmt->bindParam(':customer', $thiscustomer);
		$stmt->bindParam(':shipto', $thisshipto);
		$stmt->bindParam(':contact', $thiscontact);
		$stmt->bindParam(':phone', $thisphone);
		$stmt->bindParam(':status', $thisstatus);
		$stmt->bindParam(':orddate', $thisorddate);
		$stmt->bindParam(':promdate', $thispromdate);
		$stmt->bindParam(':shipdate', $thisshipdate);
		$stmt->bindParam(':invdate', $thisinvdate);
		$stmt->bindParam(':agedate', $thisagedate);
		$stmt->bindParam(':whosold', $thiswhosold);
		$stmt->bindParam(':whoorder', $thiswhoorder);
		$stmt->bindParam(':whoship', $thiswhoship);
		$stmt->bindParam(':whoinvoice', $thiswhoinvoice);
		$stmt->bindParam(':terms', $thisterms);
		$stmt->bindParam(':shipvia', $thisshipvia);
		$stmt->bindParam(':taxcode', $thistaxcode);
		$stmt->bindParam(':total', $thistotal);
		$stmt->bindParam(':transact', $thistransact);
		$stmt->bindParam(':printmemo', $thisprintmemo);
		$stmt->bindParam(':who', $thiswho);
		$stmt->bindParam(':shipmemo', $thisshipmemo);
		$stmt->bindParam(':memo', $thismemo);
		$stmt->bindParam(':creditcard', $thiscreditcard);
		$stmt->bindParam(':expire', $thisexpire);
		$stmt->bindParam(':cvv', $thiscvv);
		$stmt->bindParam(':sent', $thissent);
		$stmt->bindParam(':lreg', $thislreg);
		$stmt->bindParam(':lstore', $thislstore);
		// $stmt->bindParam(':isdel', $thisisdel);
		// $stmt->bindParam(':tstamp', $thiststamp);

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
