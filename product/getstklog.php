<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritslog.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritslog($db);



$stmt = $product->getstklog($startingRecord, $records_per_page);
$num = $stmt->rowCount();
if ($num > 0) {

    $products_arr = array();
    $products_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $product_item = array(
            "sku" => $sku,
            "store" => $store,
            "floor" => $floor,
            "back" => $back,
            "shipped" => $shipped,
            "kits" => $kits,
            "amount" => $amount,
            "line" => $line,
            "number" => $number,
            "type" => $type,
            "whochange" => $whochange,
            "cdate" => $cdate,
            "stat" => $stat,
            "mtd_units" => $mtd_units,
            "weeks" => $weeks,
            "sdate" => $sdate,
            "mtd_dol" => $mtd_dol,
            "mtd_prof" => $mtd_prof,
            "ytd_units" => $ytd_units,
            "ytd_dol" => $ytd_dol,
            "ytd_prof" => $ytd_prof,
            "acost" => $acost,
            "lcost" => $lcost,
            "pvend" => $pvend,
            "lvend" => $lvend,
            "pdate" => $pdate,
            "smin" => $smin,
            "sord" => $sord,
            "sweeks" => $sweeks,
            "freeze_w" => $freeze_w,
            "shelf" => $shelf,
            "rshelf" => $rshelf,
            "sloc" => $sloc,
            "bloc" => $bloc,
            "lstore" => $lstore,
            "who" => $who,
            "inet" => $inet,
            "depos" => $depos,
            "skipstat" => $skipstat,
            "tstamp" => $tstamp,
            "mincost" => $mincost,
            "isdel" => $isdel
        );

        array_push($products_arr["records"], $product_item);
    }
    http_response_code(200);
    echo json_encode($products_arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "NOT FOUND.")
    );
}
?>