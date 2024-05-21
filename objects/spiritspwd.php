<?php
class spiritspwd{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readPwd($getevent){
		$query = "select * from pwd where pwd.event = $getevent and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedPwd($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from pwd where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getPwd($getevent,$records_per_page){
			$query = "select * from pwd where isdel = 0";
			$stmt = $this->conn->prepare($query); 	
			$stmt->execute();
		return $stmt;
	}

	function updatePwd(){
		$query = "INSERT INTO pwd (class,event,ask_level,do_level,question,scoptosale,who,parent,`key`,image,descript,editable,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:class,:event,:ask_level,:do_level,:question,:scoptosale,:who,:parent,:key,:image,:descript,:editable,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		class = :class,
		ask_level = :ask_level,
		do_level = :do_level,
		question = :question,
		scoptosale = :scoptosale,
		who = :who,
		parent = :parent,
		`key` = :key,
		image = :image,
		descript = :descript,
		editable = :editable,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->class=strip_tags($this->class);
		$this->event=strip_tags($this->event);
		$this->ask_level=strip_tags($this->ask_level);
		$this->do_level=strip_tags($this->do_level);
		$this->question=strip_tags($this->question);
		$this->scoptosale=strip_tags($this->scoptosale);
		$this->who=strip_tags($this->who);
		$this->parent=strip_tags($this->parent);
		$this->key=strip_tags($this->key);
		$this->image=strip_tags($this->image);
		$this->descript=strip_tags($this->descript);
		$this->editable=strip_tags($this->editable);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':class', $this->class);
		$stmt->bindParam(':event', $this->event);
		$stmt->bindParam(':ask_level', $this->ask_level);
		$stmt->bindParam(':do_level', $this->do_level);
		$stmt->bindParam(':question', $this->question);
		$stmt->bindParam(':scoptosale', $this->scoptosale);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':parent', $this->parent);
		$stmt->bindParam(':key', $this->key);
		$stmt->bindParam(':image', $this->image);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':editable', $this->editable);
		$stmt->bindParam(':sent', $this->sent);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':isdel', $this->isdel);


		if($stmt->execute()){	
			return 'OK';
		}else{
			$stmtError = $stmt->errorInfo();
		return $stmtError;
		}
	}
}
		
?>
