<?php
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
			$var_array_nav["ref"]="NONE";
			$var_array_nav["subref"]="NONE";

			foreach ($var_array_nav as $key_ => $value_) {
				$tpl->assign($key_,$value_);
			}
			//VARIABLES VISUALES
			$tpl->assign("menu_pri",$value['menu']);
			$tpl->assign("menu_sec",$value['modulo']);
			$tpl->assign("menu_ter","NONE");
			$tpl->assign("menu_name","RESUMEN DE COTIZACIONES");
			$año = date("Y");
			$mes = date("m");
			//FILTROS
			$data = $data_class->list_sub_group("co.crea_date","DISTINCT YEAR(co.crea_date) AS year");
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value) {
					$tpl->newBlock("det_year");
					if($año==$data["content"][$key]["year"]){
						$tpl->assign("selected",$selected);
					}
					foreach ($data["content"][$key] as $key1 => $value1){
						$tpl->assign("valor",$value1);
					}
				}
			}
			$data = $data_class->list_sub_group("co.crea_date","DISTINCT MONTH(co.crea_date) AS mes");
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value) {
					$tpl->newBlock("det_mont");
					if($mes==$data["content"][$key]["mes"]){
						$tpl->assign("selected",$selected);
					}
					foreach ($data["content"][$key] as $key1 => $value1){
						$tpl->assign("valor",$value1);
						$tpl->assign("dato",$array_mont[$value1]);
					}
				}
			}
			$data = $data_class->list_sub_group("co.crea_user","(CASE WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS trabajador, co.crea_user");
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value) {
					$tpl->newBlock("det_vend");
					foreach ($data["content"][$key] as $key1 => $value1){
						$tpl->assign("valor",$data["content"][$key]["crea_user"]);
						$tpl->assign("dato",$data["content"][$key]["trabajador"]);
					}
				}
			}			
		}
	}
}
?>