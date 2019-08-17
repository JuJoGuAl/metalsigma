<?php
class permisos{
	//USUARIOS
	private $db_user;
	public $table_1;
	public $key_1;
	//USUARIOS_LIST
	private $db;
	public $table_;
	//MODULOS_USUARIO
	private $db_modu;
	public $table_2;
	public $key_2;
	//MODULOS
	private $db_mod;
	public $table_3;
	public $key_3;
	//MENU
	private $db_men;
	public $table_4;
	public $key_4;
	//SUBMENU
	private $db_smen;
	public $table_5;
	public $key_5;
	//PERMISOS
	private $db_per;
	public $table;
	public $key;
	//PERMISOS_ADMIN
	private $dba;
	public $tablea;
	public $keya;
	//USUARIOS_ALMACEN_EDIT
	private $db_alm;
	public $table_6;
	public $key_6;
	//USUARIOS_ALMACEN_LIST
	private $db_alm1;
	public $table_7;
	public $key_7;
	
	public function __construct(){
		include_once('class.bd_transsac.php');
		$this->table_1 = "adm_usuarios";
		$this->key_1 = "cusuario";
		$this->db_user = new database($this->table_1, $this->key_1);
		$this->db_user->fields = array (
			array ('system',	"$this->key_1 AS codigo"),
			array ("public",	"clave"),
			array ("public",	"status"),
			array ("public",	"ctrabajador"),
			array ("public",	"nombres"),
			array ("public_i",	$this->key_1),
			array ("public_i",	"crea_user"),
			array ("public_u",	"mod_user")
		);
		//USUARIOS LIST
		$this->table_ = "adm_usuarios u";
		$this->table_ .= " LEFT JOIN nom_trabajadores t ON u.ctrabajador=t.ctrabajador LEFT JOIN data_entes d ON t.cdata=d.cdata LEFT JOIN nom_cargos c ON t.ccargo=c.ccargo";
		//AUDITORIA
		$this->table_ .= " LEFT JOIN adm_usuarios u1 ON u.crea_user=u1.cusuario LEFT JOIN nom_trabajadores t1 ON u1.ctrabajador=t1.ctrabajador LEFT JOIN data_entes d1 ON t1.cdata=d1.cdata LEFT JOIN nom_cargos c1 ON t1.ccargo=c1.ccargo";
		$this->table_ .= " LEFT JOIN adm_usuarios u2 ON u.mod_user=u2.cusuario LEFT JOIN nom_trabajadores t2 ON u2.ctrabajador=t2.ctrabajador LEFT JOIN data_entes d2 ON t2.cdata=d2.cdata LEFT JOIN nom_cargos c2 ON t2.ccargo=c2.ccargo";
		$this->db = new database($this->table_, "u.cusuario");
		$this->db->fields = array (
			array ('system',	"u.cusuario AS codigo"),
			array ('system',	"LPAD(d.cdata*1,"._PAD_CEROS_.",'0') AS ente"),
			array ("system",	"u.clave"),
			array ("system",	"u.status"),
			array ('system',	"LPAD(u.ctrabajador*1,"._PAD_CEROS_.",'0') AS ctrabajador"),			
			array ('system',	"(CASE WHEN u.ctrabajador=0 THEN u.nombres ELSE d.data END) AS nombre"),
			array ('system',	"(CASE WHEN u.ctrabajador=0 THEN 0 ELSE d.code END) AS code"),
			array ('system',	"(CASE WHEN u.ctrabajador=0 THEN 'N/A' ELSE c.cargo END) AS cargo"),
			array ('system',	'DATE_FORMAT(u.crea_date, "%d/%m/%Y %T") AS crea_date'),
			array ('system',	'DATE_FORMAT(u.mod_date, "%d/%m/%Y %T") AS mod_date'),
			array ('system',	"(CASE WHEN u.crea_user='METALSIGMAUSER' THEN u.crea_user WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS crea_user"),
			array ('system',	"(CASE WHEN u.mod_user='METALSIGMAUSER' THEN u.mod_user WHEN u2.ctrabajador=0 THEN u2.nombres ELSE d2.data END) AS mod_user"),
			array ('system',	"IFNULL(c1.cargo, 'N/A') AS cargo_crea"),
			array ('system',	"IFNULL(c2.cargo, 'N/A') AS cargo_mod")
		);
		$this->table_2 = "adm_mod_usu";
		$this->key_2 = "cusuario";
		$this->db_modu = new database($this->table_2, $this->key_2);
		$this->db_modu->fields = array (
			array ("public",	"cmodulo"),
			array ("public",	"ins"),
			array ("public",	"upt"),
			array ("public",	$this->key_2)
		);
		$this->table_3 = "adm_mod";
		$this->key_3 = "cmodulo";
		$this->db_mod = new database($this->table_3, $this->key_3);
		$this->db_mod->fields = array (
			array ("system",	"modulo"),
			array ("system",	"mod_url"),
			array ("system",	"cmenu"),
			array ("system",	"csubmenu"),
			array ("system",	"orden"),
			array ("system",	"LPAD($this->key_3,10,0) AS codigo"),
			array ("system",	"(SELECT menu FROM adm_menu WHERE adm_menu.cmenu=adm_mod.cmenu) AS menu"),
			array ("system",	"(SELECT submenu FROM adm_menu_sub t1 WHERE t1.csubmenu=adm_mod.csubmenu) AS submenu")
		);
		$this->table_4 = "adm_menu";
		$this->key_4 = "cmenu";
		$this->db_men = new database($this->table_4, $this->key_4);
		$this->db_men->fields = array (
			array ("system",	"menu"),
			array ("system",	"icon"),
			array ("system",	"orden"),
			array ("system",	"LPAD($this->key_4,10,0) AS codigo")
		);
		$this->table_5 = "adm_menu_sub";
		$this->key_5 = "csubmenu";
		$this->db_smen = new database($this->table_5, $this->key_5);
		$this->db_smen->fields = array (
			array ("system",	"submenu"),
			array ("system",	"LPAD($this->key_5,10,0) AS codigo")
		);
		$this->table = "adm_mod_usu mu INNER JOIN adm_mod m ON mu.cmodulo=m.cmodulo";
		$this->table .= " INNER JOIN adm_menu am ON m.cmenu=am.cmenu";
		$this->table .= " INNER JOIN adm_menu_sub ams ON m.csubmenu=ams.csubmenu";
		$this->key = "m.cmodulo";
		$this->db_per = new database($this->table, $this->key);
		$this->db_per->fields = array (
			array ("system",	"m.cmodulo"),
			array ("system",	"m.modulo"),
			array ("system",	"m.mod_url"),
			array ("system",	"m.cmenu"),
			array ("system",	"am.menu"),
			array ("system",	"m.mod_icon"),
			array ("system",	"m.orden"),
			array ("system",	"m.csubmenu"),
			array ("system",	"ams.submenu"),
			array ("system",	"ams.icon"),
			array ("system",	"mu.ins"),
			array ("system",	"mu.upt")
		);
		$this->tablea = "adm_mod m ";
		$this->tablea .= " INNER JOIN adm_menu am ON m.cmenu=am.cmenu";
		$this->tablea .= " INNER JOIN adm_menu_sub ams ON m.csubmenu=ams.csubmenu";
		$this->keya = "m.cmodulo";
		$this->dba = new database($this->tablea, $this->keya);
		$this->dba->fields = array (
			array ("system",	"m.cmodulo"),
			array ("system",	"m.modulo"),
			array ("system",	"m.mod_url"),
			array ("system",	"m.cmenu"),
			array ("system",	"am.menu"),
			array ("system",	"m.orden"),
			array ("system",	"m.mod_icon"),
			array ("system",	"m.csubmenu"),
			array ("system",	"ams.submenu"),
			array ("system",	"ams.icon")
		);
		//USUARIOS_ALMACEN_EDIT
		$this->table_6 = "adm_usuarios_alm";
		$this->key_6 = "cusuario";
		$this->db_alm = new database($this->table_6, $this->key_6);
		$this->db_alm->fields = array (
			array ('public',	"cusuario"),
			array ("public",	"calmacen")
		);
		//USUARIOS_ALMACEN_LIST
		$this->table_7 = "adm_usuarios_alm ua INNER JOIN inv_almacen ia USING (calmacen)";
		$this->key_7 = "ua.cusuario";
		$this->db_alm1 = new database($this->table_7, $this->key_7);
		$this->db_alm1->fields = array (
			array ('system',	"ua.cusuario"),
			array ("system",	"ia.calmacen"),
			array ("system",	"ia.almacen"),
			array ("system",	"ia.compra"),
			array ("system",	"ia.stock")
		);
	}
	public function val_log($user,$pass){
		$usuario=strtoupper($user);
		$resultado=0;
		$data = array ();
		$data[0]["row"]="cusuario";
		$data[0]["operator"]="=";
		$data[0]["value"]=$usuario;
		$result=$this->db_user->getRecords(false,$data);
		if ($result["title"]==="SUCCESS") {
			if($result["content"][0]["status"]==1 || $result["content"][0]["cusuario"]=="ADMINISTRADOR") {
				if ($result["content"][0]["clave"] === md5($pass)) {
					$modules=$this->db_modu->getRecords(false,$data);
					if($modules["content"] || $result["content"][0]["cusuario"]=="ADMINISTRADOR"){
						$_SESSION['metalsigma_log'] = $usuario;
						$resultado=1;
					}else{
						$resultado=4;
					}
				} else {
					$resultado=3;
				}
				
			}else {
				$resultado=5;
			}
			
		} else {
			$resultado=2;
		}
		return $resultado;
	}

