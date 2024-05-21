<?php
class spiritsstk
{
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	function readStk($getsku)
	{
		$query = "select * from stk where stk.sku = $getsku and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedStk($getTstamp)
	{
		$thisTstamp = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from stk where tstamp > '$thisTstamp' order by tstamp";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getStk($getsku, $records_per_page)
	{
		$query = "select * from stk where stk.sku >= $getsku and isdel = 0 order by sku LIMIT ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function updateStk()
	{
		$query = "INSERT INTO stk (sku,store,floor,back,shipped,kits,stat,mtd_units,weeks,sdate,mtd_dol,mtd_prof,ytd_units,ytd_dol,ytd_prof,acost,lcost,pvend,lvend,pdate,smin,sord,sweeks,freeze_w,shelf,rshelf,sloc,bloc,who,inet,depos,skipstat,mincost,base,sent,ware,vintage,gosent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:sku,:store,:floor,:back,:shipped,:kits,:stat,:mtd_units,:weeks,:sdate,:mtd_dol,:mtd_prof,:ytd_units,:ytd_dol,:ytd_prof,:acost,:lcost,:pvend,:lvend,:pdate,:smin,:sord,:sweeks,:freeze_w,:shelf,:rshelf,:sloc,:bloc,:who,:inet,:depos,:skipstat,:mincost,:base,:sent,:ware,:vintage,:gosent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		floor = :floor,
		back = :back,
		shipped = :shipped,
		kits = :kits,
		stat = :stat,
		mtd_units = :mtd_units,
		weeks = :weeks,
		sdate = :sdate,
		mtd_dol = :mtd_dol,
		mtd_prof = :mtd_prof,
		ytd_units = :ytd_units,
		ytd_dol = :ytd_dol,
		ytd_prof = :ytd_prof,
		acost = :acost,
		lcost = :lcost,
		pvend = :pvend,
		lvend = :lvend,
		pdate = :pdate,
		smin = :smin,
		sord = :sord,
		sweeks = :sweeks,
		freeze_w = :freeze_w,
		shelf = :shelf,
		rshelf = :rshelf,
		sloc = :sloc,
		bloc = :bloc,
		who = :who,
		inet = :inet,
		depos = :depos,
		skipstat = :skipstat,
		mincost = :mincost,
		base = :base,
		sent = :sent,
		ware = :ware,
		vintage = :vintage,
		gosent = :gosent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->sku = strip_tags($this->sku);
		$this->store = strip_tags($this->store);
		$this->floor = strip_tags($this->floor);
		$this->back = strip_tags($this->back);
		$this->shipped = strip_tags($this->shipped);
		$this->kits = strip_tags($this->kits);
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
		$this->who = strip_tags($this->who);
		$this->inet = strip_tags($this->inet);
		$this->depos = strip_tags($this->depos);
		$this->skipstat = strip_tags($this->skipstat);
		$this->mincost = strip_tags($this->mincost);
		$this->base = strip_tags($this->base);
		$this->sent = strip_tags($this->sent);
		$this->ware = strip_tags($this->ware);
		$this->vintage = strip_tags($this->vintage);
		$this->gosent = strip_tags($this->gosent);
		$this->lreg = strip_tags($this->lreg);
		$this->lstore = strip_tags($this->lstore);
		$this->isdel = strip_tags($this->isdel);

		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':floor', $this->floor);
		$stmt->bindParam(':back', $this->back);
		$stmt->bindParam(':shipped', $this->shipped);
		$stmt->bindParam(':kits', $this->kits);
		$stmt->bindParam(':stat', $this->stat);
		$stmt->bindParam(':mtd_units', $this->mtd_units);
		$stmt->bindParam(':weeks', $this->weeks);
		$stmt->bindParam(':sdate', $this->sdate);
		$stmt->bindParam(':mtd_dol', $this->mtd_dol);
		$stmt->bindParam(':mtd_prof', $this->mtd_prof);
		$stmt->bindParam(':ytd_units', $this->ytd_units);
		$stmt->bindParam(':ytd_dol', $this->ytd_dol);
		$stmt->bindParam(':ytd_prof', $this->ytd_prof);
		$stmt->bindParam(':acost', $this->acost);
		$stmt->bindParam(':lcost', $this->lcost);
		$stmt->bindParam(':pvend', $this->pvend);
		$stmt->bindParam(':lvend', $this->lvend);
		$stmt->bindParam(':pdate', $this->pdate);
		$stmt->bindParam(':smin', $this->smin);
		$stmt->bindParam(':sord', $this->sord);
		$stmt->bindParam(':sweeks', $this->sweeks);
		$stmt->bindParam(':freeze_w', $this->freeze_w);
		$stmt->bindParam(':shelf', $this->shelf);
		$stmt->bindParam(':rshelf', $this->rshelf);
		$stmt->bindParam(':sloc', $this->sloc);
		$stmt->bindParam(':bloc', $this->bloc);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':inet', $this->inet);
		$stmt->bindParam(':depos', $this->depos);
		$stmt->bindParam(':skipstat', $this->skipstat);
		$stmt->bindParam(':mincost', $this->mincost);
		$stmt->bindParam(':base', $this->base);
		$stmt->bindParam(':sent', $this->sent);
		$stmt->bindParam(':ware', $this->ware);
		$stmt->bindParam(':vintage', $this->vintage);
		$stmt->bindParam(':gosent', $this->gosent);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':isdel', $this->isdel);


		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}
	function updateJnlStk()
	{

		$getstk_query = "SELECT back,stat,lvend,pvend,acost,lcost FROM stk WHERE sku = '$this->sku' AND store = '$this->store' LIMIT 1";
		$statement = $this->conn->query($getstk_query);
		$stk_data = $statement->fetch(PDO::FETCH_ASSOC);

		$back = $stk_data['back'];
		$stat = $stk_data['stat'];
		$acost = $stk_data['acost'];
		$lcost = $stk_data['lcost'];
		$pvend = $stk_data['pvend'];
		$lvend = $stk_data['lvend'];

		$get_username = "select uid from emp where id =$this->whochange";
		$stmt2 = $this->conn->query($get_username);
		$username = $stmt2->fetchColumn();

		$insert_log_query = "INSERT INTO stklog (sku, store, FLOOR, back, shipped, kits, amount, `NUMBER`, `TYPE`, whochange, cdate, stat, mtd_units, weeks, sdate, mtd_dol, mtd_prof, ytd_units, ytd_dol, ytd_prof, acost, lcost, pvend, lvend, pdate, smin, sord, sweeks, freeze_w, shelf, rshelf, sloc, bloc, lstore, who, tstamp, `inet`, depos, skipstat, mincost, isdel) 
		VALUES (:sku, :store, 0, :back, 0, 0, :qty, :sale, 'S', :whochange, NOW(), :stat, 0, 0, :date, 0, 0, 0, 0, 0, :acost, :lcost, :pvend, :lvend, '', 0, 0, 0, 0, 0, 0, '', '', :lstore,:who, NOW(), 0, '', 0, 0, 0)";

		$stmt = $this->conn->prepare($insert_log_query);
		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':back', $back);
		$stmt->bindParam(':qty', $this->back);
		$stmt->bindParam(':sale', $this->sale);
		$stmt->bindParam(':whochange', $username);
		$stmt->bindParam(':stat', $stat);
		$stmt->bindParam(':date', $this->sdate);
		$stmt->bindParam(':acost', $acost);
		$stmt->bindParam(':lcost', $lcost);
		$stmt->bindParam(':pvend', $pvend);
		$stmt->bindParam(':lvend', $lvend);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':who', $this->who);


		$stmt->execute();

		$query = "INSERT INTO stk (sku,store,floor,back,shipped,kits,sdate,who,tstamp,isdel,lreg,lstore)
			VALUES 
		(:sku,:store,floor + :floor,back + :back,shipped + :shipped,kits + :kits,:sdate,:who,now(),:isdel,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		floor = floor + :floor,
		back = back + :back,
		shipped = shipped + :shipped,
		kits = kits + :kits,
		sdate = :sdate,
		who = :who,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->sku = strip_tags($this->sku);
		$this->store = strip_tags($this->store);
		$this->floor = strip_tags($this->floor);
		$this->back = strip_tags($this->back);
		$this->shipped = strip_tags($this->shipped);
		$this->kits = strip_tags($this->kits);
		$this->sdate = strip_tags($this->sdate);
		$this->who = strip_tags($this->who);
		$this->lreg = strip_tags($this->lreg);
		$this->lstore = strip_tags($this->lstore);
		$this->isdel = strip_tags($this->isdel);

		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':floor', $this->floor);
		$stmt->bindParam(':back', $this->back);
		$stmt->bindParam(':shipped', $this->shipped);
		$stmt->bindParam(':kits', $this->kits);
		$stmt->bindParam(':sdate', $this->sdate);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':isdel', $this->isdel);

		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}

	}

	function updatePoStk()
	{
		$thisSku = $this->sku;
		$thisStore = $this->store;
		$thisPDate = date('Y-m-d', strtotime($this->pdate));
		$thisback = $this->back;
		$thiskits = $this->kits;
		$thisware = $this->ware;
		$thiswho = $this->who;
		$thisvcode = $this->vcode;
		$thislstore = $this->lstore;
		$thislreg = $this->lreg;
		if ($thisvcode = 'COUNT') {
			$query = "update stk set back = back + $thisback,ware = ware + $thisware, kits = kits + $thiskits, who = '$thiswho', isdel = 0 , tstamp = NOW(), lstore = $thislstore, lreg=$thislreg
			where sku = $thisSku and store = $thisStore";
		} else {
			$query = "update stk set back = back + $thisback,ware = ware + $thisware, kits = kits + $thiskits, pdate = '$thisPDate', who = '$thiswho', isdel = 0 , tstamp = NOW(), lstore = $thislstore, stat = '2', lvend = '$thisvcode', lreg=$thislreg
			where sku = $thisSku and store = $thisStore";
		}
		$stmt = $this->conn->prepare($query);
		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}


}

?>