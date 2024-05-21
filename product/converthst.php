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
		$query = "INSERT INTO hst (`sku`,`date`,`edate`,`qty`,`price`,`cost`,`promo`,`store`,`pack`,`who`,`lvl1qty`,`lvl1price`,`lvl1cost`,`lvl2qty`,`lvl2price`,`lvl2cost`,`lvl3qty`,`lvl3price`,`lvl3cost`,`lvl4qty`,`lvl4price`,`lvl4cost`,`sent`,`tstamp`,`isdel`,`lreg`,`lstore`)
			VALUES 
		(:sku,:date,:edate,:qty,:price,:cost,:promo,:store,:pack,:who,:lvl1qty,:lvl1price,:lvl1cost,:lvl2qty,:lvl2price,:lvl2cost,:lvl3qty,:lvl3price,:lvl3cost,:lvl4qty,:lvl4price,:lvl4cost,:sent,:tstamp,0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`sku` = :sku,
		`date` = :date,
		`edate` = :edate,
		`qty` = :qty,
		`price` = :price,
		`cost` = :cost,
		`promo` = :promo,
		`store` = :store,
		`pack` = :pack,
		`who` = :who,
		`lvl1qty` = :lvl1qty,
		`lvl1price` = :lvl1price,
		`lvl1cost` = :lvl1cost,
		`lvl2qty` = :lvl2qty,
		`lvl2price` = :lvl2price,
		`lvl2cost` = :lvl2cost,
		`lvl3qty` = :lvl3qty,
		`lvl3price` = :lvl3price,
		`lvl3cost` = :lvl3cost,
		`lvl4qty` = :lvl4qty,
		`lvl4price` = :lvl4price,
		`lvl4cost` = :lvl4cost,
		`sent` = :sent,
		`tstamp` = :tstamp,
		`lstore` = :lstore,
		`lreg` = :lreg";
		//  `isdel` = :isdel";

		$stmt = $db->prepare($query);
		$thissku=strip_tags($data->sku);
		$thisdate=strip_tags($data->date);
		$thisedate=strip_tags($data->edate);
		$thisqty=strip_tags($data->qty);
		$thisprice=strip_tags($data->price);
		$thiscost=strip_tags($data->cost);
		$thispromo=strip_tags($data->promo);
		$thisstore=strip_tags($data->store);
		$thispack=strip_tags($data->pack);
		$thiswho=strip_tags($data->who);
		$thislvl1qty=strip_tags($data->lvl1qty);
		$thislvl1price=strip_tags($data->lvl1price);
		$thislvl1cost=strip_tags($data->lvl1cost);
		$thislvl2qty=strip_tags($data->lvl2qty);
		$thislvl2price=strip_tags($data->lvl2price);
		$thislvl2cost=strip_tags($data->lvl2cost);
		$thislvl3qty=strip_tags($data->lvl3qty);
		$thislvl3price=strip_tags($data->lvl3price);
		$thislvl3cost=strip_tags($data->lvl3cost);
		$thislvl4qty=strip_tags($data->lvl4qty);
		$thislvl4price=strip_tags($data->lvl4price);
		$thislvl4cost=strip_tags($data->lvl4cost);
		$thissent=strip_tags($data->sent);
		$thislreg=strip_tags($data->lreg);
		$thislstore=strip_tags($data->lstore);
		// $thisisdel=strip_tags($data->isdel);
		$thiststamp=strip_tags($data->tstamp);


		$stmt->bindParam(':sku', $thissku);
		$stmt->bindParam(':date', $thisdate);
		$stmt->bindParam(':edate', $thisedate);
		$stmt->bindParam(':qty', $thisqty);
		$stmt->bindParam(':price', $thisprice);
		$stmt->bindParam(':cost', $thiscost);
		$stmt->bindParam(':promo', $thispromo);
		$stmt->bindParam(':store', $thisstore);
		$stmt->bindParam(':pack', $thispack);
		$stmt->bindParam(':who', $thiswho);
		$stmt->bindParam(':lvl1qty', $thislvl1qty);
		$stmt->bindParam(':lvl1price', $thislvl1price);
		$stmt->bindParam(':lvl1cost', $thislvl1cost);
		$stmt->bindParam(':lvl2qty', $thislvl2qty);
		$stmt->bindParam(':lvl2price', $thislvl2price);
		$stmt->bindParam(':lvl2cost', $thislvl2cost);
		$stmt->bindParam(':lvl3qty', $thislvl3qty);
		$stmt->bindParam(':lvl3price', $thislvl3price);
		$stmt->bindParam(':lvl3cost', $thislvl3cost);
		$stmt->bindParam(':lvl4qty', $thislvl4qty);
		$stmt->bindParam(':lvl4price', $thislvl4price);
		$stmt->bindParam(':lvl4cost', $thislvl4cost);
		$stmt->bindParam(':sent', $thissent);
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