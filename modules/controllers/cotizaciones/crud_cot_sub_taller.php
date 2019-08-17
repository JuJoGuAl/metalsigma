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
			$quien="TALLER";
			$var_array_nav=array();
			$var_array_nav["mod"]=$_GET['mod'];
			$var_array_nav["submod"]=$_GET['submod'];
			$var_array_nav["ref"]="FORM_COT_SUB_".$quien;
			$var_array_nav["subref"]="NONE";
			foreach ($var_array_nav as $key_ => $value_) {
				$tpl->assign($key_,$value_);
			}

			//VARIABLES VISUALES
			$tpl->assign("menu_pri",$value['menu']);
			$tpl->assign("menu_sec",$value['modulo']);
			$tpl->assign("menu_ter","NONE");
			$tpl->assign("menu_name","APROBACIONES - ".$quien);
			$tpl->assign("mod_name","COTIZACIONES DE SERVICIO");
		}
		$datos=$data_class->get_all($_GET["id"]);
		$codigo=$datos["content"]["codigo"];
		foreach ($datos["content"] as $key => $value){
			$value = ($key=="code") ? formatRut($value) : $value ;
			$tpl->assign($key,$value);
		}
		$data=$data_class->list_sub($_GET["id"],$array_cot_ta);
		if($data["title"]=="SUCCESS"){
			foreach ($data["content"] as $llave => $datos) {
				$tpl->newBlock("data");
				$id=$datos['codigo'];
				$stats_color=color_status($datos['status'],"table");
				$span="";
				if($datos["notas_user"]!="" && ($datos['status']=="PEN") || $datos['status']=="CAN"){
					$texto="";
					if($datos['status']=="PEN"){
						$texto="Re-Cotizada por: <strong>".$datos["mod_user"]."</strong><br>Fecha: <strong>".setDate($datos["mod_date"],"d/m/Y H:i:s")."</strong><br>Comentarios: <strong>".$datos["notas_user"]."</strong>";
					}elseif($datos['status']=="CAN"){
						$texto="Cancelada por: <strong>".$datos["mod_user"]."</strong><br>Fecha: <strong>".setDate($datos["mod_date"],"d/m/Y H:i:s")."</strong><br>Comentarios: <strong>".$datos["notas_user"]."</strong>";
					}
					$span.='<span class="badge badge-pill count badge-warning" data-content="'.$texto.'" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
				}
				if($datos["ultima_edicion"]>0){
					$cotiza_hist=$data_class->get_hcs($datos["ultima_edicion"]);
					$historia=$cotiza_hist["content"][0];
					$span.='<span class="badge badge-pill count badge-info" data-content="Existen cambios<br>Por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
				}
				$cadena_acciones='
				<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light menu" data-toggle="tooltip" data-placement="top" title="VER" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref"].'" data-subref="'.$var_array_nav["subref"].'" data-acc="EDIT" data-id="'.$id.'"><i class="fas fa-search"></i></button>'.$span.'
				';
				if(!empty($array_status)){
					$stat=$kstat="";
					foreach ($array_status as $key => $value){
						if($key==$datos["status"]){
							$kstat=$key;
							$stat=$value;
						}
					}
				}
				$cadena_status='<div class="tooltip_">
				<span data-toggle="tooltip" data-placement="top" title="" data-original-title="'.$stat.'">'.$kstat.'</span>
				</div>
				';
				foreach ($data["content"][$llave] as $key => $value){
					$campos = array("m_neto");
					$value = (in_array($key, $campos)) ? numeros($value,0) : $value ;
					$tpl->assign($key,$value);
					$tpl->assign("actions",$cadena_acciones);
					$tpl->assign("estatus",$stats_color);
					$tpl->assign("estatus_",$cadena_status);
				}
			}			
		}
	}
}
?>