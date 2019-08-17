<?php
$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
if($perm_val["title"]<>"SUCCESS"){
	alerta("NO POSEES PERMISO PARA ESTE MODULO","ERROR");
}else{
	include_once("./class/class.clientes.php");
	$data_class = new clientes;
	$modulo = $perm->get_module($_GET['submod']);
	if(Evaluate_Mod($modulo)){
		$tpl->newBlock("module");
		foreach ($modulo["content"] as $key => $value){
			//VARIABLES PARA NAVEGAR
			$var_array_nav=array();
			$var_array_nav["mod"]=$_GET['mod'];
			$var_array_nav["submod"]=$_GET['submod'];
			$var_array_nav["ref"]="FORM_MORAS";
			$var_array_nav["subref"]="NONE";
			foreach ($var_array_nav as $key_ => $value_) {
				$tpl->assign($key_,$value_);
			}

			//VARIABLES VISUALES
			$tpl->assign("menu_pri",$value['menu']);
			$tpl->assign("menu_sec",$value['submenu']);
			$tpl->assign("menu_ter",$value['modulo']);
			$tpl->assign("menu_name","MORAS");
			$tpl->assign("mod_name","MORAS");				
		}
		$data=$data_class->list_mor();
		if(Evaluate_Mod($data)){
			foreach ($data["content"] as $llave => $datos) {
				$margen=0;
				$gasto = ($llave==0 || $llave==2) ? $datos["valor"] : $gasto ;
				$margen = ($llave==1 || $llave==3) ? $datos["valor"] : $margen ;
				if($llave==1 || $llave==3){
					$tpl->newBlock("data");
					$id=$datos['codigo'];
					$cadena_acciones='<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light menu" data-menu="'.$_GET['mod'].'" data-mod="'.$_GET['submod'].'" data-ref="FORM_MORAS" data-acc="EDIT" data-id="'.$id.'"><i class="fa fa-edit"></i></button>';
					$mora = ($llave==1) ? "MORA OC" : "MORA PAGO" ;
					$tpl->assign("mora",$mora);
					$tpl->assign("gasto",numeros($gasto,2));
					$tpl->assign("margen",numeros($margen,2));
					$tpl->assign("actions",$cadena_acciones);
				}
			}			
		}
	}
}
?>