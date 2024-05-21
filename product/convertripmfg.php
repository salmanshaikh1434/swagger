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
		$query = "INSERT INTO ripmfg (`bdnumber`,`store`,`ponumber`,`invoice`,`vcode`,`amount`,`orddate`,`recdate`,`received`,`bdorrips`,`tstamp`,`isdel`,`lreg`,`lstore`)
			VALUES 
		(:bdnumber,:store,:ponumber,:invoice,:vcode,:amount,:orddate,:recdate,:received,:bdorrips,:tstamp,0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`bdnumber` = :bdnumber,
		`store` = :store,
		`ponumber` = :ponumber,
		`invoice` = :invoice,
		`vcode` = :vcode,
		`amount` = :amount,
		`orddate` = :orddate,
		`recdate` = :recdate,
		`received` = :received,
		`bdorrips` = :bdorrips,
		`tstamp` = :tstamp,
		`lstore` = :lstore,
		`lreg` = :lreg,
		`isdel` = :isdel";

		$stmt = $db->prepare($query);
		$thisbdnumber=strip_tags($data->bdnumber);
		$thisstore=strip_tags($data->store);
		$thisponumber=strip_tags($data->ponumber);
		$thisinvoice=strip_tags($data->invoice);
		$thisvcode=strip_tags($data->vcode);
		$thisamount=strip_tags($data->amount);
		$thisorddate=strip_tags($data->orddate);
		$thisrecdate=strip_tags($data->recdate);
		$thisreceived=strip_tags($data->received);
		$thisbdorrips=strip_tags($data->bdorrips);
		$thislreg=strip_tags($data->lreg);
		$thislstore=strip_tags($data->lstore);
		$thisisdel=strip_tags($data->isdel);
		if(empty($data->tstamp)){
			$data->tstamp = date('Y-m-d H:i:s');
		}
		$thiststamp=strip_tags($data->tstamp);


		$stmt->bindParam(':bdnumber', $thisbdnumber);
		$stmt->bindParam(':store', $thisstore);
		$stmt->bindParam(':ponumber', $thisponumber);
		$stmt->bindParam(':invoice', $thisinvoice);
		$stmt->bindParam(':vcode', $thisvcode);
		$stmt->bindParam(':amount', $thisamount);
		$stmt->bindParam(':orddate', $thisorddate);
		$stmt->bindParam(':recdate', $thisrecdate);
		$stmt->bindParam(':received', $thisreceived);
		$stmt->bindParam(':bdorrips', $thisbdorrips);
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