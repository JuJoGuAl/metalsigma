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
			$var_array_nav["ref"]="FORM_ODS";
			$var_array_nav["subref"]="NONE";
			foreach ($var_array_nav as $key_ => $value_) {
				$tpl->assign($key_,$value_);
			}

			//VARIABLES VISUALES
			$tpl->assign("menu_pri",$value['menu']);
			$tpl->assign("menu_sec",$value['modulo']);
			$tpl->assign("menu_ter","NONE");
			$tpl->assign("menu_name","ORDEN DE SERVICIO");
			$tpl->assign("mod_name","ORDENES DE SERVICIO");
		}
		if(!empty($array_ods)){
			foreach ($array_ods as $llave => $datos){
				$tpl->newBlock("fstat_det");
				$tpl->assign("code",$datos);
				$tpl->assign("valor",$array_status[$datos]);
				if($datos=="APB"){
					$tpl->assign("selected",$selected);
				}
			}
		}
		$tipo=$data_class->list_();
		foreach ($tipo["content"] as $key => $value) {
			$tpl->newBlock("tipo_det");
			foreach ($tipo["content"][$key] as $key1 => $value1){
				$tpl->assign($key1,$value1);
			}
		}
		$array_temp = array('APB');
		$data=$data_class->list_all($array_temp);
		if($data["title"]=="SUCCESS"){
			foreach ($data["content"] as $llave => $datos) {
				$tpl->newBlock("data");
				$id=$datos['codigo'];
				$cadena_acciones='
				<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light menu" data-toggle="tooltip" data-placement="top" title="DETALLES" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="CRUD_ODS_SUB" data-subref="'.$var_array_nav["subref"].'" data-acc="MODULO" data-id="'.$id.'"><i class="fas fa-arrow-right"></i></button>
				';
				foreach ($data["content"][$llave] as $key => $value){
					$value = ($key=="code") ? formatRut($value) : $value ;
					$tpl->assign($key,$value);
				}
				$tpl->assign("actions",$cadena_acciones);
				$detalles=$data_class->list_sub($datos['codigo'],$array_ods);
				$sub_status = "";
				$contador = 0;
				$class = "";
				if($detalles["title"]=="SUCCESS"){
					foreach ($detalles["content"] as $llave1 => $datos1) {
						$contador++;
						$gar = ($datos1["ctipo"]==5) ? " (GARANTIA)" : "" ;
						$class = ($datos1["ctipo"]==5) ? "table-warning" : $class ;
						$sub_status .= $datos1["correlativo"].": ".$array_status[$datos1["status"]].$gar."<br>";
					}

				}
				$tpl->assign("cuentas",$contador);
				$tpl->assign("sub_status",$sub_status);
				$tpl->assign("class",$class);
			}			
		}
	}
}
?>