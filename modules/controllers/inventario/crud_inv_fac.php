<?php
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
			$var_array_nav["ref"]="FORM_INV_FAC";
			$var_array_nav["subref"]="NONE";
			foreach ($var_array_nav as $key_ => $value_) {
				$tpl->assign($key_,$value_);
			}

			//VARIABLES VISUALES
			$tpl->assign("menu_pri",$value['menu']);
			$tpl->assign("menu_sec",$value['modulo']);
			$tpl->assign("menu_ter","NONE");
			$tpl->assign("menu_name","RECEPCION DE FACTURAS");
			$tpl->assign("mod_name","ORDENES DE COMPRAS");
		}
		$data=$data_class->list_mov("COM",false,false,false,false,false,$almacenes);
		if($data["title"]=="SUCCESS"){
			foreach ($data["content"] as $llave => $datos) {
				$tpl->newBlock("data");
				$id=$datos['codigo'];
				if($datos["dev"]!="N/A"){
					$datos['status']="CAN";
					$tpl->assign("isdev","isdev");
				}
				if(!empty($array_all)){
					foreach ($array_all as $key => $value){
						if($key==$datos['status']){
							$sts=$value;
						}
					}
					$tpl->assign("ESTATUS",$sts);
				}
				$stats_color=color_status($datos['status'],"table");
				$cadena_acciones='
				<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light menu" data-toggle="tooltip" data-placement="top" title="VER" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref"].'" data-subref="'.$var_array_nav["subref"].'" data-acc="EDIT" data-id="'.$id.'"><i class="fas fa-search"></i></button>
				';
				foreach ($data["content"][$llave] as $key => $value){
					$value = ($key=="code") ? formatRut($value) : $value ;
					$tpl->assign($key,$value);
				}
				$tpl->assign("actions",$cadena_acciones);
				$tpl->assign("estatus",$stats_color);
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