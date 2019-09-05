<?php
class cotizaciones{	
	//COTIZACIONES_TIPO
	private $db;
	public $table;
	public $Id;
	//COTIZA_LIST
	private $db1;
	public $table1;
	public $Id1;
	//COTIZA_SUB_LIST
	private $db2;
	public $table2;
	public $Id2;
	//COTIZA_SUB_EDIT
	private $db3;
	public $table3;
	public $Id3;
	//COTIZA_SUB_DET_EDIT
	private $db4;
	public $table4;
	public $Id4;
	//COTIZA_SUB_DET_ART_EDIT
	private $db5;
	public $table5;
	public $Id5;
	//COTIZA_SUB_DET_LIST
	private $db6;
	public $table6;
	public $Id6;
	//COTIZA_SUB_DET_ART_LIST
	private $db7;
	public $table7;
	public $Id7;
	//COTIZA_EDIT
	private $db8;
	public $table8;
	public $Id8;
	//HIST_COT_SUB_DET
	private $db10;
	public $table10;
	public $Id10;
	//HIST_COT_SUB_DET_ART
	private $db12;
	public $table12;
	public $Id12;
	//HIST_COT_SUB
	private $db14;
	public $table14;
	public $Id14;
	//COTIZACION_ART / INV / ART
	private $db15;
	public $table15;
	public $Id15;
	//COTIZACION COMPRAS
	private $db16;
	public $table16;
	public $Id16;
	//COTIZACION COMPRAS EDIT
	private $db17;
	public $table17;
	public $Id17;
	public function __construct(){
		include_once('class.bd_transsac.php');
		$this->table = "co_tipos";
		$this->tId = "ctipo";
		$this->db = new database($this->table, $this->tId);
		$this->db->fields = array (
			array ('system',	"LPAD(".$this->tId."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'tipo'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//COTIZACION_LIST
		$this->table1 = "co_cotizacion cp INNER JOIN cli_maquinas cm ON cp.cmaquina=cm.cmaquina INNER JOIN cli_clientes c ON cm.ccliente=c.ccliente ";
		$this->table1 .= "INNER JOIN data_entes d ON c.cdata=d.cdata INNER JOIN eq_equipos eq ON cm.cequipo=eq.cequipo ";
		$this->table1 .= "INNER JOIN eq_marcas em ON eq.cmarca=em.cmarca INNER JOIN eq_segmentos es ON es.csegmento=eq.csegmento ";
		$this->table1 .= "LEFT JOIN cli_pagos pa ON c.cpago=pa.cpago ";
		$this->table1 .= "LEFT JOIN co_cotizacion_sub cb ON cp.ccotizacion=cb.corigen ";
		//AUDITORIA
		$this->table1 .= " LEFT JOIN adm_usuarios u1 ON cp.crea_user=u1.cusuario LEFT JOIN nom_trabajadores t1 ON u1.ctrabajador=t1.ctrabajador LEFT JOIN data_entes d1 ON t1.cdata=d1.cdata LEFT JOIN nom_cargos c1 ON t1.ccargo=c1.ccargo";
		$this->table1 .= " LEFT JOIN adm_usuarios u2 ON cp.mod_user=u2.cusuario LEFT JOIN nom_trabajadores t2 ON u2.ctrabajador=t2.ctrabajador LEFT JOIN data_entes d2 ON t2.cdata=d2.cdata LEFT JOIN nom_cargos c2 ON t2.ccargo=c2.ccargo";
		$this->tId1 = "cp.ccotizacion";
		$this->db1 = new database($this->table1, $this->tId1);
		$this->db1->fields = array (
			array ('system',	"LPAD(".$this->tId1."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"IF(cp.cordenservicio=0, 'N/A', LPAD(cp.cordenservicio*1,"._PAD_CEROS_.",'0')) AS codigo_ods"),
			array ('system',	"IF(cb.cordenservicio_sub>0, CONCAT(LPAD(cp.cordenservicio*1,"._PAD_CEROS_.",'0'), '-',cb.cordenservicio_sub*1),'N/A') AS ods_pad"),
			array ('system',	"(d.code) AS code"),
			array ('system',	'd.data'),
			array ('system',	'd.data2'),
			array ('system',	'd.direccion'),
			array ('system',	'd.tel_fijo'),
			array ('system',	'd.tel_movil'),
			array ('system',	'c.contacto'),
			array ('system',	'c.descu'),
			array ('system',	'c.cpago'),
			array ('system',	'pa.pago'),
			array ('system',	'c.maqs'),
			array ('system',	'c.cat'),
			array ('system',	'c.kom'),
			array ('system',	'cm.ccliente'),
			array ('system',	'cm.cequipo'),
			array ('system',	'cm.serial'),
			array ('system',	'cm.interno'),
			array ('system',	'eq.equipo'),
			array ('system',	'eq.csegmento'),
			array ('system',	'es.segmento'),
			array ('system',	'eq.cmarca'),
			array ('system',	'em.marca'),
			array ('system',	'eq.modelo'),
			array ('system',	'SUM(CASE WHEN (cb.ccotizacion>0) THEN 1 ELSE 0 END) AS cuentas'),			
			array ('system',	'DATE_FORMAT(cp.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(cp.crea_date, "%d-%m-%Y") AS crea'),
			array ('system',	'DATE_FORMAT(cp.mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	"(CASE WHEN cp.crea_user='METALSIGMAUSER' THEN cp.crea_user WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS crea_user"),
			array ('system',	"(CASE WHEN cp.mod_user='METALSIGMAUSER' THEN cp.mod_user WHEN u2.ctrabajador=0 THEN u2.nombres ELSE d2.data END) AS mod_user"),
			array ('system',	"IFNULL(c1.cargo, 'N/A') AS cargo_crea"),
			array ('system',	"IFNULL(c2.cargo, 'N/A') AS cargo_mod")

		);
		//COTIZACIONES_SUB_LIST
		$this->table2 = "co_cotizacion_sub co INNER JOIN co_cotizacion cp ON co.corigen=cp.ccotizacion INNER JOIN cli_maquinas cm ON cp.cmaquina=cm.cmaquina INNER JOIN cli_clientes c ON cm.ccliente=c.ccliente ";
		$this->table2 .= "INNER JOIN data_entes d ON c.cdata=d.cdata ";
		$this->table2 .= "INNER JOIN co_tipos ct ON co.ctipo=ct.ctipo INNER JOIN par_lugar pl ON co.clugar=pl.clugar ";
		$this->table2 .= "INNER JOIN cli_pagos clp ON c.cpago=clp.cpago ";
		$this->table2 .= "LEFT JOIN par_vehiculos pv ON co.cvehiculo=pv.cvehiculo INNER JOIN par_eq_trabajo pe ON co.cequipo=pe.cequipo ";
		$this->table2 .= "LEFT JOIN (SELECT ccotizacion, SUM(hh_taller+hh_terreno) AS horas, MIN(finicio) AS finicio, MAX(ffin) AS ffin FROM co_cotizacion_sub_det GROUP BY ccotizacion) ctd ON ctd.ccotizacion = co.ccotizacion ";

		$this->table2 .= "LEFT JOIN (SELECT cop.cordenservicio_sub, SUM(CASE WHEN(cop.adi = 0) THEN (TIMESTAMPDIFF(MINUTE, cop.finicio, cop.ffin))/60 ELSE 0 END) AS mins_plan, SUM(CASE WHEN(cop.adi = 1) THEN (TIMESTAMPDIFF(MINUTE, cop.finicio, cop.ffin))/60 ELSE 0 END) AS mins_adi, SUM(CASE WHEN(cop.adi = 0) THEN copd.col/60 ELSE 0 END) AS col_plan, SUM(CASE WHEN(cop.adi = 1) THEN copd.col/60 ELSE 0 END) AS col_adi FROM co_planificacion cop INNER JOIN co_planificacion_det copd USING (cplanificacion) WHERE cop.cordenservicio_sub > 0 AND cop.status=1 GROUP BY cop.cordenservicio_sub) plan ON plan.cordenservicio_sub = co.ccotizacion";

		$this->table2 .= " LEFT JOIN (SELECT MAX(chistoria) AS chistoria, ccotizacion FROM hist_cotizacion_sub GROUP BY ccotizacion) hcs ON co.ccotizacion=hcs.ccotizacion";
		$this->table2 .= " INNER JOIN eq_equipos eq ON cm.cequipo=eq.cequipo";
		$this->table2 .= " INNER JOIN eq_marcas em ON eq.cmarca=em.cmarca INNER JOIN eq_segmentos es ON es.csegmento=eq.csegmento";		
		$this->table2 .= " LEFT JOIN (SELECT cda.ccotizacion AS cotizacion, COUNT(*) AS cuenta, cda.cant-(SUM(CASE WHEN (im.tipo='CSM') THEN imd.cant WHEN (im.tipo='DCS') THEN -imd.cant ELSE 0 END)) AS cant_disp FROM co_cotizacion_sub_det_art cda INNER JOIN inv_articulos ia USING (carticulo) INNER JOIN inv_clasificacion ic USING (cclasificacion) LEFT JOIN inv_movimientos_det imd ON cda.ccotizacionart=imd.corigen_det LEFT JOIN inv_movimientos im ON imd.cmovimiento_key=im.cmovimiento_key WHERE ic.articulo=1 GROUP BY cda.ccotizacion) cue ON cue.cotizacion=co.ccotizacion";
		//AUDITORIA
		$this->table2 .= " LEFT JOIN adm_usuarios u1 ON co.crea_user=u1.cusuario LEFT JOIN nom_trabajadores t1 ON u1.ctrabajador=t1.ctrabajador LEFT JOIN data_entes d1 ON t1.cdata=d1.cdata LEFT JOIN nom_cargos c1 ON t1.ccargo=c1.ccargo";
		$this->table2 .= " LEFT JOIN adm_usuarios u2 ON co.mod_user=u2.cusuario LEFT JOIN nom_trabajadores t2 ON u2.ctrabajador=t2.ctrabajador LEFT JOIN data_entes d2 ON t2.cdata=d2.cdata LEFT JOIN nom_cargos c2 ON t2.ccargo=c2.ccargo";
		//ORIGEN
		$this->table2 .= " LEFT JOIN co_cotizacion_sub co1 ON co.corigen_gar=co1.ccotizacion LEFT JOIN co_cotizacion cp1 ON co1.corigen=cp1.ccotizacion";
		$this->tId2 = "co.ccotizacion";
		$this->db2 = new database($this->table2, $this->tId2);
		$this->db2->fields = array (
			array ('system',	"LPAD(".$this->tId2."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(co.corigen*1,"._PAD_CEROS_.",'0') AS origen"),
			array ('system',	"LPAD(co.correlativo*1,"._PAD_CEROS_.",'0') AS correlativo"),
			array ('system',	"LPAD(c.ccliente*1,"._PAD_CEROS_.",'0') AS codigo_cliente"),
			array ('system',	"IF(co.cordenservicio_sub=0, 'N/A', LPAD(co.cordenservicio_sub*1,"._PAD_CEROS_.",'0')) AS codigo_ods"),
			array ('system',	"IF(cp.cordenservicio=0, 'N/A', LPAD(cp.cordenservicio*1,"._PAD_CEROS_.",'0')) AS codigo_ods_cab"),
			array ('system',	"IF(co.cordenservicio_sub>0, CONCAT(LPAD(cp.cordenservicio*1,"._PAD_CEROS_.",'0'), '-',co.cordenservicio_sub*1),'N/A') AS ods_full"),
			array ('system',	"CONCAT(LPAD(cp.ccotizacion*1,"._PAD_CEROS_.",'0'), '-',co.correlativo*1) AS cot_full"),
			array ('system',	"IF(co.corigen_gar>0, LPAD(co.corigen_gar*1,"._PAD_CEROS_.",'0'), 'N/A') AS cot_gar_full"),
			array ('system',	"IF(co1.cordenservicio_sub>0, CONCAT(LPAD(cp1.cordenservicio*1,"._PAD_CEROS_.",'0'), '-',co1.cordenservicio_sub*1),'N/A') AS ods_full_gar"),
			array ('system',	"CONCAT(LPAD(cp1.ccotizacion*1,"._PAD_CEROS_.",'0'), '-',co1.correlativo*1) AS cot_full_gar"),
			array ('system',	"IF(co.cfactura>0, co.cfactura,'N/A') AS cfactura"),
			array ('system',	"IF(co.fecha_fac>0, DATE_FORMAT(co.fecha_fac, '%d-%m-%Y'),'N/A') AS fecha_fac"),
			array ('system',	"d.direccion"),
			array ('system',	"d.tel_fijo"),
			array ('system',	"d.tel_movil"),
			array ('system',	"c.contacto"),
			array ('system',	"clp.pago"),
			array ('system',	"(d.code) AS code"),
			array ('system',	'd.data'),
			array ('system',	'co.ctipo'),
			array ('system',	'ct.tipo'),
			array ('system',	'co.clugar'),
			array ('system',	'pl.lugar'),
			array ('system',	'co.cvehiculo'),
			array ('system',	'pv.vehiculo'),
			array ('system',	'co.dist'),
			array ('system',	'co.viajes'),
			array ('system',	'(co.tipo) AS parte'),
			array ('system',	'co.cequipo'),
			array ('system',	'pe.equipo'),
			array ('system',	'pe.trabs'),
			array ('system',	'co.status'),
			array ('system',	'co.cfactura'),
			array ('system',	'co.m_serv'),
			array ('system',	'co.m_rep'),
			array ('system',	'co.m_ins'),
			array ('system',	'co.m_stt'),
			array ('system',	'co.m_tra'),
			array ('system',	'co.m_misc'),
			array ('system',	'co.m_subt'),
			array ('system',	'co.m_descp'),
			array ('system',	'co.m_desc'),
			array ('system',	'co.m_neto'),
			array ('system',	'co.m_impp'),
			array ('system',	'co.m_imp'),
			array ('system',	'co.m_bruto'),
			array ('system',	'eq.equipo AS maquina'),
			array ('system',	'eq.csegmento'),
			array ('system',	'es.segmento'),
			array ('system',	'eq.cmarca'),
			array ('system',	'em.marca'),
			array ('system',	'eq.modelo'),
			array ('system',	'cm.serial'),
			array ('system',	'cm.interno'),
			array ('system',	'DATE_FORMAT(ctd.finicio, "%d-%m-%Y") AS llegada'),
			array ('system',	'DATE_FORMAT(ctd.ffin, "%d-%m-%Y") AS retiro'),
			array ('system',	'ctd.horas'),
			array ('system',	'FORMAT(IFNULL(plan.mins_plan/pe.trabs,0),2) AS plani'),
			array ('system',	'FORMAT(IFNULL(plan.mins_adi/pe.trabs,0),2) AS adic'),
			array ('system',	'FORMAT(IFNULL(plan.col_plan/pe.trabs,0),2) AS plani_col'),
			array ('system',	'FORMAT(IFNULL(plan.col_adi/pe.trabs,0),2) AS adic_col'),
			array ('system',	'FORMAT(IFNULL((plan.mins_plan-plan.col_plan)/pe.trabs,0),2) AS ocupado'),
			array ('system',	'FORMAT(ctd.horas-IFNULL(((plan.mins_plan-plan.col_plan)/pe.trabs),0),2) AS restante'),
			array ('system',	'FORMAT(IFNULL((((plan.mins_plan-plan.col_plan)/pe.trabs)*100)/ctd.horas,0),2) AS avance'),
			array ('system',	'cue.cuenta'),
			array ('system',	'co.notas'),
			array ('system',	'co.notas_user'),
			array ('system',	'co.archivo'),
			array ('system',	"LPAD(u1.ctrabajador*1,"._PAD_CEROS_.",'0') AS trabajador_crea"),
			array ('system',	"d1.data AS data_crea"),
			array ('system',	"d1.code As code_crea"),
			array ('system',	"(CASE WHEN co.clugar=1 THEN 'NO APLICA' ELSE pv.vehiculo END) AS transporte"),
			array ('system',	'DATE_FORMAT(co.crea_date, "%d-%m-%Y") AS fecha'),
			array ('system',	'DATE_FORMAT(co.crea_date, "%d-%m-%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(co.mod_date, "%d-%m-%Y %T") AS mod_date'),
			array ('system',	"LPAD(hcs.chistoria, 10, '0') AS ultima_edicion"),
			array ('system',	"(CASE WHEN co.crea_user='METALSIGMAUSER' THEN co.crea_user WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS crea_user"),
			array ('system',	"(CASE WHEN co.mod_user='METALSIGMAUSER' THEN co.mod_user WHEN u2.ctrabajador=0 THEN u2.nombres ELSE d2.data END) AS mod_user"),
			array ('system',	"IFNULL(c1.cargo, 'N/A') AS cargo_crea"),
			array ('system',	"IFNULL(c2.cargo, 'N/A') AS cargo_mod")
		);
		//COTIZA_SUB_EDIT
		$this->table3 = "co_cotizacion_sub";
		$this->tId3 = "ccotizacion";
		$this->db3 = new database($this->table3, $this->tId3);
		$this->db3->fields = array (
			array ('system',	"LPAD(".$this->tId3."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'ctipo'),
			array ('public',	'clugar'),
			array ('public',	'cvehiculo'),
			array ('public',	'dist'),
			array ('public',	'viajes'),
			array ('public',	'tipo'),
			array ('public',	'cequipo'),
			array ('public',	'status'),
			array ('public',	'm_serv'),
			array ('public',	'm_rep'),
			array ('public',	'm_ins'),
			array ('public',	'm_stt'),
			array ('public',	'm_tra'),
			array ('public',	'm_misc'),
			array ('public',	'm_subt'),
			array ('public',	'm_descp'),
			array ('public',	'm_desc'),
			array ('public',	'm_neto'),
			array ('public',	'm_impp'),
			array ('public',	'm_imp'),
			array ('public',	'm_bruto'),
			array ('public',	'notas'),
			array ('public',	'corigen_gar'),
			array ('public_i',	'corigen'),			
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//COTIZA_SUB_DET_EDIT
		$this->table4 = "co_cotizacion_sub_det";
		$this->tId4 = "ccotizaciondet";
		$this->db4 = new database($this->table4, $this->tId4);
		$this->db4->fields = array (
			array ('system',	"LPAD(".$this->tId4."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'ccotizaciondet'),
			array ('public',	'cparte'),
			array ('public',	'cpieza'),
			array ('public',	'hh_taller'),
			array ('public',	'hh_terreno'),
			array ('public',	'dias_taller'),
			array ('public',	'cservicio'),
			array ('public',	'precio'),
			array ('public',	'finicio'),
			array ('public',	'ffin'),
			array ('public',	'ccotizacion'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//COTIZA_SUB_DET_ART_EDIT
		$this->table5 = "co_cotizacion_sub_det_art";
		$this->tId5 = "ccotizacionart";
		$this->db5 = new database($this->table5, $this->tId5);
		$this->db5->fields = array (
			array ('system',	"LPAD(".$this->tId5."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'ccotizacionart'),
			array ('public',	'carticulo'),
			array ('public',	'cant'),
			array ('public',	'precio'),
			array ('public',	'ccotizacion'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//COTIZA_SUB_DET_LIST
		$this->table6 = "co_cotizacion_sub_det cod INNER JOIN eq_partes ep ON cod.cparte=ep.cparte INNER JOIN eq_piezas eqp ON cod.cpieza=eqp.cpieza INNER JOIN inv_articulos inv ON cod.cservicio=inv.carticulo";
		$this->table6 .= " LEFT JOIN (SELECT MAX(chistoria) AS chistoria, ccotizaciondet FROM hist_cotizacion_sub_det GROUP BY ccotizaciondet) hcsd ON cod.ccotizaciondet=hcsd.ccotizaciondet";
		$this->tId6 = "cod.ccotizaciondet";
		$this->db6 = new database($this->table6, $this->tId6);
		$this->db6->fields = array (
			array ('system',	"LPAD(".$this->tId6."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	'cod.cparte'),
			array ('system',	'ep.parte'),
			array ('system',	'cod.cpieza'),
			array ('system',	'eqp.pieza'),
			array ('system',	'cod.hh_taller'),
			array ('system',	'cod.hh_terreno'),
			array ('system',	'cod.dias_taller'),
			array ('system',	'cod.cservicio'),
			array ('system',	'inv.articulo'),
			array ('system',	'cod.precio'),
			array ('system',	'cod.finicio'),
			array ('system',	'cod.ffin'),
			array ('system',	'cod.ccotizacion'),
			array ('system',	'cod.del'),
			array ('system',	'cod.crea_user'),
			array ('system',	'cod.crea_date'),
			array ('system',	'cod.mod_user'),
			array ('system',	'cod.mod_date'),
			array ('system',	"LPAD(hcsd.chistoria, 10, '0') AS ultima_edicion")
		);		
		//COTIZA_SUB_DET_ART_LIST
		$this->table7 = "co_cotizacion_sub_det_art coa INNER JOIN inv_articulos a ON coa.carticulo=a.carticulo INNER JOIN inv_clasificacion ic ON a.cclasificacion=ic.cclasificacion";
		$this->table7 .= " LEFT JOIN (SELECT MAX(chistoria) AS chistoria, ccotizacionart FROM hist_cotizacion_sub_det_art GROUP BY ccotizacionart) hcsa ON coa.ccotizacionart=hcsa.ccotizacionart";
		$this->table7 .= " LEFT JOIN (SELECT imd.carticulo, SUM(CASE WHEN (im.tipo='CSM') THEN imd.cant ELSE -imd.cant END) AS cant_csm, imd.corigen_det FROM inv_movimientos_det imd INNER JOIN inv_movimientos im ON imd.cmovimiento_key=im.cmovimiento_key WHERE im.tipo IN ('CSM','DCS') GROUP BY imd.carticulo,imd.corigen_det) inv_csm ON inv_csm.corigen_det=coa.ccotizacionart";
		$this->tId7 = "coa.ccotizacionart";
		$this->db7 = new database($this->table7, $this->tId7);
		$this->db7->fields = array (
			array ('system',	"LPAD(".$this->tId7."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	'a.codigo2'),
			array ('system',	'coa.carticulo'),
			array ('system',	'a.articulo'),
			array ('system',	'coa.cant'),
			array ('system',	'(coa.cant-inv_csm.cant_csm) AS cant_disp'),
			array ('system',	'coa.precio'),
			array ('system',	'(a.precio) AS precio_'),
			array ('system',	'coa.ccotizacion'),
			array ('system',	'a.cclasificacion'),
			array ('system',	'ic.clasificacion'),
			array ('system',	'coa.del'),
			array ('system',	'coa.crea_user'),
			array ('system',	'coa.crea_date'),
			array ('system',	'coa.mod_user'),
			array ('system',	'coa.mod_date'),
			array ('system',	"LPAD(hcsa.chistoria, 10, '0') AS ultima_edicion")
		);
		//COTIZA_EDIT
		$this->table8 = "co_cotizacion";
		$this->tId8 = "ccotizacion";
		$this->db8 = new database($this->table8, $this->tId8);
		$this->db8->fields = array (
			array ('system',	"LPAD(".$this->tId8."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'cmaquina'),
			array ('public',	'status'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//HIST_COT_SUB_DET
		$this->table10 = "hist_cotizacion_sub_det hcsd INNER JOIN eq_partes ep ON hcsd.cparte=ep.cparte INNER JOIN eq_piezas eqp ON hcsd.cpieza=eqp.cpieza INNER JOIN inv_articulos inv ON hcsd.cservicio=inv.carticulo";
		$this->tId10 = "hcsd.chistoria";
		$this->db10 = new database($this->table10, $this->tId10);
		$this->db10->fields = array (
			array ('system',	"LPAD(".$this->tId10."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	'hcsd.cparte'),
			array ('system',	'ep.parte'),
			array ('system',	'hcsd.cpieza'),
			array ('system',	'eqp.pieza'),
			array ('system',	'hcsd.hh_taller'),
			array ('system',	'hcsd.hh_terreno'),
			array ('system',	'hcsd.dias_taller'),
			array ('system',	'hcsd.cservicio'),
			array ('system',	'inv.articulo'),
			array ('system',	'hcsd.precio'),
			array ('system',	'hcsd.finicio'),
			array ('system',	'hcsd.ffin'),
			array ('system',	'hcsd.ccotizacion'),
			array ('system',	'hcsd.acc'),
			array ('system',	'hcsd.user'),
			array ('system',	'hcsd.date')
		);
		//HIST_COT_SUB_DET_ART
		$this->table12 = "hist_cotizacion_sub_det_art hcsda INNER JOIN inv_articulos a ON hcsda.carticulo=a.carticulo INNER JOIN inv_clasificacion ic ON a.cclasificacion=ic.cclasificacion";
		$this->tId12 = "hcsda.chistoria";
		$this->db12 = new database($this->table12, $this->tId12);
		$this->db12->fields = array (
			array ('system',	"LPAD(".$this->tId12."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	'a.codigo2'),
			array ('system',	'hcsda.carticulo'),
			array ('system',	'a.articulo'),
			array ('system',	'hcsda.cant'),
			array ('system',	'hcsda.precio'),
			array ('system',	'(a.precio) AS precio_'),
			array ('system',	'hcsda.ccotizacion'),
			array ('system',	'a.cclasificacion'),
			array ('system',	'ic.clasificacion'),
			array ('system',	'hcsda.acc'),
			array ('system',	'hcsda.user'),
			array ('system',	'hcsda.date')
		);
		//HIST_COT_SUB
		$this->table14 = "hist_cotizacion_sub hcs";
		$this->tId14 = "hcs.chistoria";
		$this->db14 = new database($this->table14, $this->tId14);
		$this->db14->fields = array (
			array ('system',	"LPAD(".$this->tId14."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	'hcs.m_descp'),
			array ('system',	'hcs.m_desc'),
			array ('system',	'hcs.user'),
			array ('system',	'hcs.date')
		);
		//COTIZACION_ART / INV / ART
		$this->table15 = "co_cotizacion_sub_det_art cda INNER JOIN co_cotizacion_sub cs USING (ccotizacion) INNER JOIN inv_articulos ia ON cda.carticulo=ia.carticulo";
		$this->table15 .= " LEFT JOIN (SELECT im.corigen AS cotizacion, SUM((CASE WHEN (im.tipo IN ('CSM')) THEN imd.cant ELSE imd.cant*-1 END)) AS cant FROM inv_movimientos im LEFT JOIN inv_movimientos_det imd USING (cmovimiento_key) WHERE im.tipo IN ('CSM','DCS') GROUP BY im.corigen,imd.carticulo) im ON im.cotizacion = cda.ccotizacion";

		$this->table15 .= " LEFT JOIN (SELECT ir.ccotizacion, ir.calmacen, ir.carticulo, SUM(ir.cant) AS cant FROM inv_reservas ir WHERE ir.status = 1 GROUP BY ir.ccotizacion, ir.calmacen, ir.carticulo) ir ON ir.ccotizacion = cda.ccotizacion AND ir.carticulo = ia.carticulo";

		$this->table15 .= " INNER JOIN inv_clasificacion ic USING (cclasificacion)";
		$this->tId15 = "cda.carticulo";
		$this->db15 = new database($this->table15, $this->tId15);
		$this->db15->fields = array (
			array ('system',	"LPAD(".$this->tId15."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	'ia.codigo2'),
			array ('system',	'ia.articulo'),
			array ('system',	'cda.cant AS cant_ods'),
			array ('system',	'IFNULL(im.cant,0) AS cant_ent'),
			array ('system',	'ia.cant AS cant_inv'),
			array ('system',	'ir.cant AS cant_res')
		);
		////COTIZACION COMPRAS
		$this->table16 = "com_cot_ser cot INNER JOIN com_cot_ser_det cotd USING (ccotizacion) ";
		$this->table16 .= "INNER JOIN pro_proveedores pro USING(cproveedor) INNER JOIN data_entes d USING (cdata) ";
		$this->tId16 = "cot.ccotizacion";
		$this->db16 = new database($this->table16, $this->tId16);
		$this->db16->fields = array (
			array ('system',	"LPAD(".$this->tId16."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(pro.cproveedor*1,"._PAD_CEROS_.",'0') AS codigo_proveedor"),
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
			array ('system',	'cot.mod_user'),
			array ('system',	'DATE_FORMAT(cot.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(cot.mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		////COTIZACION COMPRAS EDIT
		$this->table17 = "com_cot_ser";		
		$this->tId17 = "ccotizacion";
		$this->db17 = new database($this->table17, $this->tId17);
		$this->db17->fields = array (
			array ('system',	"LPAD(".$this->tId17."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public_u',	"cods"),
			array ('public_u',	"mod_user")
		);
	}
	/** TIPOS COTIZACIONES */
	//LISTAR
	public function list_(){
		return $this->db->getRecords();
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
		return $this->db->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db->updateRecord($id,$data);
	}
	/** COTIZACIONES */
	//LISTAR
	public function list_all($status=false,$campos=false,$tipo=false){
		$data = array ();
		$cont=-1;
		if($status){
			$cont++;
			$data[$cont]["row"]="cb.status";
			$data[$cont]["operator"]="IN";
			$data[$cont]["value"]=$status;
		}
		if($tipo){
			$cont++;
			$data[$cont]["row"]="cb.ctipo";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$tipo;
		}
		return $this->db1->getRecords($campos,$data,"cp.ccotizacion");
	}
	//GET
	public function get_all($id){
		$result=array();
		$result=$this->db1->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_all($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db8->insertRecord($data);
	}
	/** COTIZACIONES_SUB */
	//LISTAR
	public function list_sub($origen=false,$status=false,$times=false,$cliente=false,$finicio=false,$ffin=false,$cuentas=false,$notIn=false,$dias_old=false,$orden=false){
		$data = array (); $cont=-1;
		if($origen){
			$cont++;
			$data[$cont]["row"]="co.corigen";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$origen;
		}
		if($status){
			$cont++;
			$data[$cont]["row"]="co.status";
			$data[$cont]["operator"]="IN";
			$data[$cont]["value"]=$status;
		}
		if($cliente){
			$cont++;
			$data[$cont]["row"]="c.ccliente";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$cliente;
		}
		if($finicio){
			$cont++;
			$data[$cont]["row"]="DATE_FORMAT(co.crea_date, '%Y-%m-%d')";
			$data[$cont]["operator"]=">=";
			$data[$cont]["value"]=$finicio;
		}
		if($ffin){
			$cont++;
			$data[$cont]["row"]="DATE_FORMAT(co.crea_date, '%Y-%m-%d')";
			$data[$cont]["operator"]="<=";
			$data[$cont]["value"]=$ffin;
		}
		if($cuentas){
			$cont++;
			$data[$cont]["row"]="cue.cant_disp";
			$data[$cont]["operator"]=">";
			$data[$cont]["value"]=0;	
		}
		if($notIn){
			$cont++;
			$data[$cont]["row"]="co.ccotizacion";
			$data[$cont]["operator"]="NOT IN";
			$data[$cont]["value"]=$notIn;
		}
		if($dias_old){
			$cont++;
			$data[$cont]["row"]="DATEDIFF(NOW(),co.fecha_fac)";
			$data[$cont]["operator"]="<=";
			$data[$cont]["value"]=$dias_old;
			$cont++;
			$data[$cont]["row"]="co.corigen_gar";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=0;
		}
		$having = ($times) ? "restante $times" : "" ;
		$having = ($cuentas) ? "cuenta > 0" : "" ;
		$forden = ($orden) ? $orden : false ;
		return $this->db2->getRecords(false,$data,"co.ccotizacion",$forden,$having);
	}
	//LISTAR AGRUPADOS
	public function list_sub_group($group,$campos,$status=false,$vendedor=false,$mes=false,$year=false){
		$data = array (); $cont=-1;
		if($status){
			$cont++;
			$data[$cont]["row"]="co.status";
			$data[$cont]["operator"]="IN";
			$data[$cont]["value"]=$status;
		}
		if($vendedor){
			$cont++;
			$data[$cont]["row"]="co.crea_user";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$vendedor;
		}
		if($mes){
			$cont++;
			$data[$cont]["row"]="MONTH(co.crea_date)";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$mes;
		}
		if($year){
			$cont++;
			$data[$cont]["row"]="YEAR(co.crea_date)";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$year;
		}
		return $this->db2->getRecords($campos,$data,$group);
	}
	//GET
	public function get_sub($id,$Notdeleted=false){
		$result = $this->db2->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$resultado["title"]="SUCCESS";
			$cab=$result["content"][0];
			$resultado["cab"]=$cab;
			$result = $this->db1->getRecord($cab["origen"]);
			if($result["title"]=="SUCCESS"){
				$resultado["datos"]=$result["content"][0];
			}else{
				$resultado["datos"]=NULL;
			}
			$data = array ();
			$data[0]["row"]="ccotizacion";
			$data[0]["operator"]="=";
			$data[0]["value"]=$id;
			$result = $this->db6->getRecords(false,$data);
			if($result["title"]=="SUCCESS"){
				$resultado["det"]=$result["content"];
			}else{
				$resultado["det"]=NULL;
			}
			if($Notdeleted){
				$data[1]["row"]="coa.del";
				$data[1]["operator"]="<>";
				$data[1]["value"]=1;
			}
			$result = $this->db7->getRecords(false,$data);
			if($result["title"]=="SUCCESS"){
				$resultado["art"]=$result["content"];
			}else{
				$resultado["art"]=NULL;
			}
			$data = array ();
			$data[0]["row"]="cot.cods";
			$data[0]["operator"]="=";
			$data[0]["value"]=$id;
			$result = $this->db16->getRecords(false,$data,"cot.ccotizacion");
			if($result["title"]=="SUCCESS"){
				$resultado["cot"]=$result["content"];
			}else{
				$resultado["cot"]=NULL;
			}
		}else{
			$resultado = $result;
		}
		return $resultado;
	}
	//GET
	public function get_sub_ods($id){
		$data = array ();
		$data[0]["row"]="co.ccotizacion";
		$data[0]["operator"]="=";
		$data[0]["value"]=$id;
		return $this->db2->getRecords(false,$data);
	}
	//CREAR
	public function new_co_sub($data,$detalles,$arts,$cots){
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
					array_push($datos, $detalles[7][$i]);
					array_push($datos, $detalles[8][$i]);
					array_push($datos, $detalles[9][$i]);
					array_push($datos, $id);
					array_push($datos, $_SESSION['metalsigma_log']);
					$result = $this->db4->insertRecord($datos);
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						$data = array ();
						$data[0]["row"]="ccotizacion";
						$data[0]["operator"]="=";
						$data[0]["value"]=$id;
						$this->db3->deleteRecord($id);
						$this->db4->deleteRecords($data);
						break;
					}
				}
			}
			if(!empty($arts[0])){
				for ($i=0; $i<sizeof($arts[0]); $i++){
					$datos=array();
					$new_id = ($arts[0][$i]==0) ? "" : $arts[0][$i] ;
					array_push($datos, $new_id);
					array_push($datos, $arts[1][$i]);
					array_push($datos, $arts[2][$i]);
					array_push($datos, $arts[3][$i]);
					array_push($datos, $id);
					array_push($datos, $_SESSION['metalsigma_log']);
					$result = $this->db5->insertRecord($datos);
					//print_r($result);
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						$data = array ();
						$data[0]["row"]="ccotizacion";
						$data[0]["operator"]="=";
						$data[0]["value"]=$id;
						$result = $this->db3->deleteRecord($id);
						$result = $this->db4->deleteRecords($data);
						$result = $this->db5->deleteRecords($data);
						break;
					}
				}
			}
			//PRIMERO QUITO TODAS LAS COTIZACIONES QUE USO ESTA COTIZACION
			$data=$conditions=array();
			$data[]=0;
			$data[]=$_SESSION['metalsigma_log'];
			$conditions[0]["row"]="cods";
			$conditions[0]["operator"]="=";
			$conditions[0]["value"]=$id;
			$this->db17->updateRecord(0,$data,$conditions);
			if(!empty($cots[0])){
				$data=$conditions=array();
				$data[]=$id;
				$data[]=$_SESSION['metalsigma_log'];
				$conditions[0]["row"]="ccotizacion";
				$conditions[0]["operator"]="IN";
				$conditions[0]["value"]=$cots;
				$this->db17->updateRecord(0,$data,$conditions);
			}
		}
		$resultado=$result;
		return $resultado;
	}
	//ACTUALIZAR
	public function edit_co_sub($id,$data,$detalles,$arts,$cots){
		$resultado = false;
		$data[]=$_SESSION['metalsigma_log'];
		$result = $this->db3->updateRecord($id,$data);
		if($result["title"]=="SUCCESS"){
			if(!empty($detalles[0])){
				$query_id=array();
				for ($i=0; $i<sizeof($detalles[0]); $i++){
					//ARMO EL ARREGLO CON LOS IDS QUE ESTOY USANDO
					array_push($query_id, $detalles[0][$i]);
					$datos=array();
					//PARA CONTROLAR EL UPSERT SI PASO 0 (NUEVO) LO DEJO VACIO, DE LO CONTRARIO CONSERVO EL ID
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
					array_push($datos, $detalles[9][$i]);
					array_push($datos, $id);
					array_push($datos, $_SESSION['metalsigma_log']);
					$result = $this->db4->upsertRecord($datos);
					//print_r($result);
					if($result["id"]!=0){
						//SI UPSERT INSERTA TOMO EL NUEVO ID AL ARREGLO, ASI EVITO QUE SEA DEPURADO LUEGO
						array_push($query_id, $result["id"]);
					}
					//print_r($result)."<br>";
					if($result["title"]!="SUCCESS"){
						//SI OPTUVE UN ERROR DETENGO EL BUCLE Y ME SALGO
						$resultado=$result;
						break;
					}
				}
				//PROCEDO A INHABILITAR LOS REGISTROS QUE NO SE USARON
				//ME ASEGURO CON DEL QUE NO HAYAN SIDO ELIMINADOS ANTERIORMENTE Y ASI NO EXTIENDO LA FECHA DE MODIFICACION
				$data=$conditions=array();
				$data[]=1;
				$data[]=$_SESSION['metalsigma_log'];
				$conditions[0]["row"]="ccotizacion";
				$conditions[0]["operator"]="=";
				$conditions[0]["value"]=$id;
				$conditions[1]["row"]="ccotizaciondet";
				$conditions[1]["operator"]="NOT IN";
				$conditions[1]["value"]=$query_id;
				$conditions[2]["row"]="del";
				$conditions[2]["operator"]="=";
				$conditions[2]["value"]=0;
				//print_r($query_id);
				//VACIO LOS CAMPOS PARA SOLO TOCAR LOS QUE DESEO
				$this->db4->fields=array();
				$this->db4->fields[0]=array ('public_u',	'del');
				$this->db4->fields[1]=array ('public_u',	'mod_user');
				$result = $this->db4->updateRecord(0,$data,$conditions);
			}
			if(!empty($arts[0])){
				$query_id=array();
				for ($i=0; $i<sizeof($arts[0]); $i++){
					array_push($query_id, $arts[0][$i]);
					$datos=array();
					$new_id = ($arts[0][$i]==0) ? "" : $arts[0][$i] ;
					array_push($datos, $new_id);
					array_push($datos, $arts[1][$i]);
					array_push($datos, $arts[2][$i]);
					array_push($datos, $arts[3][$i]);
					array_push($datos, $id);
					array_push($datos, $_SESSION['metalsigma_log']);
					$result = $this->db5->upsertRecord($datos);
					if($result["id"]!=0){
						array_push($query_id, $result["id"]);
					}
					//print_r($result)."<br>";
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						break;
					}
				}
				//PROCEDO A INHABILITAR LOS REGISTROS QUE NO SE USARON
				$data=$conditions=array();
				$data[]=1;
				$data[]=$_SESSION['metalsigma_log'];
				$conditions[0]["row"]="ccotizacion";
				$conditions[0]["operator"]="=";
				$conditions[0]["value"]=$id;
				$conditions[1]["row"]="del";
				$conditions[1]["operator"]="=";
				$conditions[1]["value"]=0;
				$conditions[2]["row"]="ccotizacionart";
				$conditions[2]["operator"]="NOT IN";
				$conditions[2]["value"]=$query_id;
				//print_r($query_id);
				//VACIO LOS CAMPOS PARA SOLO TOCAR LOS QUE DESEO
				$this->db5->fields=array();
				$this->db5->fields[0]=array ('public_u',	'del');
				$this->db5->fields[1]=array ('public_u',	'mod_user');
				$result = $this->db5->updateRecord(0,$data,$conditions);
			}			
			//PRIMERO QUITO TODAS LAS COTIZACIONES QUE USO ESTA COTIZACION
			$data=$conditions=array();
			$data[]=0;
			$data[]=$_SESSION['metalsigma_log'];
			$conditions[0]["row"]="cods";
			$conditions[0]["operator"]="=";
			$conditions[0]["value"]=$id;
			$result = $this->db17->updateRecord(0,$data,$conditions);
			//print_r($result);
			if(!empty($cots[0])){
				$data=$conditions=array();
				$data[]=$id;
				$data[]=$_SESSION['metalsigma_log'];
				$conditions[0]["row"]="ccotizacion";
				$conditions[0]["operator"]="IN";
				$conditions[0]["value"]=$cots;
				$this->db17->updateRecord(0,$data,$conditions);
			}
		}
		$resultado=$result;
		return $resultado;
	}
	//ACTUALIZAR STATUS (APROBAR CLIENTE, RECHAZAR, ANULAR)
	public function pro_co_sub($id,$data){
		$resultado = false;
		//VACIO LOS CAMPOS DE LA TABLA PARA SOLO SETEAR 3
		$this->db3->fields=array();
		$this->db3->fields[0]=array ('public_u',	'status');
		$this->db3->fields[1]=array ('public_u',	'notas');
		$this->db3->fields[2]=array ('public_u',	'archivo');
		$this->db3->fields[3]=array ('public_u',	'notas_user');
		$this->db3->fields[4]=array ('public_u',	'mod_user');
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db3->updateRecord($id,$data);
	}
	//ODS
	public function set_ods($id,$origen){
		//VACIO LOS CAMPOS DE LA TABLA PARA SOLO SETEAR 3
		$this->db3->fields=$data=array();
		$this->db3->fields[0]=array ('public_u',	'cordenservicio_sub');
		$this->db3->fields[1]=array ('public_u',	'corigen');
		$this->db3->fields[2]=array ('public_u',	'mod_user');
		$data[]=1;
		$data[]=$origen;
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db3->updateRecord($id,$data);
	}
	//FAC
	public function set_fac($id,$data){
		//VACIO LOS CAMPOS DE LA TABLA PARA SOLO SETEAR 3
		$this->db3->fields=array();
		$this->db3->fields[0]=array ('public_u',	'cfactura');
		$this->db3->fields[1]=array ('public_u',	'fecha_fac');
		$this->db3->fields[2]=array ('public_u',	'mod_user');
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db3->updateRecord($id,$data);
	}
	//LISTAR ARTS DESDE UNA ODS (PARA COMPRAS)
	public function list_art_ods($cotizacion=false,$almacen=false){
		$f_alm = ($almacen) ? 'AND im.calmacen='.$almacen : '' ;
		$f_alm2 = ($almacen) ? 'AND ir.calmacen='.$almacen : '' ;
		$f_alm3 = ($almacen) ? 'ir.calmacen, ' : '' ;
		$f_alm4 = ($almacen) ? 'AND ir2.calmacen='.$almacen : '' ;
		$sql = 
		'SELECT
		LPAD(cda.carticulo*1,'._PAD_CEROS_.',"0") AS codigo,
		LPAD(cda.ccotizacionart*1,'._PAD_CEROS_.',"0") AS codigo_cot,
		ia.codigo2,
		ia.articulo,
		ic.cclasificacion,
		ic.clasificacion,
		cda.precio AS precio,
		cda.cant AS cant_ods,
		IFNULL(im.cant,0) AS cant_ent,
		IFNULL(imm.cant,0) AS cant_inv,
		IFNULL(ir.cant,0) AS cant_res,
		IFNULL(ir2.cant,0) AS cant_res_alm
		FROM co_cotizacion_sub_det_art cda
		INNER JOIN co_cotizacion_sub cs USING (ccotizacion)
		INNER JOIN inv_articulos ia ON cda.carticulo=ia.carticulo
		INNER JOIN inv_clasificacion ic USING (cclasificacion)
		LEFT JOIN (SELECT im.corigen AS cotizacion, (SUM(imd.cant*imu.mul)*-1) AS cant FROM inv_movimientos im INNER JOIN inv_movimientos_det imd USING(cmovimiento_key) INNER JOIN inv_multiplicador imu ON im.tipo=imu.tipo WHERE im.tipo IN("CSM", "DCS") GROUP BY im.corigen,imd.carticulo) im ON im.cotizacion = cda.ccotizacion
		LEFT JOIN (SELECT ir.ccotizacion, ir.calmacen, ir.carticulo, SUM(ir.cant) AS cant FROM inv_reservas ir WHERE ir.status = 1 GROUP BY ir.ccotizacion, ir.calmacen, ir.carticulo) ir ON ir.ccotizacion = cda.ccotizacion AND ir.carticulo = ia.carticulo '.$f_alm2.'

		LEFT JOIN (SELECT ir.calmacen, ir.carticulo, SUM(ir.cant) AS cant FROM inv_reservas ir WHERE ir.status = 1 GROUP BY '.$f_alm3.'ir.carticulo) ir2 ON ir2.carticulo = ia.carticulo '.$f_alm4.'

		LEFT JOIN (SELECT imd.carticulo, SUM(imd.cant*imu.mul) AS cant FROM inv_movimientos im INNER JOIN inv_movimientos_det imd USING(cmovimiento_key) INNER JOIN inv_multiplicador imu ON im.tipo=imu.tipo WHERE (im.tipo IN ("COM","DCO","AJE","AJS","SI","CSM","DCS","COI","DCI","TRE","TRS") || (im.tipo="NTE" && im.corigen=0)) AND im.status = "PRO" '.$f_alm.' GROUP BY imd.carticulo) imm ON imm.carticulo=ia.carticulo
		WHERE cda.carticulo > 0
		';
		if($cotizacion){
			$sql .= ' AND cda.ccotizacion = '.$cotizacion;
		}		
		//echo $sql;
		$result = $this->db15->sql($sql);
		//print_r($result);
		return $result;
	}
	/** HISTORIAL COTIZACIONES_SUB_DET */
	//OBTENER
	public function get_hcsd($id){
		return $this->db10->getRecord($id);
	}
	/** HISTORIAL COTIZACIONES_SUB_DET_ART */
	//OBTENER
	public function get_hcsa($id){
		return $this->db12->getRecord($id);
	}
	/** HISTORIAL COTIZACIONES_SUB */
	//OBTENER
	public function get_hcs($id){
		return $this->db14->getRecord($id);
	}
}
?>