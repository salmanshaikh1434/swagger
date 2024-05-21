<?php
class spiritstimeclock
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getRecentPunches($getTstamp, $startingRecord, $records_per_page)
    {
        $thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
        $query = "select * from timeclock where logindate >= '$thisDate' LIMIT ?,?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}
?>
