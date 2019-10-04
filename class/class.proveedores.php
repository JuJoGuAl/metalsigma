<?php
class proveedores{
	//DATA_EDIT
	private $db;
	public $table;
	public $Id;
	//PROVEEDORES_EDIT
	private $db1;
	public $table1;
	public $Id1;
	//PROVEEDORES_LIST
	private $db2;
	public $table2;
	public $Id2;
	//DATA_LIST
	private $db3;
	public $table3;
	public $Id3;
	//PRO_PAGOS
	private $db4;
	public $table4;
	public $Id4;	
		
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
		//PROVEEDORES_EDIT
		$this->table1 = "pro_proveedores";
		$this->tId1 = "cproveedor";
		$this->db1 = new database($this->table1, $this->tId1);
		$this->db1->fields = array (
			array ('system',	"LPAD(".$this->tId1."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'cpago'),			
			array ('public',	'status'),
			array ('public_i',	'cdata'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		
		//PROVEEDORES_LIST
		$this->table2 = "pro_proveedores pro INNER JOIN data_entes d ON pro.cdata=d.cdata LEFT JOIN cli_pagos pa ON pro.cpago=pa.cpago ";
		$this->table2 .= "LEFT JOIN data_comuna co ON d.ccomuna=co.ccomuna LEFT JOIN data_provincia pr ON co.cprovincia=pr.cprovincia ";
		$this->table2 .= "LEFT JOIN data_region r ON pr.cregion=r.cregion LEFT JOIN data_pais p ON r.cpais=p.cpais";
		//AUDITORIA
		$this->table2 .= " LEFT JOIN adm_usuarios u1 ON pro.crea_user=u1.cusuario LEFT JOIN nom_trabajadores t1 ON u1.ctrabajador=t1.ctrabajador LEFT JOIN data_entes d1 ON t1.cdata=d1.cdata LEFT JOIN nom_cargos c1 ON t1.ccargo=c1.ccargo";
		$this->table2 .= " LEFT JOIN adm_usuarios u2 ON pro.mod_user=u2.cusuario LEFT JOIN nom_trabajadores t2 ON u2.ctrabajador=t2.ctrabajador LEFT JOIN data_entes d2 ON t2.cdata=d2.cdata LEFT JOIN nom_cargos c2 ON t2.ccargo=c2.ccargo";
		//ODC
		$this->table2 .= " LEFT JOIN com_odc oc ON pro.cproveedor=oc.cproveedor AND oc.status IN ('PRO','UTI') LEFT JOIN com_odc_det ocd USING(corden)";
		$this->table2 .= " LEFT JOIN inv_articulos art USING (carticulo) LEFT JOIN inv_clasificacion ic USING (cclasificacion)";
		//INV_MOV
		$this->table2 .= " LEFT JOIN inv_movimientos im ON pro.cproveedor=im.cproveedor AND im.status='PRO' AND im.tipo='NTE' AND im.corigen=0";
		$this->tId2 = "pro.cproveedor";
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
			array ('system',	'pro.cpago'),
			array ('system',	'pa.pago'),			
			array ('system',	'pro.status'),
			array ('system',	'SUM(ocd.cant_rest) AS pendientes'),
			array ('system',	'SUM(im.cmovimiento_key) AS movimientos'),
			array ('system',	'DATE_FORMAT(pro.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(pro.mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	"(CASE WHEN pro.crea_user='METALSIGMAUSER' THEN pro.crea_user WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS crea_user"),
			array ('system',	"(CASE WHEN pro.mod_user='METALSIGMAUSER' THEN pro.mod_user WHEN u2.ctrabajador=0 THEN u2.nombres ELSE d2.data END) AS mod_user"),
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
			array ('system',	"(SELECT IFNULL(cproveedor, 0) FROM pro_proveedores t1 WHERE t1.cdata=e.cdata) AS proveedor"),
		);		
		//PRO_PAGOS
		$this->table4 = "cli_pagos";
		$this->tId4 = "cpago";
		$this->db4 = new database($this->table4, $this->tId4);
		$this->db4->fields = array (
			array ('system',	"LPAD(".$this->tId4."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"(pago) AS nombre"),
			array ('public',	'pago'),
			array ('public',	'gastos'),
			array ('public',	'margen'),
			array ('public_i',	'crea_user'),
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
		$result=$this->db3->getRecords(false,$data);
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
	/** PROVEEDORES */
	//LISTAR
	public function list_p($status=false,$withODC=false,$withmov=false){
		$data = array (); $count=-1;
		if($status){
			$count++;
			$data[$count]["row"]="pro.status";
			$data[$count]["operator"]="=";
			$data[$count]["value"]=$status;
		}
		if($withODC){
			$count++;
			$data[$count]["row"]="ic.articulo";
			$data[$count]["operator"]="=";
			$data[$count]["value"]=1;
		}
		$having = ($withODC) ? "pendientes > 0" : false ;
		$having .= ($withODC && $withmov) ? " OR " : false ;
		$having .= ($withmov) ? "movimientos > 0" : false ;
		return $this->db2->getRecords(false,$data,"pro.cproveedor",false,$having);
	}
	//OBTENER
	public function get_proveedor($id){
		$data = $result = array (); $count=-1;
		if($id){
			$count++;
			$data[$count]["row"]="cproveedor";
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
	public function new_proveedor($persona,$proveedor){
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
		//SI ARRIBA NO DIO ERROR PROCESO EL PROVEEDOR
		if($result["title"]=="SUCCESS"){
			$proveedor[] = $id;
			$proveedor[] = $_SESSION['metalsigma_log'];
			$result=$this->db1->insertRecord($proveedor);
		}
		$response = $result;
		return $response;
	}
	//ACTUALIZAR
	public function edit_proveedor($id_prov,$persona,$proveedor){
		$response=array(); $id_pers=0;
		//CONSULTO EL PROVEEDOR PARA OBTENER LA PERSONA
		$data[0]["row"]="pro.cproveedor";
		$data[0]["operator"]="=";
		$data[0]["value"]=$id_prov;
		$result=$this->db2->getRecords(false,$data);
		if($result["title"]=="SUCCESS"){
			$id_pers=$result["content"][0]["ente"];
			$persona[]=$_SESSION['metalsigma_log'];
			//ACTUALIZO LA PERSONA
			$result=$this->db->updateRecord($id_pers,$persona);
			if($result["title"]=="SUCCESS"){
				$proveedor[]=$_SESSION['metalsigma_log'];
				//ACTUALIZO EL PROVEEDOR
				$result=$this->db1->updateRecord($id_prov,$proveedor);
			}
		}
		$response = $result;
		return $response;
	}
	/** PAGOS */
	//LISTAR
	public function list_pag(){
		return $this->db4->getRecords();
	}
	//OBTENER
	public function get_pag($id){
		$result=array();
		$result=$this->db4->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_pag($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db4->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_pag($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db4->updateRecord($id,$data);
	}
}
?>