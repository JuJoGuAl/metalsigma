<?php
$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
if($perm_val["title"]<>"SUCCESS"){
	alerta("NO POSEES PERMISO PARA ESTE MODULO","ERROR");
}else{
	include_once("./class/class.planificacion.php");
	include_once("./class/class.cotizaciones.php");
	$data_class = new planificaciones;
	$cotizaciones = new cotizaciones;
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
			$tpl->assign("menu_name","PLANIFICACIONES");

			$tpl->assign("fecha",date("d-m-Y"));
			$avance = $cotizaciones->list_sub(false,$array_cot_ods);
			if($avance["title"]=="SUCCESS"){
				foreach ($avance["content"] as $key => $value) {
					$tpl->newBlock("avance");
					foreach ($avance["content"][$key] as $key1 => $value1){
						$value1 = ($key1=="avance" || $key1=="adic" || $key1=="ocupado" || $key1=="horas") ? numeros($value1,2) : $value1 ;
						$tpl->assign($key1,$value1);
					}
					$trabajos_ = $cotizaciones->get_sub($avance["content"][$key]["codigo"],true);
					if($trabajos_["title"]=="SUCCESS"){
						$cab=$trabajos_["cab"];
						$det=$trabajos_["det"];
						$art=$trabajos_["art"];
						if(!empty($det)){
							foreach ($det as $key3 => $value3){
								$tpl->newBlock("trabajos");
								$tpl->assign("tarea",$det[$key3]["articulo"]);
							}
						}
					}
				}
			}
		}
	}
}
?>