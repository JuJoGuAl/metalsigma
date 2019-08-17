<?php
class clientes{
	//DATA_EDIT
	private $db;
	public $table;
	public $Id;
	//CLIENTES_EDIT
	private $db1;
	public $table1;
	public $Id1;
	//SEGMENTOS
	private $db2;
	public $table2;
	public $Id2;
	//GIROS
	private $db3;
	public $table3;
	public $Id3;
	//CLIENTES_LIST
	private $db4;
	public $table4;
	public $Id4;
	//DATA_LIST
	private $db5;
	public $table5;
	public $Id5;
	//CLIENTES MAQS
	private $db6;
	public $table6;
	public $Id6;
	//CLI PAGOS
	private $db8;
	public $table8;
	public $Id8;
	//CLIENTES MAQS LIST
	private $db9;
	public $table9;
	public $Id9;
	//CLI MORAS_PAR
	private $db10;
	public $table10;
	public $Id10;
		
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
		//CLIENTES_EDIT
		$this->table1 = "cli_clientes";
		$this->tId1 = "ccliente";
		$this->db1 = new database($this->table1, $this->tId1);
		$this->db1->fields = array (
			array ('system',	"LPAD(".$this->tId1."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'csegmento'),
			array ('public',	'cgiro'),
			array ('public',	'contacto'),
			array ('public',	'cpago'),
			array ('public',	'credito'),
			array ('public',	'descu'),
			array ('public',	'mora_OC'),
			array ('public',	'mora_pago'),
			array ('public',	'notas'),
			array ('public',	'maqs'),
			array ('public',	'cat'),
			array ('public',	'kom'),
			array ('public',	'status'),
			array ('public_i',	'cdata'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//SEGMENTOS
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
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	"(segmento) AS nombre")
		);
		//GIROS
		$this->table3 = "cli_giros";
		$this->tId3 = "cgiro";
		$this->db3 = new database($this->table3, $this->tId3);
		$this->db3->fields = array (
			array ('system',	"LPAD(".$this->tId3."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'giro'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	"(giro) AS nombre"),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//CLIENTES_LIST
		$this->table4 = "cli_clientes c INNER JOIN data_entes d ON c.cdata=d.cdata LEFT JOIN eq_segmentos es ON c.csegmento=es.csegmento ";
		$this->table4 .= "LEFT JOIN cli_giros g ON c.cgiro=g.cgiro LEFT JOIN cli_pagos pa ON c.cpago=pa.cpago ";
		$this->table4 .= "LEFT JOIN data_comuna co ON d.ccomuna=co.ccomuna LEFT JOIN data_provincia pr ON co.cprovincia=pr.cprovincia ";
		$this->table4 .= "LEFT JOIN data_region r ON pr.cregion=r.cregion LEFT JOIN data_pais p ON r.cpais=p.cpais";
		//AUDITORIA
		$this->table4 .= " LEFT JOIN adm_usuarios u1 ON c.crea_user=u1.cusuario LEFT JOIN nom_trabajadores t1 ON u1.ctrabajador=t1.ctrabajador LEFT JOIN data_entes d1 ON t1.cdata=d1.cdata LEFT JOIN nom_cargos c1 ON t1.ccargo=c1.ccargo";
		$this->table4 .= " LEFT JOIN adm_usuarios u2 ON c.mod_user=u2.cusuario LEFT JOIN nom_trabajadores t2 ON u2.ctrabajador=t2.ctrabajador LEFT JOIN data_entes d2 ON t2.cdata=d2.cdata LEFT JOIN nom_cargos c2 ON t2.ccargo=c2.ccargo";

		$this->tId4 = "c.ccliente";
		$this->db4 = new database($this->table4, $this->tId4);
		$this->db4->fields = array (
			array ('system',	"LPAD(".$this->tId4."*1,"._PAD_CEROS_.",'0') AS codigo"),
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
			array ('system',	'c.csegmento'),
			array ('system',	'es.segmento'),
			array ('system',	'c.cgiro'),
			array ('system',	'g.giro'),
			array ('system',	'c.contacto'),
			array ('system',	'co.comuna'),
			array ('system',	'pr.provincia'),
			array ('system',	'r.region'),
			array ('system',	'p.pais'),
			array ('system',	'co.ccomuna'),
			array ('system',	'pr.cprovincia'),
			array ('system',	'r.cregion'),
			array ('system',	'p.cpais'),
			array ('system',	'c.cpago'),
			array ('system',	'pa.pago'),
			array ('system',	'c.credito'),
			array ('system',	'c.descu'),
			array ('system',	'c.mora_OC'),
			array ('system',	'c.mora_pago'),
			array ('system',	'c.notas'),
			array ('system',	'c.maqs'),
			array ('system',	'c.cat'),
			array ('system',	'c.kom'),
			array ('system',	'c.status'),
			array ('system',	'DATE_FORMAT(c.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(c.mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	"(CASE WHEN c.crea_user='METALSIGMAUSER' THEN c.crea_user WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS crea_user"),
			array ('system',	"(CASE WHEN c.mod_user='METALSIGMAUSER' THEN c.mod_user WHEN u2.ctrabajador=0 THEN u2.nombres ELSE d2.data END) AS mod_user")
		);
		//DATA_LIST
		$this->table5 = "data_entes e LEFT JOIN data_comuna c ON e.ccomuna=c.ccomuna LEFT JOIN data_provincia pr ON c.cprovincia=pr.cprovincia ";
		$this->table5 .= "LEFT JOIN data_region r ON pr.cregion=r.cregion LEFT JOIN data_pais p ON r.cpais=p.cpais";
		$this->tId5 = "e.cdata";
		$this->db5 = new database($this->table5, $this->tId5);
		$this->db5->fields = array (
			array ('system',	"LPAD(".$this->tId5."*1,"._PAD_CEROS_.",'0') AS codigo"),
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
			array ('system',	"(SELECT IFNULL(ccliente, 0) FROM cli_clientes t1 WHERE t1.cdata=e.cdata) AS cliente"),
		);
		//CLIENTES MAQS
		$this->table6 = "cli_maquinas";
		$this->tId6 = "cmaquina";
		$this->db6 = new database($this->table6, $this->tId6);
		$this->db6->fields = array (
			array ('system',	"LPAD(".$this->tId6."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(ccliente*1,"._PAD_CEROS_.",'0') AS codigo_cliente"),
			array ('system',	"LPAD(cequipo*1,"._PAD_CEROS_.",'0') AS codigo_equipo"),
			array ('public',	'ccliente'),
			array ('public',	'cmaquina'),
			array ('public',	'cequipo'),
			array ('public',	'serial'),
			array ('public',	'interno'),
			array ('public',	'status'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//CLI PAGOS
		$this->table8 = "cli_pagos";
		$this->tId8 = "cpago";
		$this->db8 = new database($this->table8, $this->tId8);
		$this->db8->fields = array (
			array ('system',	"LPAD(".$this->tId8."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"(pago) AS nombre"),
			array ('public',	'pago'),
			array ('public',	'gastos'),
			array ('public',	'margen'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//CLIENTES MAQS LIST
		$this->table9 = "cli_maquinas cm INNER JOIN eq_equipos eq ON cm.cequipo=eq.cequipo ";
		$this->table9 .= "INNER JOIN eq_marcas em ON eq.cmarca= em.cmarca ";
		$this->table9 .= "INNER JOIN eq_segmentos es ON eq.csegmento= es.csegmento ";
		$this->tId9 = "cm.cmaquina";
		$this->db9 = new database($this->table9, $this->tId9);
		$this->db9->fields = array (
			array ('system',	"LPAD(".$this->tId9."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(cm.ccliente*1,"._PAD_CEROS_.",'0') AS codigo_cliente"),
			array ('system',	"LPAD(cm.cequipo*1,"._PAD_CEROS_.",'0') AS codigo_equipo"),
			array ('system',	"LPAD(em.cmarca*1,"._PAD_CEROS_.",'0') AS codigo_marca"),
			array ('system',	"LPAD(es.csegmento*1,"._PAD_CEROS_.",'0') AS codigo_segmento"),
			array ('system',	'eq.equipo'),
			array ('system',	'eq.modelo'),
			array ('system',	'em.marca'),
			array ('system',	'es.segmento'),
			array ('system',	'cm.serial'),
			array ('system',	'cm.interno'),
			array ('system',	'cm.status')
		);
		//CLI MORAS_PAR
		$this->table10 = "adm_parametro";
		$this->tId10 = "cparametro";
		$this->db10 = new database($this->table10, $this->tId10);
		$this->db10->fields = array (
			array ('system',	"LPAD(".$this->tId10."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	'parametro'),
			array ('public_u',	'valor'),
			array ('public_u',	'mod_user')
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
		$result=$this->db5->getRecords(false,$data);
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
	/** CLIENTES */
	//LISTAR
	public function list_c($status=false){
		$data = array (); $count=-1;
		if($status){
			$count++;
			$data[$count]["row"]="c.status";
			$data[$count]["operator"]="=";
			$data[$count]["value"]=$status;
		}
		return $this->db4->getRecords(false,$data);
	}
	//OBTENER
	public function get_cliente($id){
		$data = $result = array (); $count=-1;
		if($id){
			$count++;
			$data[$count]["row"]="ccliente";
			$data[$count]["operator"]="=";
			$data[$count]["value"]=$id;
		}
		$resultado = $this->db4->getRecords(false,$data);
		if($resultado["title"]=="SUCCESS"){
			$cab=$resultado["content"][0];
			$result = $this->db9->getRecords(false,$data);
			if($result["title"]=="SUCCESS"){
				$resultado["title"]="SUCCESS";
				$resultado["cab"]=$cab;
				$resultado["det"]=$result["content"];
			}else{
				$resultado["title"]="SUCCESS";
				$resultado["cab"]=$cab;
				$resultado["det"]=NULL;
			}
		}
		return $resultado;
	}
	//CREAR
	public function new_cliente($persona,$cliente,$maquinas){
		$response=array(); $id=0;
		$data[0]["row"]="e.code";
		$data[0]["operator"]="=";
		$data[0]["value"]=$persona[0];
		$result=$this->db5->getRecords(false,$data);
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
		//SI ARRIBA NO DIO ERROR PROCESO EL CLIENTE
		if($result["title"]=="SUCCESS"){
			$cliente[] = $id;
			$cliente[] = $_SESSION['metalsigma_log'];
			$result=$this->db1->insertRecord($cliente);
			if($result["title"]=="SUCCESS"){
				$result["ente"]=$id;
				if(!empty($maquinas[0])){
					for ($i=0; $i<sizeof($maquinas[0]); $i++){
						$datos=array();
						array_push($datos, $result["id"]);
						array_push($datos, $maquinas[0][$i]);
						array_push($datos, $maquinas[1][$i]);
						array_push($datos, $maquinas[2][$i]);
						array_push($datos, $maquinas[3][$i]);
						array_push($datos, $maquinas[4][$i]);
						array_push($datos, $_SESSION['metalsigma_log']);
						$result = $this->db6->insertRecord($datos);
						if($result["title"]!="SUCCESS"){
							$data = array ();
							$data[0]["row"]="ccliente";
							$data[0]["operator"]="=";
							$data[0]["value"]=$id;
							$this->db1->deleteRecord($id);
							$this->db6->deleteRecords($data);
							break;
						}
					}
				}
			}
		}
		$response = $result;
		return $response;
	}
	//ACTUALIZAR
	public function edit_cliente($id_cliente,$persona,$cliente,$maquinas){
		$response=array(); $id_pers=0;
		//CONSULTO EL CLIENTE PARA OBTENER LA PERSONA
		$data[0]["row"]="c.ccliente";
		$data[0]["operator"]="=";
		$data[0]["value"]=$id_cliente;
		$result=$this->db4->getRecords(false,$data);
		if($result["title"]=="SUCCESS"){
			$id_pers=$result["content"][0]["ente"];
			$persona[]=$_SESSION['metalsigma_log'];
			//ACTUALIZO LA PERSONA
			$result=$this->db->updateRecord($id_pers,$persona);
			if($result["title"]=="SUCCESS"){
				$cliente[]=$_SESSION['metalsigma_log'];
				//ACTUALIZO EL CLIENTE
				$result=$this->db1->updateRecord($id_cliente,$cliente);
				if($result["title"]=="SUCCESS"){
					if(!empty($maquinas[0])){
						for ($i=0; $i<sizeof($maquinas[0]); $i++){
							$datos=array();
							//PARA CONTROLAR EL UPSERT SI PASO 0 (NUEVO) LO DEJO VACIO, DE LO CONTRARIO CONSERVO EL ID
							$new_id = ($maquinas[0][$i]==0) ? "" : $maquinas[0][$i] ;
							array_push($datos, $id_cliente);
							array_push($datos, $new_id);
							array_push($datos, $maquinas[1][$i]);
							array_push($datos, $maquinas[2][$i]);
							array_push($datos, $maquinas[3][$i]);
							array_push($datos, $maquinas[4][$i]);
							array_push($datos, $_SESSION['metalsigma_log']);
							$result = $this->db6->upsertRecord($datos);
							if($result["title"]!="SUCCESS"){
								$data = array ();
								$data[0]["row"]="ccliente";
								$data[0]["operator"]="=";
								$data[0]["value"]=$id;
								$this->db6->deleteRecords($data);
								break;
							}
						}
					}
				}
			}
		}
		$response = $result;
		return $response;
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
	/** GIROS */
	//LISTAR
	public function list_g(){
		return $this->db3->getRecords();
	}
	//OBTENER
	public function get_g($id){
		$result=array();
		$result=$this->db3->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_g($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db3->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_g($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db3->updateRecord($id,$data);
	}
	/** PAGOS */
	//LISTAR
	public function list_pag(){
		return $this->db8->getRecords();
	}
	//OBTENER
	public function get_pag($id){
		$result=array();
		$result=$this->db8->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_pag($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db8->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_pag($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db8->updateRecord($id,$data);
	}
	/** MAQUINAS CLIENTES */
	//LISTAR
	public function list_m($cliente=false){
		$data = array ();
		$data[0]["row"]="ccliente";
		$data[0]["operator"]="=";
		$data[0]["value"]=$ccliente;
		$filtro = ($ccliente) ? $data : "" ;
		return $this->db6->getRecords(false,$filtro);
	}
	//OBTIENER
	public function get_m($id){
		$result=array();
		$result=$this->db9->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_m($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db6->insertRecord($data);
	}
	/** MORAS PAR */
	//LISTAR
	public function list_mor(){
		$data = array ();
		$data[0]["row"]="cparametro";
		$data[0]["operator"]=">";
		$data[0]["value"]=10;
		$data[1]["row"]="cparametro";
		$data[1]["operator"]="<";
		$data[1]["value"]=15;
		return $this->db10->getRecords(false,$data);
	}
	//OBTENER
	public function get_mor($id){
		$result=array();
		$result=$this->db10->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//ACTUALIZAR
	public function edit_mor($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db10->updateRecord($id,$data);
	}
}
?>