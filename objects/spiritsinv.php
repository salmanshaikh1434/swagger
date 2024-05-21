<?php
use OpenApi\Annotations as OA;

class spiritsinv
{
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	/**
	 * @OA\Get(
	 *   tags={"readinv"},
	 *   path="/apidb/product/readinv.php",
	 *   summary="Summary",
	 *   @OA\Parameter(
	 *     name="sku", 
	 *     in="query", 
	 *     required=true, 
	 *     description="get data based on sku",
	 *     @OA\Schema(
	 *       type="integer",
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found")
	 * )
	 */



	function readInv($getsku)
	{
		$query = "select * from inv where inv.sku = $getsku and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	/**
	 * @OA\Get(
	 *   tags={"getupdatedinv"},
	 *   path="/apidb/product/getupdatedinv.php",
	 *   summary="Summary",
	 *   @OA\Parameter(
	 *     name="tstamp", 
	 *     in="query", 
	 *     required=true, 
	 *     description="get inventory based on tstamp",
	 *     @OA\Schema(
	 *       type="string",
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found")
	 * )
	 */
	function getupdatedInv($gettstamp, $startingrecord, $records_per_page)
	{
		$thisdate = date('Y-m-d H:i:s', strtotime($gettstamp));
		$query = "select * from inv where tstamp > '$thisdate' order by tstamp limit ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindparam(1, $startingrecord, PDO::PARAM_INT);
		$stmt->bindparam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	/**
	 * @OA\Get(
	 *   tags={"getinv"},
	 *   path="/apidb/product/getinv.php",
	 *   summary="Summary",
	 *   @OA\Parameter(
	 *     name="sku", 
	 *     in="query", 
	 *     required=true, 
	 *     description="get data based on sku",
	 *     @OA\Schema(
	 *       type="integer",
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found")
	 * )
	 */

	function getInv($getsku, $records_per_page)
	{
		$query = "select * from inv where inv.sku > $getsku and isdel = 0 order by sku limit ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindparam(1, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	/**
	 * @OA\Post(
	 *   path="/apidb/product/updateinv.php",
	 *   summary="Update inv",
	 *   tags={"updateinv"},
	 *   @OA\RequestBody(
	 *     required=true,
	 *     @OA\MediaType(
	 *       mediaType="application/json",
	 *       @OA\Schema(
	 *         @OA\Property(
	 *           property="type",
	 *           type="string",
	 *           example="2050"
	 *         ),
	 *         @OA\Property(
	 *           property="name",
	 *           type="string",
	 *           example="MONIKKA SPARKLING MOSCATO"
	 *         ),
	 *         @OA\Property(
	 *           property="ml",
	 *           type="string",
	 *           example="750"
	 *         ),
	 *         @OA\Property(
	 *           property="sname",
	 *           type="string",
	 *           example="750 M"
	 *         ),
	 *         @OA\Property(
	 *           property="pack",
	 *           type="string",
	 *           example="12"
	 *         ),
	 *         @OA\Property(
	 *           property="sku",
	 *           type="string",
	 *           example="10000"
	 *         ),
	 *         @OA\Property(
	 *           property="ssku",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="stat",
	 *           type="string",
	 *           example="2"
	 *         ),
	 *         @OA\Property(
	 *           property="mtd_units",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="weeks",
	 *           type="string",
	 *           example="0.0"
	 *         ),
	 *         @OA\Property(
	 *           property="sdate",
	 *           type="string",
	 *           example="2024-04-04"
	 *         ),
	 *         @OA\Property(
	 *           property="mtd_dol",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="mtd_prof",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="ytd_units",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="ytd_dol",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="ytd_prof",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="cat",
	 *           type="string",
	 *           example="150"
	 *         ),
	 *         @OA\Property(
	 *           property="scat",
	 *           type="string",
	 *           example="151"
	 *         ),
	 *         @OA\Property(
	 *           property="depos",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="acost",
	 *           type="string",
	 *           example="60"
	 *         ),
	 *         @OA\Property(
	 *           property="lcost",
	 *           type="string",
	 *           example="60"
	 *         ),
	 *         @OA\Property(
	 *           property="pvend",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="lvend",
	 *           type="string",
	 *           example="FOOD"
	 *         ),
	 *         @OA\Property(
	 *           property="pdate",
	 *           type="string",
	 *           example="2024-04-04"
	 *         ),
	 *         @OA\Property(
	 *           property="smin",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="sord",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="pref",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="suprof",
	 *           type="string",
	 *           example="0.00"
	 *         ),
	 *         @OA\Property(
	 *           property="scprof",
	 *           type="string",
	 *           example="0.00"
	 *         ),
	 *         @OA\Property(
	 *           property="freeze",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="sweeks",
	 *           type="string",
	 *           example="0.0"
	 *         ),
	 *         @OA\Property(
	 *           property="freeze_w",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="shelf",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="rshelf",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="sloc",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="bloc",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="proof",
	 *           type="string",
	 *           example="0.0"
	 *         ),
	 *         @OA\Property(
	 *           property="cflag",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="unit_case",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="freeform1",
	 *           type="string",
	 *           example="WINE"
	 *         ),
	 *         @OA\Property(
	 *           property="freeform2",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="freeform3",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="freeform4",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="mfg_key",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="sell",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="who",
	 *           type="string",
	 *           example="MP"
	 *         ),
	 *         @OA\Property(
	 *           property="memo",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="fson",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="fsfactor",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="cdate",
	 *           type="string",
	 *           example="2022-06-15"
	 *         ),
	 *         @OA\Property(
	 *           property="image",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="sent",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="vintage",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="websent",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="typename",
	 *           type="string",
	 *           example="IMPORTED - SPAIN"
	 *         ),
	 *         @OA\Property(
	 *           property="invprice",
	 *           type="string",
	 *           example="5.99"
	 *         ),
	 *         @OA\Property(
	 *           property="invsale",
	 *           type="string",
	 *           example="5.99"
	 *         ),
	 *         @OA\Property(
	 *           property="invclub",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *         @OA\Property(
	 *           property="tags",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="esl",
	 *           type="string",
	 *           example=""
	 *         ),
	 *         @OA\Property(
	 *           property="lreg",
	 *           type="string",
	 *           example="11"
	 *         ),
	 *         @OA\Property(
	 *           property="lstore",
	 *           type="string",
	 *           example="1"
	 *         ),
	 *         @OA\Property(
	 *           property="isdel",
	 *           type="string",
	 *           example="0"
	 *         ),
	 *       )
	 *     )
	 *   ),
	 *   @OA\Response(
	 *     response=200,
	 *     description="OK"
	 *   ),
	 *   @OA\Response(
	 *     response=401,
	 *     description="Unauthorized"
	 *   ),
	 *   @OA\Response(
	 *     response=404,
	 *     description="Not Found"
	 *   )
	 * )
	 */



	function updateInv()
	{

		$query = "insert into inv (type,name,ml,sname,pack,sku,ssku,stat,mtd_units,weeks,sdate,mtd_dol,mtd_prof,ytd_units,ytd_dol,ytd_prof,cat,scat,depos,acost,lcost,pvend,lvend,pdate,smin,sord,pref,suprof,scprof,freeze,sweeks,freeze_w,shelf,rshelf,sloc,bloc,proof,cflag,unit_case,freeform1,freeform2,freeform3,freeform4,mfg_key,sell,who,memo,fson,fsfactor,cdate,image,sent,vintage,websent,typename,invprice,invsale,invclub,tags,esl,tstamp,isdel,lreg,lstore)
			values 
		(:type,:name,:ml,:sname,:pack,:sku,:ssku,:stat,:mtd_units,:weeks,:sdate,:mtd_dol,:mtd_prof,:ytd_units,:ytd_dol,:ytd_prof,:cat,:scat,:depos,:acost,:lcost,:pvend,:lvend,:pdate,:smin,:sord,:pref,:suprof,:scprof,:freeze,:sweeks,:freeze_w,:shelf,:rshelf,:sloc,:bloc,:proof,:cflag,:unit_case,:freeform1,:freeform2,:freeform3,:freeform4,:mfg_key,:sell,:who,:memo,:fson,:fsfactor,:cdate,:image,:sent,:vintage,:websent,:typename,:invprice,:invsale,:invclub,:tags,:esl,now(),0,:lreg,:lstore)
		on duplicate key update
		type = :type,
		name = :name,
		ml = :ml,
		sname = :sname,
		pack = :pack,
		ssku = :ssku,
		stat = :stat,
		mtd_units = :mtd_units,
		weeks = :weeks,
		sdate = :sdate,
		mtd_dol = :mtd_dol,
		mtd_prof = :mtd_prof,
		ytd_units = :ytd_units,
		ytd_dol = :ytd_dol,
		ytd_prof = :ytd_prof,
		cat = :cat,
		scat = :scat,
		depos = :depos,
		acost = :acost,
		lcost = :lcost,
		pvend = :pvend,
		lvend = :lvend,
		pdate = :pdate,
		smin = :smin,
		sord = :sord,
		pref = :pref,
		suprof = :suprof,
		scprof = :scprof,
		freeze = :freeze,
		sweeks = :sweeks,
		freeze_w = :freeze_w,
		shelf = :shelf,
		rshelf = :rshelf,
		sloc = :sloc,
		bloc = :bloc,
		proof = :proof,
		cflag = :cflag,
		unit_case = :unit_case,
		freeform1 = :freeform1,
		freeform2 = :freeform2,
		freeform3 = :freeform3,
		freeform4 = :freeform4,
		mfg_key = :mfg_key,
		sell = :sell,
		who = :who,
		memo = :memo,
		fson = :fson,
		fsfactor = :fsfactor,
		cdate = :cdate,
		image = :image,
		sent = :sent,
		vintage = :vintage,
		websent = :websent,
		typename = :typename,
		invprice = :invprice,
		invsale = :invsale,
		invclub = :invclub,
		tags = :tags,
		esl = :esl,
		tstamp = now(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->type = strip_tags($this->type);
		$this->name = strip_tags($this->name);
		$this->ml = strip_tags($this->ml);
		$this->sname = strip_tags($this->sname);
		$this->pack = strip_tags($this->pack);
		$this->sku = strip_tags($this->sku);
		$this->ssku = strip_tags($this->ssku);
		$this->stat = strip_tags($this->stat);
		$this->mtd_units = strip_tags($this->mtd_units);
		$this->weeks = strip_tags($this->weeks);
		$this->sdate = strip_tags($this->sdate);
		$this->mtd_dol = strip_tags($this->mtd_dol);
		$this->mtd_prof = strip_tags($this->mtd_prof);
		$this->ytd_units = strip_tags($this->ytd_units);
		$this->ytd_dol = strip_tags($this->ytd_dol);
		$this->ytd_prof = strip_tags($this->ytd_prof);
		$this->cat = strip_tags($this->cat);
		$this->scat = strip_tags($this->scat);
		$this->depos = strip_tags($this->depos);
		$this->acost = strip_tags($this->acost);
		$this->lcost = strip_tags($this->lcost);
		$this->pvend = strip_tags($this->pvend);
		$this->lvend = strip_tags($this->lvend);
		$this->pdate = strip_tags($this->pdate);
		$this->smin = strip_tags($this->smin);
		$this->sord = strip_tags($this->sord);
		$this->pref = strip_tags($this->pref);
		$this->suprof = strip_tags($this->suprof);
		$this->scprof = strip_tags($this->scprof);
		$this->freeze = strip_tags($this->freeze);
		$this->sweeks = strip_tags($this->sweeks);
		$this->freeze_w = strip_tags($this->freeze_w);
		$this->shelf = strip_tags($this->shelf);
		$this->rshelf = strip_tags($this->rshelf);
		$this->sloc = strip_tags($this->sloc);
		$this->bloc = strip_tags($this->bloc);
		$this->proof = strip_tags($this->proof);
		$this->cflag = strip_tags($this->cflag);
		$this->unit_case = strip_tags($this->unit_case);
		$this->freeform1 = strip_tags($this->freeform1);
		$this->freeform2 = strip_tags($this->freeform2);
		$this->freeform3 = strip_tags($this->freeform3);
		$this->freeform4 = strip_tags($this->freeform4);
		$this->mfg_key = strip_tags($this->mfg_key);
		$this->sell = strip_tags($this->sell);
		$this->who = strip_tags($this->who);
		$this->memo = strip_tags($this->memo);
		$this->fson = strip_tags($this->fson);
		$this->fsfactor = strip_tags($this->fsfactor);
		$this->cdate = strip_tags($this->cdate);
		$this->image = strip_tags($this->image);
		$this->sent = strip_tags($this->sent);
		$this->vintage = strip_tags($this->vintage);
		$this->websent = strip_tags($this->websent);
		$this->typename = strip_tags($this->typename);
		$this->invprice = strip_tags($this->invprice);
		$this->invsale = strip_tags($this->invsale);
		$this->invclub = strip_tags($this->invclub);
		$this->tags = strip_tags($this->tags);
		$this->esl = strip_tags($this->esl);
		$this->lreg = strip_tags($this->lreg);
		$this->lstore = strip_tags($this->lstore);
		$this->isdel = strip_tags($this->isdel);

		$stmt->bindparam(':type', $this->type);
		$stmt->bindparam(':name', $this->name);
		$stmt->bindparam(':ml', $this->ml);
		$stmt->bindparam(':sname', $this->sname);
		$stmt->bindparam(':pack', $this->pack);
		$stmt->bindparam(':sku', $this->sku);
		$stmt->bindparam(':ssku', $this->ssku);
		$stmt->bindparam(':stat', $this->stat);
		$stmt->bindparam(':mtd_units', $this->mtd_units);
		$stmt->bindparam(':weeks', $this->weeks);
		$stmt->bindparam(':sdate', $this->sdate);
		$stmt->bindparam(':mtd_dol', $this->mtd_dol);
		$stmt->bindparam(':mtd_prof', $this->mtd_prof);
		$stmt->bindparam(':ytd_units', $this->ytd_units);
		$stmt->bindparam(':ytd_dol', $this->ytd_dol);
		$stmt->bindparam(':ytd_prof', $this->ytd_prof);
		$stmt->bindparam(':cat', $this->cat);
		$stmt->bindparam(':scat', $this->scat);
		$stmt->bindparam(':depos', $this->depos);
		$stmt->bindparam(':acost', $this->acost);
		$stmt->bindparam(':lcost', $this->lcost);
		$stmt->bindparam(':pvend', $this->pvend);
		$stmt->bindparam(':lvend', $this->lvend);
		$stmt->bindparam(':pdate', $this->pdate);
		$stmt->bindparam(':smin', $this->smin);
		$stmt->bindparam(':sord', $this->sord);
		$stmt->bindparam(':pref', $this->pref);
		$stmt->bindparam(':suprof', $this->suprof);
		$stmt->bindparam(':scprof', $this->scprof);
		$stmt->bindparam(':freeze', $this->freeze);
		$stmt->bindparam(':sweeks', $this->sweeks);
		$stmt->bindparam(':freeze_w', $this->freeze_w);
		$stmt->bindparam(':shelf', $this->shelf);
		$stmt->bindparam(':rshelf', $this->rshelf);
		$stmt->bindparam(':sloc', $this->sloc);
		$stmt->bindparam(':bloc', $this->bloc);
		$stmt->bindparam(':proof', $this->proof);
		$stmt->bindparam(':cflag', $this->cflag);
		$stmt->bindparam(':unit_case', $this->unit_case);
		$stmt->bindparam(':freeform1', $this->freeform1);
		$stmt->bindparam(':freeform2', $this->freeform2);
		$stmt->bindparam(':freeform3', $this->freeform3);
		$stmt->bindparam(':freeform4', $this->freeform4);
		$stmt->bindparam(':mfg_key', $this->mfg_key);
		$stmt->bindparam(':sell', $this->sell);
		$stmt->bindparam(':who', $this->who);
		$stmt->bindparam(':memo', $this->memo);
		$stmt->bindparam(':fson', $this->fson);
		$stmt->bindparam(':fsfactor', $this->fsfactor);
		$stmt->bindparam(':cdate', $this->cdate);
		$stmt->bindparam(':image', $this->image);
		$stmt->bindparam(':sent', $this->sent);
		$stmt->bindparam(':vintage', $this->vintage);
		$stmt->bindparam(':websent', $this->websent);
		$stmt->bindparam(':typename', $this->typename);
		$stmt->bindparam(':invprice', $this->invprice);
		$stmt->bindparam(':invsale', $this->invsale);
		$stmt->bindparam(':invclub', $this->invclub);
		$stmt->bindparam(':tags', $this->tags);
		$stmt->bindparam(':esl', $this->esl);
		$stmt->bindparam(':lreg', $this->lreg);
		$stmt->bindparam(':lstore', $this->lstore);
		$stmt->bindparam(':isdel', $this->isdel);


		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmterror = $stmt->errorinfo();
			return $stmterror;
		}
	}
}

?>