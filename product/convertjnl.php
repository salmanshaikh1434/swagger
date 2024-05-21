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
		$query = "INSERT INTO jnl (`store`,`sale`,`line`,`qty`,`pack`,`sku`,`descript`,`price`,`cost`,`discount`,`dclass`,`promo`,`cat`,`location`,`rflag`,`upc`,`boss`,`memo`,`date`,`prclevel`,`fspoints`,`rtnqty`,`tstamp`,`isdel`,`lreg`,`lstore`)
			VALUES 
		(:store,:sale,:line,:qty,:pack,:sku,:descript,:price,:cost,:discount,:dclass,:promo,:cat,:location,:rflag,:upc,:boss,:memo,:date,:prclevel,:fspoints,:rtnqty,:tstamp,0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`qty` = :qty,
		`pack` = :pack,
		`sku` = :sku,
		`descript` = :descript,
		`price` = :price,
		`cost` = :cost,
		`discount` = :discount,
		`dclass` = :dclass,
		`promo` = :promo,
		`cat` = :cat,
		`location` = :location,
		`rflag` = :rflag,
		`upc` = :upc,
		`boss` = :boss,
		`memo` = :memo,
		`date` = :date,
		`prclevel` = :prclevel,
		`fspoints` = :fspoints,
		`rtnqty` = :rtnqty,
		`tstamp` = :tstamp,
		`lstore` = :lstore,
		`lreg` = :lreg";
		// `isdel` = :isdel";

		$stmt = $db->prepare($query);
		$thisstore=strip_tags($data->store);
		$thissale=strip_tags($data->sale);
		$thisline=strip_tags($data->line);
		$thisqty=strip_tags($data->qty);
		$thispack=strip_tags($data->pack);
		$thissku=strip_tags($data->sku);
		$thisdescript=strip_tags($data->descript);
		$thisprice=strip_tags($data->price);
		$thiscost=strip_tags($data->cost);
		$thisdiscount=strip_tags($data->discount);
		$thisdclass=strip_tags($data->dclass);
		$thispromo=strip_tags($data->promo);
		$thiscat=strip_tags($data->cat);
		$thislocation=strip_tags($data->location);
		$thisrflag=strip_tags($data->rflag);
		$thisupc=strip_tags($data->upc);
		$thisboss=strip_tags($data->boss);
		$thismemo=strip_tags($data->memo);
		$thisdate=strip_tags($data->date);
		$thisprclevel=strip_tags($data->prclevel);
		$thisfspoints=strip_tags($data->fspoints);
		$thisrtnqty=strip_tags($data->rtnqty);
		$thislreg=strip_tags($data->lreg);
		$thislstore=strip_tags($data->lstore);
		// $thisisdel=strip_tags($data->isdel);
		$thiststamp=strip_tags($data->tstamp);


		$stmt->bindParam(':store', $thisstore);
		$stmt->bindParam(':sale', $thissale);
		$stmt->bindParam(':line', $thisline);
		$stmt->bindParam(':qty', $thisqty);
		$stmt->bindParam(':pack', $thispack);
		$stmt->bindParam(':sku', $thissku);
		$stmt->bindParam(':descript', $thisdescript);
		$stmt->bindParam(':price', $thisprice);
		$stmt->bindParam(':cost', $thiscost);
		$stmt->bindParam(':discount', $thisdiscount);
		$stmt->bindParam(':dclass', $thisdclass);
		$stmt->bindParam(':promo', $thispromo);
		$stmt->bindParam(':cat', $thiscat);
		$stmt->bindParam(':location', $thislocation);
		$stmt->bindParam(':rflag', $thisrflag);
		$stmt->bindParam(':upc', $thisupc);
		$stmt->bindParam(':boss', $thisboss);
		$stmt->bindParam(':memo', $thismemo);
		$stmt->bindParam(':date', $thisdate);
		$stmt->bindParam(':prclevel', $thisprclevel);
		$stmt->bindParam(':fspoints', $thisfspoints);
		$stmt->bindParam(':rtnqty', $thisrtnqty);
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