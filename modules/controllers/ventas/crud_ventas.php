<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new"){
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
			extract($_GET, EXTR_PREFIX_ALL, "");
			$datos = array();
			array_push($datos, $_factura);
			array_push($datos, setDate($_fecha));
			if($ins!=1){
				$resultado['title']="ERROR";
				$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
			}else{
				$resultado=$data_class->set_fac($_id,$datos);
			}
			$mensaje="FACTURA GENERADA!";
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
		include_once("./class/class.cotizaciones.php");
		$data_class = new cotizaciones;
		$modulo = $perm->get_module($_GET['submod']);
		if(Evaluate_Mod($modulo)){
			$tpl->newBlock("module");
			foreach ($modulo["content"] as $key => $value){
				//VARIABLES PARA NAVEGAR
				$var_array_nav=array();
				$var_array_nav["mod"]=$_GET['mod'];
				$var_array_nav["submod"]=$_GET['submod'];
				$var_array_nav["ref"]="FORM_ODS";
				$var_array_nav["subref"]="NONE";
				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter","NONE");
				$tpl->assign("menu_name","FACTURAS DE ODS");
			}
			if(!empty($array_cot_fac)){
				foreach ($array_cot_fac as $llave => $datos){
					$tpl->newBlock("fstat_det");
					$tpl->assign("code",$datos);
					$tpl->assign("valor",$array_status[$datos]);
					if($datos=="PRO"){
						$tpl->assign("selected",$selected);
					}
				}
			}
			$tipo=$data_class->list_();
			foreach ($tipo["content"] as $key => $value) {
				$tpl->newBlock("tipo_det");
				foreach ($tipo["content"][$key] as $key1 => $value1){
					$tpl->assign($key1,$value1);
				}
			}
			$array_temp = array('PRO');
			$data=$data_class->list_sub(false,$array_temp,"<= 0");
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $llave => $datos) {
					$tpl->newBlock("data");
					$id=$datos['codigo'];
					if(!empty($array_all)){
						foreach ($array_all as $key => $value){
							if($key==$datos['status']){
								$sts=$value;
							}
						}
						$tpl->assign("ESTATUS",$sts);
					}
					$stats_color=color_status($datos['status'],"table",true);
					$cadena_acciones='
					<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light menu" data-toggle="tooltip" data-placement="top" title="VER" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref"].'" data-subref="'.$var_array_nav["subref"].'" data-acc="EDIT" data-id="'.$id.'"><i class="fas fa-search"></i></button>';
					if ($datos['status']!="FAC"){
						$cadena_acciones .= '<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light open_modal" data-toggle="tooltip" data-placement="top" title="FACTURAR" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref"].'" data-subref="'.$var_array_nav["subref"].'" data-acc="EDIT" data-id="'.$id.'"><i class="fas fa-hands-helping"></i></button>
						';
					}
					foreach ($data["content"][$llave] as $key => $value){
						$value = ($key=="code") ? formatRut($value) : $value ;
						$value = (in_array($key, $array_numbers)) ? numeros($value,2) : $value ;
						$tpl->assign($key,$value);
					}
					$gar = ($data["content"][$llave]["ctipo"]==5) ? '<span class="badge badge-pill font-medium badge-warning ml-2">URGENTE</span>' : '' ;
					$tpl->assign("gar",$gar);
					$tpl->assign("actions",$cadena_acciones);
					$tpl->assign("estatus",$stats_color);
				}
			}
		}
	}
}
?>