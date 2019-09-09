<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
if($perm_val["title"]<>"SUCCESS"){
	alerta("NO POSEES PERMISO PARA ESTE MODULO","ERROR");
}else{
	include_once("./class/class.cotizaciones.php");
	include_once("./class/class.par_admin.php");
	include_once("./class/class.clientes.php");
	include_once("./class/class.compras.php");
	$data_class = new cotizaciones;
	$param = new paradm;
	$clientes = new clientes;
	$compras = new compras();
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
			$tpl->assign("menu_name","PRE VISUALIZACION ODS");
			$tpl->assign("form_title","COTIZACION: ");
			$tpl->assign("form_title2","ODS: ");
			$tpl->assign("form_title3","FAC: ");
		}
		if($action=="edit"){
			$tpl->assign("accion",'save_edit');
			$tpl->assign("id",$_GET["id"],true);
			$cotiza=$data_class->get_sub($_GET["id"],true);
			//print_r($cotiza);
			$cab=$cotiza["cab"];
			$cab_cli=$cotiza["datos"];
			$det=$cotiza["det"];
			$art=$cotiza["art"];
			$cots=$cotiza["cot"];
			$style = ($cab["clugar"]=="0000000001") ? 'style="display:none;"' : '' ;
			$codigo_origen=$cab["origen"];
			$tpl->assign("id_tittle",$cab["cot_full"]);
			$tpl->assign("id_tittle2",$cab["ods_full"]);
			$tpl->assign("id_tittle3",$cab["cfactura"]);
			$tpl->assign("status_color",color_status($cab['status'],"badge"));
			$tpl->assign("hide",$style);
			$style1 = ($cab["cot_gar_full"]=="N/A") ? 'style="display:none;"' : '' ;
			$tpl->assign("hide1",$style1);
			$csegmento=$cab_cli["csegmento"];
			$csegmento2 = ($cab["parte"]==0) ? 6 : $csegmento ;
			$cpago=$cab_cli["cpago"];
			$cequipo=$cab["cequipo"];
			$cvehiculo=$cab["cvehiculo"];
			foreach ($cab_cli as $key => $value){
				$value = ($key=="code") ? formatRut($value) : $value ;
				$tpl->assign($key,$value);
			}
			foreach ($cab as $key => $value){
				$value = (in_array($key, $array_numbers)) ? numeros($value,0)." $" : $value ;
				$tpl->assign($key,$value);
				$tpl->assign($key."_",$value);
			}
			$garantia = ($cab["cot_gar_full"]!="N/A") ? "COT: ".$cab["cot_full_gar"]." ODS: ".$cab["ods_full_gar"] : "" ;
			$tpl->assign("ods_gar_full",$garantia);
			if(!empty($array_status)){
				foreach ($array_status as $llave => $datos){
					if($llave==$cab["status"]){
						$tpl->assign("stats_code",$llave);
						$tpl->assign("stats_nom",$datos);
					}
				}
			}
			if(!empty($array_opcion)){
				foreach ($array_opcion as $llave => $datos){
					if($llave==$cab["parte"]){
						$tpl->assign("coteq",$datos);
					}
				}
			}
			
			if(!empty($det)){
				foreach ($det as $key => $value) {
					$tpl->newBlock("co_det");
					$parte = 		$value["parte"];
					$pieza = 		$value["pieza"];
					$articulo = 	$value["articulo"];
					$hh_taller =	'<input name="hhtaller[]" id="hhtaller[]" type="hidden" class="ctrl sum_hh_ta" value="'.$value["hh_taller"].'">'.$value["hh_taller"];
					$hh_terreno =	'<input name="hhterreno[]" id="hhterreno[]" type="hidden" class="ctrl sum_hh_te" value="'.$value["hh_terreno"].'">'.$value["hh_terreno"];
					$dias_taller =	'<input name="dtaller[]" id="dtaller[]" type="hidden" class="sum_dtaller" value="'.$value["dias_taller"].'">'.$value["dias_taller"];
					$finicio = 		'<input name="inicio[]" id="inicio[]" type="hidden" value="'.setDate($value["finicio"],"d-m-Y").'">'.setDate($value["finicio"],"d-m-Y");
					$ffin = 		'<input name="fin[]" id="fin[]" type="hidden" value="'.setDate($value["ffin"],"d-m-Y").'">'.setDate($value["ffin"],"d-m-Y");
					$tpl->assign("count",($key+1));
					$tpl->assign("parte",$parte);
					$tpl->assign("pieza",$pieza);
					$tpl->assign("articulo",$articulo);
					$tpl->assign("hh_taller",$hh_taller);
					$tpl->assign("hh_terreno",$hh_terreno);
					$tpl->assign("dias_taller",$dias_taller);
					$tpl->assign("finicio",$finicio);
					$tpl->assign("ffin",$ffin);
				}
			}
			if(!empty($art)){
				foreach ($art as $key => $value) {
					$tpl->newBlock("articulos");
					foreach ($value as $key1 => $value1) {
						$tpl->assign($key1,$value1);
					}
				}
			}
			if(!empty($cots)){
				$ccot_com[]=array();
				foreach ($cots as $key => $value) {
					$ccot_com[$key]=$value["codigo"];
				}
				$data_seg=$clientes->get_s($csegmento);
				$detalles=$compras->get_cot_det_array($ccot_com);
				if($detalles["title"]=="SUCCESS"){
					foreach ($detalles["content"] as $key => $value) {
						$costo = $detalles["content"][$key]["costou"];
						$precio = (($data_seg["content"]["mar_stt"]*$costo)/100)+$costo;

						$tpl->newBlock("articulos");

						$tpl->assign("codigo",$detalles["content"][$key]["codigo_art"]);
						$tpl->assign("codigo2",$detalles["content"][$key]["codigo2"]);
						$tpl->assign("articulo",$detalles["content"][$key]["articulo"]);
						$tpl->assign("cant",$detalles["content"][$key]["cant"]);
						$tpl->assign("precio",$precio);
						$tpl->assign("clasificacion","SERVICIOS TERCERIZADOS");
					}
				}
			}
			$data_mo=$param->list_vh($csegmento,$cequipo);
			$data_eq=$param->get_e($cequipo);
			$data_ar=$param->list_a($csegmento2);
			$data_VE=$param->get_v($cvehiculo);
			//CALCULO COSTO ARRIENDO DIARIO
			$arriendot=constant("ARRIENDO TALLER (EN UF)");
			$naves=constant("N° NAVES");
			$factor=constant("FACTOR DE UTILIZACION (%)");
			$uf=constant("VALOR UF");
			$costo_mes_nave=(($arriendot/$naves)*100)/$factor;
			$costo_dia_nave=$costo_mes_nave/30;
			$espacio=$data_ar["content"][0]["espacio"];
			$mar_uf=$data_ar["content"][0]["mar_uf"];
			$costo_uf=$costo_dia_nave*$espacio;
			$valor_uf_dia=(($costo_uf*$mar_uf)/100)+$costo_uf;
			$valor_peso_dia=$valor_uf_dia*$uf;
			$data_cli=$clientes->get_pag($cpago);
			$data_seg=$clientes->get_s($csegmento);
			if($cab["status"]!="PEN"){
				$tpl->newBlock("val");
			}
		}
	}
}
?>