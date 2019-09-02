<?php
$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
if($perm_val["title"]<>"SUCCESS"){
	alerta("NO POSEES PERMISO PARA ESTE MODULO","ERROR");
}else{
	include_once("./class/class.compras.php");
	$data_class = new compras;
	$modulo = $perm->get_module($_GET['submod']);
	if(Evaluate_Mod($modulo)){
		$tpl->newBlock("module");
		foreach ($modulo["content"] as $key => $value){
			//VARIABLES PARA NAVEGAR
			$var_array_nav=array();
			$var_array_nav["mod"]=$_GET['mod'];
			$var_array_nav["submod"]=$_GET['submod'];
			$var_array_nav["ref"]="FORM_COT_SERV";
			$var_array_nav["subref"]="NONE";
			foreach ($var_array_nav as $key_ => $value_) {
				$tpl->assign($key_,$value_);
			}

			//VARIABLES VISUALES
			$tpl->assign("menu_pri",$value['menu']);
			$tpl->assign("menu_sec",$value['modulo']);
			$tpl->assign("menu_ter","NONE");
			$tpl->assign("menu_name","COTIZACIONES DE SERVICIOS");
		}
		$data=$data_class->list_cot();
		if($data["title"]=="SUCCESS"){
			foreach ($data["content"] as $llave => $datos) {
				$tpl->newBlock("data");
				$id=$datos['codigo'];
				if(!empty($array_all)){
					foreach ($array_all as $key => $value){
						if($key==$datos['status']){
							//$sts=$value;
							$sts = ($datos['status']=="PRO" && $datos['cods']>0) ? "RESERVADA" : $value ;
							$class_name = ($datos['cods']>0 && ($datos['status']!="PEN")) ? "_stats" : "";
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
					$value = (in_array($key, $array_numbers)) ? numeros($value,2) : $value ;
					$tpl->assign($key,$value);
				}
				$stas_ = "-";
				if ($datos['status']=="PRO" && $datos['cods']>0){
					$stas_ = "RESERVADA";
				}elseif($datos['status']=="UTI"){
					$stas_ = "UTILIZADA";
				}elseif($datos['status']=="CAN"){
					$stas_ = "CANCELADA";
				}
				$tpl->assign("stas_",$stas_." POR:");
				$tpl->assign("actions",$cadena_acciones);
				$tpl->assign("estatus",$stats_color);
				$tpl->assign("class",$class_name);
				$cuerpo = "SIN COTIZACION!";
				if($datos['cot_pad']!="N/A"){
					$cuerpo = "<strong>".$datos["cli_cot_nom"]."</strong><br>RUT: <strong>".formatRut($datos["cli_cot_code"])."</strong><br>";
					$cuerpo .= "COT CLIENTE: <strong>".$datos["cot_pad"]."</strong><br>";
					$cuerpo .= "ODS CLIENTE: <strong>".$datos["ods_pad"]."</strong><br>";
				}
				$tpl->assign("cuerpo",$cuerpo);
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