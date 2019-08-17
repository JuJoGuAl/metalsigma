<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new" || $action=="save_edit" || $action=="proc"){
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
			$datos = $detalles = $det_art = $det_cant = array();
			$data_ = $data_class->get_req($_requisicion);
			if($data_["title"]=="SUCCESS"){
				$req_cab = $data_["cab"];
				$req_det = $data_["det"];
				$alm_ori = $req_cab["cod_almacenori"];//MOV QUE RESTA
				$alm_des = $req_cab["cod_almacendes"];//MOV QUE SUMA
				$array_art = $array_cant = array();
				foreach ($req_det as $key => $value) {
					$array_art[$req_det[$key]["cod_articulo"]] = $req_det[$key]["articulo"];
					$array_cant[$req_det[$key]["cod_articulo"]] = $req_det[$key]["cant"]*1;
				}
				//CABECERA
				$datos[] = $req_cab["codigo"];
				$datos[] = $req_cab["cod_almacenori"];
				$datos[] = $req_cab["cod_almacendes"];
				$datos[] = $_notas;

				//VERIFICO SI SE UTILIZO DETALLES (EVITO EL ERROR DE ARREGLO VACIO)
				if(!empty($_GET['carticulo'])){
					for ($i=0; $i<sizeof($_GET['carticulo']); $i++){
						$det_art[] = $_carticulo[$i];
						$det_cant[] = $_cant[$i];
						if($array_cant[$_carticulo[$i]]<$_cant[$i]){
							$resultado['title']="ERROR";
							$resultado["content"]="LA CANTIDAD A DESPACHAR DEL ARTICULO <strong>".$array_art[$_carticulo[$i]]."</strong> ES SUPERIOR A LA REQUERIDA!";
							echo json_encode($resultado);
							exit();
						}
					}
				}

				array_push($detalles, $det_art);
				array_push($detalles, $det_cant);

				if($ins!=1){
					$resultado['title']="ERROR";
					$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					$resultado=$data_class->new_transf($datos,$detalles);
				}

				$mensaje="DESPACHO DE ARTICULOS EXITOSO!";

				if($resultado["title"]=="SUCCESS"){
					$response['title']=$resultado["title"];
					$response["content"]=$mensaje;
				}else{
					$response['title']=$data_["title"];
					$response["content"]=$data_["content"];
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
		include_once("./class/class.inventario.php");
		include_once("./class/class.compras.php");
		$data_class = new inventario;
		$data_class1 = new compras;
		$modulo = $perm->get_module($_GET['submod']);
		if(Evaluate_Mod($modulo)){
			$tpl->newBlock("module");
			foreach ($modulo["content"] as $key => $value){
				//VARIABLES PARA NAVEGAR
				$var_array_nav=array();
				$var_array_nav["mod"]=$_GET['mod'];
				$var_array_nav["submod"]=$_GET['submod'];
				$var_array_nav["ref"]="FORM_INV_RECP";
				$var_array_nav["subref"]="NONE";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter","NONE");
				$tpl->assign("menu_name","ENTREGA DE ARTICULOS");
				$tpl->assign("form_title","TRANSACCION: ");
			}
			if($action=="new"){
				$tpl->assign("accion",'save_new');
				$tpl->assign("stats_code","PEN");
				$tpl->assign("stats_nom","PENDIENTE");
				$tpl->assign("id_tittle","NUEVA");
				$tpl->assign("status_color",color_status("PEN","badge"));
				$tpl->assign("codigo",0);
				$tpl->assign("fecha_mov",date("d-m-Y"));
			}elseif($action=="edit"){
				$tpl->assign("accion",'save_edit');
				$data_ent=$data_class->get_mov($_GET['id']);
				$data_sal=$data_class->get_mov($_GET['id']+1);
				if(Evaluate_Mod($data_ent)){
					$cab_ent=$data_ent["cab"];
					$cab_sal=$data_sal["cab"];
					$det=$data_ent["det"];
					$tpl->assign("id_tittle",$cab_ent["codigo_transaccion"]);
					$tpl->assign("status_color",color_status($cab_ent['status'],"badge"));
					foreach ($cab_ent as $llave => $datos) {
						$tpl->assign($llave,$datos);
					}
					$tpl->assign("almacen_ori",$cab_ent["almacen"]);
					$tpl->assign("almacen_des",$cab_sal["almacen"]);
					if(!empty($array_all)){
						foreach ($array_all as $llave => $datos){
							if($llave==$cab_ent["status"]){
								$tpl->assign("stats_code",$llave);
								$tpl->assign("stats_nom",$datos);
							}
						}
					}
					if(!empty($det)){
						foreach ($det as $key => $value) {
							$tpl->newBlock("det_arts");
							foreach ($value as $key1 => $value1) {
								$tpl->assign($key1,$value1);
							}
							$boton = '<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref"].'" data-subref="'.$var_array_nav["subref"].'"><i class="fas fa-trash-alt"></i></button>';
							$tpl->assign("actions",$boton);
							$tpl->assign("count",$key+1);
						}
					}
				}
				$tpl->newBlock("aud_data");
				$tpl->assign("crea_user",$cab_ent['crea_user']);
				$tpl->assign("mod_user",$cab_ent['mod_user']);
				$tpl->assign("crea_date",$cab_ent['crea_date']);
				$tpl->assign("mod_date",$cab_ent['mod_date']);
				if($cab_ent["status"]!="PEN"){ $tpl->newBlock("val"); }
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