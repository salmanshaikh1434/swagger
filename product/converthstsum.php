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
		$query = "INSERT INTO hstsum (`sku`,`store`,`year`,`janqty`,`jancost`,`janprice`,`febqty`,`febcost`,`febprice`,`marqty`,`marcost`,`marprice`,`aprqty`,`aprcost`,`aprprice`,`mayqty`,`maycost`,`mayprice`,`junqty`,`juncost`,`junprice`,`julqty`,`julcost`,`julprice`,`augqty`,`augcost`,`augprice`,`sepqty`,`sepcost`,`sepprice`,`octqty`,`octcost`,`octprice`,`novqty`,`novcost`,`novprice`,`decqty`,`deccost`,`decprice`,`who`,`sent`,`tstamp`,`isdel`,`lreg`,`lstore`)
			VALUES 
		(:sku,:store,:year,:janqty,:jancost,:janprice,:febqty,:febcost,:febprice,:marqty,:marcost,:marprice,:aprqty,:aprcost,:aprprice,:mayqty,:maycost,:mayprice,:junqty,:juncost,:junprice,:julqty,:julcost,:julprice,:augqty,:augcost,:augprice,:sepqty,:sepcost,:sepprice,:octqty,:octcost,:octprice,:novqty,:novcost,:novprice,:decqty,:deccost,:decprice,:who,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`sku` = :sku,
		`store` = :store,
		`year` = :year,
		`janqty` = :janqty,
		`jancost` = :jancost,
		`janprice` = :janprice,
		`febqty` = :febqty,
		`febcost` = :febcost,
		`febprice` = :febprice,
		`marqty` = :marqty,
		`marcost` = :marcost,
		`marprice` = :marprice,
		`aprqty` = :aprqty,
		`aprcost` = :aprcost,
		`aprprice` = :aprprice,
		`mayqty` = :mayqty,
		`maycost` = :maycost,
		`mayprice` = :mayprice,
		`junqty` = :junqty,
		`juncost` = :juncost,
		`junprice` = :junprice,
		`julqty` = :julqty,
		`julcost` = :julcost,
		`julprice` = :julprice,
		`augqty` = :augqty,
		`augcost` = :augcost,
		`augprice` = :augprice,
		`sepqty` = :sepqty,
		`sepcost` = :sepcost,
		`sepprice` = :sepprice,
		`octqty` = :octqty,
		`octcost` = :octcost,
		`octprice` = :octprice,
		`novqty` = :novqty,
		`novcost` = :novcost,
		`novprice` = :novprice,
		`decqty` = :decqty,
		`deccost` = :deccost,
		`decprice` = :decprice,
		`who` = :who,
		`sent` = :sent,
		`tstamp` = NOW(),
		`lstore` = :lstore,
		`lreg` = :lreg";
		// `isdel` = :isdel";

		$stmt = $db->prepare($query);
		$thissku=strip_tags($data->sku);
		$thisstore=strip_tags($data->store);
		$thisyear=strip_tags($data->year);
		$thisjanqty=strip_tags($data->janqty);
		$thisjancost=strip_tags($data->jancost);
		$thisjanprice=strip_tags($data->janprice);
		$thisfebqty=strip_tags($data->febqty);
		$thisfebcost=strip_tags($data->febcost);
		$thisfebprice=strip_tags($data->febprice);
		$thismarqty=strip_tags($data->marqty);
		$thismarcost=strip_tags($data->marcost);
		$thismarprice=strip_tags($data->marprice);
		$thisaprqty=strip_tags($data->aprqty);
		$thisaprcost=strip_tags($data->aprcost);
		$thisaprprice=strip_tags($data->aprprice);
		$thismayqty=strip_tags($data->mayqty);
		$thismaycost=strip_tags($data->maycost);
		$thismayprice=strip_tags($data->mayprice);
		$thisjunqty=strip_tags($data->junqty);
		$thisjuncost=strip_tags($data->juncost);
		$thisjunprice=strip_tags($data->junprice);
		$thisjulqty=strip_tags($data->julqty);
		$thisjulcost=strip_tags($data->julcost);
		$thisjulprice=strip_tags($data->julprice);
		$thisaugqty=strip_tags($data->augqty);
		$thisaugcost=strip_tags($data->augcost);
		$thisaugprice=strip_tags($data->augprice);
		$thissepqty=strip_tags($data->sepqty);
		$thissepcost=strip_tags($data->sepcost);
		$thissepprice=strip_tags($data->sepprice);
		$thisoctqty=strip_tags($data->octqty);
		$thisoctcost=strip_tags($data->octcost);
		$thisoctprice=strip_tags($data->octprice);
		$thisnovqty=strip_tags($data->novqty);
		$thisnovcost=strip_tags($data->novcost);
		$thisnovprice=strip_tags($data->novprice);
		$thisdecqty=strip_tags($data->decqty);
		$thisdeccost=strip_tags($data->deccost);
		$thisdecprice=strip_tags($data->decprice);
		$thiswho=strip_tags($data->who);
		$thissent=strip_tags($data->sent);
		$thislreg=strip_tags($data->lreg);
		$thislstore=strip_tags($data->lstore);
		// $thisisdel=strip_tags($data->isdel);
		// $thiststamp=strip_tags($data->tstamp);


		$stmt->bindParam(':sku', $thissku);
		$stmt->bindParam(':store', $thisstore);
		$stmt->bindParam(':year', $thisyear);
		$stmt->bindParam(':janqty', $thisjanqty);
		$stmt->bindParam(':jancost', $thisjancost);
		$stmt->bindParam(':janprice', $thisjanprice);
		$stmt->bindParam(':febqty', $thisfebqty);
		$stmt->bindParam(':febcost', $thisfebcost);
		$stmt->bindParam(':febprice', $thisfebprice);
		$stmt->bindParam(':marqty', $thismarqty);
		$stmt->bindParam(':marcost', $thismarcost);
		$stmt->bindParam(':marprice', $thismarprice);
		$stmt->bindParam(':aprqty', $thisaprqty);
		$stmt->bindParam(':aprcost', $thisaprcost);
		$stmt->bindParam(':aprprice', $thisaprprice);
		$stmt->bindParam(':mayqty', $thismayqty);
		$stmt->bindParam(':maycost', $thismaycost);
		$stmt->bindParam(':mayprice', $thismayprice);
		$stmt->bindParam(':junqty', $thisjunqty);
		$stmt->bindParam(':juncost', $thisjuncost);
		$stmt->bindParam(':junprice', $thisjunprice);
		$stmt->bindParam(':julqty', $thisjulqty);
		$stmt->bindParam(':julcost', $thisjulcost);
		$stmt->bindParam(':julprice', $thisjulprice);
		$stmt->bindParam(':augqty', $thisaugqty);
		$stmt->bindParam(':augcost', $thisaugcost);
		$stmt->bindParam(':augprice', $thisaugprice);
		$stmt->bindParam(':sepqty', $thissepqty);
		$stmt->bindParam(':sepcost', $thissepcost);
		$stmt->bindParam(':sepprice', $thissepprice);
		$stmt->bindParam(':octqty', $thisoctqty);
		$stmt->bindParam(':octcost', $thisoctcost);
		$stmt->bindParam(':octprice', $thisoctprice);
		$stmt->bindParam(':novqty', $thisnovqty);
		$stmt->bindParam(':novcost', $thisnovcost);
		$stmt->bindParam(':novprice', $thisnovprice);
		$stmt->bindParam(':decqty', $thisdecqty);
		$stmt->bindParam(':deccost', $thisdeccost);
		$stmt->bindParam(':decprice', $thisdecprice);
		$stmt->bindParam(':who', $thiswho);
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
