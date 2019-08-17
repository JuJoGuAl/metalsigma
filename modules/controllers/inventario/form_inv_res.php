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
			extract($_GET, EXTR_PREFIX_ALL, "");
			$detalles = $det_art = $det_cant = $det_alm = $det_ods = $det_sts = $det_not = array();
			//VERIFICO SI SE UTILIZO DETALLES (EVITO EL ERROR DE ARREGLO VACIO)
			if(!empty($_GET['carticulo'])){
				for ($i=0; $i<sizeof($_GET['carticulo']); $i++){
					array_push($det_ods, $_cods);
					array_push($det_alm, $_calmacen);
					array_push($det_art, $_carticulo[$i]);
					array_push($det_cant, $_cant[$i]);
					array_push($det_not, $_notas);
					array_push($det_sts, 1);
				}
			}
			array_push($detalles, $det_ods);
			array_push($detalles, $det_alm);
			array_push($detalles, $det_art);
			array_push($detalles, $det_cant);
			array_push($detalles, $det_not);
			array_push($detalles, $det_sts);			

			if($action=="save_new"){
				if($ins!=1){
					$resultado['title']="ERROR";
					$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
				}else{
					$resultado=$data_class->new_resv($detalles);
				}
			}

			$mensaje="RESERVA REALIZADA CON EXITO!";
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
				$var_array_nav["ref"]="FORM_INV_RES";
				$var_array_nav["subref"]="NONE";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter","NONE");
				$tpl->assign("menu_name","RESERVA DE ARTICULOS PARA ODS");
			}
			if($action=="new"){
				$tpl->assign("accion",'save_new');;
				$ins=$perm_val["content"][0]["ins"];
				if($ins==1){
					$tpl->newBlock("data_save");
					foreach ($var_array_nav as $key_ => $value_) {
						$tpl->assign($key_,$value_);
					}
				}else{ $tpl->assign("read",'readonly'); }
				$data=$data_class->list_a(1,false,true,false,$almacenes);
				if($data["title"]=="SUCCESS"){
					foreach ($data["content"] as $key => $value){
						$tpl->newBlock("alm_det");
						foreach ($data["content"][$key] as $key1 => $value1){
							$tpl->assign($key1,$value1);
						}
					}
				}
			}
		}
	}
}
?>