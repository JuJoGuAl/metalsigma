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
			$var_array_nav["ref"]="FORM_PAR_ARR";
			$var_array_nav["subref"]="NONE";
			foreach ($var_array_nav as $key_ => $value_) {
				$tpl->assign($key_,$value_);
			}

			//VARIABLES VISUALES
			$tpl->assign("menu_pri",$value['menu']);
			$tpl->assign("menu_sec",$value['submenu']);
			$tpl->assign("menu_ter",$value['modulo']);
			$tpl->assign("menu_name","COSTOS");
			$tpl->assign("mod_name","ARRIENDO DEL TALLER SEGUN SEGMENTO");
		}
		$data=$data_class->list_a();
		$par=$parametros->list_all();
		$arriendot=$par["content"][5]["valor"];
		$naves=$par["content"][6]["valor"];
		$factor=$par["content"][7]["valor"];
		$costo_mes_nave=(($arriendot/$naves)*100)/$factor;
		$costo_dia_nave=$costo_mes_nave/30;
		if(Evaluate_Mod($data)){
			foreach ($data["content"] as $llave => $datos) {
				$tpl->newBlock("data");
				$id=$datos['codigo'];
				$costo_uf=$costo_dia_nave*$datos['espacio'];
				$valor_uf_dia=(($costo_uf*$datos['mar_uf'])/100)+$costo_uf;
				$cadena_acciones='
				<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light menu" data-toggle="tooltip" data-placement="top" title="VER" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref"].'" data-subref="'.$var_array_nav["subref"].'" data-acc="EDIT" data-id="'.$id.'"><i class="fas fa-search"></i></button>
				';
				foreach ($data["content"][$llave] as $key => $value){
					$tpl->assign($key,$value);
					$tpl->assign("costouf",numeros($costo_uf,2));
					$tpl->assign("valor_uf",numeros($valor_uf_dia,2));
					$tpl->assign("actions",$cadena_acciones);
				}
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