	public function get_menu($user){
		$usuario=strtoupper($user);
		$resultado = false;
		$data = array ();
		if($usuario=="ADMINISTRADOR"){
			$result=$this->dba->getRecords("DISTINCT(am.cmenu),am.menu,am.icon",false,false,"am.orden ASC");
		}else{
			$data[0]["row"]="cusuario";
			$data[0]["operator"]="=";
			$data[0]["value"]=$usuario;
			$result=$this->db_per->getRecords("DISTINCT(am.cmenu),am.menu,am.icon",$data,false,"am.orden ASC");
		}
		$resultado = ($result) ? $result : false ;
		return $resultado;
	}
	public function get_submenu($user,$menu){
		$usuario=strtoupper($user);
		$resultado = false;
		$data = array ();
		if($usuario=="ADMINISTRADOR"){
			$data[0]["row"]="am.cmenu";
			$data[0]["operator"]="=";
			$data[0]["value"]=$menu;
			$result=$this->dba->getRecords("DISTINCT(ams.csubmenu),ams.submenu,ams.icon",$data,false,"am.orden ASC");
		}else{
			$data[0]["row"]="cusuario";
			$data[0]["operator"]="=";
			$data[0]["value"]=$usuario;
			$data[1]["row"]="am.cmenu";
			$data[1]["operator"]="=";
			$data[1]["value"]=$menu;
			$result=$this->db_per->getRecords("DISTINCT(ams.csubmenu),ams.submenu,ams.icon",$data,false,"am.orden ASC");
		}		
		$resultado = ($result) ? $result : false ;
		return $resultado;
	}
	public function get_mod($user,$menu,$submenu){
		$usuario=strtoupper($user);
		$resultado = false;
		$data = array ();
		if($usuario=="ADMINISTRADOR"){
			$data[0]["row"]="am.cmenu";
			$data[0]["operator"]="=";
			$data[0]["value"]=$menu;
			if($submenu){
				$data[1]["row"]="ams.csubmenu";
				$data[1]["operator"]="=";
				$data[1]["value"]=$submenu;
			}
			$result=$this->dba->getRecords(false,$data,false,"m.orden ASC");
		}else{
			$data[0]["row"]="cusuario";
			$data[0]["operator"]="=";
			$data[0]["value"]=$usuario;
			$data[1]["row"]="am.cmenu";
			$data[1]["operator"]="=";
			$data[1]["value"]=$menu;
			$data[2]["row"]="ams.csubmenu";
			$data[2]["operator"]="=";
			$data[2]["value"]=$submenu;
			$result=$this->db_per->getRecords(false,$data,false,"m.orden ASC");
		}
		$resultado = ($result) ? $result : false ;
		return $resultado;
	}
	public function val_mod($user,$mod){
		$usuario=strtoupper($user);
		$resultado = false;
		$data = array ();
		if($usuario=="ADMINISTRADOR"){
			$result["title"]="SUCCESS";
			$result["content"][0]["ins"]=1;
			$result["content"][0]["upt"]=1;
			$result["content"][0]["alm"]=NULL;
		}else{
			$cont=-1;
			if($user){
				$cont++;
				$data[$cont]["row"]="cusuario";
				$data[$cont]["operator"]="=";
				$data[$cont]["value"]=$usuario;
			}
			if($mod){
				$cont++;
				$data[$cont]["row"]="m.mod_url";
				$data[$cont]["operator"]="=";
				$data[$cont]["value"]=$mod;
			}
			$result=$this->db_per->getRecords(false,$data);
			if($result["title"]=="SUCCESS"){
				$result["content"][0]["alm"]=NULL;
				$data = array ();
				$data[0]["row"]="ua.cusuario";
				$data[0]["operator"]="=";
				$data[0]["value"]=$usuario;
				$result2=$this->db_alm1->getRecords(false,$data);
				if($result2["title"]=="SUCCESS"){
					$result["content"][0]["alm"]=$result2["content"];
				}
			}
		}		
		$resultado = ($result) ? $result : false ;
		return $resultado;
	}
	public function get_module($mod){
		$data = array ();
		$data[0]["row"]="mod_url";
		$data[0]["operator"]="=";
		$data[0]["value"]=$mod;
		return $this->db_mod->getRecords(false,$data);
	}
	//LISTAR
	public function list_($status=false){
		$data = array ();
		$cont=0;
		$data[$cont]["row"]="u.cusuario";
		$data[$cont]["operator"]="<>";
		$data[$cont]["value"]="ADMINISTRADOR";
		if($status){
			$cont++;
			$data[$cont]["row"]="u.status";
			$data[$cont]["operator"]="=";
			$data[$cont]["value"]=$status;
		}
		return $this->db->getRecords(false,$data);
	}
	//LISTAR MODULOS_MENU
	public function list_mod_menu(){
		return $this->db_mod->getRecords(false,false,false,"cmenu,cmodulo ASC");
	}
	//LISTAR MODULOS_USUARIOS
	public function list_mod_usu($user=false){
		$data = array ();
		if($user){
			$data[0]["row"]="cusuario";
			$data[0]["operator"]="=";
			$data[0]["value"]=$user;
		}
		return $this->db_modu->getRecords(false,$data);
	}
	//OBTIENER
	public function get_($id){
		$resultado = false;
		$result = $this->db->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$resultado["title"]="SUCCESS";
			$resultado["cab"]=$result["content"][0];
			$data[0]["row"]="cusuario";
			$data[0]["operator"]="=";
			$data[0]["value"]=$id;
			$result = $this->db_alm1->getRecords(false,$data);
			if($result["title"]=="SUCCESS"){
				$resultado["alm"]=$result["content"];
			}else{
				$resultado["alm"]=NULL;
			}			
		}
		return $resultado;
	}
	//CREAR USUARIO
	public function new_user($data,$mod,$alm){
		$resultado = false;
		$data[]=$_SESSION['metalsigma_log'];
		$user=$data[4];
		$result = $this->db_user->insertRecord($data);
		if($result["title"]=="SUCCESS"){
			if(!empty($mod)){
				for ($i=0; $i<sizeof($mod[0]); $i++){
					$datos=array();
					array_push($datos, $mod[0][$i]);
					array_push($datos, $mod[1][$i]);
					array_push($datos, $mod[2][$i]);
					array_push($datos, $user);
					$result = $this->db_modu->insertRecord($datos);
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						$data = array ();
						$data[0]["row"]="cusuario";
						$data[0]["operator"]="=";
						$data[0]["value"]=$user;
						$this->db_modu->deleteRecords($data);
						break;
					}
				}
			}
			if(!empty($alm)){
				for ($i=0; $i<sizeof($alm); $i++){
					$datos=array();
					array_push($datos, $user);
					array_push($datos, $alm[$i]);
					$result = $this->db_alm->insertRecord($datos);
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						$data = array ();
						$data[0]["row"]="cusuario";
						$data[0]["operator"]="=";
						$data[0]["value"]=$user;
						$this->db_alm->deleteRecords($data);
						break;
					}
				}
			}
		}
		$resultado=$result;
		return $resultado;
	}
	//ACTUALIZAR USUARIO
	public function edit_user($id,$data,$mod,$alm){
		$resultado = false;
		$data[]=$_SESSION['metalsigma_log'];
		$result = $this->db_user->updateRecord($id,$data);
		if($result["title"]=="SUCCESS"){
			$data = array ();
			$data[0]["row"]="cusuario";
			$data[0]["operator"]="=";
			$data[0]["value"]=$id;
			$this->db_modu->deleteRecords($data);
			$this->db_alm->deleteRecords($data);
			if(!empty($mod)){
				for ($i=0; $i<sizeof($mod[0]); $i++){
					$datos=array();
					array_push($datos, $mod[0][$i]);
					array_push($datos, $mod[1][$i]);
					array_push($datos, $mod[2][$i]);
					array_push($datos, $id);
					$result = $this->db_modu->insertRecord($datos);
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						$data = array ();
						$data[0]["row"]="cusuario";
						$data[0]["operator"]="=";
						$data[0]["value"]=$id;
						$this->db_modu->deleteRecords($data);
						break;
					}
				}
			}
			if(!empty($alm)){
				for ($i=0; $i<sizeof($alm); $i++){
					$datos=array();
					array_push($datos, $id);
					array_push($datos, $alm[$i]);
					$result = $this->db_alm->insertRecord($datos);
					if($result["title"]!="SUCCESS"){
						$resultado=$result;
						$data = array ();
						$data[0]["row"]="cusuario";
						$data[0]["operator"]="=";
						$data[0]["value"]=$id;
						$this->db_alm->deleteRecords($data);
						break;
					}
				}
			}
		}
		$resultado=$result;
		return $resultado;
	}
	//ACTUALIZAR STATUS
	public function change_status($user){
		$resultado = false;
		$_status = 0;
		$data[0]["row"]="cusuario";
		$data[0]["operator"]="=";
		$data[0]["value"]=$user;
		$result = $this->db_user->getRecords(false,$data);
		if($result["title"]=="SUCCESS"){
			$status = $result["content"][0]["status"];
			$_status = ($status==1) ? 0 : 1 ;
			$this->db_user->fields=$data=array();
			$this->db_user->fields[0]=array ('public_u',	'status');
			$this->db_user->fields[1]=array ('public_u',	'mod_user');
			$data[]=$_status;
			$data[]=$_SESSION['metalsigma_log'];
			$result = $this->db_user->updateRecord($user,$data);
		}
		$resultado=$result;
		return $resultado;
	}
	//CAMBIA CLAVE
	public function change_pass($pass_old,$pass_new){
		$resultado=0;
		$data = array ();
		$data[0]["row"]="cusuario";
		$data[0]["operator"]="=";
		$data[0]["value"]=$_SESSION['metalsigma_log'];
		$result=$this->db_user->getRecords(false,$data);
		if ($result["title"]==="SUCCESS") {
			if ($result["content"][0]["clave"] === md5($pass_old)) {
				$this->db_user->fields=array();
				$this->db_user->fields[0]=array ('public_u',	'clave');
				$this->db_user->fields[1]=array ('public_u',	'mod_user');
				$data=array();
				$data[]=md5($pass_new);
				$data[]=$_SESSION['metalsigma_log'];
				$result = $this->db_user->updateRecord($_SESSION['metalsigma_log'],$data);
			}else{ $resultado = 2; }//CLAVE INVALIDA
		}else{ $resultado = 3; }//USUARIO INVALIDA
		if($resultado!=2){
			$resultado=1;
		}
		return $resultado;
	}
}
?>