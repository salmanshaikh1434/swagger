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
		$query = "INSERT INTO fshst (`date`,`storeno`,`saleno`,`custid`,`dcredits`,`who`,`timestamp`,`credorpts`,`sent`,`type`,`olddcredit`,`newdcredit`,`tstamp`,`isdel`,`lreg`,`lstore`)
			VALUES 
		(:date,:storeno,:saleno,:custid,:dcredits,:who,:timestamp,:credorpts,:sent,:type,:olddcredit,:newdcredit,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`date` = :date,
		`storeno` = :storeno,
		`saleno` = :saleno,
		`custid` = :custid,
		`dcredits` = :dcredits,
		`who` = :who,
		`timestamp` = :timestamp,
		`credorpts` = :credorpts,
		`sent` = :sent,
		`type` = :type,
		`olddcredit` = :olddcredit,
		`newdcredit` = :newdcredit,
		`tstamp` = NOW(),
		`lstore` = :lstore,
		`lreg` = :lreg";
		// `isdel` = :isdel";

		$stmt = $db->prepare($query);
		$thisdate=strip_tags($data->date);
		$thisstoreno=strip_tags($data->storeno);
		$thissaleno=strip_tags($data->saleno);
		$thiscustid=strip_tags($data->custid);
		$thisdcredits=strip_tags($data->dcredits);
		$thiswho=strip_tags($data->who);
		$thistimestamp=strip_tags($data->timestamp);
		$thiscredorpts=strip_tags($data->credorpts);
		$thissent=strip_tags($data->sent);
		$thistype=strip_tags($data->type);
		$thisolddcredit=strip_tags($data->olddcredit);
		$thisnewdcredit=strip_tags($data->newdcredit);
		$thislreg=strip_tags($data->lreg);
		$thislstore=strip_tags($data->lstore);
		// $thisisdel=strip_tags($data->isdel);
		// $thiststamp=strip_tags($data->tstamp);


		$stmt->bindParam(':date', $thisdate);
		$stmt->bindParam(':storeno', $thisstoreno);
		$stmt->bindParam(':saleno', $thissaleno);
		$stmt->bindParam(':custid', $thiscustid);
		$stmt->bindParam(':dcredits', $thisdcredits);
		$stmt->bindParam(':who', $thiswho);
		$stmt->bindParam(':timestamp', $thistimestamp);
		$stmt->bindParam(':credorpts', $thiscredorpts);
		$stmt->bindParam(':sent', $thissent);
		$stmt->bindParam(':type', $thistype);
		$stmt->bindParam(':olddcredit', $thisolddcredit);
		$stmt->bindParam(':newdcredit', $thisnewdcredit);
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
