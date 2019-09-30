<?php
class planificaciones{	
	//PLANIFICACIONES_EDIT
	private $db;
	public $table;
	public $Id;
	//PLANIFICACIONES_DET_EDIT
	private $db1;
	public $table1;
	public $Id1;
	//PLANIFICACIONES
	private $db2;
	public $table2;
	public $Id2;
	//PLANIFICACIONES_CON_TRABAJADORES
	private $db3;
	public $table3;
	public $Id3;
	//PARA CONTROLAR
	public $campos;
	//PLANIFICACIONES_INACTIVAR
	private $db4;
	public $table4;
	public $Id4;
	public function __construct(){
		include_once('class.bd_transsac.php');
		$this->table = "co_planificacion";
		$this->tId = "cplanificacion";
		$this->db = new database($this->table, $this->tId);
		$this->db->fields = array (
			array ('system',	"LPAD(".$this->tId."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"(cordenservicio_sub) AS codigo_ods_calendar"),
			array ('public',	'cordenservicio_sub'),
			array ('public',	'finicio'),
			array ('public',	'ffin'),
			array ('public',	'adi'),
			array ('public',	'notas'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		$this->table1 = "co_planificacion_det";
		$this->tId1 = "cplanificacion_det";
		$this->db1 = new database($this->table1, $this->tId1);
		$this->db1->fields = array (
			array ('system',	"LPAD(".$this->tId1."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'ctrabajador'),
			array ('public',	'cplanificacion'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		$this->table2 = "co_planificacion pc";
		$this->table2 .= " INNER JOIN co_cotizacion_sub cs ON pc.cordenservicio_sub=cs.ccotizacion";
		$this->table2 .= " INNER JOIN co_cotizacion cc ON cs.corigen=cc.ccotizacion";
		$this->table2 .= " LEFT JOIN par_vehiculos ve ON cs.cvehiculo=ve.cvehiculo";
		$this->table2 .= " INNER JOIN par_lugar pl ON cs.clugar=pl.clugar";
		$this->table2 .= " INNER JOIN cli_maquinas cm ON cc.cmaquina=cm.cmaquina";
		$this->table2 .= " INNER JOIN cli_clientes c ON cm.ccliente=c.ccliente INNER JOIN data_entes d ON c.cdata=d.cdata INNER JOIN eq_equipos eq ON cm.cequipo=eq.cequipo";
		$this->table2 .= " INNER JOIN eq_marcas em ON eq.cmarca=em.cmarca INNER JOIN eq_segmentos es ON es.csegmento=eq.csegmento";
		//AUDITORIA
		$this->table2 .= " LEFT JOIN adm_usuarios u1 ON pc.crea_user=u1.cusuario LEFT JOIN nom_trabajadores t1 ON u1.ctrabajador=t1.ctrabajador LEFT JOIN data_entes d1 ON t1.cdata=d1.cdata LEFT JOIN nom_cargos c1 ON t1.ccargo=c1.ccargo";
		$this->table2 .= " LEFT JOIN adm_usuarios u2 ON pc.mod_user=u2.cusuario LEFT JOIN nom_trabajadores t2 ON u2.ctrabajador=t2.ctrabajador LEFT JOIN data_entes d2 ON t2.cdata=d2.cdata LEFT JOIN nom_cargos c2 ON t2.ccargo=c2.ccargo";
		$this->tId2 = "pc.cplanificacion";
		$this->db2 = new database($this->table2, $this->tId2);
		$this->db2->fields = array (
			array ('system',	"LPAD(".$this->tId2."*1,"._PAD_CEROS_.",'0') AS codigo_cabecera"),			
			array ('system',	"CONCAT(LPAD(cc.cordenservicio*1,"._PAD_CEROS_.",'0'), '-',cs.cordenservicio_sub*1) AS codigo_ods"),
			array ('system',	'pc.cordenservicio_sub'),
			array ('system',	'pc.finicio'),
			array ('system',	'pc.ffin'),
			array ('system',	'cs.cvehiculo'),
			array ('system',	've.vehiculo'),
			array ('system',	"(CASE WHEN cs.clugar=1 THEN 'NO APLICA' ELSE ve.vehiculo END) AS transporte"),
			array ('system',	'pc.adi'),
			array ('system',	'cs.status'),
			array ('system',	'pc.notas'),
			array ('system',	'pl.lugar'),
			array ('system',	"(d.code) AS code"),
			array ('system',	'd.data'),
			array ('system',	'd.data2'),
			array ('system',	'cm.cequipo'),
			array ('system',	'cm.serial'),
			array ('system',	'cm.interno'),
			array ('system',	'eq.equipo'),
			array ('system',	'eq.csegmento'),
			array ('system',	'es.segmento'),
			array ('system',	'eq.cmarca'),
			array ('system',	'em.marca'),
			array ('system',	'eq.modelo'),
			array ('system',	'pc.status AS plan_status'),
			array ('system',	'((TIMESTAMPDIFF(MINUTE, pc.finicio, pc.ffin))/60) AS duracion'),
			array ('system',	'DATE_FORMAT(pc.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(pc.mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	"(CASE WHEN pc.crea_user='METALSIGMAUSER' THEN pc.crea_user WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS crea_user"),
			array ('system',	"(CASE WHEN pc.mod_user='METALSIGMAUSER' THEN pc.mod_user WHEN u2.ctrabajador=0 THEN u2.nombres ELSE d2.data END) AS mod_user"),
			array ('system',	"IFNULL(c1.cargo, 'N/A') AS cargo_crea"),
			array ('system',	"IFNULL(c2.cargo, 'N/A') AS cargo_mod")
		);
		$this->table3 = "co_planificacion_det pd";
		$this->table3 .= " LEFT JOIN co_planificacion pc USING (cplanificacion)";
		$this->table3 .= " LEFT JOIN nom_trabajadores nt USING (ctrabajador)";
		$this->table3 .= " LEFT JOIN data_entes d USING (cdata)";
		$this->table3 .= " LEFT JOIN nom_cargos nc USING (ccargo)";
		$this->table3 .= " INNER JOIN co_cotizacion_sub cs ON pc.cordenservicio_sub=cs.ccotizacion";
		$this->table3 .= " INNER JOIN co_cotizacion cc ON cs.corigen=cc.ccotizacion";
		$this->table3 .= " LEFT JOIN par_vehiculos ve ON cs.cvehiculo=ve.cvehiculo";
		$this->table3 .= " INNER JOIN par_lugar pl ON cs.clugar=pl.clugar";
		$this->table3 .= " INNER JOIN cli_maquinas cm ON cc.cmaquina=cm.cmaquina";
		$this->table3 .= " INNER JOIN cli_clientes c ON cm.ccliente=c.ccliente INNER JOIN data_entes d1 ON c.cdata=d1.cdata INNER JOIN eq_equipos eq ON cm.cequipo=eq.cequipo";
		$this->table3 .= " INNER JOIN eq_marcas em ON eq.cmarca=em.cmarca INNER JOIN eq_segmentos es ON es.csegmento=eq.csegmento";
		$this->tId3 = "pd.cplanificacion_det";
		$this->db3 = new database($this->table3, $this->tId3);
		$this->db3->fields = array (
			array ('system',	"LPAD(".$this->tId3."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(pc.cplanificacion*1,"._PAD_CEROS_.",'0') AS codigo_cab"),
			array ('system',	"LPAD(nt.ctrabajador*1,"._PAD_CEROS_.",'0') AS codigo_trabajador"),
			array ('system',	"CONCAT(LPAD(cc.cordenservicio*1,"._PAD_CEROS_.",'0'), '-',cs.cordenservicio_sub*1) AS codigo_ods"),
			array ('system',	'pc.cordenservicio_sub'),
			array ('system',	'pc.finicio'),
			array ('system',	'pc.ffin'),
			// test
			array ('system',	'((TIMESTAMPDIFF(MINUTE, pc.finicio, pc.ffin))/60) AS duracion'),
			array ('system',	'DATE_FORMAT(pc.finicio, "%T") AS inicio'),
			array ('system',	'DATE_FORMAT(pc.ffin, "%T") AS fin'),
			array ('system',	"(d.code) AS code"),
			array ('system',	'd.data'),
			array ('system',	'cs.cvehiculo'),
			array ('system',	've.vehiculo'),
			array ('system',	"(CASE WHEN cs.clugar=1 THEN 'NO APLICA' ELSE ve.vehiculo END) AS transporte"),
			array ('system',	'pc.adi'),
			array ('system',	'cs.status'),
			array ('system',	'pc.notas'),
			array ('system',	'pl.lugar'),
			array ('system',	"(d1.code) AS cli_code"),
			array ('system',	'd1.data AS cli_data'),
			array ('system',	'd1.data2 AS cli_data2'),
			array ('system',	'cm.cequipo'),
			array ('system',	'cm.serial'),
			array ('system',	'cm.interno'),
			array ('system',	'eq.equipo'),
			array ('system',	'eq.csegmento'),
			array ('system',	'es.segmento'),
			array ('system',	'eq.cmarca'),
			array ('system',	'em.marca'),
			array ('system',	'eq.modelo'),
			array ('system',	'nc.cargo'),
			array ('system',	'pc.status AS plan_status'),
			array ('system',	'nt.horas AS horas_sem'),
			array ('system',	'(nt.horas)/5 AS horas_dia')
		);
		$this->db3->campos=sizeof($this->db3->fields);
		//PLANIFICACIONES_INACTIVAR
		$this->table4 = "co_planificacion";
		$this->tId4 = "cplanificacion";
		$this->db4 = new database($this->table4, $this->tId4);
		$this->db4->fields = array (
			array ('system',	"LPAD(".$this->tId4."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public_u',	'status'),
			array ('public_u',	'mod_user')
		);
	}
	/** PLANIFICACIONES */
	//LISTAR
	public function list_(){
		return $this->db->getRecords();
	}
	//LISTAR ODS PLANIFICADAS
	public function list_t(){
		$data = array ();
		$data[0]["row"]="pc.status";
		$data[0]["operator"]="=";
		$data[0]["value"]=1;
		/*$data[1]["row"]="cs.status";
		$data[1]["operator"]="=";
		$data[1]["value"]="PRO";*/
		return $this->db2->getRecords(false,$data);
	}
	//LISTAR ODS PLANIFICADAS, AGRUPADAS POR ODS
	public function list_group(){
		$data = array ();
		$data[0]["row"]="pc.status";
		$data[0]["operator"]="=";
		$data[0]["value"]=1;
		return $this->db2->getRecords("COUNT(DISTINCT(pc.cordenservicio_sub)) AS cuenta",$data);
	}
	//LISTAR DETALLES ODS PLANIFICADA
	public function list_dets($plan){
		$data[0]["row"]="pd.cplanificacion";
		$data[0]["operator"]="=";
		$data[0]["value"]=$plan;
		return $this->db3->getRecords(false,$data);
	}
	//LISTAR TRABAJADORES PLANIFICADOS
	public function list_ocupa_plan($group=false,$ini=false,$fin=false,$cargos=false,$trab=false){
		$result=array(); $data = array (); $cont=-1; $dia = 0;
		if($ini &&  $fin){
			$date1 = new DateTime($ini);
			$date2 = new DateTime($fin);
			$diff = $date1->diff($date2);
			$dia = ($diff->format("%a")+1);
			if(sizeof($this->db3->fields)<=$this->db3->campos){
				$this->db3->fields[]=array ('system',	'((nt.horas)/5)*'.$dia.' AS horas_rango');
				$this->db3->fields[]=array ('system',	'((((SUM(TIMESTAMPDIFF(MINUTE, pc.finicio, pc.ffin))/60))-(SUM(pd.col)/60))*100)/(((nt.horas)/5)*'.$dia.') AS ocupa');
			}			
		}
		if($ini){
			$cont++;
			$data[$cont]["row"]="DATE_FORMAT(pc.finicio,'%Y-%m-%d')";
			$data[$cont]["operator"]=">=";
			$data[$cont]["value"]=$ini;
		}
		if($fin){
			$cont++;
			$data[$cont]["row"]="DATE_FORMAT(pc.ffin,'%Y-%m-%d')";
			$data[$cont]["operator"]="<=";
			$data[$cont]["value"]=$fin;
		}
		if($cargos){
			$cont++;
			$data[$cont]["row"]="nc.ccargo";
			$data[$cont]["operator"]="IN";
			$data[$cont]["value"]=$cargos;
		}
		if($trab){
			$cont++;
			$data[$cont]["row"]="nt.ctrabajador";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$trab;
		}
		return $this->db3->getRecords(false,$data,$group,"nc.ccargo ASC");
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
	//OBTENER POR ID
	public function get_plan($id){
		$data = $result = $resultado = array ();
		$result = $this->db2->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$resultado["title"]="SUCCESS";
			$cab=$result["content"][0];
			$resultado["cab"]=$cab;

			$data[0]["row"]="pd.cplanificacion";
			$data[0]["operator"]="=";
			$data[0]["value"]=$id;
			$result = $this->db3->getRecords(false,$data);
			if($result["title"]=="SUCCESS"){
				$resultado["det"]=$result["content"];
			}else{
				$resultado["det"]=NULL;
			}
		}else{
			$resultado = $result;
		}
		return $resultado;
	}
	//OBTENER POR COT
	public function get_plan_cot($cot){
		$data = $result = $resultado = array ();
		$data[0]["row"]="pc.cordenservicio_sub";
		$data[0]["operator"]="=";
		$data[0]["value"]=$cot;
		$result = $this->db2->getRecords(false,$data);
		if($result["title"]=="SUCCESS"){
			$resultado["title"]="SUCCESS";
			$cab=$result["content"][0];
			$id = $cab["codigo_cabecera"];
			$resultado["cab"]=$cab;

			$data[0]["row"]="pd.cplanificacion";
			$data[0]["operator"]="=";
			$data[0]["value"]=$id;
			$result = $this->db3->getRecords(false,$data);
			if($result["title"]=="SUCCESS"){
				$resultado["det"]=$result["content"];
			}else{
				$resultado["det"]=NULL;
			}
		}else{
			$resultado = $result;
		}
		return $resultado;
	}
	//CHEQUEAR DISPONIBILIDAD DE TRABAJADOR
	public function get_plan_worker($trabajador,$rango=false,$plan=false,$date=false){
		if(sizeof($this->db3->fields)>$this->db3->campos){
			array_pop($this->db3->fields);
			array_pop($this->db3->fields);
			array_pop($this->db3->fields);
		}
		$data = array ();
		$cont=-1;
		if($trabajador){
			$cont++;
			$data[$cont]["row"]="nt.ctrabajador";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$trabajador;
		}
		if($rango){
			$cont++;
			$data[$cont]["row"]="pc.finicio";
			$data[$cont]["operator"]="<=";
			$data[$cont]["value"]=$rango;
			$cont++;
			$data[$cont]["row"]="pc.ffin";
			$data[$cont]["operator"]=">";
			$data[$cont]["value"]=$rango;
		}
		if($date){
			$cont++;
			$data[$cont]["row"]="DATE_FORMAT(pc.finicio,'%Y-%m-%d')";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$date;
		}
		if($plan){
			$cont++;
			$data[$cont]["row"]="pc.cplanificacion";
			$data[$cont]["operator"]="<>";
			$data[$cont]["value"]=$plan;
		}
		$cont++;
		$data[$cont]["row"]="pc.status";
		$data[$cont]["operator"]="=";
		$data[$cont]["value"]=1;
		return $this->db3->getRecords(false,$data);
	}
	//CHEQUEAR DISPONIBILIDAD DE VEHICULO
	public function get_plan_vehic($ods,$date,$plan=false){
		$data = array ();
		$cont=-1;
		if($ods){
			$cont++;
			$data[$cont]["row"]="pc.cordenservicio_sub";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$ods;
		}
		if($date){
			$cont++;
			$data[$cont]["row"]="pc.finicio";
			$data[$cont]["operator"]="<=";
			$data[$cont]["value"]=$date;
			$cont++;
			$data[$cont]["row"]="pc.ffin";
			$data[$cont]["operator"]=">";
			$data[$cont]["value"]=$date;
		}
		if($plan){
			$cont++;
			$data[$cont]["row"]="pc.cplanificacion";
			$data[$cont]["operator"]="<>";
			$data[$cont]["value"]=$plan;
		}
		$cont++;
		$data[$cont]["row"]="pc.status";
		$data[$cont]["operator"]="=";
		$data[$cont]["value"]=1;
		return $this->db2->getRecords(false,$data);
	}
	//CREAR
	public function new_($data,$trabs){
		$resultado = false;
		$data[]=$_SESSION['metalsigma_log'];
		$result = $this->db->insertRecord($data);
		if($result["title"]=="SUCCESS"){
			$id=$result["id"];
			if(!empty($trabs)){
				for ($i=0; $i<sizeof($trabs); $i++){
					$datos=array();
					array_push($datos, $trabs[$i]);
					array_push($datos, $id);
					array_push($datos, $_SESSION['metalsigma_log']);
					$result = $this->db1->insertRecord($datos);
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						$data = array ();
						$data[0]["row"]="cplanificacion";
						$data[0]["operator"]="=";
						$data[0]["value"]=$id;
						$this->db->deleteRecord($id);
						$this->db1->deleteRecords($data);
						break;
					}
				}
			}
		}
		$resultado=$result;
		return $resultado;
	}
	//ACTUALIZAR
	public function edit_($id,$data,$trabs){
		$resultado = false;
		$data[]=$_SESSION['metalsigma_log'];
		$result = $this->db->updateRecord($id,$data);
		if($result["title"]=="SUCCESS"){
			$data = array ();
			$data[0]["row"]="cplanificacion";
			$data[0]["operator"]="=";
			$data[0]["value"]=$id;
			$this->db1->deleteRecords($data);
			if(!empty($trabs)){
				for ($i=0; $i<sizeof($trabs); $i++){
					$datos=array();
					array_push($datos, $trabs[$i]);
					array_push($datos, $id);
					array_push($datos, $_SESSION['metalsigma_log']);
					$result = $this->db1->insertRecord($datos);
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						$this->db->deleteRecord($id);
						$this->db1->deleteRecords($data);
						break;
					}
				}
			}
		}
		$resultado=$result;
		return $resultado;
	}
	//ELIMINAR
	public function delete_($id){
		$data = array (); $resultado = false;
		$data[]=0;
		$data[]=$_SESSION['metalsigma_log'];		
		return $this->db4->updateRecord($id,$data);
	}	
}
?>