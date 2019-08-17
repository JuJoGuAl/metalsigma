<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new" || $action=="new_eq_cli"){
	include_once("../../../class/functions.php");
	include_once("../../../class/class.cotizaciones.php");
	include_once("../../../class/class.clientes.php");
	$data_class = new cotizaciones;
	$clientes = new clientes;
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
			$datos =  array();
			if($action=="new_eq_cli"){
				$datos[] .= $_ccliente_;
				$datos[] .= 0;
				$datos[] .= $_equipo;
				$datos[] .= $_serial_;
				$datos[] .= $_interno_;
				$datos[] .= 1;
				if($ins!=1){
					$resultado['title']="ERROR";
					$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					$resultado=$clientes->new_m($datos);
				}
				$mensaje="EQUIPO AÑADIDO AL CLIENTE!";
			}else{
				array_push($datos, $_cmaquina[0]);
				array_push($datos, 0);//STATUS
				if($action=="save_new"){
					if($ins!=1){
						$resultado['title']="ERROR";
						$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
					}else{
						$resultado=$data_class->new_all($datos);
					}
				}

				$mensaje="COTIZACION CREADA CON EXITO";
			}			
			if($resultado["title"]=="SUCCESS"){
				$response['title']=$resultado["title"];
				$response["content"]=$mensaje;
				if($action=="new_eq_cli"){
					$maq=$clientes->get_m($resultado["id"]);
					if($maq["title"]=="SUCCESS"){
						$response["maquina"] = $maq["content"];
					}
				}
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
		include_once("./class/class.equipos.php");
		$data_class = new cotizaciones;
		$equipos = new equipos;
		$modulo = $perm->get_module($_GET['submod']);
		if(Evaluate_Mod($modulo)){
			$tpl->newBlock("module");
			foreach ($modulo["content"] as $key => $value){
				//VARIABLES PARA NAVEGAR
				$var_array_nav=array();
				$var_array_nav["mod"]=$_GET['mod'];
				$var_array_nav["submod"]=$_GET['submod'];
				$var_array_nav["ref"]="FORM_COT_ALL";
				$var_array_nav["subref"]="NONE";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter","NONE");
				$tpl->assign("menu_name","COTIZACIONES");
				$tpl->assign("form_title","TRANSACCION: ");
			}
			if($action=="new"){
				$tpl->assign("accion",'save_new');
				$tpl->assign("stats_code","PEN");
				$tpl->assign("stats_nom","PENDIENTE");
				$tpl->assign("id_tittle","NUEVA");
				$tpl->assign("status_color",color_status("PEN","badge"));
				$tpl->assign("codigo",0);

				$data=$equipos->list_();
				if($data["title"]=="SUCCESS"){
					foreach ($data["content"] as $key => $value){
						$tpl->newBlock("equipos");
						$tpl->assign("count",$key+1);
						foreach ($data["content"][$key] as $key_ => $value_) {
							$tpl->assign($key_,$value_);
						}
						//$table.='<tr><td class="_id">'.$value["codigo"].'</td><td class="_nom">'.$value['equipo'].'</td><td class="_mar">'.$value['marca'].'</td><td class="_mod">'.$value['modelo'].'</td><td class="_seg">'.$value['segmento'].'</td></tr>';
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