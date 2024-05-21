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

foreach ($bulk->records as $data) {

    try {
        $query = "INSERT INTO `stklog` (`sku`, `store`, `floor`, `back`, `shipped`, `kits`, `amount`, `line`, `number`, `type`, `whochange`, `cdate`, `stat`, `mtd_units`, `weeks`, `sdate`, `mtd_dol`, `mtd_prof`, `ytd_units`, `ytd_dol`, `ytd_prof`, `acost`, `lcost`, `pvend`, `lvend`, `pdate`, `smin`, `sord`, `sweeks`, `freeze_w`, `shelf`, `rshelf`, `sloc`, `bloc`, `lstore`, `who`, `tstamp`, `inet`, `depos`, `skipstat`, `mincost`, `isdel`) 
        VALUES (:sku, :store, :floor, :back, :shipped, :kits, :amount, :line, :number, :type, :whochange, :cdate, :stat, :mtd_units, :weeks, :sdate, :mtd_dol, :mtd_prof, :ytd_units, :ytd_dol, :ytd_prof, :acost, :lcost, :pvend, :lvend, :pdate, :smin, :sord, :sweeks, :freeze_w, :shelf, :rshelf, :sloc, :bloc, :lstore, :who, :tstamp, :inet, :depos, :skipstat, :mincost, :isdel) 
        ON DUPLICATE KEY UPDATE 
        `store` = :store, 
        `floor` = :floor, 
        `back` = :back, 
        `shipped` = :shipped, 
        `kits` = :kits, 
        `amount` = :amount, 
        `line` = :line, 
        `type` = :type, 
        `whochange` = :whochange, 
        `cdate` = :cdate, 
        `stat` = :stat, 
        `mtd_units` = :mtd_units, 
        `weeks` = :weeks, 
        `sdate` = :sdate, 
        `mtd_dol` = :mtd_dol, 
        `mtd_prof` = :mtd_prof, 
        `ytd_units` = :ytd_units, 
        `ytd_dol` = :ytd_dol, 
        `ytd_prof` = :ytd_prof, 
        `acost` = :acost, 
        `lcost` = :lcost, 
        `pvend` = :pvend, 
        `lvend` = :lvend, 
        `pdate` = :pdate, 
        `smin` = :smin, 
        `sord` = :sord, 
        `sweeks` = :sweeks, 
        `freeze_w` = :freeze_w, 
        `shelf` = :shelf, 
        `rshelf` = :rshelf, 
        `sloc` = :sloc, 
        `bloc` = :bloc, 
        `lstore` = :lstore, 
        `who` = :who, 
        `tstamp` = :tstamp, 
        `inet` = :inet, 
        `depos` = :depos, 
        `skipstat` = :skipstat, 
        `mincost` = :mincost, 
        `isdel` = :isdel";


        $stmt = $db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':sku', $data->sku);
        $stmt->bindParam(':store', $data->store);
        $stmt->bindParam(':floor', $data->floor);
        $stmt->bindParam(':back', $data->back);
        $stmt->bindParam(':shipped', $data->shipped);
        $stmt->bindParam(':kits', $data->kits);
        $stmt->bindParam(':amount', $data->amount);
        $stmt->bindParam(':line', $data->line);
        $stmt->bindParam(':number', $data->number);
        $stmt->bindParam(':type', $data->type);
        $stmt->bindParam(':whochange', $data->whochange);
        $stmt->bindParam(':cdate', $data->cdate);
        $stmt->bindParam(':stat', $data->stat);
        $stmt->bindParam(':mtd_units', $data->mtd_units);
        $stmt->bindParam(':weeks', $data->weeks);
        $stmt->bindParam(':sdate', $data->sdate);
        $stmt->bindParam(':mtd_dol', $data->mtd_dol);
        $stmt->bindParam(':mtd_prof', $data->mtd_prof);
        $stmt->bindParam(':ytd_units', $data->ytd_units);
        $stmt->bindParam(':ytd_dol', $data->ytd_dol);
        $stmt->bindParam(':ytd_prof', $data->ytd_prof);
        $stmt->bindParam(':acost', $data->acost);
        $stmt->bindParam(':lcost', $data->lcost);
        $stmt->bindParam(':pvend', $data->pvend);
        $stmt->bindParam(':lvend', $data->lvend);
        $stmt->bindParam(':pdate', $data->pdate);
        $stmt->bindParam(':smin', $data->smin);
        $stmt->bindParam(':sord', $data->sord);
        $stmt->bindParam(':sweeks', $data->sweeks);
        $stmt->bindParam(':freeze_w', $data->freeze_w);
        $stmt->bindParam(':shelf', $data->shelf);
        $stmt->bindParam(':rshelf', $data->rshelf);
        $stmt->bindParam(':sloc', $data->sloc);
        $stmt->bindParam(':bloc', $data->bloc);
        $stmt->bindParam(':lstore', $data->lstore);
        $stmt->bindParam(':who', $data->who);
        $stmt->bindParam(':tstamp', $data->tstamp);
        $stmt->bindParam(':inet', $data->inet);
        $stmt->bindParam(':depos', $data->depos);
        $stmt->bindParam(':skipstat', $data->skipstat);
        $stmt->bindParam(':mincost', $data->mincost);
        $stmt->bindParam(':isdel', $data->isdel);



        $stmt->execute();

    } catch (PDOException $e) {
        $message = $e->getMessage();
        echo $message;
    }

}
$spiritsEND = $db->commit();
if ($spiritsEND == TRUE) {
    http_response_code(200);
    echo json_encode(array("message" => "UPDATED.."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "ERROR UPDATING!!"));
    echo json_encode(array("error" => $spiritsEND));
}
?>