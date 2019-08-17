<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new" || $action=="save_edit" || $action=="proc"){
	include_once("../../../class/functions.php");
	include_once("../../../class/class.compras.php");
	$data_class = new compras;
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
			$datos = $detalles = $det_det = $det_art = $det_cant = $det_costou = $det_impp = $det_impm = $det_total = $det_cot_det = array();			
			$status_ = ($action=="proc") ? "PRO" : "PEN";
			array_push($datos, $_cproveedor);
			array_push($datos, setDate($_fecha));
			array_push($datos, 0);//ODS
			array_push($datos, $status_);//STATUS
			if(!empty($_GET['carticulo'])){
				for ($i=0; $i<sizeof($_GET['carticulo']); $i++){
					$bruto = $_cant[$i]*$_precio[$i];
					$impuesto = ($bruto*$_imp[$i])/100;
					$total = $bruto + $impuesto;
					array_push($det_det, $_corden_det[$i]);
					array_push($det_art, $_carticulo[$i]);
					array_push($det_cant, $_cant[$i]);
					array_push($det_costou, $_precio[$i]);
					array_push($det_impp, $_imp[$i]);
					array_push($det_impm, $impuesto);
					array_push($det_total, $total);
					array_push($det_cot_det, 0);//COTIZA_DET
				}
			}
			array_push($detalles, $det_det);
			array_push($detalles, $det_art);
			array_push($detalles, $det_cant);
			array_push($detalles, $det_costou);
			array_push($detalles, $det_impp);
			array_push($detalles, $det_impm);
			array_push($detalles, $det_total);
			array_push($detalles, $det_cot_det);

			if($action=="save_edit" || $action=="proc"){
				if($upt!=1){
					$resultado['title']="ERROR";
					$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					if($_id==0){
						$resultado=$data_class->new_cot($datos,$detalles);
					}else{
						$resultado=$data_class->edit_cot($_id,$datos,$detalles);
					}
				}
			}else{
				if($ins!=1){
					$resultado['title']="ERROR";
					$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					$resultado=$data_class->new_cot($datos,$detalles);
				}
			}

			$mensaje="SIN MENSAJE";
			switch ($action) {
				case "save_new":
					$mensaje="COTIZACION CREADA CON EXITO";
				break;
				case "save_edit":
					$mensaje="DATOS DE LA COTIZACION ACTUALIZADOS";
				break;
				case "proc":
					$mensaje="COTIZACION PROCESADA!";
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
		include_once("./class/class.compras.php");
		$data_class = new compras;
		$modulo = $perm->get_module($_GET['submod']);
		if(Evaluate_Mod($modulo)){
			$tpl->newBlock("module");
			foreach ($modulo["content"] as $key => $value){
				//VARIABLES PARA NAVEGAR
				$var_array_nav=array();
				$var_array_nav["mod"]=$_GET['mod'];
				$var_array_nav["submod"]=$_GET['submod'];
				$var_array_nav["ref"]="FORM_COT_SERV";
				$var_array_nav["subref"]="NONE";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter","NONE");
				$tpl->assign("menu_name","COTIZACION DE SERVICIO");
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
			}elseif($action=="edit"){
				$tpl->assign("accion",'save_edit');
				$data=$data_class->get_cot($_GET['id']);
				if(Evaluate_Mod($data)){
					$cab=$data["cab"];
					$det=$data["det"];
					$tpl->assign("id_tittle",$_GET["id"]);
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
					if(!empty($det)){
						foreach ($det as $key => $value) {
							$tpl->newBlock("art_det");
							foreach ($value as $key1 => $value1) {
								$tpl->assign($key1,$value1);
							}
							$tpl->assign("count",$key);
							$tpl->assign("actions",'<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl"><i class="fas fa-trash-alt"></i></button>');
						}
					}
				}
				$tpl->newBlock("aud_data");
				$tpl->assign("crea_user",$cab['crea_user']);
				$tpl->assign("mod_user",$cab['mod_user']);
				$tpl->assign("crea_date",$cab['crea_date']);
				$tpl->assign("mod_date",$cab['mod_date']);
				if($cab['status']!="PEN"){ $tpl->newBlock("val"); }
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