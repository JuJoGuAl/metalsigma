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
			$datos = $detalles = $det_mov = $det_art = $det_cant = $det_costou = $det_impp = $det_impm = $det_total = $det_odc_det = $det_cnota_det = $det_origen_det = array();
			$monto_mov = $monto_desc = $monto_total = 0;
			$status_ = "PRO";
			$tipo="AJE";
			//VERIFICO SI SE UTILIZO DETALLES (EVITO EL ERROR DE ARREGLO VACIO)
			if(!empty($_GET['carticulo'])){
				for ($i=0; $i<sizeof($_GET['carticulo']); $i++){
					array_push($det_mov, 0);
					array_push($det_art, $_carticulo[$i]);
					array_push($det_cant, $_cant[$i]);
					array_push($det_costou, 0);
					array_push($det_impp, 0);
					array_push($det_impm, 0);
					array_push($det_total, 0);
					array_push($det_origen_det, 0);//ORIGEN
					array_push($det_odc_det, 0);//ODC
					array_push($det_cnota_det, 0);//NTE					
				}
			}
			array_push($datos, date("Y-m-d"));
			array_push($datos, 0);
			array_push($datos, 0);
			array_push($datos, setDate($_f_doc));
			array_push($datos, $_calmacen);
			array_push($datos, 0);//ALMACEN 2
			array_push($datos, $status_);
			array_push($datos, 0);
			array_push($datos, 0);
			array_push($datos, 0);
			array_push($datos, 0);//ORIGEN
			array_push($datos, $_notas);

			array_push($detalles, $det_mov);
			array_push($detalles, $det_art);
			array_push($detalles, $det_cant);
			array_push($detalles, $det_costou);
			array_push($detalles, $det_impp);
			array_push($detalles, $det_impm);
			array_push($detalles, $det_total);
			array_push($detalles, $det_origen_det);
			array_push($detalles, $det_odc_det);
			array_push($detalles, $det_cnota_det);

			if($action=="save_new"){
				if($ins!=1){
					$resultado['title']="ERROR";
					$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					$resultado=$data_class->new_mov($tipo,$datos,$detalles);
				}
			}

			$mensaje="SIN MENSAJE";
			switch ($action) {
				case "save_new":
					$mensaje="REGISTRO CREADO CON EXITO!";
				break;
				case "save_edit":
					$mensaje="REGISTRO ACTUALIZADO CON EXITO!";
				break;
				case "proc":
					$mensaje="MOVIMIENTO PROCESADO";
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
				$var_array_nav["ref"]="FORM_INV_AJE";
				$var_array_nav["subref"]="NONE";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter","NONE");
				$tpl->assign("menu_name","AJUSTES DE ENTRADA");
				$tpl->assign("form_title","TRANSACCION: ");
			}
			if($action=="new"){
				$tpl->assign("accion",'save_new');
				$tpl->assign("stats_code","PEN");
				$tpl->assign("stats_nom","PENDIENTE");
				$tpl->assign("id_tittle","NUEVA");
				$tpl->assign("status_color",color_status("PEN","badge"));
				$tpl->assign("codigo",0);
				$tpl->assign("fecha_doc",date("d-m-Y"));
				$tpl->assign("fecha_mov",date("d-m-Y"));
				$data=$data_class->list_a(1,false,true,false,$almacenes);
				if($data["title"]=="SUCCESS"){
					foreach ($data["content"] as $key => $value){
						$tpl->newBlock("alm_det");
						foreach ($data["content"][$key] as $key1 => $value1){
							$tpl->assign($key1,$value1);
						}
					}
				}
			}elseif($action=="edit"){
				$tpl->assign("accion",'save_edit');
				$data=$data_class->get_mov($_GET['id']);
				if(Evaluate_Mod($data)){
					$cab=$data["cab"];
					$det=$data["det"];
					$tpl->assign("id_tittle",$cab["codigo_transaccion"]);
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
							$tpl->newBlock("alm_det");
							if($data["content"][$key]["codigo"]==$cab["codigo_almacen"]){
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