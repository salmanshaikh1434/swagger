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
		$query = "INSERT INTO odd (`order`,`store`,`line`,`sku`,`status`,`customer`,`orddate`,`agedate`,`qty`,`pack`,`descript`,`price`,`cost`,`discount`,`promo`,`dflag`,`dclass`,`damount`,`taxlevel`,`surcharge`,`cat`,`location`,`dml`,`cpack`,`onsale`,`freeze`,`memo`,`bqty`,`extax`,`tstamp`,`isdel`,`lreg`,`lstore`)
			VALUES 
		(:order,:store,:line,:sku,:status,:customer,:orddate,:agedate,:qty,:pack,:descript,:price,:cost,:discount,:promo,:dflag,:dclass,:damount,:taxlevel,:surcharge,:cat,:location,:dml,:cpack,:onsale,:freeze,:memo,:bqty,:extax,:tstamp,0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`order` = :order,
		`store` = :store,
		`line` = :line,
		`sku` = :sku,
		`status` = :status,
		`customer` = :customer,
		`orddate` = :orddate,
		`agedate` = :agedate,
		`qty` = :qty,
		`pack` = :pack,
		`descript` = :descript,
		`price` = :price,
		`cost` = :cost,
		`discount` = :discount,
		`promo` = :promo,
		`dflag` = :dflag,
		`dclass` = :dclass,
		`damount` = :damount,
		`taxlevel` = :taxlevel,
		`surcharge` = :surcharge,
		`cat` = :cat,
		`location` = :location,
		`dml` = :dml,
		`cpack` = :cpack,
		`onsale` = :onsale,
		`freeze` = :freeze,
		`memo` = :memo,
		`bqty` = :bqty,
		`extax` = :extax,
		`tstamp` = :tstamp,
		`lstore` = :lstore,
		`lreg` = :lreg";
		// `isdel` = :isdel";

		$stmt = $db->prepare($query);
		$thisorder=strip_tags($data->order);
		$thisstore=strip_tags($data->store);
		$thisline=strip_tags($data->line);
		$thissku=strip_tags($data->sku);
		$thisstatus=strip_tags($data->status);
		$thiscustomer=strip_tags($data->customer);
		$thisorddate=strip_tags($data->orddate);
		$thisagedate=strip_tags($data->agedate);
		$thisqty=strip_tags($data->qty);
		$thispack=strip_tags($data->pack);
		$thisdescript=strip_tags($data->descript);
		$thisprice=strip_tags($data->price);
		$thiscost=strip_tags($data->cost);
		$thisdiscount=strip_tags($data->discount);
		$thispromo=strip_tags($data->promo);
		$thisdflag=strip_tags($data->dflag);
		$thisdclass=strip_tags($data->dclass);
		$thisdamount=strip_tags($data->damount);
		$thistaxlevel=strip_tags($data->taxlevel);
		$thissurcharge=strip_tags($data->surcharge);
		$thiscat=strip_tags($data->cat);
		$thislocation=strip_tags($data->location);
		$thisdml=strip_tags($data->dml);
		$thiscpack=strip_tags($data->cpack);
		$thisonsale=strip_tags($data->onsale);
		$thisfreeze=strip_tags($data->freeze);
		$thismemo=strip_tags($data->memo);
		$thisbqty=strip_tags($data->bqty);
		$thisextax=strip_tags($data->extax);
		$thislreg=strip_tags($data->lreg);
		$thislstore=strip_tags($data->lstore);
		$thiststamp=strip_tags($data->tstamp);
		// $thisisdel=strip_tags($data->isdel);


		$stmt->bindParam(':order', $thisorder);
		$stmt->bindParam(':store', $thisstore);
		$stmt->bindParam(':line', $thisline);
		$stmt->bindParam(':sku', $thissku);
		$stmt->bindParam(':status', $thisstatus);
		$stmt->bindParam(':customer', $thiscustomer);
		$stmt->bindParam(':orddate', $thisorddate);
		$stmt->bindParam(':agedate', $thisagedate);
		$stmt->bindParam(':qty', $thisqty);
		$stmt->bindParam(':pack', $thispack);
		$stmt->bindParam(':descript', $thisdescript);
		$stmt->bindParam(':price', $thisprice);
		$stmt->bindParam(':cost', $thiscost);
		$stmt->bindParam(':discount', $thisdiscount);
		$stmt->bindParam(':promo', $thispromo);
		$stmt->bindParam(':dflag', $thisdflag);
		$stmt->bindParam(':dclass', $thisdclass);
		$stmt->bindParam(':damount', $thisdamount);
		$stmt->bindParam(':taxlevel', $thistaxlevel);
		$stmt->bindParam(':surcharge', $thissurcharge);
		$stmt->bindParam(':cat', $thiscat);
		$stmt->bindParam(':location', $thislocation);
		$stmt->bindParam(':dml', $thisdml);
		$stmt->bindParam(':cpack', $thiscpack);
		$stmt->bindParam(':onsale', $thisonsale);
		$stmt->bindParam(':freeze', $thisfreeze);
		$stmt->bindParam(':memo', $thismemo);
		$stmt->bindParam(':bqty', $thisbqty);
		$stmt->bindParam(':extax', $thisextax);
		$stmt->bindParam(':lreg', $thislreg);
		$stmt->bindParam(':lstore', $thislstore);
		$stmt->bindParam(':tstamp', $thiststamp);
		// $stmt->bindParam(':isdel', $thisisdel);

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