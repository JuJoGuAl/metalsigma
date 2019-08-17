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
			$tpl->assign("menu_name","PLANIFICACIONES");

			$tpl->assign("fecha",date("d-m-Y"));
			$avance = $cotizaciones->list_sub(false,$array_cot_ods);
			if($avance["title"]=="SUCCESS"){
				foreach ($avance["content"] as $key => $value) {
					$tpl->newBlock("avance");
					foreach ($avance["content"][$key] as $key1 => $value1){
						$value1 = ($key1=="avance" || $key1=="adic" || $key1=="ocupado" || $key1=="horas") ? numeros($value1,2) : $value1 ;
						$tpl->assign($key1,$value1);
					}
					$trabajos_ = $cotizaciones->get_sub($avance["content"][$key]["codigo"]);
					if($trabajos_["title"]=="SUCCESS"){
						$cab=$trabajos_["cab"];
						$det=$trabajos_["det"];
						$art=$trabajos_["art"];
						if(!empty($det)){
							foreach ($det as $key3 => $value3){
								$tpl->newBlock("trabajos");
								$tpl->assign("tarea",$det[$key3]["articulo"]);
							}
						}
					}
				}
			}
			
			// $fecha = date("Y-m-d");
			// $fecha = "2019-05-16";
			// $data = $data_class->list_ocupa_plan("nt.ctrabajador",$fecha,$fecha,$array_car_emp);
			// if($data["title"]=="SUCCESS"){
			// 	$prom = 0;
			// 	foreach ($data["content"] as $key => $value) {
			// 		$tpl->newBlock("data");
			// 		$prom = $prom + $data["content"][$key]["ocupa"];
			// 		$tpl->assign("trabajador",$data["content"][$key]["data"]);
			// 		$tpl->assign("cargo",$data["content"][$key]["cargo"]);
			// 		$tpl->assign("ocupa",$data["content"][$key]["ocupa"]);
			// 		$tpl->assign("ocupa%",numeros($data["content"][$key]["ocupa"],2));
			// 	}
			// 	$prom = $prom / count($data["content"]);
			// 	$tpl->newBlock("prom");
			// 	$tpl->assign("ocupa_prom",$prom);
			// 	$tpl->assign("ocupa%_prom",numeros($prom,2));
			// }
			/*$data = $data_class->list_ocupa_plan("nt.ctrabajador",$fecha,$fecha,$array_car_emp);
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value) {
					$tpl->newBlock("trabajos");
					$tpl->assign("trabajador",$data["content"][$key]["data"]);
					$tpl->assign("cargo",$data["content"][$key]["cargo"]);
					$planes = $data_class->get_plan_worker($data["content"][$key]["codigo_trabajador"],false,false,$fecha);
					if($planes["title"]=="SUCCESS"){
						foreach ($planes["content"] as $key => $value){
							$minutes2	=	(12 * 60.0 + 0 * 1.0);
							$time2		=	explode(':', $planes["content"][$key]["inicio"]);
							$minutes1	=	($time2[0] * 60.0 + $time2[1] * 1.0);
							$dif_hora	=	($minutes2 - $minutes1);
							$bloque = ($dif_hora>0) ? "man" : "tar" ;
							$tpl->newBlock("trabajos_det_".$bloque);
							foreach ($planes["content"][$key] as $key1 => $value1){
								$tpl->assign($key1,$value1);
							}
							$trabajos = $cotizaciones->get_sub($planes["content"][$key]["cordenservicio_sub"]);
							if($trabajos["title"]=="SUCCESS"){
								$cab=$trabajos["cab"];
								$det=$trabajos["det"];
								$art=$trabajos["art"];
								if(!empty($det)){
									foreach ($det as $key2 => $value2){
										$tpl->newBlock("listados_".$bloque);
										$tpl->assign("tarea",$det[$key2]["articulo"]);
									}
								}
							}
						}
					}
				}
			}*/
		}
	}
}
?>