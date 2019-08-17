<?php
class paradm{	
	//VALOR_HH LIST
	private $db;
	public $table;
	public $Id;
	//VALOR_HH
	private $db1;
	public $table1;
	public $Id1;
	//LUGAR
	private $db2;
	public $table2;
	public $Id2;
	//EQUIPO
	private $db3;
	public $table3;
	public $Id3;
	//ARRIENDO
	private $db4;
	public $table4;
	public $Id4;
	//VEHICULOS
	private $db5;
	public $table5;
	public $Id5;
	public function __construct(){
		include_once('class.bd_transsac.php');
		//VALOR_HH LIST
		$this->table = "par_valor_hh vh INNER JOIN par_eq_trabajo et ON vh.cequipotrab=et.cequipo ";
		$this->table .= "INNER JOIN par_lugar l ON vh.clugar=l.clugar ";
		$this->table .= "INNER JOIN eq_segmentos es ON vh.csegmento=es.csegmento";
		//AUDITORIA
		$this->table .= " LEFT JOIN adm_usuarios u1 ON vh.crea_user=u1.cusuario LEFT JOIN nom_trabajadores t1 ON u1.ctrabajador=t1.ctrabajador LEFT JOIN data_entes d1 ON t1.cdata=d1.cdata LEFT JOIN nom_cargos c1 ON t1.ccargo=c1.ccargo";
		$this->table .= " LEFT JOIN adm_usuarios u2 ON vh.mod_user=u2.cusuario LEFT JOIN nom_trabajadores t2 ON u2.ctrabajador=t2.ctrabajador LEFT JOIN data_entes d2 ON t2.cdata=d2.cdata LEFT JOIN nom_cargos c2 ON t2.ccargo=c2.ccargo";
		$this->tId = "vh.chora";
		$this->db = new database($this->table, $this->tId);
		$this->db->fields = array (
			array ('system',	"LPAD(".$this->tId."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	'vh.csegmento'),
			array ('system',	'es.segmento'),
			array ('system',	'vh.clugar'),
			array ('system',	'l.lugar'),
			array ('system',	'vh.cequipotrab'),
			array ('system',	'et.equipo'),
			array ('system',	'et.trabs'),
			array ('system',	'vh.costo_hh_normal'),
			array ('system',	'vh.mar_normal'),
			array ('system',	'vh.mar_extra'),
			array ('system',	"(CASE WHEN vh.crea_user='METALSIGMAUSER' THEN vh.crea_user WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS crea_user"),
			array ('system',	"(CASE WHEN vh.mod_user='METALSIGMAUSER' THEN vh.mod_user WHEN u2.ctrabajador=0 THEN u2.nombres ELSE d2.data END) AS mod_user"),
			array ('system',	"IFNULL(c1.cargo, 'N/A') AS cargo_crea"),
			array ('system',	"IFNULL(c2.cargo, 'N/A') AS cargo_mod"),
			array ('system',	'DATE_FORMAT(vh.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(vh.mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		$this->table1 = "par_valor_hh";
		$this->tId1 = "chora";
		$this->db1 = new database($this->table1, $this->tId1);
		$this->db1->fields = array (
			array ('system',	"LPAD(".$this->tId1."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'csegmento'),
			array ('public',	'clugar'),
			array ('public',	'cequipotrab'),
			array ('public',	'costo_hh_normal'),
			array ('public',	'mar_normal'),
			array ('public',	'mar_extra'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		$this->table2 = "par_lugar";
		$this->tId2 = "clugar";
		$this->db2 = new database($this->table2, $this->tId2);
		$this->db2->fields = array (
			array ('system',	"LPAD(".$this->tId2."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'lugar'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		$this->table3 = "par_eq_trabajo";
		$this->tId3 = "cequipo";
		$this->db3 = new database($this->table3, $this->tId3);
		$this->db3->fields = array (
			array ('system',	"LPAD(".$this->tId3."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'equipo'),
			array ('public',	'trabs'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		$this->table4 = "par_arriendo_taller";
		$this->tId4 = "carriendot";
		$this->db4 = new database($this->table4, $this->tId4);
		$this->db4->fields = array (
			array ('system',	"LPAD(".$this->tId4."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	'(SELECT es.segmento FROM eq_segmentos es WHERE es.csegmento=par_arriendo_taller.csegmento) AS segmento'),
			array ('public',	'csegmento'),
			array ('public',	'espacio'),
			array ('public',	'mar_uf'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		$this->table5 = "par_vehiculos";
		$this->tId5 = "cvehiculo";
		$this->db5 = new database($this->table5, $this->tId5);
		$this->db5->fields = array (
			array ('system',	"LPAD(".$this->tId5."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'vehiculo'),
			array ('public',	'salida'),
			array ('public',	'costo_km'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
	}
	/** VALOR_HH */
	//LISTAR
	public function list_(){
		return $this->db->getRecords();
	}
	public function list_vh($seg=false,$equipo=false,$lugar=false){
		$data = array (); $cont=-1;
		if($seg){
			$cont++;
			$data[$cont]["row"]="vh.csegmento";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$seg;
		}
		if($equipo){
			$cont++;
			$data[$cont]["row"]="vh.cequipotrab";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$equipo;
		}
		if($lugar){
			$cont++;
			$data[$cont]["row"]="vh.clugar";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$lugar;
		}
		return $this->db->getRecords("SUM(CASE WHEN vh.clugar = 1 THEN ROUND(((vh.costo_hh_normal*vh.mar_normal)/100)+vh.costo_hh_normal,0) ELSE 0 END) hh_normal_taller,
		SUM(CASE WHEN vh.clugar = 2 THEN ROUND(((vh.costo_hh_normal*vh.mar_normal)/100)+vh.costo_hh_normal,0) ELSE 0 END) hh_normal_terreno",$data);
	}
	//OBTENER
	public function get_($id){
		$result=array();
		$result=$this->db->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db1->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db1->updateRecord($id,$data);
	}
	/** LUGAR */
	//LISTAR
	public function list_l(){
		return $this->db2->getRecords();
	}
	//OBTENER
	public function get_l($id){
		$result=array();
		$result=$this->db2->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_l($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db2->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_l($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db2->updateRecord($id,$data);
	}
	/** EQUIPO */
	//LISTAR
	public function list_e(){
		return $this->db3->getRecords();
	}
	//OBTENER
	public function get_e($id){
		$result=array();
		$result=$this->db3->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_e($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db3->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_e($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db3->updateRecord($id,$data);
	}
	/** ARRIENDO */
	//LISTAR
	public function list_a($seg=false){
		$data[0]["row"]="csegmento";
		$data[0]["operator"]="=";
		$data[0]["value"]=$seg;
		$filtro = ($seg) ? $data : "" ;
		return $this->db4->getRecords(false,$filtro);
	}
	//OBTENER
	public function get_a($id){
		$result=array();
		$result=$this->db4->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_a($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db4->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_a($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db4->updateRecord($id,$data);
	}
	/** VEHICULO */
	//LISTAR
	public function list_v(){
		return $this->db5->getRecords();
	}
	//OBTENER
	public function get_v($id){
		$result=array();
		$result=$this->db5->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_v($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db5->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_v($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db5->updateRecord($id,$data);
	}
}
?>