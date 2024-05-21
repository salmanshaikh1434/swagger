<?php
class spiritsmobd
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    function getUpdatedmobd($getTstamp,$lstore, $startingRecord, $records_per_page)
    {
        $thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
        $query = "select * from mobd where tstamp >= '$thisDate' and lstore = ? LIMIT ?,?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $lstore, PDO::PARAM_INT);
        $stmt->bindParam(2, $startingRecord, PDO::PARAM_INT);
        $stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    function  readMobd($saleno,$store){
        $query = "select * from mobd where sale='$saleno' and `isdel`=0 and `lstore`= '$store'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


}