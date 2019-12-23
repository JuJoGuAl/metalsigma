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
			$tpl->assign("menu_name","PLANIFICACIONES DE ODS");
			
			$colacion		=	constant("DUR_COL");
			$inicio			=	constant("H_INI");
			$fin			=	constant("H_FIN");
			$dias_pasado	=	constant("DIAS_PAST");

			$tpl->assign("inicio",$inicio.":00");
			$tpl->assign("fin",$fin.":00");
			$tpl->assign("fecha_past",setDate(date("d-m-Y"),"d-m-Y H:i","-P".$dias_pasado."D"));
			$tpl->assign("fin_cola",setDate($fin,"H:i","PT".setDate("00:".$colacion,"i")."M"));
		}
	}
}
?>