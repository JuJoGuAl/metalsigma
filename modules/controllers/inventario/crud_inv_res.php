<?php
$almacenes = array();
$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
if(!empty($perm_val["content"][0]["alm"])){
	foreach ($perm_val["content"][0]["alm"] as $key => $value) {
		$almacenes[] .= $perm_val["content"][0]["alm"][$key]["calmacen"];
	}
}
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
			$var_array_nav["ref_"]="FORM_INV_RES_VIEW";
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
		$data=$data_class->list_reser(1,$almacenes);
		if($data["title"]=="SUCCESS"){
			foreach ($data["content"] as $llave => $datos) {
				$tpl->newBlock("data");
				$id=$datos['ccotizacion'].",".$datos['calmacen'];
				$cadena_acciones='
				<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light menu" data-toggle="tooltip" data-placement="top" title="VER" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref_"].'" data-subref="'.$var_array_nav["subref"].'" data-acc="EDIT" data-id="'.$id.'"><i class="fas fa-search"></i></button>
				';
				foreach ($data["content"][$llave] as $key => $value){
					$tpl->assign($key,$value);
					$tpl->assign("actions",$cadena_acciones);
				}
			}			
		}
		$ins=$perm_val["content"][0]["ins"];
		if($ins==1){
			$tpl->newBlock("data_new");
			foreach ($var_array_nav as $key_ => $value_) {
				$tpl->assign($key_,$value_);
			}
		}
	}
}
?>