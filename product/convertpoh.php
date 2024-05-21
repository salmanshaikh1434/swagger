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
		$query = "INSERT INTO poh (`order`,`store`,`vendor`,`vcode`,`pay_vendor`,`contact`,`phone`,`status`,`orddate`,`promdate`,`rcvdate`,`agedate`,`whoreq`,`whoord`,`whorcv`,`terms`,`shipvia`,`customer`,`taxcode`,`total`,`lastline`,`transact`,`who`,`memo`,`discounts`,`tax`,`newdeposit`,`rtndeposit`,`freight`,`salesman`,`transfer`,`includedep`,`invoicenbr`,`repost`,`postcost`,`bdrips`,`sent`,`applytax`,`applycred`,`applyship`,`applybdrip`,`approved`,`cstore`,`tstamp`,`isdel`,`lreg`,`lstore`)
			VALUES 
		(:order,:store,:vendor,:vcode,:pay_vendor,:contact,:phone,:status,:orddate,:promdate,:rcvdate,:agedate,:whoreq,:whoord,:whorcv,:terms,:shipvia,:customer,:taxcode,:total,:lastline,:transact,:who,:memo,:discounts,:tax,:newdeposit,:rtndeposit,:freight,:salesman,:transfer,:includedep,:invoicenbr,:repost,:postcost,:bdrips,:sent,:applytax,:applycred,:applyship,:applybdrip,:approved,:cstore,:tstamp,0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`order` = :order,
		`store` = :store,
		`vendor` = :vendor,
		`vcode` = :vcode,
		`pay_vendor` = :pay_vendor,
		`contact` = :contact,
		`phone` = :phone,
		`status` = :status,
		`orddate` = :orddate,
		`promdate` = :promdate,
		`rcvdate` = :rcvdate,
		`agedate` = :agedate,
		`whoreq` = :whoreq,
		`whoord` = :whoord,
		`whorcv` = :whorcv,
		`terms` = :terms,
		`shipvia` = :shipvia,
		`customer` = :customer,
		`taxcode` = :taxcode,
		`total` = :total,
		`lastline` = :lastline,
		`transact` = :transact,
		`who` = :who,
		`memo` = :memo,
		`discounts` = :discounts,
		`tax` = :tax,
		`newdeposit` = :newdeposit,
		`rtndeposit` = :rtndeposit,
		`freight` = :freight,
		`salesman` = :salesman,
		`transfer` = :transfer,
		`includedep` = :includedep,
		`invoicenbr` = :invoicenbr,
		`repost` = :repost,
		`postcost` = :postcost,
		`bdrips` = :bdrips,
		`sent` = :sent,
		`applytax` = :applytax,
		`applycred` = :applycred,
		`applyship` = :applyship,
		`applybdrip` = :applybdrip,
		`approved` = :approved,
		`cstore` = :cstore,
		`tstamp` = :tstamp,
		`lstore` = :lstore,
		`lreg` = :lreg";
	    // `isdel` = :isdel";

		$stmt = $db->prepare($query);
		$thisorder=strip_tags($data->order);
		$thisstore=strip_tags($data->store);
		$thisvendor=strip_tags($data->vendor);
		$thisvcode=strip_tags($data->vcode);
		$thispay_vendor=strip_tags($data->pay_vendor);
		$thiscontact=strip_tags($data->contact);
		$thisphone=strip_tags($data->phone);
		$thisstatus=strip_tags($data->status);
		$thisorddate=strip_tags($data->orddate);
		$thispromdate=strip_tags($data->promdate);
		$thisrcvdate=strip_tags($data->rcvdate);
		$thisagedate=strip_tags($data->agedate);
		$thiswhoreq=strip_tags($data->whoreq);
		$thiswhoord=strip_tags($data->whoord);
		$thiswhorcv=strip_tags($data->whorcv);
		$thisterms=strip_tags($data->terms);
		$thisshipvia=strip_tags($data->shipvia);
		$thiscustomer=strip_tags($data->customer);
		$thistaxcode=strip_tags($data->taxcode);
		$thistotal=strip_tags($data->total);
		$thislastline=strip_tags($data->lastline);
		$thistransact=strip_tags($data->transact);
		$thiswho=strip_tags($data->who);
		$thismemo=strip_tags($data->memo);
		$thisdiscounts=strip_tags($data->discounts);
		$thistax=strip_tags($data->tax);
		$thisnewdeposit=strip_tags($data->newdeposit);
		$thisrtndeposit=strip_tags($data->rtndeposit);
		$thisfreight=strip_tags($data->freight);
		$thissalesman=strip_tags($data->salesman);
		$thistransfer=strip_tags($data->transfer);
		$thisincludedep=strip_tags($data->includedep);
		$thisinvoicenbr=strip_tags($data->invoicenbr);
		$thisrepost=strip_tags($data->repost);
		$thispostcost=strip_tags($data->postcost);
		$thisbdrips=strip_tags($data->bdrips);
		$thissent=strip_tags($data->sent);
		$thisapplytax=strip_tags($data->applytax);
		$thisapplycred=strip_tags($data->applycred);
		$thisapplyship=strip_tags($data->applyship);
		$thisapplybdrip=strip_tags($data->applybdrip);
		$thisapproved=strip_tags($data->approved);
		$thiscstore=strip_tags($data->cstore);
		$thislreg=strip_tags($data->lreg);
		$thislstore=strip_tags($data->lstore);
		// $thisisdel=strip_tags($data->isdel);
		$thiststamp=strip_tags($data->tstamp);


		$stmt->bindParam(':order', $thisorder);
		$stmt->bindParam(':store', $thisstore);
		$stmt->bindParam(':vendor', $thisvendor);
		$stmt->bindParam(':vcode', $thisvcode);
		$stmt->bindParam(':pay_vendor', $thispay_vendor);
		$stmt->bindParam(':contact', $thiscontact);
		$stmt->bindParam(':phone', $thisphone);
		$stmt->bindParam(':status', $thisstatus);
		$stmt->bindParam(':orddate', $thisorddate);
		$stmt->bindParam(':promdate', $thispromdate);
		$stmt->bindParam(':rcvdate', $thisrcvdate);
		$stmt->bindParam(':agedate', $thisagedate);
		$stmt->bindParam(':whoreq', $thiswhoreq);
		$stmt->bindParam(':whoord', $thiswhoord);
		$stmt->bindParam(':whorcv', $thiswhorcv);
		$stmt->bindParam(':terms', $thisterms);
		$stmt->bindParam(':shipvia', $thisshipvia);
		$stmt->bindParam(':customer', $thiscustomer);
		$stmt->bindParam(':taxcode', $thistaxcode);
		$stmt->bindParam(':total', $thistotal);
		$stmt->bindParam(':lastline', $thislastline);
		$stmt->bindParam(':transact', $thistransact);
		$stmt->bindParam(':who', $thiswho);
		$stmt->bindParam(':memo', $thismemo);
		$stmt->bindParam(':discounts', $thisdiscounts);
		$stmt->bindParam(':tax', $thistax);
		$stmt->bindParam(':newdeposit', $thisnewdeposit);
		$stmt->bindParam(':rtndeposit', $thisrtndeposit);
		$stmt->bindParam(':freight', $thisfreight);
		$stmt->bindParam(':salesman', $thissalesman);
		$stmt->bindParam(':transfer', $thistransfer);
		$stmt->bindParam(':includedep', $thisincludedep);
		$stmt->bindParam(':invoicenbr', $thisinvoicenbr);
		$stmt->bindParam(':repost', $thisrepost);
		$stmt->bindParam(':postcost', $thispostcost);
		$stmt->bindParam(':bdrips', $thisbdrips);
		$stmt->bindParam(':sent', $thissent);
		$stmt->bindParam(':applytax', $thisapplytax);
		$stmt->bindParam(':applycred', $thisapplycred);
		$stmt->bindParam(':applyship', $thisapplyship);
		$stmt->bindParam(':applybdrip', $thisapplybdrip);
		$stmt->bindParam(':approved', $thisapproved);
		$stmt->bindParam(':cstore', $thiscstore);
		$stmt->bindParam(':lreg', $thislreg);
		$stmt->bindParam(':lstore', $thislstore);
		// $stmt->bindParam(':isdel', $thisisdel);
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