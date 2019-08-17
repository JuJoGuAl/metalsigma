<?php
$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
if($perm_val["title"]<>"SUCCESS"){
	alerta("NO POSEES PERMISO PARA ESTE MODULO","ERROR");
}else{
	include_once("./class/class.par_admin.php");
	include_once("./class/class.parameter.php");
	$data_class = new paradm;
	$parametros = new parametros();
	$modulo = $perm->get_module($_GET['submod']);
	if(Evaluate_Mod($modulo)){
		$tpl->newBlock("module");
		foreach ($modulo["content"] as $key => $value){
			//VARIABLES PARA NAVEGAR
			$var_array_nav=array();
			$var_array_nav["mod"]=$_GET['mod'];
			$var_array_nav["submod"]=$_GET['submod'];
			$var_array_nav["ref"]="FORM_PAR_HHTT";
			$var_array_nav["subref"]="NONE";
			foreach ($var_array_nav as $key_ => $value_) {
				$tpl->assign($key_,$value_);
			}

			//VARIABLES VISUALES
			$tpl->assign("menu_pri",$value['menu']);
			$tpl->assign("menu_sec",$value['submenu']);
			$tpl->assign("menu_ter",$value['modulo']);
			$tpl->assign("menu_name","COSTOS");
			$tpl->assign("mod_name","VALOR HORA HOMBRE");
		}
		$data=$data_class->list_();
		$par=$parametros->get_(9); //COSTO ADIC HORA EXTRA
		if(Evaluate_Mod($data)){
			foreach ($data["content"] as $llave => $datos) {
				$tpl->newBlock("data");
				$id=$datos['codigo'];
				$costo_hh_normal=$datos['costo_hh_normal'];
					$costo_hh_extra=(($costo_hh_normal*$par['content']["valor"])/100)+$costo_hh_normal;
					$margen_hh_normal=$datos['mar_normal'];
					$margen_hh_extra=$datos['mar_extra'];
					$valor_hh_normal=(($costo_hh_normal*$margen_hh_normal)/100)+$costo_hh_normal;
					$valor_hh_extra=(($costo_hh_extra*$margen_hh_extra)/100)+$costo_hh_normal;
				$cadena_acciones='
				<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light menu" data-toggle="tooltip" data-placement="top" title="VER" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref"].'" data-subref="'.$var_array_nav["subref"].'" data-acc="EDIT" data-id="'.$id.'"><i class="fas fa-search"></i></button>
				';
				foreach ($data["content"][$llave] as $key => $value){
					$tpl->assign($key,$value);
				}
				$tpl->assign("valor_normal",numeros($valor_hh_normal));
				$tpl->assign("valor_extra",numeros($valor_hh_extra));
				$tpl->assign("actions",$cadena_acciones);
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