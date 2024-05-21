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
		$query = "INSERT INTO ripmfgd (`bdnumber`,`ponumber`,`store`,`line`,`sku`,`vid`,`name`,`sname`,`pack`,`oqty`,`coqty`,`amount`,`orddate`,`recdate`,`rec`,`bdorrips`,`tstamp`,`isdel`,`lreg`,`lstore`)
			VALUES 
		(:bdnumber,:ponumber,:store,:line,:sku,:vid,:name,:sname,:pack,:oqty,:coqty,:amount,:orddate,:recdate,:rec,:bdorrips,:tstamp,0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`bdnumber` = :bdnumber,
		`ponumber` = :ponumber,
		`store` = :store,
		`line` = :line,
		`sku` = :sku,
		`vid` = :vid,
		`name` = :name,
		`sname` = :sname,
		`pack` = :pack,
		`oqty` = :oqty,
		`coqty` = :coqty,
		`amount` = :amount,
		`orddate` = :orddate,
		`recdate` = :recdate,
		`rec` = :rec,
		`bdorrips` = :bdorrips,
		`tstamp` = :tstamp,
		`lstore` = :lstore,
		`lreg` = :lreg,
		`isdel` = :isdel";

		$stmt = $db->prepare($query);
		$thisbdnumber=strip_tags($data->bdnumber);
		$thisponumber=strip_tags($data->ponumber);
		$thisstore=strip_tags($data->store);
		$thisline=strip_tags($data->line);
		$thissku=strip_tags($data->sku);
		$thisvid=strip_tags($data->vid);
		$thisname=strip_tags($data->name);
		$thissname=strip_tags($data->sname);
		$thispack=strip_tags($data->pack);
		$thisoqty=strip_tags($data->oqty);
		$thiscoqty=strip_tags($data->coqty);
		$thisamount=strip_tags($data->amount);
		$thisorddate=strip_tags($data->orddate);
		$thisrecdate=strip_tags($data->recdate);
		$thisrec=strip_tags($data->rec);
		$thisbdorrips=strip_tags($data->bdorrips);
		$thislreg=strip_tags($data->lreg);
		$thislstore=strip_tags($data->lstore);
		$thisisdel=strip_tags($data->isdel);
		if(empty($data->tstamp)){
			$data->tstamp = date('Y-m-d H:i:s');
		}
		$thiststamp=strip_tags($data->tstamp);


		$stmt->bindParam(':bdnumber', $thisbdnumber);
		$stmt->bindParam(':ponumber', $thisponumber);
		$stmt->bindParam(':store', $thisstore);
		$stmt->bindParam(':line', $thisline);
		$stmt->bindParam(':sku', $thissku);
		$stmt->bindParam(':vid', $thisvid);
		$stmt->bindParam(':name', $thisname);
		$stmt->bindParam(':sname', $thissname);
		$stmt->bindParam(':pack', $thispack);
		$stmt->bindParam(':oqty', $thisoqty);
		$stmt->bindParam(':coqty', $thiscoqty);
		$stmt->bindParam(':amount', $thisamount);
		$stmt->bindParam(':orddate', $thisorddate);
		$stmt->bindParam(':recdate', $thisrecdate);
		$stmt->bindParam(':rec', $thisrec);
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