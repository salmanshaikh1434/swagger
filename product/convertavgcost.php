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
		$query = "INSERT INTO avgcost (`sku`,`store`,`oldcost`,`newcost`,`who`,`type`,`number`,`costype`,`posted`,`sent`,`tstamp`,`isdel`,`lreg`,`lstore`)
			VALUES 
		(:sku,:store,:oldcost,:newcost,:who,:type,:number,:costype,:posted,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`sku` = :sku,
		`store` = :store,
		`oldcost` = :oldcost,
		`newcost` = :newcost,
		`who` = :who,
		`type` = :type,
		`number` = :number,
		`costype` = :costype,
		`posted` = :posted,
		`sent` = :sent,
		`tstamp` = NOW(),
		`lstore` = :lstore,
		`lreg` = :lreg";
		// `isdel` = :isdel";

		$stmt = $db->prepare($query);
		$thissku=strip_tags($data->sku);
		$thisstore=strip_tags($data->store);
		$thisoldcost=strip_tags($data->oldcost);
		$thisnewcost=strip_tags($data->newcost);
		$thiswho=strip_tags($data->who);
		$thistype=strip_tags($data->type);
		$thisnumber=strip_tags($data->number);
		$thiscostype=strip_tags($data->costype);
		$thisposted=strip_tags($data->posted);
		$thissent=strip_tags($data->sent);
		$thislreg=strip_tags($data->lreg);
		$thislstore=strip_tags($data->lstore);
		// $thisisdel=strip_tags($data->isdel);
		// $thiststamp=strip_tags($data->tstamp);


		$stmt->bindParam(':sku', $thissku);
		$stmt->bindParam(':store', $thisstore);
		$stmt->bindParam(':oldcost', $thisoldcost);
		$stmt->bindParam(':newcost', $thisnewcost);
		$stmt->bindParam(':who', $thiswho);
		$stmt->bindParam(':type', $thistype);
		$stmt->bindParam(':number', $thisnumber);
		$stmt->bindParam(':costype', $thiscostype);
		$stmt->bindParam(':posted', $thisposted);
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
