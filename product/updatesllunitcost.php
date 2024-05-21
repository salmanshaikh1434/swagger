<?php
//Added by salman to update unit cost to sll table

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();
$data = json_decode(file_get_contents("php://input"));
$store = $data->store;
$promo = $data->promo;
$fromdate = $data->fromdate;
$todate   = $data->todate;
$query = "SELECT * FROM sll WHERE listnum = :listnum AND store = :store";
$stmt = $db->prepare($query);
$stmt->bindParam(":listnum", $data->listnum);
$stmt->bindParam(":store", $store);
$stmt->execute();
$slldata = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($slldata);

// exit;
foreach ($slldata as $sllgrd) {
    // echo "Processing SKU: " . trim($sllgrd['sku']) . "\n";
    $query = "SELECT * FROM inv WHERE sku = :sku";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':sku', $sllgrd['sku']);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $sInv = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($sInv['ssku'] != 0) {
            $ThisSKU = $sInv['ssku'];
        } else {
            $ThisSKU = $sllgrd['sku'];
        }
    } else {
        $ThisSKU = $sllgrd['sku'];
    }


    $query = "SELECT SUM(`lvl1qty`) AS lvl1qty, SUM(`lvl2qty`) AS lvl2qty, SUM(`lvl3qty`) AS lvl3qty, SUM(`lvl4qty`) AS lvl4qty,
                 SUM(`qty`/`pack`) AS qtypack,
                 SUM(`lvl1price`) AS lvl1price, SUM(`lvl2price`) AS lvl2price, SUM(`lvl3price`) AS lvl3price, SUM(`lvl4price`) AS lvl4price,
                 SUM(`lvl1cost`) AS lvl1cost, SUM(`lvl2cost`) AS lvl2cost, SUM(`lvl3cost`) AS lvl3cost , SUM(`lvl4cost`) AS lvl4cost
          FROM hst
          WHERE sku = :sku AND store = :store AND promo = :promo AND isdel = 0 AND `date` >= :fromdate AND `date` <= :todate";


    $stmt = $db->prepare($query);
    $stmt->bindParam(':sku', $ThisSKU);
    $stmt->bindParam(':store', $store);
    $stmt->bindParam(':promo', $promo);
    $stmt->bindParam(':fromdate', $fromdate);
    $stmt->bindParam(':todate', $todate);
    $stmt->execute();



    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        switch ($sllgrd['level']) {
            case "1":
                $mQty =   $row['lvl1qty'];
                $mCases = $row['qtypack'];
                $mprice = $row['lvl1price'];
                $mycost = $row['lvl1cost'];
                break;
            case "2":
                $mQty = $row['lvl2qty'];
                $mCases = $row['qtypack'];
                $mprice = $row['lvl2price'];
                $mycost = $row['lvl2cost'];
                break;
            case "3":
                $mQty = $row['lvl3qty'];
                $mCases = $row['qtypack'];
                $mprice = $row['lvl3price'];
                $mycost = $row['lvl3cost'];
                break;
            case "4":
                $mQty = $row['lvl4qty'];
                $mCases = $row['qtypack'];
                $mprice = $row['lvl4price'];
                $mycost = $row['lvl4cost'];
                break;
            default:
                $mQty = $row['lvl1qty'];
                $mCases = $row['qtypack'];
                $mprice = $row['lvl1price'];
                $mycost = $row['lvl1cost'];
                break;
        }
        // echo "for SKU:" . $sllgrd['sku'] . "\n";
        // echo "qty" . $mQty . "\n";
        // echo "cases" . $mCases . "\n";
        // echo "mprice" . $mprice . "\n";
        // echo "mcost" . $mycost . "\n";


        // Update sllgrd.Units, sllgrd.Sales, and sllgrd.Profit
        $query = "UPDATE sll SET units = :units, sales = :sales, profit = :profit WHERE sku = :sku AND isdel= 0";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':units', $mQty);
        $stmt->bindParam(':sales', $mprice);
        $stmt->bindValue(':profit', ($mprice - $mycost));
        $stmt->bindParam(':sku', $sllgrd['sku']);
        $stmt->execute();
    }
}
$query = "SELECT SUM(`units`) AS mUnits,SUM(`sales`) AS mSales,SUM(`profit`) AS mProfit FROM sll WHERE listnum = :listnum AND store = :store AND isdel = 0";
$stmt = $db->prepare($query);
$stmt->bindParam(":listnum", $data->listnum);
$stmt->bindParam(":store", $store);

if ($stmt->execute()) {
    $slhdata = $stmt->fetch(PDO::FETCH_ASSOC);
    $slhdata['mUnits'] = isset($slhdata['mUnits']) ? $slhdata['mUnits']: 0;
    $slhdata['mSales'] = isset($slhdata['mSales']) ? $slhdata['mSales']: 0;
    $slhdata['mProfit'] = isset($slhdata['mProfit']) ? $slhdata['mProfit']: 0;
   
    echo json_encode($slhdata);
} else {
    echo 'No Record Found';
}

// Close the database connection
$database = null;
