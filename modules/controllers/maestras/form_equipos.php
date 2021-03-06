<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new" || $action=="save_edit"){
	include_once("../../../class/functions.php");
	include_once("../../../class/class.equipos.php");
	$data_class = new equipos;
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
			$datos=array();
			array_push($datos, $_dato);
			array_push($datos, $_marca);
			array_push($datos, $_modelo);
			array_push($datos, $_segmento);

			if($action=="save_edit"){
				if($upt!=1){
					$resultado['title']="ERROR";
					$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					$resultado=$data_class->edit_($_id,$datos);
				}
			}else{
				if($ins!=1){
					$resultado['title']="ERROR";
					$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					$resultado=$data_class->new_($datos);
				}
			}

			$mensaje="SIN MENSAJE";
			switch ($action) {
				case "save_new":
					$mensaje="EQUIPO CREADO CON EXITO";
				break;
				case "save_edit":
					$mensaje="DATOS DEL EQUIPO ACTUALIZADOS";
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
		include_once("./class/class.equipos.php");
		$data_class = new equipos;
		$modulo = $perm->get_module($_GET['submod']);
		if(Evaluate_Mod($modulo)){
			$tpl->newBlock("module");
			foreach ($modulo["content"] as $key => $value){
				//VARIABLES PARA NAVEGAR
				$var_array_nav=array();
				$var_array_nav["mod"]=$_GET['mod'];
				$var_array_nav["submod"]=$_GET['submod'];
				$var_array_nav["ref"]="FORM_EQUIPOS";
				$var_array_nav["subref"]="CRUD_EQUIPOS";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['submenu']);
				$tpl->assign("menu_ter",$value['modulo']);
				$tpl->assign("menu_name","EQUIPOS");
				$tpl->assign("mod_name","FORMULARIO DE EQUIPOS");
			}
			if($action=="new"){
				$tpl->assign("accion",'save_new');
				$marcas = $data_class->list_m();
				if(!empty($marcas)){
					foreach ($marcas["content"] as $key => $value) {
						$tpl->newBlock("marca_det");
						foreach ($marcas["content"][$key] as $key1 => $value1){
							$tpl->assign($key1,$value1);
						}
					}
				}
				$segmento = $data_class->list_s();
				if(!empty($segmento)){
					foreach ($segmento["content"] as $key => $value) {
						$tpl->newBlock("seg_det");
						foreach ($segmento["content"][$key] as $key1 => $value1){
							$tpl->assign($key1,$value1);
						}
					}
				}
			}elseif($action=="edit"){
				$tpl->assign("accion",'save_edit');
				$data=$data_class->get_($_GET['id']);
				if(Evaluate_Mod($data)){
					$cab=$data["content"];
					foreach ($cab as $llave => $datos) {
						$tpl->assign($llave,$datos);
					}
					$marcas = $data_class->list_m();
					if(!empty($marcas)){
						foreach ($marcas["content"] as $key => $value) {
							$tpl->newBlock("marca_det");
							if($value["codigo"]==$cab["cmarca"]){
								$tpl->assign("selected",$selected);
							}
							foreach ($marcas["content"][$key] as $key1 => $value1){
								$tpl->assign($key1,$value1);
							}
						}
					}
					$segmento = $data_class->list_s();
					if(!empty($segmento)){
						foreach ($segmento["content"] as $key => $value) {
							$tpl->newBlock("seg_det");
							if($value["codigo"]==$cab["csegmento"]){
								$tpl->assign("selected",$selected);
							}
							foreach ($segmento["content"][$key] as $key1 => $value1){
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