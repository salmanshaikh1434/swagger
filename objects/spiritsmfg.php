<?php
class spiritsmfg
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function readmfg($id)
    {
        $query = "select * from mfg where mfg.id = $id and isdel = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function getUpdatedmfg($getTstamp, $startingRecord, $records_per_page)
    {
        $thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
        $query = "select * from mfg where tstamp >= '$thisDate' LIMIT ?,?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    function getmfg($records_per_page)
    {
        $query = "select * from mfg where isdel = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function updatemfg()
    {
        $query = "INSERT INTO mfg (id,name,caseamt,unitamt,tstamp,isdel,lreg,lstore)
			VALUES 
		(:id,:name,:caseamt,:unitamt,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		id = :id,
		name = :name,
		caseamt = :caseamt,
		unitamt = :unitamt,
		tstamp = NOW(),
		lreg= :lreg,
		isdel = :isdel,
        lstore= :lstore";

        $stmt = $this->conn->prepare($query);
        $this->id =  strip_tags($this->id);
        $this->name =  strip_tags($this->name);
        $this->caseamt =  strip_tags($this->caseamt);
        $this->unitamt =  strip_tags($this->unitamt);
        $this->lreg =  strip_tags($this->lreg);
        $this->isdel =  strip_tags($this->isdel);
        $this->lstore =  strip_tags($this->lstore);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':caseamt', $this->caseamt);
        $stmt->bindParam(':unitamt', $this->unitamt);
        $stmt->bindParam(':lreg', $this->lreg);
        $stmt->bindParam(':isdel', $this->isdel);
        $stmt->bindParam(':lstore', $this->lstore);


        if ($stmt->execute()) {
            return 'OK';
        } else {
            $stmtError = $stmt->errorInfo();
            return $stmtError;
        }
    }
}
