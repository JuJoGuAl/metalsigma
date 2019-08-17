<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new" || $action=="save_edit"){
	include_once("../../../class/functions.php");
	include_once("../../../class/class.clientes.php");
	$data_class = new clientes;
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
			$datos=$datos1=array();
			$code1=$_id;
			$code2=$_id-1;
			array_push($datos1, $_gastos);
			array_push($datos, $_margen);			

			if($action=="save_edit"){
				if($upt!=1){
					$resultado['title']="ERROR";
					$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					$resultado=$data_class->edit_mor($code1,$datos);
					$resultado=$data_class->edit_mor($code2,$datos1);
				}
			}

			$mensaje="SIN MENSAJE";
			switch ($action) {
				case "save_new":
					$mensaje="CONDICION DE MORA CREADA CON EXITO";
				break;
				case "save_edit":
					$mensaje="DATOS DE LA MORA ACTUALIZADOS";
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
		include_once("./class/class.clientes.php");
		$data_class = new clientes;
		$modulo = $perm->get_module($_GET['submod']);
		if(Evaluate_Mod($modulo)){
			$tpl->newBlock("module");
			foreach ($modulo["content"] as $key => $value){
				//VARIABLES PARA NAVEGAR
				$var_array_nav=array();
				$var_array_nav["mod"]=$_GET['mod'];
				$var_array_nav["submod"]=$_GET['submod'];
				$var_array_nav["ref"]="FORM_MORAS";
				$var_array_nav["subref"]="NONE";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['submenu']);
				$tpl->assign("menu_ter",$value['modulo']);
				$tpl->assign("menu_name","MORAS");
				$tpl->assign("mod_name","FORMULARIO DE MORAS");
			}
			if($action=="new"){
				$tpl->assign("accion",'save_new');
			}elseif($action=="edit"){
				$tpl->assign("accion",'save_edit');
				$data1=$data_class->get_mor($_GET['id']);
				$data2=$data_class->get_mor($_GET['id']-1);
				$mora = ($_GET['id']==12) ? "MORA OC" : "MORA PAGO" ;
				$tpl->assign("codigo",$_GET['id']);
				$tpl->assign("dato",$mora);
				$tpl->assign("gastos",$data2["content"]["valor"]);
				$tpl->assign("margen",$data1["content"]["valor"]);
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