<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_edit"){
	include_once("../../../class/functions.php");
	include_once("../../../class/class.parameter.php");
	$data_class = new parametros;
	session_start();
	$response=array();
	if(isset($_SESSION["metalsigma_log"])){
		$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
		if($perm_val["title"]<>"SUCCESS"){
			$response['title']="ERROR";
			$response["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA EL MODULO</strong>";
		}else{
			$upt=$perm_val["content"][0]["upt"];
			extract($_GET, EXTR_PREFIX_ALL, "");
			$datos =  array();
			if($upt!=1){
				$resultado['title']="ERROR";
				$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
			}else{
				array_push($datos, $_valor);
				$resultado=$data_class->edit_parametro($_id,$datos);
				$mensaje="PARAMETRO ACTUALIZADO!";
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
		include_once("./class/class.parameter.php");
		$data_class = new parametros;
		$modulo = $perm->get_module($_GET['submod']);
		if(Evaluate_Mod($modulo)){
			$tpl->newBlock("module");
			foreach ($modulo["content"] as $key => $value){
				//VARIABLES PARA NAVEGAR
				$var_array_nav=array();
				$var_array_nav["mod"]=$_GET['mod'];
				$var_array_nav["submod"]=$_GET['submod'];
				$var_array_nav["ref"]="FORM_PARAMETRO";
				$var_array_nav["subref"]="NONE";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter","NONE");
				$tpl->assign("menu_name","PARAMETROS");
			}
			if($action=="edit"){
				$tpl->assign("accion",'save_edit');
				$data=$data_class->get_parametro($_GET['id']);
				if(Evaluate_Mod($data)){
					$cab=$data["content"];
					foreach ($cab as $llave => $datos) {
						$tpl->assign($llave,$datos);
					}
				}
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