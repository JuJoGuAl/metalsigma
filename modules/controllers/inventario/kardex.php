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
			$var_array_nav["ref"]="NONE";
			$var_array_nav["subref"]="NONE";
			foreach ($var_array_nav as $key_ => $value_) {
				$tpl->assign($key_,$value_);
			}

			//VARIABLES VISUALES
			$tpl->assign("menu_pri",$value['menu']);
			$tpl->assign("menu_sec",$value['modulo']);
			$tpl->assign("menu_ter","NONE");
			$tpl->assign("menu_name","KARDEX DE ARTICULOS");
			$tpl->assign("mod_name","ORDENES DE COMPRAS");
		}
		$data=$data_class->list_a(1,false,false,false,$almacenes);
		if($data["title"]=="SUCCESS"){
			foreach ($data["content"] as $llave => $datos) {
				$tpl->newBlock("falmacen");
				foreach ($data["content"][$llave] as $key => $value){
					$tpl->assign($key,$value);
				}
			}
		}
		if(!empty($array_movi)){
			foreach ($array_movi as $llave => $datos){
				$tpl->newBlock("ftipo");
				$tpl->assign("code",$llave);
				$tpl->assign("valor",$datos);
			}
		}
		$data=$data_class->kardex();
		if($data["title"]=="SUCCESS"){
			foreach ($data["content"] as $llave => $datos) {
				$tpl->newBlock("data");
				foreach ($data["content"][$llave] as $key => $value){
					$value = (in_array($key, $array_numbers)) ? numeros($value,2) : $value ;
					$tpl->assign($key,$value);
				}
				$costot = ($datos['costou']>0) ? $datos['cant']*$datos['costou'] : 0 ;
				$tpl->assign("costo_total",numeros($costot,2));
			}			
		}		
	}
}
?>