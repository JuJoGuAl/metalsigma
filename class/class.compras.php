<?php
class compras{	
	//COTIZACION_LIST
	private $db1;
	public $table1;
	public $Id1;
	//COTIZACION_DET_LIST
	private $db2;
	public $table2;
	public $Id2;
	//COTIZACION_EDIT
	private $db3;
	public $table3;
	public $Id3;
	//COTIZACION_DET_EDIT
	private $db4;
	public $table4;
	public $Id4;
	//ODC_LIST
	private $db5;
	public $table5;
	public $Id5;
	//ODC_DET_LIST
	private $db6;
	public $table6;
	public $Id6;
	//ODC_EDIT
	private $db7;
	public $table7;
	public $Id7;
	//ODC_DET_EDIT
	private $db8;
	public $table8;
	public $Id8;
	//INV_MOVIMIENTOS_DET_LIST
	private $db9;
	public $table9;
	public $Id9;
	//ODC_ODS_USADOS
	private $db10;
	public $table10;
	public $Id10;
	//ODC_COUNT
	private $db11;
	public $table11;
	public $Id11;
	public function __construct(){
		include_once('class.bd_transsac.php');
		//COTIZACION_LIST
		$this->table1 = "com_cot_ser cot INNER JOIN com_cot_ser_det cotd USING (ccotizacion) ";
		$this->table1 .= "INNER JOIN pro_proveedores pro USING(cproveedor) INNER JOIN data_entes d USING (cdata) ";
		//AUDITORIA
		$this->table1 .= " LEFT JOIN adm_usuarios u1 ON cot.crea_user=u1.cusuario LEFT JOIN nom_trabajadores t1 ON u1.ctrabajador=t1.ctrabajador LEFT JOIN data_entes d1 ON t1.cdata=d1.cdata LEFT JOIN nom_cargos c1 ON t1.ccargo=c1.ccargo";
		$this->table1 .= " LEFT JOIN adm_usuarios u2 ON cot.mod_user=u2.cusuario LEFT JOIN nom_trabajadores t2 ON u2.ctrabajador=t2.ctrabajador LEFT JOIN data_entes d2 ON t2.cdata=d2.cdata LEFT JOIN nom_cargos c2 ON t2.ccargo=c2.ccargo";
		//ODS
		$this->table1 .= " LEFT JOIN co_cotizacion_sub cs ON cot.cods=cs.ccotizacion LEFT JOIN co_cotizacion cc ON cs.corigen=cc.ccotizacion LEFT JOIN cli_maquinas cm ON cc.cmaquina=cm.cmaquina LEFT JOIN cli_clientes c ON cm.ccliente=c.ccliente LEFT JOIN data_entes d3 ON c.cdata=d3.cdata";
		$this->tId1 = "cot.ccotizacion";
		$this->db1 = new database($this->table1, $this->tId1);
		$this->db1->fields = array (
			array ('system',	"LPAD(".$this->tId1."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(pro.cproveedor*1,"._PAD_CEROS_.",'0') AS codigo_proveedor"),
			array ('system',	"IF(cc.cordenservicio>0, CONCAT(LPAD(cc.cordenservicio*1,"._PAD_CEROS_.",'0'), '-',cs.cordenservicio_sub*1),'N/A') AS ods_pad"),
			array ('system',	"IF(cot.cods>0, CONCAT(LPAD(cc.ccotizacion*1,"._PAD_CEROS_.",'0'), '-',cs.correlativo*1),'N/A') AS cot_pad"),
			array ('system',	"(d3.code) AS cli_cot_code"),
			array ('system',	'd3.data AS cli_cot_nom'),
			array ('system',	"(d.code) AS code"),
			array ('system',	'd.data'),
			array ('system',	'd.data2'),
			array ('system',	'd.direccion'),
			array ('system',	'd.tel_fijo'),
			array ('system',	'd.tel_movil'),
			array ('system',	'DATE_FORMAT(cot.fecha,"%d-%m-%Y") AS fecha'),
			array ('system',	'cot.status'),
			array ('system',	'cot.cods'),
			array ('system',	'SUM(cotd.costot) AS monto_total'),
			array ('system',	'COUNT(cotd.ccotizacion_det) AS servicios'),
			array ('system',	'DATE_FORMAT(cot.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(cot.mod_date, "%d/%m/%Y %T") AS mod_date'),			
			array ('system',	"(CASE WHEN cot.crea_user='METALSIGMAUSER' THEN cot.crea_user WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS crea_user"),
			array ('system',	"(CASE WHEN cot.mod_user='METALSIGMAUSER' THEN cot.mod_user WHEN u2.ctrabajador=0 THEN u2.nombres ELSE d2.data END) AS mod_user"),
			array ('system',	"IFNULL(c1.cargo, 'N/A') AS cargo_crea"),
			array ('system',	"IFNULL(c2.cargo, 'N/A') AS cargo_mod"),
		);
		//COTIZACION_DET_LIST
		$this->table2 = "com_cot_ser_det cotd ";
		$this->table2 .= "INNER JOIN inv_articulos art USING (carticulo)";
		$this->table2 .= " LEFT JOIN com_cot_ser oc USING (ccotizacion)";
		$this->tId2 = "cotd.ccotizacion_det";
		$this->db2 = new database($this->table2, $this->tId2);
		$this->db2->fields = array (
			array ('system',	"LPAD(".$this->tId2."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(cotd.ccotizacion*1,"._PAD_CEROS_.",'0') AS origen"),
			array ('system',	"LPAD(art.carticulo*1,"._PAD_CEROS_.",'0') AS codigo_art"),
			array ('system',	'art.codigo2'),
			array ('system',	'art.articulo'),
			array ('system',	'art.descripcion'),
			array ('system',	'cotd.cant'),
			array ('system',	'cotd.costou'),
			array ('system',	'cotd.imp_p'),
			array ('system',	'cotd.imp_m'),
			array ('system',	'cotd.costot'),
			array ('system',	'DATE_FORMAT(cotd.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(cotd.mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//COTIZACION_EDIT
		$this->table3 = "com_cot_ser";
		$this->tId3 = "ccotizacion";
		$this->db3 = new database($this->table3, $this->tId3);
		$this->db3->fields = array (
			array ('system',	"LPAD(".$this->tId3."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	"cproveedor"),
			array ('public',	'fecha'),
			array ('public',	'cods'),
			array ('public',	'status'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//COTIZACION_DET_EDIT
		$this->table4 = "com_cot_ser_det";
		$this->tId4 = "ccotizacion_det";
		$this->db4 = new database($this->table4, $this->tId4);
		$this->db4->fields = array (
			array ('system',	"LPAD(".$this->tId4."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	"ccotizacion_det"),
			array ('public',	"carticulo"),
			array ('public',	'cant'),
			array ('public',	'costou'),
			array ('public',	'imp_p'),
			array ('public',	'imp_m'),
			array ('public',	'costot'),
			array ('public',	"ccotizacion"),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//ODC_LIST
		$this->table5 = "com_odc oc INNER JOIN com_odc_det ocd USING(corden) ";
		$this->table5 .= "INNER JOIN pro_proveedores pro USING(cproveedor) INNER JOIN data_entes d USING (cdata) ";
		$this->table5 .= "LEFT JOIN data_comuna co USING (ccomuna) LEFT JOIN data_provincia pr USING (cprovincia) ";
		$this->table5 .= "LEFT JOIN data_region r USING (cregion) LEFT JOIN data_pais p USING (cpais) ";
		$this->table5 .= "LEFT JOIN cli_pagos cp USING (cpago) ";
		//AUDITORIA
		$this->table5 .= " LEFT JOIN adm_usuarios u1 ON oc.crea_user=u1.cusuario LEFT JOIN nom_trabajadores t1 ON u1.ctrabajador=t1.ctrabajador LEFT JOIN data_entes d1 ON t1.cdata=d1.cdata LEFT JOIN nom_cargos c1 ON t1.ccargo=c1.ccargo";
		$this->table5 .= " LEFT JOIN adm_usuarios u2 ON oc.mod_user=u2.cusuario LEFT JOIN nom_trabajadores t2 ON u2.ctrabajador=t2.ctrabajador LEFT JOIN data_entes d2 ON t2.cdata=d2.cdata LEFT JOIN nom_cargos c2 ON t2.ccargo=c2.ccargo";
		//ODS
		$this->table5 .= " LEFT JOIN co_cotizacion_sub cs ON oc.ods=cs.ccotizacion LEFT JOIN co_cotizacion cc ON cs.corigen=cc.ccotizacion LEFT JOIN cli_maquinas cm ON cc.cmaquina=cm.cmaquina LEFT JOIN cli_clientes c ON cm.ccliente=c.ccliente LEFT JOIN data_entes d3 ON c.cdata=d3.cdata";
		//COT (COMP)
		$this->table5 .= " LEFT JOIN com_cot_ser cos ON oc.ccotizacion=cos.ccotizacion LEFT JOIN co_cotizacion_sub cs1 ON cos.cods=cs1.ccotizacion LEFT JOIN co_cotizacion cc1 ON cs1.corigen=cc1.ccotizacion LEFT JOIN cli_maquinas cm1 ON cc1.cmaquina=cm1.cmaquina LEFT JOIN cli_clientes c3 ON cm1.ccliente=c3.ccliente LEFT JOIN data_entes d4 ON c3.cdata=d4.cdata";
		$this->tId5 = "oc.corden";
		$this->db5 = new database($this->table5, $this->tId5);
		$this->db5->fields = array (
			array ('system',	"LPAD(".$this->tId5."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(pro.cproveedor*1,"._PAD_CEROS_.",'0') AS codigo_proveedor"),
			array ('system',	"IF(cs.cordenservicio_sub>0, CONCAT(LPAD(cc.cordenservicio*1,"._PAD_CEROS_.",'0'), '-',cs.cordenservicio_sub*1),'N/A') AS ods_pad"),
			array ('system',	"IF(oc.ccotizacion>0, LPAD(oc.ccotizacion*1,"._PAD_CEROS_.",'0'),'N/A') AS cot_pad"),
			array ('system',	"IF(cc1.cordenservicio>0, CONCAT(LPAD(cc1.cordenservicio*1,"._PAD_CEROS_.",'0'), '-',cs1.cordenservicio_sub*1),'N/A') AS ods_pad_cot"),
			array ('system',	"IF(oc.ccotizacion>0, CONCAT(LPAD(cc1.ccotizacion*1,"._PAD_CEROS_.",'0'), '-',cs1.correlativo*1),'N/A') AS cot_pad_cot"),
			array ('system',	"(d4.code) AS cli_cot_code"),
			array ('system',	'd4.data AS cli_cot_nom'),
			array ('system',	"(d.code) AS code"),
			array ('system',	'd.data'),
			array ('system',	'd.data2'),
			array ('system',	'd3.data AS cliente'),
			array ('system',	'd.direccion'),
			array ('system',	'd.tel_fijo'),
			array ('system',	'd.tel_movil'),
			array ('system',	'co.ccomuna'),
			array ('system',	'co.comuna'),
			array ('system',	'pr.cprovincia'),
			array ('system',	'pr.provincia'),
			array ('system',	'r.cregion'),
			array ('system',	'r.region'),
			array ('system',	'p.cpais'),
			array ('system',	'p.pais'),
			array ('system',	'cp.cpago'),
			array ('system',	'cp.pago'),
			array ('system',	'DATE_FORMAT(oc.fecha_orden,"%d-%m-%Y") AS fecha_orden'),
			array ('system',	'oc.status'),
			array ('system',	'oc.ods'),
			array ('system',	'oc.ccotizacion'),
			array ('system',	'SUM(ocd.costot) AS monto_total'),
			array ('system',	'SUM(ocd.cant_rest) AS pendientes'),
			array ('system',	'SUM(ocd.cant) AS solicitados'),
			array ('system',	'COUNT(ocd.corden_det) AS articulos'),			
			array ('system',	'DATE_FORMAT(oc.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(oc.mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	"(CASE WHEN oc.crea_user='METALSIGMAUSER' THEN oc.crea_user WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS crea_user"),
			array ('system',	"(CASE WHEN oc.mod_user='METALSIGMAUSER' THEN oc.mod_user WHEN u2.ctrabajador=0 THEN u2.nombres ELSE d2.data END) AS mod_user"),
			array ('system',	"IFNULL(c1.cargo, 'N/A') AS cargo_crea"),
			array ('system',	"IFNULL(c2.cargo, 'N/A') AS cargo_mod"),
		);
		//ODC_DET_LIST
		$this->table6 = "com_odc_det ocd ";
		$this->table6 .= "INNER JOIN inv_articulos art USING (carticulo) INNER JOIN inv_clasificacion ic USING (cclasificacion)";
		//$this->table6 .= " LEFT JOIN inv_movimientos_det imd USING (corden_det) LEFT JOIN inv_movimientos im USING (cmovimiento_key)";
		$this->table6 .= " LEFT JOIN com_odc oc USING (corden)";

		$this->table6 .= " LEFT JOIN (SELECT imd.carticulo, coa.cant-(SUM(CASE WHEN (im.tipo='CSM') THEN imd.cant ELSE -imd.cant END)) AS cant_disp, c.corden FROM inv_movimientos_det imd INNER JOIN inv_movimientos im ON imd.cmovimiento_key=im.cmovimiento_key LEFT JOIN co_cotizacion_sub_det_art coa ON imd.corigen_det=coa.ccotizacionart LEFT JOIN com_odc c ON coa.ccotizacion=c.ods WHERE im.tipo IN ('CSM','DCS') GROUP BY imd.carticulo,c.corden) disp ON disp.corden=oc.corden AND disp.carticulo=ocd.carticulo";
		$this->table6 .= " LEFT JOIN co_cotizacion_sub_det_art csda ON ocd.carticulo=csda.carticulo AND oc.ods=csda.ccotizacion AND csda.del=0";
		$this->tId6 = "ocd.corden_det";
		$this->db6 = new database($this->table6, $this->tId6);
		$this->db6->fields = array (
			array ('system',	"LPAD(".$this->tId6."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(ocd.corden*1,"._PAD_CEROS_.",'0') AS origen"),
			array ('system',	"LPAD(art.carticulo*1,"._PAD_CEROS_.",'0') AS codigo_art"),
			array ('system',	"LPAD(ocd.ccotizacion_det*1,"._PAD_CEROS_.",'0') AS codigo_cotiza_det"),
			array ('system',	'art.codigo2'),
			array ('system',	'art.articulo'),
			array ('system',	'art.descripcion'),
			array ('system',	"ic.clasificacion"),
			array ('system',	"(ic.articulo) AS tip_clasif"),
			array ('system',	'art.cant AS cant_inv'),
			array ('system',	'disp.cant_disp AS cant_ods'),
			array ('system',	'ocd.cant'),
			array ('system',	'csda.cant AS cant_ods_req'),
			array ('system',	'ocd.costou'),
			array ('system',	'ocd.imp_p'),
			array ('system',	'ocd.imp_m'),
			array ('system',	'ocd.costot'),
			array ('system',	'ocd.cant_rest'),
			array ('system',	'ocd.crea_user'),
			array ('system',	'ocd.mod_user'),
			array ('system',	'DATE_FORMAT(ocd.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(ocd.mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//ODC_EDIT
		$this->table7 = "com_odc";
		$this->tId7 = "corden";
		$this->db7 = new database($this->table7, $this->tId7);
		$this->db7->fields = array (
			array ('system',	"LPAD(".$this->tId7."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	"cproveedor"),
			array ('public',	'fecha_orden'),
			array ('public',	'ods'),
			array ('public',	'status'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//ODC_DET_EDIT
		$this->table8 = "com_odc_det";
		$this->tId8 = "corden_det";
		$this->db8 = new database($this->table8, $this->tId8);
		$this->db8->fields = array (
			array ('system',	"LPAD(".$this->tId8."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	"corden_det"),
			array ('public',	"carticulo"),
			array ('public',	'cant'),
			array ('public',	'costou'),
			array ('public',	'imp_p'),
			array ('public',	'imp_m'),
			array ('public',	'costot'),
			array ('public',	'ccotizacion_det'),
			array ('public',	'cant_rest'),
			array ('public',	"corden"),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//INV_MOVIMIENTOS_DET_LIST
		$this->table9 = "inv_movimientos_det imd1 ";
		$this->table9 .= "INNER JOIN inv_movimientos im USING (cmovimiento_key) ";
		$this->table9 .= "INNER JOIN inv_movimientos_det imd USING (cmovimiento_key) ";
		$this->table9 .= "INNER JOIN inv_articulos ia ON imd.carticulo=ia.carticulo ";
		$this->tId9 = "imd.cmovimiento_det";
		$this->db9 = new database($this->table9, $this->tId9);
		$this->db9->fields = array (
			array ('system',	"LPAD(".$this->tId9."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(ia.carticulo*1,"._PAD_CEROS_.",'0') AS codigo_articulo"),
			array ('system',	"LPAD(imd.cmovimiento_key*1,"._PAD_CEROS_.",'0') AS codigo_cabecera"),			
			array ('system',	"LPAD(im.cmovimiento*1,"._PAD_CEROS_.",'0') AS codigo_movimiento"),
			array ('system',	'DATE_FORMAT(im.fecha_mov,"%d-%m-%Y") AS fecha_mov'),
			array ('system',	'(SELECT COUNT(*) FROM inv_movimientos_det t WHERE t.cmovimiento_key=im.cmovimiento_key) AS articulos'),
			array ('system',	"ia.codigo2"),
			array ('system',	"ia.articulo"),
			array ('system',	"imd.cant"),
			array ('system',	"imd.costou"),
			array ('system',	"imd.imp_p"),
			array ('system',	"imd.imp_m"),
			array ('system',	"imd.costot"),
			array ('system',	"imd.corigen_det"),
			array ('system',	"imd.corden_det")
		);
		//ODC_DET_LIST
		$this->table10 = "com_odc_det ocd ";
		$this->table10 .= "INNER JOIN inv_articulos art USING (carticulo) INNER JOIN inv_clasificacion ic USING (cclasificacion)";
		$this->table10 .= " INNER JOIN com_odc oc USING (corden)";
		$this->table10 .= "INNER JOIN pro_proveedores pro USING(cproveedor) INNER JOIN data_entes d USING (cdata) ";
		$this->tId10 = "ocd.corden_det";
		$this->db10 = new database($this->table10, $this->tId10);
		$this->db10->fields = array (
			array ('system',	"LPAD(".$this->tId10."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(ocd.corden*1,"._PAD_CEROS_.",'0') AS origen"),
			array ('system',	"LPAD(art.carticulo*1,"._PAD_CEROS_.",'0') AS codigo_art"),
			array ('system',	"LPAD(oc.ods*1,"._PAD_CEROS_.",'0') AS codigo_ods"),
			array ('system',	"(d.code) AS code"),
			array ('system',	'd.data'),
			array ('system',	'oc.status'),
			array ('system',	'art.codigo2'),
			array ('system',	'art.articulo'),
			array ('system',	'art.descripcion'),
			array ('system',	"ic.clasificacion"),
			array ('system',	"(ic.articulo) AS tip_clasif"),
			array ('system',	'art.cant AS cant_inv'),
			array ('system',	'ocd.cant'),
			array ('system',	'ocd.costou'),
			array ('system',	'ocd.imp_p'),
			array ('system',	'ocd.imp_m'),
			array ('system',	'ocd.costot'),
			array ('system',	'ocd.cant_rest'),
			array ('system',	'ocd.crea_user'),
			array ('system',	'ocd.mod_user'),
			array ('system',	'DATE_FORMAT(ocd.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(ocd.mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//ODC_COUNT
		$this->table11 = "com_odc";
		$this->tId11 = "corden";
		$this->db11 = new database($this->table11, $this->tId11);
		$this->db11->fields = array (
			array ('system',    'SUM(CASE WHEN (ccotizacion>0 AND ods=0) THEN 1 ELSE 0 END) AS cuenta_odc_cot'),
			array ('system',    'SUM(CASE WHEN (ccotizacion=0 AND ods>0) THEN 1 ELSE 0 END) AS cuenta_odc_ods'),
			array ('system',    'SUM(CASE WHEN (ccotizacion=0 AND ods=0) THEN 1 ELSE 0 END) AS cuenta_odc')
		);
	}
	//LISTAR_CUENTAS
	public function list_status(){
		$data = array ();
		$data[0]["row"]="status";
		$data[0]["operator"]="=";
		$data[0]["value"]="PEN";
		return $this->db11->getRecords(false,$data);
	}
	/** COTIZACIONES */
	//LISTAR
	public function list_cot($status=false,$prov=false,$non=false,$ods=false){
		$data = array ();
		$cont=-1;
		if($status){
			$cont++;
			$data[$cont]["row"]="cot.status";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$status;
		}
		if($prov){
			$cont++;
			$data[$cont]["row"]="cot.cproveedor";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$prov;
		}
		if($non){
			$cont++;
			$data[$cont]["row"]="cot.ccotizacion";
			$data[$cont]["operator"]="NOT IN";
			$data[$cont]["value"]=$non;
		}
		if($ods){
			$cont++;
			$data[$cont]["row"]="cot.cods";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=0;
		}/*else{
			$cont++;
			$data[$cont]["row"]="cot.cods";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=0;
		}*/
		return $this->db1->getRecords(false,$data,"cot.ccotizacion");
	}	
	//OBTENER
	public function get_cot($id){
		$resultado = false;
		$result = $this->db1->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$resultado["title"]="SUCCESS";
			$cab=$result["content"][0];
			$resultado["cab"]=$cab;
			$data = $conditions = array ();
			$data[0]["row"]="cotd.ccotizacion";
			$data[0]["operator"]="=";
			$data[0]["value"]=$id;
			$result = $this->db2->getRecords(false,$data);
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
	//OBTENER DET POR ARRAY CAB
	public function get_cot_det_array($cab_array){
		$data = array (); $cont=-1;
		$cont++;
		$data[$cont]["row"]="cotd.ccotizacion";
		$data[$cont]["operator"]="IN";
		$data[$cont]["value"]=$cab_array;
		$result = $this->db2->getRecords(false,$data);
		return $result;
	}
	//OBTENER
	public function get_cot_det($id){
		$result=array();
		$result=$this->db2->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_cot($data,$detalles){
		$resultado = false;
		$data[]=$_SESSION['metalsigma_log'];
		$result = $this->db3->insertRecord($data);
		if($result["title"]=="SUCCESS"){
			$id=$result["id"];
			if(!empty($detalles[0])){				
				for ($i=0; $i<sizeof($detalles[0]); $i++){
					$datos=array();
					$new_id = ($detalles[0][$i]==0) ? "" : $detalles[0][$i] ;
					array_push($datos, $new_id);
					array_push($datos, $detalles[1][$i]);
					array_push($datos, $detalles[2][$i]);
					array_push($datos, $detalles[3][$i]);
					array_push($datos, $detalles[4][$i]);
					array_push($datos, $detalles[5][$i]);
					array_push($datos, $detalles[6][$i]);
					array_push($datos, $id);
					array_push($datos, $_SESSION['metalsigma_log']);
					$result = $this->db4->insertRecord($datos);
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						$data = array ();
						$data[0]["row"]="corden";
						$data[0]["operator"]="=";
						$data[0]["value"]=$id;
						$this->db3->deleteRecord($id);
						$this->db4->deleteRecords($data);
						break;
					}
				}
			}
		}
		$resultado=$result;
		return $resultado;
	}
	//ACTUALIZAR
	public function edit_cot($id,$data,$detalles){
		$resultado = false;
		$data[]=$_SESSION['metalsigma_log'];
		$result = $this->db3->updateRecord($id,$data);
		if($result["title"]=="SUCCESS"){
			if(!empty($detalles[0])){
				$query_id=array();
				for ($i=0; $i<sizeof($detalles[0]); $i++){
					array_push($query_id, $detalles[0][$i]);
					$datos=array();					
					$new_id = ($detalles[0][$i]==0) ? "" : $detalles[0][$i] ;
					array_push($datos, $new_id);
					array_push($datos, $detalles[1][$i]);
					array_push($datos, $detalles[2][$i]);
					array_push($datos, $detalles[3][$i]);
					array_push($datos, $detalles[4][$i]);
					array_push($datos, $detalles[5][$i]);
					array_push($datos, $detalles[6][$i]);
					array_push($datos, $id);
					array_push($datos, $_SESSION['metalsigma_log']);
					$result = $this->db4->upsertRecord($datos);
					if($result["id"]!=0){
						array_push($query_id, $result["id"]);
					}
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						break;
					}
				}
				$data = array ();
				$data[0]["row"]="ccotizacion_det";
				$data[0]["operator"]="NOT IN";
				$data[0]["value"]=$query_id;
				$data[1]["row"]="ccotizacion";
				$data[1]["operator"]="=";
				$data[1]["value"]=$id;
				$result = $this->db4->deleteRecords($data);
			}
		}
		$resultado=$result;
		return $resultado;
	}
	/** ODC */
	//LISTAR
	public function list_odc($status=false,$count=false,$prov=false,$non=false,$ods=false,$cot=false){
		$data = array ();
		$cont=-1;
		if($status){
			$cont++;
			$data[$cont]["row"]="oc.status";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$status;
		}
		if($prov){
			$cont++;
			$data[$cont]["row"]="oc.cproveedor";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$prov;
		}
		if($non){
			$cont++;
			$data[$cont]["row"]="oc.corden";
			$data[$cont]["operator"]="NOT IN";
			$data[$cont]["value"]=$non;
		}
		if($ods===true){
			$cont++;
			$data[$cont]["row"]="oc.ods";
			$data[$cont]["operator"]=">";
			$data[$cont]["value"]=0;
		}else if($ods===-1){
			$cont++;
			$data[$cont]["row"]="oc.ods";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=0;
		}
		if($cot){
			$cont++;
			$data[$cont]["row"]="oc.ccotizacion";
			$data[$cont]["operator"]=">";
			$data[$cont]["value"]=0;
		}else{
			$cont++;
			$data[$cont]["row"]="oc.ccotizacion";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=0;
		}
		$having = ($count) ? "pendientes > 0" : false ;
		return $this->db5->getRecords(false,$data,"oc.corden",false,$having);
	}	
	//LISTAR ODC BY DET
	public function list_odc_det($dets){
		$data = array ();
		$cont=-1;
		if($dets){
			$cont++;
			$data[$cont]["row"]="ocd.corden_det";
			$data[$cont]["operator"]="IN";
			$data[$cont]["value"]=$dets;
		}
		return $this->db5->getRecords('oc.corden AS codigo,d.data,DATE_FORMAT(oc.fecha_orden,"%d-%m-%Y") AS fecha_orden,SUM(ocd.cant) AS solicitados,SUM(ocd.cant_rest) AS pendientes,COUNT(ocd.cant) AS articulos, SUM(ocd.costot) AS monto_total',$data,"oc.corden");
	}
	//OBTENER
	public function get_odc($id){
		$resultado = false;
		$result = $this->db5->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$resultado["title"]="SUCCESS";
			$cab=$result["content"][0];
			$resultado["cab"]=$cab;
			$data = $conditions = array ();
			$data[0]["row"]="ocd.corden";
			$data[0]["operator"]="=";
			$data[0]["value"]=$id;			
			$result = $this->db6->getRecords(false,$data);
			//print_r($result);
			if($result["title"]=="SUCCESS"){
				$resultado["det"]=$result["content"];
				$query_id=array();
				foreach ($resultado["det"] as $key => $value) {
					array_push($query_id, $value["codigo"]);
				}
				$conditions[0]["row"]="imd1.corden_det";
				$conditions[0]["operator"]="IN";
				$conditions[0]["value"]=$query_id;
				$result = $this->db9->getRecords(false,$conditions);
				//print_r($result);
				if($result["title"]=="SUCCESS"){
					$resultado["mov"]=$result["content"];
				}else{
					$resultado["mov"]=NULL;
				}
			}else{
				$resultado["det"]=NULL;
			}
		}else{
			$resultado = $result;
		}
		return $resultado;
	}
	//OBTENER
	public function get_odc_det($id){
		$result=array();
		$result=$this->db6->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_odc($data,$detalles){
		$resultado = false;
		$data[]=$_SESSION['metalsigma_log'];
		$result = $this->db7->insertRecord($data);
		//print_r($result);
		if($result["title"]=="SUCCESS"){
			$id=$result["id"];
			if(!empty($detalles[0])){				
				for ($i=0; $i<sizeof($detalles[0]); $i++){
					$datos=array();
					$new_id = ($detalles[0][$i]==0) ? "" : $detalles[0][$i] ;
					array_push($datos, $new_id);
					array_push($datos, $detalles[1][$i]);
					array_push($datos, $detalles[2][$i]);
					array_push($datos, $detalles[3][$i]);
					array_push($datos, $detalles[4][$i]);
					array_push($datos, $detalles[5][$i]);
					array_push($datos, $detalles[6][$i]);
					array_push($datos, $detalles[7][$i]);
					array_push($datos, $detalles[8][$i]);
					array_push($datos, $id);
					array_push($datos, $_SESSION['metalsigma_log']);
					$result = $this->db8->insertRecord($datos);
					//print_r($result);
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						$data = array ();
						$data[0]["row"]="corden";
						$data[0]["operator"]="=";
						$data[0]["value"]=$id;
						$result = $this->db7->deleteRecord($id);
						$result = $this->db8->deleteRecords($data);
						break;
					}
				}
			}
		}
		$resultado=$result;
		return $resultado;
	}
	//ACTUALIZAR
	public function edit_odc($id,$data,$detalles){
		$resultado = false;
		$data[]=$_SESSION['metalsigma_log'];
		$result = $this->db7->updateRecord($id,$data);
		if($result["title"]=="SUCCESS"){
			if(!empty($detalles[0])){
				$query_id=array();
				for ($i=0; $i<sizeof($detalles[0]); $i++){
					array_push($query_id, $detalles[0][$i]);
					$datos=array();					
					$new_id = ($detalles[0][$i]==0) ? "" : $detalles[0][$i] ;
					array_push($datos, $new_id);
					array_push($datos, $detalles[1][$i]);
					array_push($datos, $detalles[2][$i]);
					array_push($datos, $detalles[3][$i]);
					array_push($datos, $detalles[4][$i]);
					array_push($datos, $detalles[5][$i]);
					array_push($datos, $detalles[6][$i]);
					array_push($datos, $detalles[7][$i]);
					array_push($datos, $detalles[8][$i]);
					array_push($datos, $id);
					array_push($datos, $_SESSION['metalsigma_log']);
					$result = $this->db8->upsertRecord($datos);
					//print_r($result);
					if($result["id"]!=0){
						array_push($query_id, $result["id"]);
					}
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						break;
					}
				}
				$data = array ();
				$data[0]["row"]="corden_det";
				$data[0]["operator"]="NOT IN";
				$data[0]["value"]=$query_id;
				$data[1]["row"]="corden";
				$data[1]["operator"]="=";
				$data[1]["value"]=$id;
				$result = $this->db8->deleteRecords($data);
			}
		}
		$resultado=$result;
		return $resultado;
	}
	//OBTENER
	public function get_art_odc_used($art,$ods){
		$data = array ();
		$data[0]["row"]="art.carticulo";
		$data[0]["operator"]="=";
		$data[0]["value"]=$art;
		$data[1]["row"]="oc.ods";
		$data[1]["operator"]="=";
		$data[1]["value"]=$ods;
		return $this->db10->getRecords(false,$data);
	}
	// ODC POR ARRAY (CAB Y DET)
	public function get_odc_full($odc=false){
		$data = array (); $count=-1; $resultado=array();
		if($odc){
			$count++;
			$data[$count]["row"]="oc.corden";
			$data[$count]["operator"]="IN";
			$data[$count]["value"]=$odc;
		}
		$result=$this->db5->getRecords(false,$data,"oc.corden");
		if($result["title"]=="SUCCESS"){
			$resultado["title"]="SUCCESS";
			foreach ($result["content"] as $key => $value) {
				$data[0]["row"]="ocd.corden";
				$data[0]["operator"]="=";
				$data[0]["value"]=$result["content"][$key]["codigo"];
				$result1 = $this->db6->getRecords(false,$data);
				//print_r($result);
				if($result1["title"]=="SUCCESS"){
					$result["content"][$key]["dets"]=$result1["content"];
				}else{
					$result["content"][$key]["dets"]=NULL;
				}
			}
			$resultado["content"]=$result["content"];
		}else{
			$resultado = $result;
		}
		return $resultado;
	}
}
?>