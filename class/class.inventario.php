<?php
class inventario{	
	//ARTICULOS_LIST
	private $db;
	public $table;
	public $Id;
	//ALMACEN
	private $db1;
	public $table1;
	public $Id1;
	//ART_CLASIF
	private $db2;
	public $table2;
	public $Id2;
	//INV_MOVIMIENTOS_LIST
	private $db3;
	public $table3;
	public $Id3;
	//INV_MOVIMIENTOS_DET_LIST
	private $db4;
	public $table4;
	public $Id4;
	//INV_MOVIMIENTOS_EDIT
	private $db5;
	public $table5;
	public $Id5;
	//INV_MOVIMIENTOS_DET_EDIT
	private $db6;
	public $table6;
	public $Id6;
	//ODC_DET_CANT
	private $db7;
	public $table7;
	public $Id7;
	//INV_ARTICULOS_EDIT
	private $db8;
	public $table8;
	public $Id8;
	//REQUISICIONES_LIST
	private $db9;
	public $table9;
	public $Id9;
	//REQUISICIONES_DET_LIST
	private $db10;
	public $table10;
	public $Id10;
	//REQUISICIONES_EDIT
	private $db11;
	public $table11;
	public $Id11;
	//REQUISICIONES_DET_EDIT
	private $db12;
	public $table12;
	public $Id12;
	//REQUISICIONES_STATUS
	private $db13;
	public $table13;
	public $Id13;
	//RESERVAS_EDIT
	private $db14;
	public $table14;
	public $Id14;
	//RESERVAS_LIST
	private $db15;
	public $table15;
	public $Id15;
	//RESERVAS_LIST_DET
	private $db16;
	public $table16;
	public $Id16;
	//RESERVAS_DET_UP
	private $db17;
	public $table17;
	public $Id17;
	//INVENTARIO UND
	private $db18;
	public $table18;
	public $Id18;
	//INVENTARIO ORIGEN
	private $db19;
	public $table19;
	public $Id19;
	//INVENTARIO_COUNT
	private $db20;
	public $table20;
	public $Id20;
	public function __construct(){
		include_once('class.bd_transsac.php');
		//ARTICULOS
		$this->table = "inv_articulos ia INNER JOIN inv_clasificacion ic USING(cclasificacion)";
		//AUDITORIA
		$this->table .= " LEFT JOIN adm_usuarios u1 ON ia.crea_user=u1.cusuario LEFT JOIN nom_trabajadores t1 ON u1.ctrabajador=t1.ctrabajador LEFT JOIN data_entes d1 ON t1.cdata=d1.cdata LEFT JOIN nom_cargos c1 ON t1.ccargo=c1.ccargo";
		$this->table .= " LEFT JOIN adm_usuarios u2 ON ia.mod_user=u2.cusuario LEFT JOIN nom_trabajadores t2 ON u2.ctrabajador=t2.ctrabajador LEFT JOIN data_entes d2 ON t2.cdata=d2.cdata LEFT JOIN nom_cargos c2 ON t2.ccargo=c2.ccargo";
		$this->tId = "ia.carticulo";
		$this->db = new database($this->table, $this->tId);
		$this->db->fields = array (
			array ('system',	"LPAD(".$this->tId."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"ic.clasificacion"),
			array ('system',	"(ic.articulo) AS tip_clasif"),
			array ('system',	'ia.codigo2'),
			array ('system',	'ia.cbarra'),
			array ('system',	'ia.articulo'),
			array ('system',	'ia.descripcion'),
			array ('system',	'ia.cclasificacion'),
			array ('system',	'ia.costo_prom'),
			array ('system',	'ia.costo_ant'),
			array ('system',	'ia.costo_actual'),
			array ('system',	'ia.cunidad'),
			array ('system',	'ia.cant'),
			array ('system',	'ia.precio'),
			array ('system',	'ia.status'),
			array ('system',	'DATE_FORMAT(ia.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(ia.mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	"(CASE WHEN ia.crea_user='METALSIGMAUSER' THEN ia.crea_user WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS crea_user"),
			array ('system',	"(CASE WHEN ia.mod_user='METALSIGMAUSER' THEN ia.mod_user WHEN u2.ctrabajador=0 THEN u2.nombres ELSE d2.data END) AS mod_user"),
			array ('system',	"IFNULL(c1.cargo, 'N/A') AS cargo_crea"),
			array ('system',	"IFNULL(c2.cargo, 'N/A') AS cargo_mod")
		);
		//ALMACEN
		$this->table1 = "inv_almacen";
		$this->tId1 = "calmacen";
		$this->db1 = new database($this->table1, $this->tId1);
		$this->db1->fields = array (
			array ('system',	"LPAD(".$this->tId1."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'almacen'),
			array ('public',	'compra'),
			array ('public',	'stock'),
			array ('public',	'status'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//ART_CLASIF
		$this->table2 = "inv_clasificacion";
		$this->tId2 = "cclasificacion";
		$this->db2 = new database($this->table2, $this->tId2);
		$this->db2->fields = array (
			array ('system',	"LPAD(".$this->tId2."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'clasificacion'),
			array ('public',	'articulo'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//INV_MOVIMIENTOS_LIST
		$this->table3 = "inv_movimientos im INNER JOIN inv_almacen ia ON im.calmacen=ia.calmacen LEFT JOIN pro_proveedores pro ON im.cproveedor=pro.cproveedor ";
		$this->table3 .= "LEFT JOIN data_entes d ON pro.cdata=d.cdata ";
		$this->table3 .= "LEFT JOIN data_comuna co ON d.ccomuna=co.ccomuna LEFT JOIN data_provincia pr ON co.cprovincia=pr.cprovincia ";
		$this->table3 .= "LEFT JOIN data_region r ON pr.cregion=r.cregion LEFT JOIN data_pais p ON r.cpais=p.cpais ";
		$this->table3 .= "INNER JOIN inv_movimientos_det imd ON (im.cmovimiento_key=imd.cmovimiento_key)";
		$this->table3 .= " LEFT JOIN co_cotizacion_sub cs ON im.corigen=cs.ccotizacion LEFT JOIN co_cotizacion cp ON cs.corigen=cp.ccotizacion";
		$this->table3 .= " LEFT JOIN cli_maquinas cm ON cp.cmaquina=cm.cmaquina LEFT JOIN cli_clientes c ON cm.ccliente=c.ccliente";
		$this->table3 .= " LEFT JOIN data_entes d3 ON c.cdata=d3.cdata";
		$this->table3 .= " LEFT JOIN eq_equipos eq ON cm.cequipo=eq.cequipo";
		$this->table3 .= " LEFT JOIN eq_marcas em ON eq.cmarca=em.cmarca LEFT JOIN eq_segmentos es ON es.csegmento=eq.csegmento";
		//AUDITORIA
		$this->table3 .= " LEFT JOIN adm_usuarios u1 ON im.crea_user=u1.cusuario LEFT JOIN nom_trabajadores t1 ON u1.ctrabajador=t1.ctrabajador LEFT JOIN data_entes d1 ON t1.cdata=d1.cdata LEFT JOIN nom_cargos c1 ON t1.ccargo=c1.ccargo";
		$this->table3 .= " LEFT JOIN adm_usuarios u2 ON im.mod_user=u2.cusuario LEFT JOIN nom_trabajadores t2 ON u2.ctrabajador=t2.ctrabajador LEFT JOIN data_entes d2 ON t2.cdata=d2.cdata LEFT JOIN nom_cargos c2 ON t2.ccargo=c2.ccargo";
		//ANULACIONES
		$this->table3 .= " LEFT JOIN inv_movimientos im1 ON im.cmovimiento_key=im1.corigen AND im1.tipo NOT IN ('COM','NTE','CSM')";
		//ORIGENES
		$this->table3 .= " LEFT JOIN inv_movimientos im2 ON im.corigen=im2.cmovimiento_key";
		$this->tId3 = "im.cmovimiento_key";
		$this->db3 = new database($this->table3, $this->tId3);
		$this->db3->fields = array (
			array ('system',	"LPAD(".$this->tId3."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(im.cmovimiento*1,"._PAD_CEROS_.",'0') AS codigo_transaccion"),
			array ('system',	"LPAD(pro.cproveedor*1,"._PAD_CEROS_.",'0') AS codigo_proveedor"),
			array ('system',	"LPAD(ia.calmacen*1,"._PAD_CEROS_.",'0') AS codigo_almacen"),
			array ('system',	"IF(cs.cordenservicio_sub>0, CONCAT(LPAD(cp.cordenservicio*1,"._PAD_CEROS_.",'0'), '-',cs.cordenservicio_sub*1),'N/A') AS ods_pad"),
			array ('system',	"IF(im1.corigen>0,im1.corigen,'N/A') AS dev"),
			array ('system',	"IF(im1.corigen>0,LPAD(im1.cmovimiento*1,"._PAD_CEROS_.",'0'),'N/A') AS cod_dev"),
			array ('system',	"IF(im.corigen>0,LPAD(im2.cmovimiento*1,"._PAD_CEROS_.",'0'),'N/A') AS codigo_devolucion"),
			array ('system',	"IF(im.corigen>0,LPAD(im2.cmovimiento_key*1,"._PAD_CEROS_.",'0'),'N/A') AS codigo_devolucion_trans"),
			array ('system',	"IF(im.corigen>0,DATE_FORMAT(im2.fecha_mov,'%d-%m-%Y'),'N/A') AS fecha_origen"),
			array ('system',	"(d3.code) AS cot_code"),
			array ('system',	'd3.data AS cot_cliente'),
			array ('system',	'eq.equipo AS maquina'),
			array ('system',	'eq.csegmento'),
			array ('system',	'es.segmento'),
			array ('system',	'eq.cmarca'),
			array ('system',	'em.marca'),
			array ('system',	'eq.modelo'),
			array ('system',	'cm.serial'),
			array ('system',	'cm.interno'),
			array ('system',	"(d.code) AS code"),
			array ('system',	'd.data'),
			array ('system',	'd.data2'),
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
			array ('system',	"im.tipo"),
			array ('system',	'DATE_FORMAT(im.fecha_mov,"%d-%m-%Y") AS fecha_mov'),
			array ('system',	"im.documento"),
			array ('system',	'DATE_FORMAT(im.fecha_doc,"%d-%m-%Y") AS fecha_doc'),
			array ('system',	"ia.almacen"),
			array ('system',	"im.tipo"),
			array ('system',	"im.status"),
			array ('system',	"im.monto_mov"),
			array ('system',	"im.monto_desc"),
			array ('system',	"im.monto_total"),
			array ('system',	"im.corigen"),
			array ('system',	"im.observacion"),
			array ('system',	'COUNT(imd.cant) AS articulos'),
			array ('system',	'DATE_FORMAT(im.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(im.mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	"(CASE WHEN im.crea_user='METALSIGMAUSER' THEN im.crea_user WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS crea_user"),
			array ('system',	"(CASE WHEN im.mod_user='METALSIGMAUSER' THEN im.mod_user WHEN u2.ctrabajador=0 THEN u2.nombres ELSE d2.data END) AS mod_user"),
			array ('system',	"IFNULL(c1.cargo, 'N/A') AS cargo_crea"),
			array ('system',	"IFNULL(c2.cargo, 'N/A') AS cargo_mod")
		);
		//INV_MOVIMIENTOS_DET_LIST
		$this->table4 = "inv_movimientos_det imd LEFT JOIN com_odc_det ocd ON imd.corden_det=ocd.corden_det ";
		$this->table4 .= "LEFT JOIN com_odc oc ON ocd.corden=oc.corden ";
		//SI TIENE NTE
		$this->table4 .= "LEFT JOIN inv_movimientos_det imd1 ON imd.cnota_det=imd1.cmovimiento_det ";
		$this->table4 .= "LEFT JOIN inv_movimientos im1 ON imd1.cmovimiento_key=im1.cmovimiento_key ";
		$this->table4 .= "INNER JOIN inv_articulos ia ON imd.carticulo=ia.carticulo ";
		$this->table4 .= "LEFT JOIN inv_movimientos im ON im.cmovimiento_key=imd.cmovimiento_key ";
		//SI EL MOVIMIENTO TIENE ORIGEN
		$this->table4 .= "LEFT JOIN inv_movimientos_det imdo ON imd.corigen_det=imdo.cmovimiento_det ";
		$this->table4 .= "LEFT JOIN inv_movimientos imo ON imdo.cmovimiento_key=imo.cmovimiento_key ";
		$this->table4 .= "LEFT JOIN inv_multiplicador imul ON im.tipo=imul.tipo ";
		$this->tId4 = "imd.cmovimiento_det";
		$this->db4 = new database($this->table4, $this->tId4);
		$this->db4->fields = array (
			array ('system',	"LPAD(".$this->tId4."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(ia.carticulo*1,"._PAD_CEROS_.",'0') AS codigo_articulo"),
			array ('system',	"LPAD(imd.cmovimiento_key*1,"._PAD_CEROS_.",'0') AS codigo_cabecera"),
			array ('system',	"LPAD(IFNULL(oc.corden,0)*1,"._PAD_CEROS_.",'0') AS codigo_odc"),
			array ('system',	"LPAD(IFNULL(im1.cmovimiento,0)*1,"._PAD_CEROS_.",'0') AS codigo_nte"),
			array ('system',	"LPAD(IFNULL(im1.cmovimiento_key,0)*1,"._PAD_CEROS_.",'0') AS codigo_nte_cab"),
			array ('system',	"LPAD(IFNULL(imd1.cmovimiento_det,0)*1,"._PAD_CEROS_.",'0') AS codigo_nte_det"),
			array ('system',	"LPAD(imdo.cmovimiento_det*1,"._PAD_CEROS_.",'0') AS codigo_origen_det"),
			array ('system',	"LPAD(imo.cmovimiento*1,"._PAD_CEROS_.",'0') AS codigo_origen_cab"),
			array ('system',	"LPAD(imo.cmovimiento_key*1,"._PAD_CEROS_.",'0') AS codigo_origen_cabecera"),
			array ('system',	"LPAD(im.cmovimiento*1,"._PAD_CEROS_.",'0') AS codigo_movimiento"),
			array ('system',	"ia.codigo2"),
			array ('system',	"ia.articulo"),
			array ('system',	"imd.cant"),
			//array ('system',	"(CASE WHEN (im.tipo IN ('NTE','COM','AJE','SI','DCS','DCI', 'TRE')) THEN 1 ELSE -1 END) AS mul"),
			array ('system',	"imul.mul"),
			array ('system',	"ocd.cant_rest"),
			array ('system',	"imd.costou"),
			array ('system',	"imd.imp_p"),
			array ('system',	"imd.imp_m"),
			array ('system',	"imd.costot"),
			array ('system',	"imd.corigen_det"),
			array ('system',	"imd.corden_det"),
			array ('system',	"imd.cnota_det")
		);
		//INV_MOVIMIENTOS_EDIT
		$this->table5 = "inv_movimientos";
		$this->tId5 = "cmovimiento_key";
		$this->db5 = new database($this->table5, $this->tId5);
		$this->db5->fields = array (
			array ('system',	"LPAD(".$this->tId5."*1,"._PAD_CEROS_.",'0') AS codigo"),			
			array ('public',	"fecha_mov"),
			array ('public',	'documento'),
			array ('public',	'cproveedor'),
			array ('public',	'fecha_doc'),
			array ('public',	'calmacen'),
			array ('public',	'calmacen2'),
			array ('public',	'status'),
			array ('public',	'monto_mov'),
			array ('public',	'monto_desc'),
			array ('public',	'monto_total'),
			array ('public',	'corigen'),
			array ('public',	'observacion'),
			array ('public_i',	"tipo"),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//INV_MOVIMIENTOS_DET_EDIT
		$this->table6 = "inv_movimientos_det";
		$this->tId6 = "cmovimiento_det";
		$this->db6 = new database($this->table6, $this->tId6);
		$this->db6->fields = array (
			array ('system',	"LPAD(".$this->tId6."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	"cmovimiento_det"),
			array ('public',	"carticulo"),
			array ('public',	"cant"),
			array ('public',	"costou"),
			array ('public',	"imp_p"),
			array ('public',	"imp_m"),
			array ('public',	"costot"),
			array ('public',	"corigen_det"),
			array ('public',	"corden_det"),
			array ('public',	"cnota_det"),
			array ('public',	"cmovimiento_key"),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//ODC_DET_EDIT
		$this->table7 = "com_odc_det";
		$this->tId7 = "corden_det";
		$this->db7 = new database($this->table7, $this->tId7);
		$this->db7->fields = array (
			array ('system',	"LPAD(".$this->tId7."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public_u',	'cant_rest'),
			array ('public_u',	'mod_user')
		);
		//ARTICULOS_EDIT
		$this->table8 = "inv_articulos";
		$this->tId8 = "carticulo";
		$this->db8 = new database($this->table8, $this->tId8);
		$this->db8->fields = array (
			array ('system',	"LPAD(".$this->tId8."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	'codigo2'),
			array ('public',	'cbarra'),
			array ('public',	'articulo'),
			array ('public',	'descripcion'),
			array ('public',	'cclasificacion'),
			array ('public',	'precio'),
			array ('public',	'costo_prom'),
			array ('public',	'status'),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//REQUISICIONES_LIST
		$this->table9 = "inv_requisiciones ir INNER JOIN inv_almacen ia1 ON ir.calmacenori=ia1.calmacen INNER JOIN inv_almacen ia2 ON ir.calmacendes=ia2.calmacen";
		//AUDITORIA
		$this->table9 .= " LEFT JOIN adm_usuarios u1 ON ir.crea_user=u1.cusuario LEFT JOIN nom_trabajadores t1 ON u1.ctrabajador=t1.ctrabajador LEFT JOIN data_entes d1 ON t1.cdata=d1.cdata LEFT JOIN nom_cargos c1 ON t1.ccargo=c1.ccargo";
		$this->table9 .= " LEFT JOIN adm_usuarios u2 ON ir.mod_user=u2.cusuario LEFT JOIN nom_trabajadores t2 ON u2.ctrabajador=t2.ctrabajador LEFT JOIN data_entes d2 ON t2.cdata=d2.cdata LEFT JOIN nom_cargos c2 ON t2.ccargo=c2.ccargo";
		$this->tId9 = "ir.crequisicion";
		$this->db9 = new database($this->table9, $this->tId9);
		$this->db9->fields = array (
			array ('system',	"LPAD(".$this->tId9."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"LPAD(ia1.calmacen*1,"._PAD_CEROS_.",'0') AS cod_almacenori"),
			array ('system',	"LPAD(ia2.calmacen*1,"._PAD_CEROS_.",'0') AS cod_almacendes"),
			array ('system',	'DATE_FORMAT(ir.fecha,"%d-%m-%Y") AS fecha'),
			array ('system',	"ia1.almacen AS alm_ori"),
			array ('system',	"ia2.almacen AS alm_des"),
			array ('system',	"ir.status"),
			array ('system',	"ir.observacion"),
			array ('system',	'DATE_FORMAT(ir.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(ir.mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	"(CASE WHEN ir.crea_user='METALSIGMAUSER' THEN ir.crea_user WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS crea_user"),
			array ('system',	"(CASE WHEN ir.mod_user='METALSIGMAUSER' THEN ir.mod_user WHEN u2.ctrabajador=0 THEN u2.nombres ELSE d2.data END) AS mod_user"),
			array ('system',	"IFNULL(c1.cargo, 'N/A') AS cargo_crea"),
			array ('system',	"IFNULL(c2.cargo, 'N/A') AS cargo_mod")
		);
		//REQUISICIONES_DET_LIST
		$this->table10 = "inv_requisiciones_det ird INNER JOIN inv_requisiciones ir USING (crequisicion) INNER JOIN inv_articulos ia USING (carticulo)";
		$this->table10 .= " INNER JOIN inv_clasificacion ic USING (cclasificacion)";
		$this->tId10 = "ird.crequisicion_det";
		$this->db10 = new database($this->table10, $this->tId10);
		$this->db10->fields = array (
			array ('system',	"LPAD(".$this->tId10."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"ir.crequisicion AS cod_requisicion"),
			array ('system',	"ia.carticulo AS cod_articulo"),
			array ('system',	"ia.codigo2"),
			array ('system',	"ia.articulo"),
			array ('system',	"ia.descripcion"),
			array ('system',	"ic.cclasificacion"),
			array ('system',	"ic.clasificacion"),
			array ('system',	"ird.cant")
		);
		//REQUISICIONES_EDIT
		$this->table11 = "inv_requisiciones";
		$this->tId11 = "crequisicion";
		$this->db11 = new database($this->table11, $this->tId11);
		$this->db11->fields = array (
			array ('system',	"LPAD(".$this->tId11."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	"calmacenori"),
			array ('public',	"calmacendes"),
			array ('public',	"fecha"),
			array ('public',	"observacion"),
			array ('public',	"status"),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user'),
			array ('system',	'DATE_FORMAT(crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//REQUISICIONES_DET_EDIT
		$this->table12 = "inv_requisiciones_det";
		$this->tId12 = "crequisicion_det";
		$this->db12 = new database($this->table12, $this->tId12);
		$this->db12->fields = array (
			array ('system',	"LPAD(".$this->tId12."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	"crequisicion_det"),
			array ('public',	"carticulo"),
			array ('public',	"cant"),
			array ('public',	"crequisicion"),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//REQUISICIONES_STATUS
		$this->table13 = "inv_requisiciones";
		$this->tId13 = "crequisicion";
		$this->db13 = new database($this->table13, $this->tId13);
		$this->db13->fields = array (
			array ('system',	"LPAD(".$this->tId13."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public_u',	"status"),
			array ('public_u',	'mod_user')
		);
		//RESERVAS_EDIT
		$this->table14 = "inv_reservas";
		$this->tId14 = "creserva";
		$this->db14 = new database($this->table14, $this->tId14);
		$this->db14->fields = array (
			array ('system',	"LPAD(".$this->tId14."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	"ccotizacion"),
			array ('public',	"calmacen"),
			array ('public',	"carticulo"),
			array ('public',	"cant"),
			array ('public',	"notas"),
			array ('public',	"status"),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		$this->db14->campos=sizeof($this->db14->fields);
		//RESERVAS_LIST
		$this->table15 = "inv_reservas ir INNER JOIN inv_almacen ia USING (calmacen) INNER JOIN co_cotizacion_sub co USING (ccotizacion) INNER JOIN co_cotizacion cp ON co.corigen=cp.ccotizacion";
		//AUDITORIA
		$this->table15 .= " LEFT JOIN adm_usuarios u1 ON ir.crea_user=u1.cusuario LEFT JOIN nom_trabajadores t1 ON u1.ctrabajador=t1.ctrabajador LEFT JOIN data_entes d1 ON t1.cdata=d1.cdata LEFT JOIN nom_cargos c1 ON t1.ccargo=c1.ccargo";
		$this->table15 .= " LEFT JOIN adm_usuarios u2 ON ir.mod_user=u2.cusuario LEFT JOIN nom_trabajadores t2 ON u2.ctrabajador=t2.ctrabajador LEFT JOIN data_entes d2 ON t2.cdata=d2.cdata LEFT JOIN nom_cargos c2 ON t2.ccargo=c2.ccargo";
		$this->tId15 = "ir.creserva";
		$this->db15 = new database($this->table15, $this->tId15);
		$this->db15->fields = array (
			array ('system',	"LPAD(".$this->tId15."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"IF(co.cordenservicio_sub>0, CONCAT(LPAD(cp.cordenservicio*1,"._PAD_CEROS_.",'0'), '-',co.cordenservicio_sub*1),'N/A') AS ods_full"),
			//array ('system',	"IF(co.cordenservicio_sub>0, CONCAT(cp.cordenservicio*1, '-',TRIM(LEADING '0' FROM co.cordenservicio_sub)),'N/A') AS ods_pad"),
			array ('system',	"ir.ccotizacion"),
			array ('system',	"ia.calmacen"),
			array ('system',	"ia.almacen"),
			array ('system',	"COUNT(DISTINCT(ir.carticulo)) AS articulos"),
			array ('system',	'DATE_FORMAT(ir.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(ir.mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	"(CASE WHEN ir.crea_user='METALSIGMAUSER' THEN ir.crea_user WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS crea_user"),
			array ('system',	"(CASE WHEN ir.mod_user='METALSIGMAUSER' THEN ir.mod_user WHEN u2.ctrabajador=0 THEN u2.nombres ELSE d2.data END) AS mod_user"),
			array ('system',	"IFNULL(c1.cargo, 'N/A') AS cargo_crea"),
			array ('system',	"IFNULL(c2.cargo, 'N/A') AS cargo_mod")
		);
		//RESERVAS_LIST_DET
		$this->table16 = "inv_reservas ir INNER JOIN inv_almacen ia USING (calmacen) INNER JOIN co_cotizacion_sub co USING (ccotizacion) INNER JOIN co_cotizacion cp ON co.corigen=cp.ccotizacion";
		$this->table16 .= " INNER JOIN inv_articulos iar ON ir.carticulo=iar.carticulo";
		$this->table16 .= " INNER JOIN cli_maquinas cm ON cp.cmaquina=cm.cmaquina INNER JOIN cli_clientes c ON cm.ccliente=c.ccliente ";
		$this->table16 .= "INNER JOIN data_entes d ON c.cdata=d.cdata ";
		$this->tId16 = "ir.creserva";
		$this->db16 = new database($this->table16, $this->tId16);
		$this->db16->fields = array (
			array ('system',	"LPAD(".$this->tId16."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('system',	"IF(co.cordenservicio_sub>0, CONCAT(LPAD(cp.cordenservicio*1,"._PAD_CEROS_.",'0'), '-',co.cordenservicio_sub*1),'N/A') AS ods_full"),
			//array ('system',	"IF(co.cordenservicio_sub>0, CONCAT(cp.cordenservicio, '-',TRIM(LEADING '0' FROM co.cordenservicio_sub)),'N/A') AS ods_pad"),
			array ('system',	"ir.ccotizacion"),
			array ('system',	"(d.code) AS code"),
			array ('system',	'd.data'),
			array ('system',	"ia.calmacen"),
			array ('system',	"ia.almacen"),
			array ('system',	"iar.carticulo"),
			array ('system',	"iar.codigo2"),
			array ('system',	"iar.articulo"),
			array ('system',	"iar.descripcion"),
			array ('system',	"(ir.cant) AS cant"),
			array ('system',	"ir.notas"),
			array ('system',	"ir.status"),
			array ('system',	'ir.crea_user'),
			array ('system',	'ir.mod_user'),
			array ('system',	'DATE_FORMAT(ir.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(ir.mod_date, "%d/%m/%Y %T") AS mod_date')
		);
		//RESERVAS_DET_UP
		$this->table17 = "inv_reservas";
		$this->tId17 = "creserva";
		$this->db17 = new database($this->table17, $this->tId17);
		$this->db17->fields = array (
			array ('system',	"LPAD(".$this->tId17."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public_u',	"status"),
			array ('public_u',	'mod_user')
		);
		//INVENTARIO UND
		$this->table18 = "inv_unidades";
		$this->tId18 = "cunidad";
		$this->db18 = new database($this->table18, $this->tId18);
		$this->db18->fields = array (
			array ('system',	"LPAD(".$this->tId18."*1,"._PAD_CEROS_.",'0') AS codigo"),
			array ('public',	"unidad"),
			array ('public',	"multiplicador"),
			array ('public',	"status"),
			array ('public_i',	'crea_user'),
			array ('public_u',	'mod_user')
		);
		//INVENTARIO ORIGEN
		$this->table19 = "inv_movimientos";
		$this->tId19 = "cmovimiento_key";
		$this->db19 = new database($this->table19, $this->tId19);
		$this->db19->fields = array (
			array ('system',	"LPAD(".$this->tId19."*1,"._PAD_CEROS_.",'0') AS codigo"),			
			array ('public_u',	"corigen"),
			array ('public_u',	'mod_user')
		);
		//INVENTARIO_COUNT
		$this->table20 = "inv_movimientos";
		$this->tId20 = "cmovimiento";
		$this->db20 = new database($this->table20, $this->tId20);
		$this->db20->fields = array (
			array ('system',	"COUNT(*) AS cuenta"),
			array ('system',	'tipo')
		);
	}
	//LISTAR_CUENTAS
	public function list_status(){
		$data = array ();
		$data[0]["row"]="status";
		$data[0]["operator"]="=";
		$data[0]["value"]="PEN";
		return $this->db20->getRecords(false,$data,"tipo");
	}
	/** ARTICULOS */
	//LISTAR
	public function list_($clasif=false,$tipoclasif=false,$non=false){
		$data = array ();
		$cont=-1;
		if($clasif){
			$cont++;
			$data[$cont]["row"]="ic.cclasificacion";
			$data[$cont]["operator"]="IN";
			$data[$cont]["value"]=$clasif;
		}
		if($tipoclasif){
			$tipoclasif = ($tipoclasif=="-1") ? "0" : $tipoclasif ;
			$cont++;
			$data[$cont]["row"]="ic.articulo";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$tipoclasif;
		}
		if($non){
			$cont++;
			$data[$cont]["row"]="ia.carticulo";
			$data[$cont]["operator"]="NOT IN";
			$data[$cont]["value"]=$non;
		}
		return $this->db->getRecords(false,$data);
	}
	//CHECK ARTS (DESDE EXCEL)
	public function setArticulos($articulos){
		$query_id=$resultado=array();
		$cont_ins=$cont_upt=0;
		for ($i=0; $i<sizeof($articulos[0]); $i++){
			$conditions=$datos=array();
			$conditions[0]["row"]="ia.codigo2";
			$conditions[0]["operator"]="=";
			$conditions[0]["value"]=$articulos[0][$i];
			$result = $this->db->getRecords(false,$conditions);
			//CONSULTO LA CCLASIFICACION
			$rs_cat=$this->db2->getRecord($articulos[3][$i]);
			$cat = ($rs_cat["title"]=="SUCCESS") ? $articulos[3][$i] : 5 ;

			array_push($datos, $articulos[0][$i]);	// CODIGO2
			array_push($datos, "");					// COD BARRA
			array_push($datos, $articulos[1][$i]);	// ARTICULO
			array_push($datos, $articulos[2][$i]);	// DESCRIPCION
			array_push($datos, $cat);				// CCLASIFICACION
			array_push($datos, 0);					// PRECIO
			array_push($datos, $articulos[4][$i]);	// COSTO
			array_push($datos, 1);					// STATUS
			array_push($datos, $_SESSION['metalsigma_log']);

			if($result["title"]=="SUCCESS"){
				$code = $result["content"][0]["codigo"];
				$result = $this->db8->updateRecord($code,$datos);
			}elseif($result["title"]=="WARNING"){
				$result = $this->db8->insertRecord($datos);				
			}
			if($result["title"]=="ERROR"){
				return $result;
			}elseif($result["title"]=="SUCCESS"){
				if($result["id"]==0){
					$cont_upt++;
				}else{
					$cont_ins++;
				}
			}
			//ARMO UN ARRAY CON LOS CODIGOS2 QUE ESTOY ENVIANDO
			array_push($query_id, $articulos[0][$i]);
		}
		//SELECCIONO LOS MISMOS ARTICULOS ENVIADOS
		$conditions=array();
		$conditions[0]["row"]="ia.codigo2";
		$conditions[0]["operator"]="IN";
		$conditions[0]["value"]=$query_id;
		$result = $this->db->getRecords(false,$conditions);
		if($result["title"]=="SUCCESS"){
			$result["ins"]=$cont_ins;
			$result["upt"]=$cont_upt;
		}
		$resultado = $result;
		return $resultado;
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
		return $this->db8->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db8->updateRecord($id,$data);
	}
	/** ALMACEN */
	//LISTAR
	public function list_a($status=false,$compra=false,$stock=false,$non=false,$in=false){
		$data = array ();
		$cont=-1;
		if($status){
			$cont++;
			$data[$cont]["row"]="status";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$status;
		}
		if($compra){
			$cont++;
			$data[$cont]["row"]="compra";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$compra;
		}
		if($stock){
			$cont++;
			$data[$cont]["row"]="stock";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$stock;
		}
		if($non){
			$cont++;
			$data[$cont]["row"]="calmacen";
			$data[$cont]["operator"]="NOT IN";
			$data[$cont]["value"]=$non;
		}
		//MUESTRA ALMACENES DE USUARIOS QUE NO SEAN ADMINISTRADOR
		if($in && ($_SESSION['metalsigma_log']!="ADMINISTRADOR")){
			$cont++;
			$data[$cont]["row"]="calmacen";
			$data[$cont]["operator"]="IN";
			$data[$cont]["value"]=$in;
		}
		return $this->db1->getRecords(false,$data);
	}
	//OBTENER
	public function get_a($id){
		$result=array();
		$result=$this->db1->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_a($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db1->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_a($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db1->updateRecord($id,$data);
	}
	/** ART_CLASIF */
	//LISTAR
	public function list_ac($clas=false){
		$data = array ();
		$cont=-1;
		if($clas){
			$clas = ($clas=="-1") ? "0" : $clas ;
			$cont++;
			$data[$cont]["row"]="articulo";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$clas;
		}
		return $this->db2->getRecords(false,$data);
	}
	//OBTENER
	public function get_ac($id){
		$result=array();
		$result=$this->db2->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//CREAR
	public function new_ac($data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db2->insertRecord($data);
	}
	//ACTUALIZAR
	public function edit_ac($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db2->updateRecord($id,$data);
	}
	/** INV_MOVIMIENTOS */
	//LISTAR
	public function list_mov($tipo=false,$alm=false,$prov=false,$status=false,$non=false,$orig=false,$in=false,$dev=false){
		$data = array ();
		$cont=-1;
		if($tipo){
			$cont++;
			$data[$cont]["row"]="im.tipo";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$tipo;
		}
		if($alm){
			$cont++;
			$data[$cont]["row"]="ia.calmacen";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$alm;
		}
		if($prov){
			$cont++;
			$data[$cont]["row"]="pro.cproveedor";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$prov;
		}
		if($status){
			$cont++;
			$data[$cont]["row"]="im.status";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$status;
		}
		if($non){
			$cont++;
			$data[$cont]["row"]="im.cmovimiento_key";
			$data[$cont]["operator"]="NOT IN";
			$data[$cont]["value"]=$non;
		}
		if($orig===true){
			$cont++;
			$data[$cont]["row"]="im.corigen";
			$data[$cont]["operator"]=">";
			$data[$cont]["value"]=0;
		}else if($orig===-1){
			$cont++;
			$data[$cont]["row"]="im.corigen";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=0;
		}
		if($dev){
			$algo=null;
			$cont++;
			$data[$cont]["row"]="im1.corigen";
			$data[$cont]["operator"]="IS";
			$data[$cont]["value"]=$algo;
		}
		//MUESTRA ALMACENES DE USUARIOS QUE NO SEAN ADMINISTRADOR
		if($in && ($_SESSION['metalsigma_log']!="ADMINISTRADOR")){
			$cont++;
			$data[$cont]["row"]="ia.calmacen";
			$data[$cont]["operator"]="IN";
			$data[$cont]["value"]=$in;
		}
		return $this->db3->getRecords(false,$data,"im.cmovimiento_key");
	}
	//LISTAR
	public function kardex($almacen=false,$ini=false,$fin=false,$articulo=false,$tipo=false){
		$sql = 
		'SELECT
		imd.cmovimiento_det,
		im.cmovimiento,
		im.tipo,
		im.documento,
		DATE_FORMAT(im.fecha_doc,"%d-%m-%Y") AS fecha_doc,
		ia.carticulo,
		ia.articulo,
		imd.costou,
		(imd.cant*imul.mul) AS cant
		FROM inv_articulos ia
		INNER JOIN inv_movimientos_det imd ON ia.carticulo=imd.carticulo
		INNER JOIN inv_movimientos im ON imd.cmovimiento_key=im.cmovimiento_key
		INNER JOIN inv_multiplicador imul ON im.tipo=imul.tipo
		WHERE im.cmovimiento_key > 0
		AND (im.tipo IN ("COM","DCO","AJE","AJS","SI","CSM","DCS","COI","DCI","TRE","TRS") || (im.tipo="NTE" && im.corigen=0))
		AND im.status = "PRO"';
		if($almacen){
			$sql .= ' AND im.calmacen = '.$almacen;
		}
		if($ini){
			$sql .= " AND DATE_FORMAT(im.fecha_doc,'%d-%m-%Y') >= '$ini'";
		}
		if($fin){
			$sql .= " AND DATE_FORMAT(im.fecha_doc,'%d-%m-%Y') <= '$fin'";
		}
		if($articulo){
			$sql .= ' AND ia.carticulo = '.$articulo;
		}
		if($tipo){
			$sql .= " AND im.tipo = '$tipo'";
		}
		$sql .= ' ORDER BY im.fecha_doc ASC';
		//echo $sql;
		return $this->db4->sql($sql);
	}
	//OBTENER
	public function get_mov($id){
		$resultado = false;
		$result = $this->db3->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$resultado["title"]="SUCCESS";
			$cab=$result["content"][0];
			$resultado["cab"]=$cab;
			$data = array ();
			$data[0]["row"]="imd.cmovimiento_key";
			$data[0]["operator"]="=";
			$data[0]["value"]=$id;			
			$result = $this->db4->getRecords(false,$data);
			//print_r($result);
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
	//LISTAR MOV BY DET
	public function list_mov_det($dets){
		$data = array ();
		$cont=-1;
		if($dets){
			$cont++;
			$data[$cont]["row"]="imd.cmovimiento_det";
			$data[$cont]["operator"]="IN";
			$data[$cont]["value"]=$dets;
		}
		return $this->db3->getRecords('DISTINCT(im.cmovimiento_key) AS codigo, im.cmovimiento AS codigo_cab, d.data,DATE_FORMAT(im.fecha_mov,"%d-%m-%Y") AS fecha_mov,COUNT(imd.cant) AS articulos,im.monto_total AS monto_total',$data);
	}
	//CREAR
	public function new_mov($tipo,$data,$det){
		$resultado = false;
		$status=$data[6];
		$origen=$data[10];
		$data[]=$tipo;
		$data[]=$_SESSION['metalsigma_log'];
		$result = $this->db5->insertRecord($data);
		//print_r($result);
		if($result["title"]=="SUCCESS"){
			if(!empty($det)){
				$id=$result["id"];
				$query_id=array();
				for ($i=0; $i<sizeof($det[0]); $i++){
					$datos=array();
					array_push($query_id, $det[9][$i]);
					$new_id = ($det[0][$i]==0) ? "" : $det[0][$i] ;
					array_push($datos, $new_id);
					array_push($datos, $det[1][$i]);
					array_push($datos, $det[2][$i]);
					array_push($datos, $det[3][$i]);
					array_push($datos, $det[4][$i]);
					array_push($datos, $det[5][$i]);
					array_push($datos, $det[6][$i]);
					array_push($datos, $det[7][$i]);
					array_push($datos, $det[8][$i]);
					array_push($datos, $det[9][$i]);
					array_push($datos, $id);
					array_push($datos, $_SESSION['metalsigma_log']);
					$result = $this->db6->insertRecord($datos);
					//print_r($result);
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						$data = array ();
						$data[0]["row"]="cmovimiento_key";
						$data[0]["operator"]="=";
						$data[0]["value"]=$id;
						$this->db5->deleteRecords($data);
						$this->db6->deleteRecords($data);
						break;
					}else{
						if($det[8][$i]!="0"){
							if($status=="PRO" && ($tipo=="COM" || $tipo=="NTE" || $tipo=="DNT" || $tipo=="DCO")){
								$datos1=array();
								$mul = ($tipo=="COM" || $tipo=="NTE") ? -1 : 1 ;
								array_push($datos1, ($det[2][$i]*$mul));
								array_push($datos1, $_SESSION['metalsigma_log']);
								$this->db7->updateRecord($det[8][$i],$datos1);
							}
						}
					}
				}
				if($tipo=="DCO" && $status=="PRO"){
					$conditions=$data1=array ();
					array_push($data1, 0);
					array_push($data1, $_SESSION['metalsigma_log']);
					$conditions[0]["row"]="corigen";
					$conditions[0]["operator"]="=";
					$conditions[0]["value"]=$origen;
					$conditions[1]["row"]="tipo";
					$conditions[1]["operator"]="=";
					$conditions[1]["value"]="NTE";
					$this->db19->updateRecord(0,$data1,$conditions);
				}
				if($tipo=="COM" || $tipo=="NTE"){
					$data1 = array ();
					$data1[0]["row"]="imd.cmovimiento_det";
					$data1[0]["operator"]="IN";
					$data1[0]["value"]=$query_id;
					$movs = $this->db3->getRecords('DISTINCT(im.cmovimiento_key) AS codigo, im.cmovimiento AS codigo_cab, d.data,DATE_FORMAT(im.fecha_mov,"%d-%m-%Y") AS fecha_mov,COUNT(imd.cant) AS articulos,monto_total AS monto_total',$data1);
					if($movs["title"]=="SUCCESS"){
						$cabs = array();
						foreach ($movs["content"] as $key => $value) {
							array_push($cabs, $value["codigo"]);
						}
						$data=$conditions=array();
						$data[]=$id;
						$data[]=$_SESSION['metalsigma_log'];
						$conditions[0]["row"]="cmovimiento_key";
						$conditions[0]["operator"]="IN";
						$conditions[0]["value"]=$cabs;
						$this->db5->fields=array();
						$this->db5->fields[0]=array ('public_u',	'corigen');
						$this->db5->fields[1]=array ('public_u',	'mod_user');
						$this->db5->updateRecord(0,$data,$conditions);
					}
				}
			}
		}
		$resultado=$result;
		return $resultado;
	}
	//ACTUALIZAR
	public function edit_mov($id,$data,$det,$tipo){
		$resultado = false;
		$status=$data[6];
		$data[]=$_SESSION['metalsigma_log'];
		$result = $this->db5->updateRecord($id,$data);
		//print_r($result);
		if($result["title"]=="SUCCESS"){
			if(!empty($det)){
				//ARMO 2 VARIABLES PARA LAS QUERYS
				$query_id=$query_nota=array(); $not_det="";
				for ($i=0; $i<sizeof($det[0]); $i++){
					$datos=$datos1=array();
					$new_id = ($det[0][$i]==0) ? "" : $det[0][$i] ;
					array_push($query_id, $det[0][$i]);
					array_push($query_nota, $det[9][$i]);
					$not_det .= $det[0][$i].", ";
					array_push($datos, $new_id);
					array_push($datos, $det[1][$i]);
					array_push($datos, $det[2][$i]);
					array_push($datos, $det[3][$i]);
					array_push($datos, $det[4][$i]);
					array_push($datos, $det[5][$i]);
					array_push($datos, $det[6][$i]);
					array_push($datos, $det[7][$i]);
					array_push($datos, $det[8][$i]);
					array_push($datos, $det[9][$i]);
					array_push($datos, $id);
					array_push($datos, $_SESSION['metalsigma_log']);
					$result = $this->db6->upsertRecord($datos);
					//print_r($result);
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						$data = array ();
						$data[0]["row"]="cmovimiento_key";
						$data[0]["operator"]="=";
						$data[0]["value"]=$id;
						$this->db5->deleteRecords($data);
						$this->db6->deleteRecords($data);
						break;
					}else{
						//SI UPSERT INSERTO UN DETALLE CAPTURO EL ID
						if($result["id"]!=0){
							array_push($query_id, $result["id"]);
							$not_det .= $result["id"].", ";
						}
						//SI EL STATUS ES PROCESADO Y ES UNA RECEPCION REDUZCO LA ODC
						if($status=="PRO" && ($tipo=="COM" || $tipo=="NTE")){
							array_push($datos1, ($det[2][$i]*-1));
							array_push($datos1, $_SESSION['metalsigma_log']);
							$this->db7->updateRecord($det[8][$i],$datos1);
						}
					}
				}
				if($tipo=="COM" || $tipo=="NTE"){					
					// OBTENGO LAS NTE ORIGEN QUE NO FUERON USADAS PARA LIBERARLAS
					$not_det = substr($not_det,0,-2);
					$sql = "SELECT DISTINCT(im1.cmovimiento_key) AS codigo FROM inv_movimientos_det imd INNER JOIN inv_movimientos im ON imd.cmovimiento_key=im.cmovimiento_key INNER JOIN inv_movimientos_det imd1 ON imd.cnota_det=imd1.cmovimiento_det INNER JOIN inv_movimientos im1 ON imd1.cmovimiento_key=im1.cmovimiento_key WHERE im.cmovimiento_key = ".$id." AND imd.cmovimiento_det NOT IN (".$not_det.")";
					$movs = $this->db3->sql($sql);
					if($movs["title"]=="SUCCESS"){
						$cabs = array();
						foreach ($movs["content"] as $key => $value) {
							array_push($cabs, $value["codigo"]);
						}
						$data=$conditions=array();
						$data[]=0;
						$data[]=$_SESSION['metalsigma_log'];
						$conditions[0]["row"]="cmovimiento_key";
						$conditions[0]["operator"]="IN";
						$conditions[0]["value"]=$cabs;
						$this->db5->fields=array();
						$this->db5->fields[0]=array ('public_u',	'corigen');
						$this->db5->fields[1]=array ('public_u',	'mod_user');
						$this->db5->updateRecord(0,$data,$conditions);						
					}
					// A LAS NTE QUE FUERON USADAS LAS CASO CON LA CABECERA DEL MOV ACTUAL
					$data1 = array ();
					$data1[0]["row"]="imd.cmovimiento_det";
					$data1[0]["operator"]="IN";
					$data1[0]["value"]=$query_nota;
					$movs = $this->db3->getRecords('DISTINCT(im.cmovimiento_key) AS codigo, im.cmovimiento AS codigo_cab, d.data,DATE_FORMAT(im.fecha_mov,"%d-%m-%Y") AS fecha_mov,COUNT(imd.cant) AS articulos,monto_total AS monto_total',$data1);
					if($movs["title"]=="SUCCESS"){
						$cabs = array();
						foreach ($movs["content"] as $key => $value) {
							array_push($cabs, $value["codigo"]);
						}
						$data=$conditions=array();
						$data[]=$id;
						$data[]=$_SESSION['metalsigma_log'];
						$conditions[0]["row"]="cmovimiento_key";
						$conditions[0]["operator"]="IN";
						$conditions[0]["value"]=$cabs;
						$this->db5->fields=array();
						$this->db5->fields[0]=array ('public_u',	'corigen');
						$this->db5->fields[1]=array ('public_u',	'mod_user');
						$this->db5->updateRecord(0,$data,$conditions);
					}
				}
				// LOS DETALLES QUE NO FUERON USADOS LOS BORRO
				$conditions=array();
				$conditions[0]["row"]="cmovimiento_key";
				$conditions[0]["operator"]="=";
				$conditions[0]["value"]=$id;
				$conditions[1]["row"]="cmovimiento_det";
				$conditions[1]["operator"]="NOT IN";
				$conditions[1]["value"]=$query_id;
				$this->db6->deleteRecords($conditions);
			}
		}
		$resultado=$result;
		return $resultado;
	}
	//MOV TRANSFERENCIA
	public function new_transf($data,$det){
		$tipo = array ("TRE","TRS");
		$resultado = false;
		foreach ($tipo as $key => $value) {
			$datos = array ();
			$alm = ($key==0) ? 2 : 1 ;
			$datos[$key][] = date("Y-m-d");
			$datos[$key][] = 0;
			$datos[$key][] = 0;
			$datos[$key][] = date("Y-m-d");
			$datos[$key][] = $data[$alm];
			$datos[$key][] = 0;
			$datos[$key][] = "PRO";
			$datos[$key][] = 0;
			$datos[$key][] = 0;
			$datos[$key][] = 0;
			$datos[$key][] = $data[0];
			$datos[$key][] = $data[3];
			$datos[$key][] = $tipo[$key];
			$datos[$key][] = $_SESSION['metalsigma_log'];

			$result = $this->db5->insertRecord($datos[$key]);
			if($result["title"]=="SUCCESS"){
				$id=$result["id"];
				if(!empty($det)){
					for ($i=0; $i<sizeof($det[0]); $i++){
						$datos=array();
						$datos[] = 0;
						$datos[] = $det[0][$i];
						$datos[] = $det[1][$i];
						$datos[] = 0;
						$datos[] = 0;
						$datos[] = 0;
						$datos[] = 0;
						$datos[] = 0;
						$datos[] = 0;
						$datos[] = 0;
						$datos[] = $id;
						$datos[] = $_SESSION['metalsigma_log'];
						$result = $this->db6->insertRecord($datos);
						if($result["title"]!="SUCCESS"){
							$resultado=$result;
							$data = array ();
							$data[0]["row"]="cmovimiento_key";
							$data[0]["operator"]="=";
							$data[0]["value"]=$id;
							$this->db5->deleteRecords($data);
							$this->db6->deleteRecords($data);
							break 2;
						}
					}
				}
				//SELLO LA REQUISICION
				$datos=array();
				$datos[] = "UTI";
				$datos[] = $_SESSION['metalsigma_log'];
				$result = $this->db13->updateRecord($data[0],$datos);
			}else{
				$resultado=$result;
				break;
			}
		}
		$resultado=$result;
		return $resultado;
	}
	/** REQUISICIONES */
	//LISTAR
	public function list_req($status=false,$almori=false,$almdes=false){
		$data = array ();
		$cont=-1;
		if($status){
			$cont++;
			$data[$cont]["row"]="ir.status";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$status;
		}
		if($almori){
			$cont++;
			$data[$cont]["row"]="ir.calmacenori";
			$data[$cont]["operator"]="IN";
			$data[$cont]["value"]=$almori;
		}
		//MUESTRA ALMACENES DE USUARIOS QUE NO SEAN ADMINISTRADOR
		if($almdes && ($_SESSION['metalsigma_log']!="ADMINISTRADOR")){
			$cont++;
			$data[$cont]["row"]="ir.calmacendes";
			$data[$cont]["operator"]="IN";
			$data[$cont]["value"]=$almdes;
		}
		return $this->db9->getRecords(false,$data);
	}
	//OBTENER
	public function get_req($id){
		$result=array();
		$result=$this->db9->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$resultado["title"]="SUCCESS";
			$resultado["cab"]=$result["content"][0];
			$data = array ();
			$data[0]["row"]="ir.crequisicion";
			$data[0]["operator"]="=";
			$data[0]["value"]=$id;
			$result = $this->db10->getRecords(false,$data);
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
	// NUEVO
	public function new_req($data,$detalles){
		$resultado = false;
		$data[]=$_SESSION['metalsigma_log'];
		$result = $this->db11->insertRecord($data);
		if($result["title"]=="SUCCESS"){
			$id=$result["id"];
			if(!empty($detalles[0])){
				for ($i=0; $i<sizeof($detalles[0]); $i++){
					$datos=array();
					$new_id = ($detalles[0][$i]==0) ? "" : $detalles[0][$i] ;
					array_push($datos, $new_id);
					array_push($datos, $detalles[1][$i]);
					array_push($datos, $detalles[2][$i]);
					array_push($datos, $id);
					array_push($datos, $_SESSION['metalsigma_log']);
					$result = $this->db12->insertRecord($datos);
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						$data = array ();
						$data[0]["row"]="crequisicion";
						$data[0]["operator"]="=";
						$data[0]["value"]=$id;
						$this->db11->deleteRecord($id);
						$this->db12->deleteRecords($data);
						break;
					}
				}
			}
		}
		$resultado=$result;
		return $resultado;
	}
	//ACTUALIZAR
	public function edit_req($id,$data,$detalles){
		$resultado = false;
		$data[]=$_SESSION['metalsigma_log'];
		$result = $this->db11->updateRecord($id,$data);
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
					array_push($datos, $id);
					array_push($datos, $_SESSION['metalsigma_log']);
					$result = $this->db12->upsertRecord($datos);
					//print_r($result);
					if($result["id"]!=0){
						array_push($query_id, $result["id"]);
					}
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						break;
					}
				}
				$conditions=array();
				$conditions[0]["row"]="crequisicion";
				$conditions[0]["operator"]="=";
				$conditions[0]["value"]=$id;
				$conditions[1]["row"]="crequisicion_det";
				$conditions[1]["operator"]="NOT IN";
				$conditions[1]["value"]=$query_id;
				$this->db12->deleteRecords($conditions);
			}
		}
		$resultado=$result;
		return $resultado;
	}
	/** RESERVAS */
	//LISTAR
	public function list_reser($status=false,$almacen=false,$cotizacion=false,$articulo=false){
		$data = array ();
		$cont=-1;
		if($status){
			$cont++;
			$data[$cont]["row"]="ir.status";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$status;
		}
		if($almacen){
			$cont++;
			$data[$cont]["row"]="ir.calmacen";
			$data[$cont]["operator"]="IN";
			$data[$cont]["value"]=$almacen;
		}
		if($cotizacion){
			$cont++;
			$data[$cont]["row"]="ir.ccotizacion";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$cotizacion;
		}
		if($articulo){
			$cont++;
			$data[$cont]["row"]="ir.carticulo";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$articulo;
		}
		return $this->db15->getRecords(false,$data,"ir.ccotizacion,ia.calmacen");
	}
	//OBTENER RESERVAS
	public function get_reser($status=false,$almacen=false,$cotizacion=false,$articulo=false){
		$data = array ();
		$cont=-1;
		if($status){
			$cont++;
			$data[$cont]["row"]="ir.status";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$status;
		}
		if($almacen){
			$cont++;
			$data[$cont]["row"]="ir.calmacen";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$almacen;
		}
		if($cotizacion){
			$cont++;
			$data[$cont]["row"]="ir.ccotizacion";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$cotizacion;
		}
		if($articulo){
			$cont++;
			$data[$cont]["row"]="ir.carticulo";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$articulo;
		}
		return $this->db16->getRecords(false,$data);
	}
	public function new_resv($detalles){
		$resultado = false;
		if(!empty($detalles[0])){
			for ($i=0; $i<sizeof($detalles[0]); $i++){
				$datos=array();
				array_push($datos, $detalles[0][$i]);
				array_push($datos, $detalles[1][$i]);
				array_push($datos, $detalles[2][$i]);
				array_push($datos, $detalles[3][$i]);
				array_push($datos, $detalles[4][$i]);
				array_push($datos, $detalles[5][$i]);
				array_push($datos, $_SESSION['metalsigma_log']);
				$result = $this->db14->insertRecord($datos);
				if($result["title"]!="SUCCESS"){
					$resultado=$result;
					$data = array ();
					$data[0]["row"]="ccotizacion";
					$data[0]["operator"]="=";
					$data[0]["value"]=$detalles[0][0];
					$data[1]["row"]="calmacen";
					$data[1]["operator"]="=";
					$data[1]["value"]=$detalles[1][0];
					$this->db14->deleteRecords($data);
					break;
				}else{
					$data=$conditions=array();
					$data[]=0;
					$data[]=$_SESSION['metalsigma_log'];
					$conditions[0]["row"]="ccotizacion";
					$conditions[0]["operator"]="=";
					$conditions[0]["value"]=$detalles[0][$i];
					$conditions[1]["row"]="calmacen";
					$conditions[1]["operator"]="=";
					$conditions[1]["value"]=$detalles[1][$i];
					$conditions[2]["row"]="carticulo";
					$conditions[2]["operator"]="=";
					$conditions[2]["value"]=$detalles[2][$i];
					$conditions[3]["row"]="creserva";
					$conditions[3]["operator"]="<>";
					$conditions[3]["value"]=$result["id"];
					$this->db17->updateRecord(0,$data,$conditions);
				}
			}
		}
		$resultado=$result;
		return $resultado;
	}
	/** UNIDADES */
	//LISTAR
	public function list_und($status=false){
		$data = array ();
		$cont=-1;
		if($status){
			$cont++;
			$data[$cont]["row"]="status";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$status;
		}
		return $this->db18->getRecords(false,$data);
	}
}
?>