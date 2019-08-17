<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
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
		if($action=="edit"){
			$tpl->assign("accion",'save_edit');
			$tpl->assign("tex_row","NOTAS");
			$variables = explode(",", $_GET["id"]);
			$cod_almacen = $variables[1];
			$cod_cotizacion = $variables[0];
			$data=$data_class->get_reser(false,$cod_almacen,$cod_cotizacion);
			if(Evaluate_Mod($data)){
				foreach ($data["content"] as $llave => $datos) {
					foreach ($data["content"][$llave] as $llave1 => $datos1) {
						$tpl->assign($llave1,$datos1);
					}
				}
				foreach ($data["content"] as $llave => $datos) {
					$tpl->newBlock("art_det");
					foreach ($data["content"][$llave] as $llave1 => $datos1) {
						$tpl->assign($llave1,$datos1);
					}
					$descripcion = (strlen($data["content"][$llave]["notas"])>15) ? substr($data["content"][$llave]["notas"],0,15).' <span class="fas fa-info-circle pop" data-body="'.$data["content"][$llave]["notas"].'"></span>' : $data["content"][$llave]["notas"] ;
					$estatus_ = ($data["content"][$llave]["status"]==1) ? "ACT" : "INC" ;
					$tpl->assign("notas_par",$descripcion);
					$tpl->assign("esta_",$estatus_);
				}
			}
			$tpl->newBlock("val");
		}
	}
}
?>