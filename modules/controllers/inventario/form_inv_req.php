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
			$datos = $detalles = $det_mov = $det_art = $det_cant = array();
			$monto_mov = $monto_desc = $monto_total = 0;
			$status_ = ($action=="proc") ? "PRO" : "PEN";
			//VERIFICO SI SE UTILIZO DETALLES (EVITO EL ERROR DE ARREGLO VACIO)
			if(!empty($_GET['carticulo'])){
				for ($i=0; $i<sizeof($_GET['carticulo']); $i++){
					array_push($det_mov, $_corden_det[$i]);
					array_push($det_art, $_carticulo[$i]);
					array_push($det_cant, $_cant[$i]);					
				}
			}
			array_push($datos, $_calmacen_ori);
			array_push($datos, $_calmacen_des);
			array_push($datos, setDate($_fecha));
			array_push($datos, $_notas);
			array_push($datos, $status_);			

			array_push($detalles, $det_mov);
			array_push($detalles, $det_art);
			array_push($detalles, $det_cant);			

			if($action=="save_edit" || $action=="proc"){
				if($upt!=1){
					$resultado['title']="ERROR";
					$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					if($_id==0){
						$resultado=$data_class->new_req($datos,$detalles);
					}else{
						$resultado=$data_class->edit_req($_id,$datos,$detalles);
					}
				}
			}else{
				if($ins!=1){
					$resultado['title']="ERROR";
					$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					$resultado=$data_class->new_req($datos,$detalles);
				}
			}

			$mensaje="SIN MENSAJE";
			switch ($action) {
				case "save_new":
					$mensaje="REQUISICION CREADA!";
				break;
				case "save_edit":
					$mensaje="REQUISICION ACTUALIZADA!";
				break;
				case "proc":
					$mensaje="REQUISICION PROCESADA!";
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
				$var_array_nav["ref"]="FORM_INV_REQ";
				$var_array_nav["subref"]="NONE";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter","NONE");
				$tpl->assign("menu_name","REQUISICION DE ARTICULOS");
				$tpl->assign("form_title","TRANSACCION: ");
			}
			if($action=="new"){
				$tpl->assign("accion",'save_new');
				$tpl->assign("stats_code","PEN");
				$tpl->assign("stats_nom","PENDIENTE");
				$tpl->assign("id_tittle","NUEVA");
				$tpl->assign("status_color",color_status("PEN","badge"));
				$tpl->assign("codigo",0);
				$tpl->assign("fecha",date("d-m-Y"));
				$tpl->assign("vis","");
				$data=$data_class->list_a(1,false,true,false,$almacenes);
				if($data["title"]=="SUCCESS"){
					foreach ($data["content"] as $key => $value){
						$tpl->newBlock("alm_det_des");
						foreach ($data["content"][$key] as $key1 => $value1){
							$tpl->assign($key1,$value1);
						}
					}
				}
				$data=$data_class->list_a(1,true,false,false);
				if($data["title"]=="SUCCESS"){
					foreach ($data["content"] as $key => $value){
						$tpl->newBlock("alm_det_ent");
						foreach ($data["content"][$key] as $key1 => $value1){
							$tpl->assign($key1,$value1);
						}
					}
				}
			}elseif($action=="edit"){
				$tpl->assign("accion",'save_edit');
				$tpl->assign("vis","d-none");
				$data=$data_class->get_req($_GET['id']);
				if(Evaluate_Mod($data)){
					$cab=$data["cab"];
					$det=$data["det"];
					$tpl->assign("id_tittle",$cab["codigo"]);
					$tpl->assign("status_color",color_status($cab['status'],"badge"));
					foreach ($cab as $llave => $datos) {
						$tpl->assign($llave,$datos);
					}
					if(!empty($array_all)){
						foreach ($array_all as $llave => $datos){
							if($llave==$cab["status"]){
								$tpl->assign("stats_code",$llave);
								$tpl->assign("stats_nom",$datos);
							}
						}
					}
					$data=$data_class->list_a(1,false,true,false,$almacenes);
					if($data["title"]=="SUCCESS"){
						foreach ($data["content"] as $key => $value){
							$tpl->newBlock("alm_det_des");
							if($data["content"][$key]["codigo"]==$cab["cod_almacendes"]){
								$tpl->assign("selected",$selected);
							}
							foreach ($data["content"][$key] as $key1 => $value1){
								$tpl->assign($key1,$value1);
							}
						}
					}
					$data=$data_class->list_a(1,true,false,false);
					if($data["title"]=="SUCCESS"){
						foreach ($data["content"] as $key => $value){
							$tpl->newBlock("alm_det_ent");
							if($data["content"][$key]["codigo"]==$cab["cod_almacenori"]){
								$tpl->assign("selected",$selected);
							}
							foreach ($data["content"][$key] as $key1 => $value1){
								$tpl->assign($key1,$value1);
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
				$tpl->assign("crea_user",$cab['crea_user']);
				$tpl->assign("mod_user",$cab['mod_user']);
				$tpl->assign("crea_date",$cab['crea_date']);
				$tpl->assign("mod_date",$cab['mod_date']);
				if($cab["status"]!="PEN"){ $tpl->newBlock("val"); }
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