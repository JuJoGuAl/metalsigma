<?php
class equipos{	
	//EQUIPOS
	private $db;
	public $table;
	public $Id;
	//MARCA
	private $db1;
	public $table1;
	public $Id1;
	//SEGMENTO
	private $db2;
	public $table2;
	public $Id2;
	//EQUIPOS FULL
	private $db3;
	public $table3;
	public $Id3;
	//PARTES
	private $db4;
	public $table4;
	public $Id4;
	//PIEZAS
	private $db5;
	public $table5;
	public $Id5;
	//EQUIPOS CLIENTE
	private $db6;
	public $table6;
	public $Id6;
	public function __construct(){
		include_once('class.bd_transsac.php');
		//EQUIPOS
		$this->table = "eq_equipos";
		$this->tId = "cequipo";
		$this->db = new database($this->table, $this->tId);
		$this->db->fields = array (
			array ('system',	"LPAD(".$this->tId."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'equipo'),
			array ('public',	'cmarca'),
			array ('public',	'modelo'),
			array ('public',	'csegmento'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//MARCA
		$this->table1 = "eq_marcas";
		$this->tId1 = "cmarca";
		$this->db1 = new database($this->table1, $this->tId1);
		$this->db1->fields = array (
			array ('system',	"LPAD(".$this->tId1."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'marca'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	"(marca) AS nombre")
		);
		//SEGMENTO
		$this->table2 = "eq_segmentos";
		$this->tId2 = "csegmento";
		$this->db2 = new database($this->table2, $this->tId2);
		$this->db2->fields = array (
			array ('system',	"LPAD(".$this->tId2."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'segmento'),
			array ('public',	'mar_ins'),
			array ('public',	'mar_rep'),
			array ('public',	'mar_stt'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//EQUIPOS FULL
		$this->table3 = "eq_equipos e INNER JOIN eq_marcas m ON e.cmarca=m.cmarca INNER JOIN eq_segmentos s ON e.csegmento=s.csegmento";
		$this->tId3 = "e.cequipo";
		$this->db3 = new database($this->table3, $this->tId3);
		$this->db3->fields = array (
			array ('system',	"LPAD(".$this->tId3."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	'e.equipo'),
			array ('system',	'e.cmarca'),
			array ('system',	'm.marca'),
			array ('system',	'e.modelo'),
			array ('system',	'e.csegmento'),
			array ('system',	's.segmento'),
			array ('system',	'DATE_FORMAT(e.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(e.mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	'e.crea_user'),
			array ('system',	'e.mod_user')
		);
		//PARTES
		$this->table4 = "eq_partes";
		$this->tId4 = "cparte";
		$this->db4 = new database($this->table4, $this->tId4);
		$this->db4->fields = array (
			array ('system',	"LPAD(".$this->tId4."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"(parte) AS nombre"),
			array ('public',	'code'),
			array ('public',	'parte'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//PIEZAS
		$this->table5 = "eq_piezas";
		$this->tId5 = "cpieza";
		$this->db5 = new database($this->table5, $this->tId5);
		$this->db5->fields = array (
			array ('system',	"LPAD(".$this->tId5."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"(SELECT parte FROM eq_partes p WHERE p.cparte=eq_piezas.cparte) as parte"),			
			array ('public',	'code'),
			array ('public',	'pieza'),
			array ('public',	'cparte'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//EQUIPOS CLIENTE
		$this->table6 = "eq_equipos e INNER JOIN cli_maquinas cm ON e.cequipo=cm.cequipo INNER JOIN eq_marcas m ON e.cmarca=m.cmarca INNER JOIN eq_segmentos s ON e.csegmento=s.csegmento";
		$this->tId6 = "cm.cmaquina";
		$this->db6 = new database($this->table6, $this->tId6);
		$this->db6->fields = array (
			array ('system',	"LPAD(".$this->tId6."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	'e.equipo'),
			array ('system',	'e.cequipo'),
			array ('system',	'e.cmarca'),
			array ('system',	'm.marca'),
			array ('system',	'e.modelo'),
			array ('system',	'e.csegmento'),
			array ('system',	's.segmento'),
			array ('system',	'cm.serial'),
			array ('system',	'cm.interno'),
			array ('system',	'cm.status')
		);
	}
	/** EQUIPOS */
	//LISTAR
	public function list_($not=false){
		return $this->db3->getRecords();
	}
	//OBTENER
	public function get_($id){
		$result=array();
		$result=$this->db3->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db->updateRecord($id,$data);
	}
	/** MARCAS */
	//LISTAR
	public function list_m(){
		return $this->db1->getRecords();
	}
	//OBTENER
	public function get_m($id){
		$result=array();
		$result=$this->db1->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_m($data){
		return $this->db1->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_m($id,$data){
		return $this->db1->updateRecord($id,$data);
	}
	/** SEGMENTOS */
	//LISTAR
	public function list_s(){
		return $this->db2->getRecords();
	}
	//OBTENER
	public function get_s($id){
		$result=array();
		$result=$this->db2->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_s($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db2->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_s($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db2->updateRecord($id,$data);
	}
	/** PARTES */
	//LISTAR
	public function list_pa($fil=false){
		$data = array (); $count=-1;
		if($fil){
			$count++;
			$data[$count]["row"]="cequipo";
			$data[$count]["operator"]="=";
			$data[$count]["value"]=$fil;
		}
		return $this->db4->getRecords(false,$data);
	}
	//OBTENER
	public function get_pa($id){
		$result=array();
		$result=$this->db4->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_pa($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db4->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_pa($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db4->updateRecord($id,$data);
	}
	/** PIEZAS */
	//LISTAR
	public function list_pi($fil=false){
		$data = array (); $count=-1;
		if($fil){
			$count++;
			$data[$count]["row"]="cparte";
			$data[$count]["operator"]="=";
			$data[$count]["value"]=$fil;
		}
		return $this->db5->getRecords(false,$data);
	}
	//OBTENER
	public function get_pi($id){
		$result=array();
		$result=$this->db5->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_pi($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db5->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_pi($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db5->updateRecord($id,$data);
	}
	/** EQUIPOS CLIENTES */
	//LISTAR
	public function list_eq($cli=false,$active=false){
		$data = array (); $count=-1;
		if($cli){
			$count++;
			$data[$count]["row"]="cm.ccliente";
			$data[$count]["operator"]="=";
			$data[$count]["value"]=$cli;
		}
		if($active){
			$count++;
			$data[$count]["row"]="cm.status";
			$data[$count]["operator"]="=";
			$data[$count]["value"]=$active;
		}
		return $this->db6->getRecords(false,$data);
	}
	//OBTENER
	public function get_eq($id){
		$result=array();
		$result=$this->db6->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
}
?>