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
		$query = "INSERT INTO pod (`order`,`store`,`line`,`sku`,`name`,`sname`,`ml`,`status`,`vendor`,`vcode`,`vid`,`orddate`,`rcvdate`,`oqty`,`coqty`,`bqty`,`cbqty`,`fifo`,`cost`,`unitcost`,`pack`,`glaccount`,`deal`,`salesman`,`transfer`,`sord`,`creditstat`,`crdpaydate`,`who`,`memo`,`creditdue`,`creditpaid`,`crdpaynbr`,`deposits`,`invoice`,`invoicenbr`,`upstk`,`bdrips`,`adjcost`,`reccoqty`,`recoqty`,`rips`,`freight`,`tax`,`discounts`,`wareoqty`,`warecoqty`,`tstamp`,`isdel`,`lreg`,`lstore`)
			VALUES 
		(:order,:store,:line,:sku,:name,:sname,:ml,:status,:vendor,:vcode,:vid,:orddate,:rcvdate,:oqty,:coqty,:bqty,:cbqty,:fifo,:cost,:unitcost,:pack,:glaccount,:deal,:salesman,:transfer,:sord,:creditstat,:crdpaydate,:who,:memo,:creditdue,:creditpaid,:crdpaynbr,:deposits,:invoice,:invoicenbr,:upstk,:bdrips,:adjcost,:reccoqty,:recoqty,:rips,:freight,:tax,:discounts,:wareoqty,:warecoqty,:tstamp,0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`order` = :order,
		`store` = :store,
		`line` = :line,
		`sku` = :sku,
		`name` = :name,
		`sname` = :sname,
		`ml` = :ml,
		`status` = :status,
		`vendor` = :vendor,
		`vcode` = :vcode,
		`vid` = :vid,
		`orddate` = :orddate,
		`rcvdate` = :rcvdate,
		`oqty` = :oqty,
		`coqty` = :coqty,
		`bqty` = :bqty,
		`cbqty` = :cbqty,
		`fifo` = :fifo,
		`cost` = :cost,
		`unitcost` = :unitcost,
		`pack` = :pack,
		`glaccount` = :glaccount,
		`deal` = :deal,
		`salesman` = :salesman,
		`transfer` = :transfer,
		`sord` = :sord,
		`creditstat` = :creditstat,
		`crdpaydate` = :crdpaydate,
		`who` = :who,
		`memo` = :memo,
		`creditdue` = :creditdue,
		`creditpaid` = :creditpaid,
		`crdpaynbr` = :crdpaynbr,
		`deposits` = :deposits,
		`invoice` = :invoice,
		`invoicenbr` = :invoicenbr,
		`upstk` = :upstk,
		`bdrips` = :bdrips,
		`adjcost` = :adjcost,
		`reccoqty` = :reccoqty,
		`recoqty` = :recoqty,
		`rips` = :rips,
		`freight` = :freight,
		`tax` = :tax,
		`discounts` = :discounts,
		`wareoqty` = :wareoqty,
		`warecoqty` = :warecoqty,
		`tstamp` = :tstamp,
		`lstore` = :lstore,
		`lreg` = :lreg";
		// `isdel` = :isdel";

		$stmt = $db->prepare($query);
		$thisorder=strip_tags($data->order);
		$thisstore=strip_tags($data->store);
		$thisline=strip_tags($data->line);
		$thissku=strip_tags($data->sku);
		$thisname=strip_tags($data->name);
		$thissname=strip_tags($data->sname);
		$thisml=strip_tags($data->ml);
		$thisstatus=strip_tags($data->status);
		$thisvendor=strip_tags($data->vendor);
		$thisvcode=strip_tags($data->vcode);
		$thisvid=strip_tags($data->vid);
		$thisorddate=strip_tags($data->orddate);
		$thisrcvdate=strip_tags($data->rcvdate);
		$thisoqty=strip_tags($data->oqty);
		$thiscoqty=strip_tags($data->coqty);
		$thisbqty=strip_tags($data->bqty);
		$thiscbqty=strip_tags($data->cbqty);
		$thisfifo=strip_tags($data->fifo);
		$thiscost=strip_tags($data->cost);
		$thisunitcost=strip_tags($data->unitcost);
		$thispack=strip_tags($data->pack);
		$thisglaccount=strip_tags($data->glaccount);
		$thisdeal=strip_tags($data->deal);
		$thissalesman=strip_tags($data->salesman);
		$thistransfer=strip_tags($data->transfer);
		$thissord=strip_tags($data->sord);
		$thiscreditstat=strip_tags($data->creditstat);
		$thiscrdpaydate=strip_tags($data->crdpaydate);
		$thiswho=strip_tags($data->who);
		$thismemo=strip_tags($data->memo);
		$thiscreditdue=strip_tags($data->creditdue);
		$thiscreditpaid=strip_tags($data->creditpaid);
		$thiscrdpaynbr=strip_tags($data->crdpaynbr);
		$thisdeposits=strip_tags($data->deposits);
		$thisinvoice=strip_tags($data->invoice);
		$thisinvoicenbr=strip_tags($data->invoicenbr);
		$thisupstk=strip_tags($data->upstk);
		$thisbdrips=strip_tags($data->bdrips);
		$thisadjcost=strip_tags($data->adjcost);
		$thisreccoqty=strip_tags($data->reccoqty);
		$thisrecoqty=strip_tags($data->recoqty);
		$thisrips=strip_tags($data->rips);
		$thisfreight=strip_tags($data->freight);
		$thistax=strip_tags($data->tax);
		$thisdiscounts=strip_tags($data->discounts);
		$thiswareoqty=strip_tags($data->wareoqty);
		$thiswarecoqty=strip_tags($data->warecoqty);
		$thislreg=strip_tags($data->lreg);
		$thislstore=strip_tags($data->lstore);
		// $thisisdel=strip_tags($data->isdel);
		$thiststamp=strip_tags($data->tstamp);


		$stmt->bindParam(':order', $thisorder);
		$stmt->bindParam(':store', $thisstore);
		$stmt->bindParam(':line', $thisline);
		$stmt->bindParam(':sku', $thissku);
		$stmt->bindParam(':name', $thisname);
		$stmt->bindParam(':sname', $thissname);
		$stmt->bindParam(':ml', $thisml);
		$stmt->bindParam(':status', $thisstatus);
		$stmt->bindParam(':vendor', $thisvendor);
		$stmt->bindParam(':vcode', $thisvcode);
		$stmt->bindParam(':vid', $thisvid);
		$stmt->bindParam(':orddate', $thisorddate);
		$stmt->bindParam(':rcvdate', $thisrcvdate);
		$stmt->bindParam(':oqty', $thisoqty);
		$stmt->bindParam(':coqty', $thiscoqty);
		$stmt->bindParam(':bqty', $thisbqty);
		$stmt->bindParam(':cbqty', $thiscbqty);
		$stmt->bindParam(':fifo', $thisfifo);
		$stmt->bindParam(':cost', $thiscost);
		$stmt->bindParam(':unitcost', $thisunitcost);
		$stmt->bindParam(':pack', $thispack);
		$stmt->bindParam(':glaccount', $thisglaccount);
		$stmt->bindParam(':deal', $thisdeal);
		$stmt->bindParam(':salesman', $thissalesman);
		$stmt->bindParam(':transfer', $thistransfer);
		$stmt->bindParam(':sord', $thissord);
		$stmt->bindParam(':creditstat', $thiscreditstat);
		$stmt->bindParam(':crdpaydate', $thiscrdpaydate);
		$stmt->bindParam(':who', $thiswho);
		$stmt->bindParam(':memo', $thismemo);
		$stmt->bindParam(':creditdue', $thiscreditdue);
		$stmt->bindParam(':creditpaid', $thiscreditpaid);
		$stmt->bindParam(':crdpaynbr', $thiscrdpaynbr);
		$stmt->bindParam(':deposits', $thisdeposits);
		$stmt->bindParam(':invoice', $thisinvoice);
		$stmt->bindParam(':invoicenbr', $thisinvoicenbr);
		$stmt->bindParam(':upstk', $thisupstk);
		$stmt->bindParam(':bdrips', $thisbdrips);
		$stmt->bindParam(':adjcost', $thisadjcost);
		$stmt->bindParam(':reccoqty', $thisreccoqty);
		$stmt->bindParam(':recoqty', $thisrecoqty);
		$stmt->bindParam(':rips', $thisrips);
		$stmt->bindParam(':freight', $thisfreight);
		$stmt->bindParam(':tax', $thistax);
		$stmt->bindParam(':discounts', $thisdiscounts);
		$stmt->bindParam(':wareoqty', $thiswareoqty);
		$stmt->bindParam(':warecoqty', $thiswarecoqty);
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