<?php
class spiritslog
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    function getupdatedStkLog($gettstamp, $startingrecord, $records_per_page)
    {
        $thisdate = date('Y-m-d H:i:s', strtotime($gettstamp));
        $query = "select * from stklog where tstamp > '$thisdate' order by tstamp limit ?,?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(1, $startingrecord, PDO::PARAM_INT);
        $stmt->bindparam(2, $records_per_page, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
    function getstklog($getPage, $records_per_page)
    {
        $query = "select * from stklog where isdel = 0 order by tstamp LIMIT ?,?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $getPage, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function updateStklog()
    {
        $query = "INSERT INTO `stklog` (`sku`, `store`, `floor`, `back`, `shipped`, `kits`, `amount`, `line`, `number`, `type`,
        `whochange`, `cdate`, `stat`, `mtd_units`, `weeks`, `sdate`, `mtd_dol`, `mtd_prof`, `ytd_units`, `ytd_dol`, `ytd_prof`,
        `acost`, `lcost`, `pvend`, `lvend`, `pdate`, `smin`, `sord`, `sweeks`, `freeze_w`, `shelf`, `rshelf`, `sloc`, `bloc`,
        `lstore`, `who`, `tstamp`, `inet`, `depos`, `skipstat`, `mincost`, `isdel`) VALUES (:sku, :store, :floor, :back, :shipped, :kits, :amount, :line, :number, :type,
        :whochange, :cdate, :stat, :mtd_units, :weeks, :sdate, :mtd_dol, :mtd_prof, :ytd_units, :ytd_dol, :ytd_prof,
        :acost, :lcost, :pvend, :lvend, :pdate, :smin, :sord, :sweeks, :freeze_w, :shelf, :rshelf, :sloc, :bloc,
        :lstore, :who, NOW(), :inet, :depos, :skipstat, :mincost, :isdel)";

        $stmt = $this->conn->prepare($query);

        $this->sku = strip_tags($this->sku);
        $this->store = strip_tags($this->store);
        $this->floor = strip_tags($this->floor);
        $this->back = strip_tags($this->back);
        $this->shipped = strip_tags($this->shipped);
        $this->kits = strip_tags($this->kits);
        $this->amount = strip_tags($this->amount);
        $this->line = strip_tags($this->line);
        $this->number = strip_tags($this->number);
        $this->type = strip_tags($this->type);
        $this->whochange = strip_tags($this->whochange);
        $this->cdate = strip_tags($this->cdate);
        $this->stat = strip_tags($this->stat);
        $this->mtd_units = strip_tags($this->mtd_units);
        $this->weeks = strip_tags($this->weeks);
        $this->sdate = strip_tags($this->sdate);
        $this->mtd_dol = strip_tags($this->mtd_dol);
        $this->mtd_prof = strip_tags($this->mtd_prof);
        $this->ytd_units = strip_tags($this->ytd_units);
        $this->ytd_dol = strip_tags($this->ytd_dol);
        $this->ytd_prof = strip_tags($this->ytd_prof);
        $this->acost = strip_tags($this->acost);
        $this->lcost = strip_tags($this->lcost);
        $this->pvend = strip_tags($this->pvend);
        $this->lvend = strip_tags($this->lvend);
        $this->pdate = strip_tags($this->pdate);
        $this->smin = strip_tags($this->smin);
        $this->sord = strip_tags($this->sord);
        $this->sweeks = strip_tags($this->sweeks);
        $this->freeze_w = strip_tags($this->freeze_w);
        $this->shelf = strip_tags($this->shelf);
        $this->rshelf = strip_tags($this->rshelf);
        $this->sloc = strip_tags($this->sloc);
        $this->bloc = strip_tags($this->bloc);
        $this->lstore = strip_tags($this->lstore);
        $this->who = strip_tags($this->who);
        $this->inet = strip_tags($this->inet);
        $this->depos = strip_tags($this->depos);
        $this->skipstat = strip_tags($this->skipstat);
        $this->mincost = strip_tags($this->mincost);
        $this->isdel = strip_tags($this->isdel);

        $stmt->bindparam(':sku', $this->sku);
        $stmt->bindparam(':store', $this->store);
        $stmt->bindparam(':floor', $this->floor);
        $stmt->bindparam(':back', $this->back);
        $stmt->bindparam(':shipped', $this->shipped);
        $stmt->bindparam(':kits', $this->kits);
        $stmt->bindparam(':amount', $this->amount);
        $stmt->bindparam(':line', $this->line);
        $stmt->bindparam(':number', $this->number);
        $stmt->bindparam(':type', $this->type);
        $stmt->bindparam(':whochange', $this->whochange);
        $stmt->bindparam(':cdate', $this->cdate);
        $stmt->bindparam(':stat', $this->stat);
        $stmt->bindparam(':mtd_units', $this->mtd_units);
        $stmt->bindparam(':weeks', $this->weeks);
        $stmt->bindparam(':sdate', $this->sdate);
        $stmt->bindparam(':mtd_dol', $this->mtd_dol);
        $stmt->bindparam(':mtd_prof', $this->mtd_prof);
        $stmt->bindparam(':ytd_units', $this->ytd_units);
        $stmt->bindparam(':ytd_dol', $this->ytd_dol);
        $stmt->bindparam(':ytd_prof', $this->ytd_prof);
        $stmt->bindparam(':acost', $this->acost);
        $stmt->bindparam(':lcost', $this->lcost);
        $stmt->bindparam(':pvend', $this->pvend);
        $stmt->bindparam(':lvend', $this->lvend);
        $stmt->bindparam(':pdate', $this->pdate);
        $stmt->bindparam(':smin', $this->smin);
        $stmt->bindparam(':sord', $this->sord);
        $stmt->bindparam(':sweeks', $this->sweeks);
        $stmt->bindparam(':freeze_w', $this->freeze_w);
        $stmt->bindparam(':shelf', $this->shelf);
        $stmt->bindparam(':rshelf', $this->rshelf);
        $stmt->bindparam(':sloc', $this->sloc);
        $stmt->bindparam(':bloc', $this->bloc);
        $stmt->bindparam(':lstore', $this->lstore);
        $stmt->bindparam(':who', $this->who);
        $stmt->bindparam(':inet', $this->inet);
        $stmt->bindparam(':depos', $this->depos);
        $stmt->bindparam(':skipstat', $this->skipstat);
        $stmt->bindparam(':mincost', $this->mincost);
        $stmt->bindparam(':isdel', $this->isdel);

        if ($stmt->execute()) {
            return 'OK';
        } else {
            $stmterror = $stmt->errorinfo();
            return $stmterror;
        }
    }


}