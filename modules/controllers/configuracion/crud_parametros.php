<?php
$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
if($perm_val["title"]<>"SUCCESS"){
	alerta("NO POSEES PERMISO PARA ESTE MODULO","ERROR");
}else{
	include_once("./class/class.parameter.php");
	$data_class = new parametros;
	$modulo = $perm->get_module($_GET['submod']);
	if(Evaluate_Mod($modulo)){
		$tpl->newBlock("module");
		foreach ($modulo["content"] as $key => $value){
			//VARIABLES PARA NAVEGAR
			$var_array_nav=array();
			$var_array_nav["mod"]=$_GET['mod'];
			$var_array_nav["submod"]=$_GET['submod'];
			$var_array_nav["ref"]="FORM_PARAMETRO";
			$var_array_nav["subref"]="NONE";
			foreach ($var_array_nav as $key_ => $value_) {
				$tpl->assign($key_,$value_);
			}

			//VARIABLES VISUALES
			$tpl->assign("menu_pri",$value['menu']);
			$tpl->assign("menu_sec",$value['modulo']);
			$tpl->assign("menu_ter","NONE");
			$tpl->assign("menu_name",$value['modulo']);
		}
		$data=$data_class->list_();
		if($data["title"]=="SUCCESS"){
			foreach ($data["content"] as $llave => $datos) {
				$tpl->newBlock("data");
				$id=$datos['codigo'];				
				$cadena_acciones='
				<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light menu" data-toggle="tooltip" data-placement="top" title="VER" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref"].'" data-subref="'.$var_array_nav["subref"].'" data-acc="EDIT" data-id="'.$id.'"><i class="fas fa-search"></i></button>
				';
				$boton_1 ='<button class="btn btn-outline-secondary waves-effect waves-light" data-acc="DWN_1" type="button"><span class="btn-label"><i class="fas fa-download"></i></span> BAJAR DEMO</button>';
				$tpl->assign("actions",$cadena_acciones);
				$tpl->assign("codigo",$data["content"][$llave]["codigo"]);
				$tpl->assign("parametro",$data["content"][$llave]["parametro"]);
				$campos = array(5,6,10);
				$valor = (in_array($data["content"][$llave]["codigo"],$campos)) ? numeros($data["content"][$llave]["valor"]) : $data["content"][$llave]["valor"] ;
				$valor = ($data["content"][$llave]["codigo"]==23) ? $boton_1 : $valor ;
				$tpl->assign("valor",$valor);
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