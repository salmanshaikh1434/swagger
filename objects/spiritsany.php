<?php
class spiritsany
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function updateAny()
    {
        $query = $this->query;

        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return 'OK';
        } else {
            $stmtError = $stmt->errorInfo();
            return $stmtError;
        }
    }

    public function getbyquery($query)
    {

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }


    function getlastrecord($tcolumn, $table, $store)
    {

        $vlast = 1;
        // Check if lastrecords table is empty
        $checkEmptyQuery = $this->conn->prepare("SELECT COUNT(*) FROM lastrecords");
        $checkEmptyQuery->execute();
        $tableIsEmpty = ($checkEmptyQuery->fetchColumn() == 0);

        if ($tableIsEmpty) {
            // If the table is empty, insert a new row directly
            $insertsql = $this->conn->prepare("
                    INSERT INTO lastrecords (`StoreNo`, `TableColumn`, `TableName`, `lastvalue`)
                    VALUES (:store, :tcolumn, :table, :vlast)
                ");
        } else {
            // If the table is not empty
            $insertsql = $this->conn->prepare("
                INSERT INTO lastrecords (`StoreNo`, `TableColumn`, `TableName`, `lastvalue`)
                SELECT :store, :tcolumn, :table, :vlast
                FROM lastrecords
                WHERE NOT EXISTS (
                    SELECT 1
                    FROM lastrecords
                    WHERE `StoreNo` = :store AND `TableColumn` = :tcolumn AND `TableName` = :table
                )
                LIMIT 1
            ");
        }

        $insertsql->bindParam(':store', $store);
        $insertsql->bindParam(':tcolumn', $tcolumn);
        $insertsql->bindParam(':table', $table);
        $insertsql->bindParam(':vlast', $vlast);
        $insertsql->execute();

        if ($store == 0) {
            $stmt = $this->conn->prepare("SELECT `lastvalue` From lastrecords where `TableColumn`= '$tcolumn' AND `TableName`='$table'");
        } else {
            $stmt = $this->conn->prepare("SELECT `lastvalue` From lastrecords where `StoreNo` = '$store' AND `TableColumn`= '$tcolumn' AND `TableName`='$table'");
        }


        $stmt->execute();
        $ToCheck = $stmt->fetchColumn() + 1;
        // added by salman from TRN
        if (($table == 'cus' || $table == 'poh') && $store > 1) {
            $ToCheck = 10000000 * $store + $ToCheck;
        } elseif ($table == 'trn' && $store > 1) {
            $ToCheck = 1000000 * $store + $ToCheck;
        }

        $stmt = $this->conn->prepare("call sp_CheckMissingIds('$table','$tcolumn','$store','$ToCheck')");

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $lastvalue = $row['MissingId'];

        if (($table == 'cus' && $store > 1) || ($table == 'poh' && $store > 1)) {
            $final = $lastvalue - 10000000 * $store;
            $stmt = $this->conn->prepare("update lastrecords set `lastvalue`= '$final' where `tablecolumn`='$tcolumn' AND `tablename`='$table' AND `storeno`= '$store'");

            $stmt->execute();
        }
        // } else if ($table == 'trn' && $store > 1) {
        //     echo 'this is trn and Store is' . $store;

        //     $final = $lastvalue - 1000000 * $store;
        //     $stmt = $this->conn->prepare("update lastrecords set `lastvalue`= '$final' where `tablecolumn`='$tcolumn' AND `tablename`='$table' AND `storeno`= '$store'");
        //     $stmt->execute();
        // } else {
        //     $stmt = $this->conn->prepare("update lastrecords set `lastvalue`= '$lastvalue' where `tablecolumn`='$tcolumn' AND `tablename`='$table' AND `storeno`= '$store'");

        //     $stmt->execute();
        // }

        // exit;
        return $row['MissingId'];



    }
    // function getlastrecord($tcolumn, $table,$store)
    // {

    // 	if($store == 0){
    // 		 $stmt = $this->conn->prepare("SELECT `lastvalue` From lastrecords where `TableColumn`= '$tcolumn' AND `TableName`='$table'");
    // 	}else{
    // 		 $stmt = $this->conn->prepare("SELECT `lastvalue` From lastrecords where `StoreNo` = '$store' AND `TableColumn`= '$tcolumn' AND `TableName`='$table'");
    // 	}

    //     $stmt->execute();
    //     $ToCheck =  $stmt->fetchColumn() + 1;
    //     if($table = 'cus'){
    //         $ToCheck = 1000000 * $store + $ToCheck;
    //     }

    //     $stmt = $this->conn->prepare("call sp_CheckMissingIds('$table','$tcolumn','$store','$ToCheck')");
    // 	$row = $stmt->fetch(PDO::FETCH_ASSOC);
    //     $lastvalue = $row['MissingId'];

    //     if($table = 'cus'){
    //         $lastvalue = $lastvalue - 1000000 * $store;
    //     }

    //     if($store == 0){
    //         $stmt = $this->conn->prepare("update lastrecords set `lastvalue`= '$lastvalue' where `tablecolumn`='$tcolumn' AND `tablename`='$table'"); 
    //     }else{
    //         $stmt = $this->conn->prepare("update lastrecords set `lastvalue`= '$lastvalue' where `tablecolumn`='$tcolumn' AND `tablename`='$table' AND `storeno`= '$store'"); 
    //     }
    //     if($stmt->execute()){
    //         return  $lastvalue;
    //     }
    // }
}