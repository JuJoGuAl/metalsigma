<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new"){
	include_once("../../../class/functions.php");
	include_once("../../../class/class.inventario.php");
	include_once("../../../class/class.compras.php");
	$data_class = new inventario;
	$data_class1 = new compras;
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
			$tipo="DCO";
			$data=$data_class->get_mov($_ctransaccion);
			//print_r($data);
			if($data["title"]=="SUCCESS"){
				if($data["det"]){
					foreach ($data["det"] as $key => $value) {
						$bruto = $value["cant"]*$value["costou"];
						$impuesto = ($bruto*$value["imp_p"])/100;
						$total = $bruto + $impuesto;
						$monto_mov = $monto_mov + $total;
						array_push($det_mov, 0);
						array_push($det_art, $value["codigo_articulo"]);
						array_push($det_cant, $value["cant"]);
						array_push($det_costou, $value["costou"]);
						array_push($det_impp, $value["imp_p"]);
						array_push($det_impm, $impuesto);
						array_push($det_total, $total);
						array_push($det_origen_det, $value["codigo"]);//ORIGEN
						array_push($det_odc_det, 0);//ODC
						array_push($det_cnota_det, 0);//NTE

						//SI TIENE UNA ODC BUSCO SU CANTIDAD RESTANTE
						if($value["corden_det"]>0){
							//DETERMINO SI LA ODC EXISTE Y POSEE UNIDADES DISPONIBLE
							$data1=$data_class1->get_odc_det($value["corden_det"]);
							//VERIFICO LA DISPONIBILIDAD DE ART
							$disponible = ($data1["content"]["cant_rest"])*1;
							$original = ($data1["content"]["cant"])*1;
							$movimniento = $value["cant"]*1;
							if($disponible==$original){
								$response['title']="ERROR";
								$response["content"]="NO EXISTEN CANTIDADES DISPONIBLES PARA EL ARTICULO: <strong>".$data1["content"]["articulo"]."</strong> EN LA ODC: <strong>".$data1["content"]["origen"]."</strong>";
								echo json_encode($response);
								exit();// ME SALGO DEL BUCLE YA QUE NO PROCESARE NADA
							}else if(($disponible+$movimniento)>$original){
								$response['title']="ERROR";
								$response["content"]="LA CANTIDAD A PROCESAR DEL ARTICULO: <strong>".$data1["content"]["articulo"]."</strong> EN LA ODC: <strong>".$data1["content"]["origen"]." ES MAYOR A LA CANTIDAD A SOLICITADA</strong>";
								echo json_encode($response);
								exit();// ME SALGO DEL BUCLE YA QUE NO PROCESARE NADA
							}
						}
					}
					$monto_total=$monto_mov-$monto_desc;

					array_push($datos, date("Y-m-d"));
					array_push($datos, $data["cab"]["documento"]);
					array_push($datos, $data["cab"]["codigo_proveedor"]);
					array_push($datos, date("Y-m-d"));
					array_push($datos, $data["cab"]["codigo_almacen"]);
					array_push($datos, 0);//ALMACEN 2
					array_push($datos, $status_);
					array_push($datos, $monto_mov);
					array_push($datos, $monto_desc);
					array_push($datos, $monto_total);
					array_push($datos, $data["cab"]["codigo"]);//ORIGEN
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
							print_r($resultado);
						}
					}

					$mensaje="RECEPCION DE FACTURA ANULADA!";
					
					if($resultado["title"]=="SUCCESS"){
						$response['title']=$resultado["title"];
						$response["content"]=$mensaje;
					}else{
						$response['title']=$resultado["title"];
						$response["content"]=$resultado["content"];
					}
				}
			}else{
				$response['title']="ERROR";
				$response["content"]=$data["content"];
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
				$var_array_nav["ref"]="FRM_INV_DCO";
				$var_array_nav["subref"]="NONE";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter","NONE");
				$tpl->assign("menu_name","ANULAR RECEPCIONES DE FACTURAS");
				$tpl->assign("form_title","TRANSACCION: ");
			}
			if($action=="modulo"){
				$tpl->assign("accion",'save_new');
				$tpl->assign("stats_code","PEN");
				$tpl->assign("stats_nom","PENDIENTE");
				$tpl->assign("id_tittle","NUEVA");
				$tpl->assign("status_color",color_status("PEN","badge"));
				$tpl->assign("codigo",0);
				$tpl->assign("fecha_anul",date("d-m-Y"));
			}
			$ins=$perm_val["content"][0]["ins"];
			if($ins==1){
				$tpl->newBlock("data_save");
				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}
				$tpl->newBlock("data_save_search");
				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}
			}else{ $tpl->assign("read",'readonly'); }
		}
	}
}
?>