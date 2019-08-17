<?php
class trabajadores{
	//DATA_EDIT
	private $db;
	public $table;
	public $Id;
	//TRABAJADORES_EDIT
	private $db1;
	public $table1;
	public $Id1;
	//TRABAJADORES_LIST
	private $db2;
	public $table2;
	public $Id2;
	//DATA_LIST
	private $db3;
	public $table3;
	public $Id3;
	//TRABAJADORES_CARGOS
	private $db4;
	public $table4;
	public $Id4;
	//TRABAJADORES_ESPECIALIDADES
	private $db5;
	public $table5;
	public $Id5;
		
	public function __construct(){
		include_once('class.bd_transsac.php');
		//DATA_EDIT
		$this->table = "data_entes";
		$this->tId = "cdata";
		$this->db = new database($this->table, $this->tId);
		$this->db->fields = array (
			array ('system',	"LPAD(".$this->tId."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'code'),
			array ('public',	'data'),
			array ('public',	'data2'),
			array ('public',	'nac'),
			array ('public',	'sexo'),
			array ('public',	'fecha'),
			array ('public',	'direccion'),
			array ('public',	'mail'),
			array ('public',	'tel_fijo'),
			array ('public',	'tel_movil'),
			array ('public',	'estado'),
			array ('public',	'ccomuna'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//TRABAJADORES_EDIT
		$this->table1 = "nom_trabajadores";
		$this->tId1 = "ctrabajador";
		$this->db1 = new database($this->table1, $this->tId1);
		$this->db1->fields = array (
			array ('system',	"LPAD(".$this->tId1."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'ccargo'),
			array ('public',	'cespecialidad'),
			array ('public',	'horas'),
			array ('public',	'status'),
			array ('public_i',	'cdata'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		
		//TRABAJADORES_LIST
		$this->table2 = "nom_trabajadores nt INNER JOIN data_entes d ON nt.cdata=d.cdata ";
		$this->table2 .= "LEFT JOIN data_comuna co ON d.ccomuna=co.ccomuna LEFT JOIN data_provincia pr ON co.cprovincia=pr.cprovincia ";
		$this->table2 .= "LEFT JOIN data_region r ON pr.cregion=r.cregion LEFT JOIN data_pais p ON r.cpais=p.cpais ";
		$this->table2 .= "LEFT JOIN nom_cargos nc USING (ccargo) LEFT JOIN nom_especialidad ne USING (cespecialidad) ";
		//AUDITORIA
		$this->table2 .= " LEFT JOIN adm_usuarios u1 ON nt.crea_user=u1.cusuario LEFT JOIN nom_trabajadores t1 ON u1.ctrabajador=t1.ctrabajador LEFT JOIN data_entes d1 ON t1.cdata=d1.cdata LEFT JOIN nom_cargos c1 ON t1.ccargo=c1.ccargo";
		$this->table2 .= " LEFT JOIN adm_usuarios u2 ON nt.mod_user=u2.cusuario LEFT JOIN nom_trabajadores t2 ON u2.ctrabajador=t2.ctrabajador LEFT JOIN data_entes d2 ON t2.cdata=d2.cdata LEFT JOIN nom_cargos c2 ON t2.ccargo=c2.ccargo";
		$this->tId2 = "nt.ctrabajador";
		$this->db2 = new database($this->table2, $this->tId2);
		$this->db2->fields = array (
			array ('system',	"LPAD(".$this->tId2."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(d.cdata*1,"._PAD_CEROS_.",'0') AS ente"),
			array ('system',	'd.code'),
			array ('system',	'd.code2'),
			array ('system',	'd.data'),
			array ('system',	'd.data2'),
			array ('system',	'd.nac'),
			array ('system',	'd.sexo'),
			array ('system',	'd.fecha'),
			array ('system',	'd.direccion'),
			array ('system',	'd.mail'),
			array ('system',	'd.tel_fijo'),
			array ('system',	'd.tel_movil'),
			array ('system',	'd.estado'),
			array ('system',	'co.comuna'),
			array ('system',	'pr.provincia'),
			array ('system',	'r.region'),
			array ('system',	'p.pais'),
			array ('system',	'co.ccomuna'),
			array ('system',	'pr.cprovincia'),
			array ('system',	'r.cregion'),
			array ('system',	'p.cpais'),
			array ('system',	'p.code AS cod_pais'),
			array ('system',	'nc.ccargo'),
			array ('system',	'nc.cargo'),
			array ('system',	'ne.cespecialidad'),
			array ('system',	'ne.especialidad'),
			array ('system',	'nt.horas'),
			array ('system',	'nt.status'),
			array ('system',	'DATE_FORMAT(nt.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(nt.mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	"(CASE WHEN nt.crea_user='METALSIGMAUSER' THEN nt.crea_user WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS crea_user"),
			array ('system',	"(CASE WHEN nt.mod_user='METALSIGMAUSER' THEN nt.mod_user WHEN u2.ctrabajador=0 THEN u2.nombres ELSE d2.data END) AS mod_user"),
			array ('system',	"IFNULL(c1.cargo, 'N/A') AS cargo_crea"),
			array ('system',	"IFNULL(c2.cargo, 'N/A') AS cargo_mod")
		);
		//DATA_LIST
		$this->table3 = "data_entes e LEFT JOIN data_comuna c ON e.ccomuna=c.ccomuna LEFT JOIN data_provincia pr ON c.cprovincia=pr.cprovincia ";
		$this->table3 .= "LEFT JOIN data_region r ON pr.cregion=r.cregion LEFT JOIN data_pais p ON r.cpais=p.cpais";
		$this->tId3 = "e.cdata";
		$this->db3 = new database($this->table3, $this->tId3);
		$this->db3->fields = array (
			array ('system',	"LPAD(".$this->tId3."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	'e.code'),
			array ('system',	'e.code2'),
			array ('system',	'e.data'),
			array ('system',	'e.data2'),
			array ('system',	'e.nac'),
			array ('system',	'e.sexo'),
			array ('system',	'DATE_FORMAT(e.fecha, "%d-%m-%Y") AS fecha'),
			array ('system',	'e.direccion'),
			array ('system',	'e.mail'),
			array ('system',	'e.tel_fijo'),
			array ('system',	'e.tel_movil'),
			array ('system',	'e.estado'),
			array ('system',	'c.ccomuna'),
			array ('system',	'c.comuna'),
			array ('system',	'pr.cprovincia'),
			array ('system',	'pr.provincia'),
			array ('system',	'r.cregion'),
			array ('system',	'r.region'),
			array ('system',	'p.cpais'),
			array ('system',	'p.pais'),
			array ('system',	"(SELECT IFNULL(ctrabajador, 0) FROM nom_trabajadores t1 WHERE t1.cdata=e.cdata) AS trabajador"),
			array ('system',	'DATE_FORMAT(e.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(e.mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	'e.crea_user'),
			array ('system',	'e.mod_user')
		);		
		//TRABAJADORES_CARGOS
		$this->table4 = "nom_cargos";
		$this->tId4 = "ccargo";
		$this->db4 = new database($this->table4, $this->tId4);
		$this->db4->fields = array (
			array ('system',	"LPAD(".$this->tId4."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'cargo'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//TRABAJADORES_ESPECIALIDADES
		$this->table5 = "nom_especialidad";
		$this->tId5 = "cespecialidad";
		$this->db5 = new database($this->table5, $this->tId5);
		$this->db5->fields = array (
			array ('system',	"LPAD(".$this->tId5."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'especialidad'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
	}
	/** DATA */
	//LISTAR
	public function list_(){
		return $this->db->getRecords();
	}
	//OBTIENER
	public function get_($id){
		$result=array();
		$result=$this->db->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//OBTIENER POR RUT
	public function get_rut($rut){
		$data = $result = array (); $count=-1;
		if($rut){
			$count++;
			$data[$count]["row"]="e.code";
			$data[$count]["operator"]="=";
			$data[$count]["value"]=$rut;
		}
		$result=$this->db3->getRecords(false,$data);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;	
	}
	/** TRABAJADORES */
	//LISTAR
	public function list_t($status=false,$cargo=false,$non=false){
		$data = $result = array (); $count=-1;
		if($status){
			$count++;
			$data[$count]["row"]="nt.status";
			$data[$count]["operator"]="=";
			$data[$count]["value"]=$status;
		}
		if($cargo){
			$count++;
			$data[$count]["row"]="nc.ccargo";
			$data[$count]["operator"]="IN";
			$data[$count]["value"]=$cargo;
		}
		if($non){
			$count++;
			$data[$count]["row"]="nt.ctrabajador";
			$data[$count]["operator"]="NOT IN";
			$data[$count]["value"]=$non;
		}
		return $this->db2->getRecords(false,$data);
	}
	//OBTENER
	public function get_trabajador($id){
		$data = $result = array (); $count=-1;
		if($id){
			$count++;
			$data[$count]["row"]="nt.ctrabajador";
			$data[$count]["operator"]="=";
			$data[$count]["value"]=$id;
		}
		$result = $this->db2->getRecords(false,$data);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_trabajador($persona,$trabajador){
		$response=array(); $id=0;
		$data[0]["row"]="e.code";
		$data[0]["operator"]="=";
		$data[0]["value"]=$persona[0];
		$result=$this->db3->getRecords(false,$data);
		if($result["title"]=="WARNING"){
			//INSERTO LA PERSONA
			$persona[]=$_SESSION['metalsigma_log'];
			$result=$this->db->insertRecord($persona);
			if($result["title"]=="SUCCESS"){
				$id=$result["id"];
			}
		}else if($result["title"]=="SUCCESS"){
			//RUT ENCONTRO
			$id = $result["content"]["codigo"];
		}
		//SI ARRIBA NO DIO ERROR PROCESO EL TRABAJADOR
		if($result["title"]=="SUCCESS"){
			$trabajador[] = $id;
			$trabajador[] = $_SESSION['metalsigma_log'];
			$result=$this->db1->insertRecord($trabajador);
			if($result["title"]=="SUCCESS"){
				$result["ente"]=$id_pers;
			}
		}
		$response = $result;
		return $response;
	}
	//ACTUALIZAR
	public function edit_trabajador($id_trab,$persona,$trabajador){
		$response=array(); $id_pers=0;
		//CONSULTO EL TRABAJADOR PARA OBTENER LA PERSONA
		$data[0]["row"]="nt.ctrabajador";
		$data[0]["operator"]="=";
		$data[0]["value"]=$id_trab;
		$result=$this->db2->getRecords(false,$data);
		if($result["title"]=="SUCCESS"){
			$id_pers=$result["content"][0]["ente"];
			$persona[]=$_SESSION['metalsigma_log'];
			//ACTUALIZO LA PERSONA
			$result=$this->db->updateRecord($id_pers,$persona);
			if($result["title"]=="SUCCESS"){
				$trabajador[]=$_SESSION['metalsigma_log'];
				//ACTUALIZO EL TRABAJADOR
				$result=$this->db1->updateRecord($id_trab,$trabajador);
				if($result["title"]=="SUCCESS"){
					$result["ente"]=$id_pers;
				}
			}
		}
		$response = $result;
		return $response;
	}
	/** CARGOS */
	//LISTAR
	public function list_car(){
		return $this->db4->getRecords();
	}
	//OBTENER
	public function get_car($id){
		$result=array();
		$result=$this->db4->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_car($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db4->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_car($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db4->updateRecord($id,$data);
	}
	/** ESPECIALIDADES */
	//LISTAR
	public function list_esp(){
		return $this->db5->getRecords();
	}
	//OBTENER
	public function get_esp($id){
		$result=array();
		$result=$this->db5->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_esp($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db5->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_esp($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db5->updateRecord($id,$data);
	}
}
?>