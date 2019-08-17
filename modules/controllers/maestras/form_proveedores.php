<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new" || $action=="save_edit"){
	include_once("../../../class/functions.php");
	include_once("../../../class/class.proveedores.php");
	$data_class = new proveedores;
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
			extract($_GET, EXTR_PREFIX_ALL, "");
			$persona=$proveedor=array();
			$status_ = ($action=="save_edit") ? $_estatus : 1;

			array_push($persona, $_rut);
			array_push($persona, $_nombre);
			array_push($persona, $_nombre2);
			array_push($persona, "");
			array_push($persona, "");
			array_push($persona, "");
			array_push($persona, $_direccion);
			array_push($persona, $_email);
			array_push($persona, $_tel1);
			array_push($persona, $_tel2);
			array_push($persona, "");
			array_push($persona, $_comuna);

			array_push($proveedor, $_pago);
			array_push($proveedor, $status_);

			if($action=="save_edit"){
				if($upt!=1){
					$response['title']="ERROR";
					$response["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					$resultado=$data_class->edit_proveedor($_id,$persona,$proveedor);
				}
			}else{
				if($ins!=1){
					$response['title']="ERROR";
					$response["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					$resultado=$data_class->new_proveedor($persona,$proveedor);
				}
			}

			$mensaje="SIN MENSAJE";
			switch ($action) {
				case "save_new":
					$mensaje="PROVEEDOR CREADO CON EXITO!";
				break;
				case "save_edit":
					$mensaje="DATOS DEL PROVEEDOR ACTUALIZADOS";
				break;
			}
			if($resultado["title"]=="SUCCESS"){
				$response['title']=$resultado["title"];
				$response["content"]=$mensaje;
			}else{
				$response['title']=$resultado["title"];
				$response["content"]=$resultado["content"];
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
		include_once("./class/class.proveedores.php");
		include_once("./class/class.zonas.php");
		$data_class = new proveedores;
		$zonas = new zonas;
		$modulo = $perm->get_module($_GET['submod']);
		if(Evaluate_Mod($modulo)){
			$tpl->newBlock("module");
			foreach ($modulo["content"] as $key => $value){
				//VARIABLES PARA NAVEGAR
				$var_array_nav=array();
				$var_array_nav["mod"]=$_GET['mod'];
				$var_array_nav["submod"]=$_GET['submod'];
				$var_array_nav["ref"]="FORM_PROVEEDORES";
				$var_array_nav["subref"]="NONE";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$mod = ($_GET['mod']=="NONE") ? "HOME" : $_GET['mod'] ;
				$tpl->assign("menu_pri",$mod);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter",$value['modulo']);
				$tpl->assign("menu_name","FORMULARIO DE PROVEEDORES");
				$tpl->assign("mod_name","FORMULARIO DE PROVEEDORES");
			}
			if($action=="new"){
				$tpl->assign("accion",'save_new');
				$paises = $zonas->list_p();
				if(!empty($paises)){
					foreach ($paises["content"] as $key => $value) {
						$tpl->newBlock("pais_det");
						if($value["codigo"]==1){
							$tpl->assign("selected",$selected);
						}
						foreach ($paises["content"][$key] as $key1 => $value1){
							$tpl->assign($key1,$value1);
						}
					}
				}
				$regiones = $zonas->list_r(1);
				if(!empty($regiones)){
					foreach ($regiones["content"] as $key => $value) {
						$tpl->newBlock("region_det");
						if($value["codigo"]==13){
							$tpl->assign("selected",$selected);
						}
						foreach ($regiones["content"][$key] as $key1 => $value1){
							$tpl->assign($key1,$value1);
						}
					}
				}
				$provincias = $zonas->list_pr(13);
				if(!empty($provincias)){
					foreach ($provincias["content"] as $key => $value) {
						$tpl->newBlock("prov_det");
						foreach ($provincias["content"][$key] as $key1 => $value1){
							$tpl->assign($key1,$value1);
						}
					}
				}
				$pagos = $data_class->list_pag();
				if(!empty($pagos)){
					foreach ($pagos["content"] as $key => $value) {
						$tpl->newBlock("pago_det");
						foreach ($pagos["content"][$key] as $key1 => $value1){
							$tpl->assign($key1,$value1);
						}
					}
				}
			}elseif($action=="edit"){
				$tpl->assign("accion",'save_edit');
				$data=$data_class->get_proveedor($_GET['id']);
				if(Evaluate_Mod($data)){
					$cab=$data["content"];
					foreach ($cab as $llave => $datos) {
						$tpl->assign($llave,$datos);
					}					
					if(!empty($array_estatus)){
						$tpl->newBlock("st_block");
						foreach ($array_estatus as $llave => $datos){
							$tpl->newBlock("st_det");
							if($llave==$cab['status']){
								$tpl->assign("selected",$selected);
							}
							$tpl->assign("code",$llave);
							$tpl->assign("valor",$datos);
						}
					}
					$paises = $zonas->list_p();
					if(!empty($paises)){
						foreach ($paises["content"] as $key => $value) {
							$tpl->newBlock("pais_det");
							if($value["codigo"]==$cab["cpais"]){
								$tpl->assign("selected",$selected);								
							}
							foreach ($paises["content"][$key] as $key1 => $value1){
								$tpl->assign($key1,$value1);
							}
						}
					}
					$regiones = $zonas->list_r($cab["cpais"]);
					if(!empty($regiones)){
						foreach ($regiones["content"] as $key => $value) {
							$tpl->newBlock("region_det");
							if($value["codigo"]==$cab["cregion"]){
								$tpl->assign("selected",$selected);
							}
							foreach ($regiones["content"][$key] as $key1 => $value1){
								$tpl->assign($key1,$value1);
							}
						}
					}
					$provincias = $zonas->list_pr($cab["cregion"]);
					if(!empty($provincias)){
						foreach ($provincias["content"] as $key => $value) {
							$tpl->newBlock("prov_det");
							if($value["codigo"]==$cab["cprovincia"]){
								$tpl->assign("selected",$selected);
							}
							foreach ($provincias["content"][$key] as $key1 => $value1){
								$tpl->assign($key1,$value1);
							}
						}
					}
					$comuna = $zonas->list_c($cab["cprovincia"]);
					if(!empty($comuna)){
						foreach ($comuna["content"] as $key => $value) {
							$tpl->newBlock("com_det");
							if($value["codigo"]==$cab["ccomuna"]){
								$tpl->assign("selected",$selected);
							}
							foreach ($comuna["content"][$key] as $key1 => $value1){
								$tpl->assign($key1,$value1);
							}
						}
					}					
					$pagos = $data_class->list_pag();
					if(!empty($pagos)){
						foreach ($pagos["content"] as $key => $value) {
							$tpl->newBlock("pago_det");
							if($value["codigo"]==$cab["cpago"]){
								$tpl->assign("selected",$selected);
							}
							foreach ($pagos["content"][$key] as $key1 => $value1){
								$tpl->assign($key1,$value1);
							}
						}
					}
				}
				$tpl->newBlock("aud_data");
				$tpl->assign("crea_user",$cab['crea_user']);
				$tpl->assign("mod_user",$cab['mod_user']);
				$tpl->assign("crea_date",$cab['crea_date']);
				$tpl->assign("mod_date",$cab['mod_date']);
				$tpl->newBlock("val");
			}
			$upt=$perm_val["content"][0]["upt"];
			if($upt==1){
				$tpl->newBlock("data_save");
				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}
			}else{ $tpl->assign("read",'readonly'); }
		}
	}
}
?>