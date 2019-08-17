<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new" || $action=="save_edit"){
	include_once("../../../class/functions.php");
	include_once("../../../class/class.inventario.php");
	$data_class = new inventario;
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
			$status_ = ($action=="save_edit") ? $_estatus : 1;
			$datos=array();
			array_push($datos, $_dato);
			array_push($datos, $_compra);
			array_push($datos, $_sto);
			array_push($datos, $status_);

			if($action=="save_edit"){
				if($upt!=1){
					$resultado['title']="ERROR";
					$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					$resultado=$data_class->edit_a($_id,$datos);
				}
			}else{
				if($ins!=1){
					$resultado['title']="ERROR";
					$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					$resultado=$data_class->new_a($datos);
				}
			}

			$mensaje="SIN MENSAJE";
			switch ($action) {
				case "save_new":
					$mensaje="ALMACEN CREADO CON EXITO";
				break;
				case "save_edit":
					$mensaje="DATOS DEL ALMACEN ACTUALIZADOS";
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
		include_once("./class/class.inventario.php");
		$data_class = new inventario;
		$modulo = $perm->get_module($_GET['submod']);
		if(Evaluate_Mod($modulo)){
			$tpl->newBlock("module");
			foreach ($modulo["content"] as $key => $value){
				//VARIABLES PARA NAVEGAR
				$var_array_nav=array();
				$var_array_nav["mod"]=$_GET['mod'];
				$var_array_nav["submod"]=$_GET['submod'];
				$var_array_nav["ref"]="FORM_ALMACEN";
				$var_array_nav["subref"]="NONE";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['submenu']);
				$tpl->assign("menu_ter",$value['modulo']);
				$tpl->assign("menu_name","INVENTARIO");
				$tpl->assign("mod_name","FORMULARIO DE ALMACENES");
			}
			if($action=="new"){
				$tpl->assign("accion",'save_new');
				if(!empty($array_bool)){
					foreach ($array_bool as $llave => $datos){
						$tpl->newBlock("comp_det");
						$tpl->assign("code",$llave);
						$tpl->assign("valor",$datos);
					}
				}
				if(!empty($array_bool)){
					foreach ($array_bool as $llave => $datos){
						$tpl->newBlock("stock_det");
						$tpl->assign("code",$llave);
						$tpl->assign("valor",$datos);
					}
				}
				if(!empty($array_bool)){
					foreach ($array_bool as $llave => $datos){
						$tpl->newBlock("reserv_det");
						$tpl->assign("code",$llave);
						$tpl->assign("valor",$datos);
					}
				}
			}elseif($action=="edit"){
				$tpl->assign("accion",'save_edit');
				$data=$data_class->get_a($_GET['id']);
				if(Evaluate_Mod($data)){
					$cab=$data["content"];
					foreach ($cab as $llave => $datos) {
						$tpl->assign($llave,$datos);
					}
					if(!empty($array_bool)){
						foreach ($array_bool as $llave => $datos){
							$tpl->newBlock("comp_det");
							if($llave==$cab['compra']){
								$tpl->assign("selected",$selected);
							}
							$tpl->assign("code",$llave);
							$tpl->assign("valor",$datos);
						}
					}
					if(!empty($array_bool)){
						foreach ($array_bool as $llave => $datos){
							$tpl->newBlock("stock_det");
							if($llave==$cab['stock']){
								$tpl->assign("selected",$selected);
							}
							$tpl->assign("code",$llave);
							$tpl->assign("valor",$datos);
						}
					}
					$tpl->newBlock("st_block");
					if(!empty($array_estatus)){
						foreach ($array_estatus as $llave => $datos){
							$tpl->newBlock("st_det");
							if($llave==$cab['status']){
								$tpl->assign("selected",$selected);
							}
							$tpl->assign("code",$llave);
							$tpl->assign("valor",$datos);
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