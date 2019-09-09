<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new"){
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
			if($action=="save_new"){
				extract($_GET, EXTR_PREFIX_ALL, "");
				$datos = $detalles = $det_mov = $det_art = $det_cant = $det_costou = $det_impp = $det_impm = $det_total = $det_odc_det = $det_cnota_det = $det_origen_det = array();
				$monto_mov = $monto_desc = $monto_total = 0;
				$status_ = "PRO";
				$tipo="CSM";
				if(!empty($_GET['carticulo'])){
					for ($i=0; $i<sizeof($_GET['carticulo']); $i++){
						$bruto = $_cant[$i]*$_precio[$i];
						$impuesto = 0;
						$total = $bruto + $impuesto;
						$monto_mov = $monto_mov + $total;
						array_push($det_mov, 0);
						array_push($det_art, $_carticulo[$i]);
						array_push($det_cant, $_cant[$i]);
						array_push($det_costou, $_precio[$i]);
						array_push($det_impp, 0);
						array_push($det_impm, 0);
						array_push($det_total, $total);
						array_push($det_origen_det, $_cot_det[$i]);//ORIGEN
						array_push($det_odc_det, 0);//ODC
						array_push($det_cnota_det, 0);//NTE
					}
					$monto_total=$monto_mov-$monto_desc;
				}
				array_push($datos, date("Y-m-d"));
				array_push($datos, "123");
				array_push($datos, 0);
				array_push($datos, date("Y-m-d"));
				array_push($datos, $_calmacen);//ALMACEN
				array_push($datos, 0);
				array_push($datos, $status_);
				array_push($datos, $monto_mov);
				array_push($datos, $monto_desc);
				array_push($datos, $monto_total);
				array_push($datos, $_id);//ORIGEN
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
				$mensaje="CONSUMO PROCESADO";

				if($resultado["title"]=="SUCCESS"){
					$response['title']=$resultado["title"];
					$response["content"]=$mensaje;
				}else{
					$response['title']=$resultado["title"];
					$response["content"]=$resultado["content"];
				}				
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
				$var_array_nav["ref"]="FORM_INV_ODS";
				$var_array_nav["subref"]="NONE";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter","NONE");
				$tpl->assign("menu_name","CONSUMOS DE ODS");
			}
			if($action=="new"){
				$tpl->assign("accion",'save_new');
				$data=$data_class->get_sub($_GET["id"],true);
				if($data["title"]=="SUCCESS"){
					foreach ($data["cab"] as $key => $value){
						$tpl->assign($key,$value);
					}
					$art=$data["art"];
					if(!empty($art)){
						foreach ($art as $key => $value) {
							$tpl->newBlock("det_csm");
							foreach ($value as $key1 => $value1) {
								$tpl->assign($key1,$value1);
							}
							$tpl->assign("count",($key+1));
						}
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