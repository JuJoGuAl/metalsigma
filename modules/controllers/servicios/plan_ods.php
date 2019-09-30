<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
if($perm_val["title"]<>"SUCCESS"){
	alerta("NO POSEES PERMISO PARA ESTE MODULO","ERROR");
}else{
	include_once("./class/functions.php");
	include_once("./class/class.cotizaciones.php");
	include_once("./class/class.planificacion.php");
	$data_class = new cotizaciones;
	$planificaciones = new planificaciones;
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
			$tpl->assign("menu_name","PLANIFICACION DE ODS");
			$tpl->assign("mod_name","ORDENES DE SERVICIO");
		}
		$colacion		=	constant("DUR_COL");
		$inicio			=	constant("H_INI");
		$fin			=	constant("H_FIN");
		$dias_pasado	=	constant("DIAS_PAST");

		$tpl->assign("inicio",$inicio.":00");
		$tpl->assign("fin",$fin.":00");
		$tpl->assign("fecha_past",setDate(date("d-m-Y"),"d-m-Y H:i","-P".$dias_pasado."D"));
		$tpl->assign("fin_cola",setDate($fin,"H:i","PT".setDate("00:".$colacion,"i")."M"));

		$data=$data_class->list_all($array_cot_fac,"DISTINCT((d.code)) AS code");
		if($data["title"]=="SUCCESS"){
			$tpl->assign("clientes",sizeof($data["content"]));
		}
		$data1=$data_class->list_sub(false,$array_cot_fac);
		if($data1["title"]=="SUCCESS"){
			$tpl->assign("ods",sizeof($data1["content"]));
		}
		$data1=$planificaciones->list_group();
		if($data1["title"]=="SUCCESS"){
			$tpl->assign("plan",$data1["content"][0]["cuenta"]);
		}
		$trab_color=array();
		$colores=array();

		$data_=$data_class->list_sub(false,$array_ods);
		if($data_["title"]=="SUCCESS"){
			foreach ($data_["content"] as $key => $value){
				$color_new="";
				if (!array_key_exists($value["ods_full"], $trab_color)) {
					if(empty($colores)){
						$colores=array("primary","warning","info","danger","success","secondary");
					}
					$color_new=array_rand($colores,1);
					$trab_color[$value["ods_full"]]=$colores[$color_new];
					unset($colores[$color_new]);
				}
			}
		}
		$data4=$data_class->list_sub(false,$array_cot_ods,">= 0",false,false,false,false,false,false,"co.mod_date DESC");
		//print_r($data4);
		if($data4["title"]=="SUCCESS"){
			foreach ($data4["content"] as $key => $value){
				$tpl->newBlock("ods");
				foreach ($data4["content"][$key] as $key1 => $value1){
					$tpl->assign($key1,$value1);
				}
				$clas_ = ($data4["content"][$key]["ctipo"]==5) ? "bg-warning" : "" ;
				$tpl->assign("bg",$clas_);
				$clas2_ = ($data4["content"][$key]["ctipo"]==5) ? "" : "text-success" ;
				$tpl->assign("text",$clas2_);
				$tpl->assign("color",$trab_color[$data4["content"][$key]["ods_full"]]);
			}
		}

		$data2=$planificaciones->list_t();
		if($data2["title"]=="SUCCESS"){
			foreach ($data2["content"] as $key => $value){
				$tpl->newBlock("events");
				$tpl->assign("id","id: '".$value["codigo_cabecera"]."'");
				$tpl->assign("title","title: 'ODS: #".$value["codigo_ods"]."'");
				$tpl->assign("ods","ods: 'ODS: #".$value["codigo_ods"]."'");
				$tpl->assign("status","status: '".$value["status"]."'");
				$tpl->assign("transporte","transporte: '".$value["transporte"]."'");
				$tpl->assign("start","start: '".$value["finicio"]."'");
				$tpl->assign("end","end: '".$value["ffin"]."'");
				$tpl->assign("end","end: '".$value["ffin"]."'");
				$color_plan = (!array_key_exists($value["codigo_ods"], $trab_color)) ? "dark" : $trab_color[$value["codigo_ods"]] ;
				$tpl->assign("color","className: 'bg-".$color_plan."'");
				$data3=$planificaciones->list_dets($value["codigo_cabecera"]);
				if($data3["title"]=="SUCCESS"){
					foreach ($data3["content"] as $key1 => $value1){
						$code = $key1+1;
						$tpl->newBlock("trabs");
						$tpl->assign("trabajador","trabajador_".$code.": '".$value1["data"]."'");
						$tpl->assign("cargo","cargo_".$code.": '".$value1["cargo"]."'");
					}
				}
			}
		}		
	}
}
?>