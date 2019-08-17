<?php
class zonas{
	//PAIS
	private $db;
	public $table;
	public $Id;
	//REGION
	private $db1;
	public $table1;
	public $Id1;
	//PROVINCIA
	private $db2;
	public $table2;
	public $Id2;
	//COMUNA
	private $db3;
	public $table3;
	public $Id3;
	public function __construct(){
		include_once('class.bd_transsac.php');
		//PAIS
		$this->table = "data_pais";
		$this->tId = "cpais";
		$this->db = new database($this->table, $this->tId);
		$this->db->fields = array (
			array ('system',	"LPAD(".$this->tId."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'pais'),
			array ('public',	'code'),
			array ('system',	"(pais) AS nombre")
		);
		//REGION
		$this->table1 = "data_region";
		$this->tId1 = "cregion";
		$this->db1 = new database($this->table1, $this->tId1);
		$this->db1->fields = array (
			array ('system',	"LPAD(".$this->tId1."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'region'),
			array ('public',	'cpais'),
			array ('system',	"(region) AS nombre")
		);
		//PROVINCIA
		$this->table2 = "data_provincia";
		$this->tId2 = "cprovincia";
		$this->db2 = new database($this->table2, $this->tId2);
		$this->db2->fields = array (
			array ('system',	"LPAD(".$this->tId2."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'provincia'),
			array ('public',	'cregion'),
			array ('system',	"(provincia) AS nombre")
		);
		//COMUNA
		$this->table3 = "data_comuna";
		$this->tId3 = "ccomuna";
		$this->db3 = new database($this->table3, $this->tId3);
		$this->db3->fields = array (
			array ('system',	"LPAD(".$this->tId3."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'comuna'),
			array ('public',	'cprovincia'),
			array ('system',	"(comuna) AS nombre")
		);
	}
	//LISTAR PAIS
	public function list_p(){
		return $this->db->getRecords();
	}
	//LISTAR REGION
	public function list_r($fil){
		$data = array ();
		$data[0]["row"]="cpais";
		$data[0]["operator"]="=";
		$data[0]["value"]=$fil;
		$fwhere = ($fil) ? $data : "" ;
		return $this->db1->getRecords(false,$fwhere);
	}
	//LISTAR PROVINCIA
	public function list_pr($fil){
		$data = array ();
		$data[0]["row"]="cregion";
		$data[0]["operator"]="=";
		$data[0]["value"]=$fil;
		$fwhere = ($fil) ? $data : "" ;
		return $this->db2->getRecords(false,$fwhere);
	}
	//LISTAR COMUNA
	public function list_c($fil){
		$data = array ();
		$data[0]["row"]="cprovincia";
		$data[0]["operator"]="=";
		$data[0]["value"]=$fil;
		$fwhere = ($fil) ? $data : "" ;
		return $this->db3->getRecords(false,$fwhere);
	}
}
?>