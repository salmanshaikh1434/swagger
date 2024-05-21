<?php

class SpiritsTimeClock
{
    private $conn;

    public $timeId;
    public $loginId;    // Assuming you'll bind it like in spiritsprc
    public $logindate;
    public $logstatus;
    public $logintime;
    public $logouttime;
    public $store;
    public $who;
    public $sent;
    public $isdel;	// Assuming you'll bind it

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getTimeClockByLoginId($loginId)
    {
        $query = "SELECT * FROM timeclock WHERE LOGINID = :loginId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':loginId', $loginId);
        $stmt->execute();
        return $stmt;
    }

    function getUpdatedTimeClock($getTstamp, $startingRecord, $records_per_page)
    {
        $thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
        $query = "SELECT * FROM timeclock WHERE TSTAMP > :thisDate LIMIT :startingRecord, :records_per_page";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':thisDate', $thisDate);
        $stmt->bindParam(':startingRecord', $startingRecord, PDO::PARAM_INT);
        $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    function updateTimeClock()
    {
        $query = "INSERT INTO timeclock (TIMEID,LOGINID, LOGINDATE, LOGSTATUS, LOGINTIME, LOGOUTTIME, STORE, WHO, TSTAMP, SENT, ISDEL) 
                  VALUES (:timeid,:loginId, :logindate, :logstatus, :logintime, :logouttime, :store, :who, NOW(), :sent)
                  ON DUPLICATE KEY UPDATE 
                  TIMEID =:timeid,LOGINID = :loginid, LOGINDATE =:logindate, LOGSTATUS = :logstatus, LOGINTIME = :logintime, LOGOUTTIME = :logouttime, 
                  STORE = :store, WHO = :who, TSTAMP = NOW(), 0, SENT = :sent";

        $stmt = $this->conn->prepare($query);
        $this->timeid = strip_tags($this->timeid);
        $this->loginid = strip_tags($this->loginid);
        $this->logindate = strip_tags($this->logindate);
        $this->logstatus = strip_tags($this->logstatus);
        $this->logintime = strip_tags($this->logintime);
        $this->logouttime = strip_tags($this->logouttime);
        $this->store = strip_tags($this->store);
        $this->who = strip_tags($this->who);
        $this->sent = strip_tags($this->sent);
        $this->isdel = strip_tags($this->isdel);



        $stmt->bindParam(':timeId', $this->timeid);
        $stmt->bindParam(':loginId', $this->loginid);
        $stmt->bindParam(':logindate', $this->logindate);
        $stmt->bindParam(':logstatus', $this->logstatus);
        $stmt->bindParam(':logintime', $this->logintime);
        $stmt->bindParam(':logouttime', $this->logouttime);
        $stmt->bindParam(':store', $this->store);
        $stmt->bindParam(':who', $this->who);
        $stmt->bindParam(':sent', $this->sent);
        $stmt->bindParam(':isdel', $this->isdel);

        if ($stmt->execute()) {
            return 'OK';
        } else {
            $stmtError = $stmt->errorInfo();
            return $stmtError;
        }
    }
}

?>