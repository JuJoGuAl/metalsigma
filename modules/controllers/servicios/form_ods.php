<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new" || $action=="save_edit" || $action=="proc"){
	include_once("../../../class/functions.php");
	include_once("../../../class/class.cotizaciones.php");
	$data_class = new cotizaciones;
	session_start();
	$response=array();
	if(isset($_SESSION["metalsigma_log"])){
		$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
		if($perm_val["title"]<>"SUCCESS"){
			$response['title']="ERROR";
			$response["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA EL MODULO</strong>";
		}else{
			$ins=$perm_val["content"][0]["ins"];
			$upt=$perm_val["content"][0]["upt"];
			if($action=="proc"){
				extract($_GET, EXTR_PREFIX_ALL, "");
				if($action=="proc"){
					if($upt!=1){
						$resultado['title']="ERROR";
						$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
					}else{
						$resultado=$data_class->set_ods($_id,$_origen);
					}
				}
				$mensaje="ORDEN DE SERVICIO APLICADA";
				if($resultado["title"]=="SUCCESS"){
					$response['title']=$resultado["title"];
					$response["content"]=$mensaje;
				}else{
					$response['title']=$resultado["title"];
					$response["content"]=$resultado["content"];
				}
			}
		}		
	}else{
		$response['title']="INFO";
		$response["content"]=-1;
	}
	echo json_encode($response);
}else{
	$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
	if($perm_val["title"]<>"SUCCESS"){
		alerta("NO POSEES PERMISO PARA ESTE MODULO","ERROR");
	}else{
		include_once("./class/class.cotizaciones.php");
		include_once("./class/class.par_admin.php");
		include_once("./class/class.clientes.php");
		include_once("./class/class.compras.php");
		$data_class = new cotizaciones;
		$param = new paradm;
		$clientes = new clientes;
		$compras = new compras();
		$modulo = $perm->get_module($_GET['submod']);
		if(Evaluate_Mod($modulo)){
			$tpl->newBlock("module");
			foreach ($modulo["content"] as $key => $value){
				//VARIABLES PARA NAVEGAR
				$var_array_nav=array();
				$var_array_nav["mod"]=$_GET['mod'];
				$var_array_nav["submod"]=$_GET['submod'];
				$var_array_nav["ref"]="FORM_ODS";
				$var_array_nav["subref"]="CRUD_ODS_SUB";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter","NONE");
				$tpl->assign("menu_name","COTIZACIONES");
				$tpl->assign("form_title","COTIZACION: ");
				$tpl->assign("form_title2","ODS: ");
			}
			if($action=="edit"){
				$tpl->assign("accion",'save_edit');
				$tpl->assign("id",$_GET["id"]);
				$cotiza=$data_class->get_sub($_GET["id"]);
				$cab=$cotiza["cab"];
				$cab_cli=$cotiza["datos"];
				$det=$cotiza["det"];
				$art=$cotiza["art"];
				$cots=$cotiza["cot"];
				$csegmento=$cab_cli["csegmento"];
				$style = ($cab["clugar"]=="0000000001") ? 'style="display:none;"' : '' ;
				$codigo_origen=$cab["origen"];
				$tpl->assign("codigo_origen",$cab["origen"]);
				$tpl->assign("id_tittle",$cab["cot_full"]);
				$sub_ods = ($cab["codigo_ods"]=="N/A") ? "NUEVA" : $cab["ods_full"] ;
				$tpl->assign("id_tittle2",$sub_ods);
				$tpl->assign("status_color",color_status($cab['status'],"badge"));
				$tpl->assign("hide",$style);
				foreach ($cab as $key => $value){
					$campos = array("m_serv","m_rep","m_ins","m_stt","m_tra","m_misc","m_subt","m_desc","m_neto","m_imp","m_bruto");
					$value = (in_array($key, $campos)) ? numeros($value,0)." $" : $value ;
					$tpl->assign($key,$value);
					$tpl->assign($key."_",$value);
				}
				foreach ($cab_cli as $key => $value){
					$value = ($key=="code") ? formatRut($value) : $value ;
					$tpl->assign($key,$value);
				}
				if(!empty($array_status)){
					foreach ($array_status as $llave => $datos){
						if($llave==$cab["status"]){
							$tpl->assign("stats_code",$llave);
							$tpl->assign("stats_nom",$datos);
						}
					}
				}
				if(!empty($array_opcion)){
					foreach ($array_opcion as $llave => $datos){
						if($llave==$cab["parte"]){
							$tpl->assign("coteq",$datos);
						}
					}
				}
				if(!empty($det)){
					foreach ($det as $key => $value) {
						$tpl->newBlock("co_det");
						$tpl->assign("count",($key+1));
						foreach ($value as $key1 => $value1) {
							if($key1=="finicio" || $key1=="ffin"){
								$tpl->assign($key1,setDate($value1,"d-m-Y"));
							}else{
								$tpl->assign($key1,$value1);
							}
						}
					}
				}
				if(!empty($art)){
					foreach ($art as $key => $value) {
						$tpl->newBlock("articulos");
						foreach ($value as $key1 => $value1) {
							$tpl->assign($key1,$value1);
						}
					}
				}
				if(!empty($cots)){
					$ccot_com[]=array();
					foreach ($cots as $key => $value) {
						$ccot_com[$key]=$value["codigo"];
					}
					$data_seg=$clientes->get_s($csegmento);
					$detalles=$compras->get_cot_det_array($ccot_com);
					if($detalles["title"]=="SUCCESS"){
						foreach ($detalles["content"] as $key => $value) {
							$costo = $detalles["content"][$key]["costou"];
							$precio = (($data_seg["content"]["mar_stt"]*$costo)/100)+$costo;

							$tpl->newBlock("articulos");

							$tpl->assign("codigo",$detalles["content"][$key]["codigo_art"]);
							$tpl->assign("codigo2",$detalles["content"][$key]["codigo2"]);
							$tpl->assign("articulo",$detalles["content"][$key]["articulo"]);
							$tpl->assign("cant",$detalles["content"][$key]["cant"]);
							$tpl->assign("precio",$precio);
							$tpl->assign("clasificacion","SERVICIOS TERCERIZADOS");
						}
					}
				}
				$tpl->newBlock("aud_data");
				$tpl->assign("crea_user",$cab['crea_user']);
				$tpl->assign("mod_user",$cab['mod_user']);
				$tpl->assign("crea_date",$cab['crea_date']);
				$tpl->assign("mod_date",$cab['mod_date']);
			}
			$upt=$perm_val["content"][0]["upt"];
			if($upt==1 && $cab["status"]=="APB" && $cab["codigo_ods"]==0){
				$tpl->newBlock("data_save");
				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}
				$tpl->assign("codigo",$codigo_origen);
			}else{ $tpl->assign("read",'readonly'); }
		}
	}
}
?>