<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new" || $action=="save_edit" || $action=="del"){
	include_once("../../../class/functions.php");
	include_once("../../../class/class.planificacion.php");
	include_once("../../../class/class.cotizaciones.php");
	include_once("../../../class/class.parameter.php");
	$data_class = new planificaciones;
	$cotizaciones = new cotizaciones();
	$parametros = new parametros();
	session_start();
	$response=array();
	if(isset($_SESSION["metalsigma_log"])){
		$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
		if($perm_val["title"]<>"SUCCESS"){
			$response['title']="ERROR";
			$response["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA EL MODULO</strong>";
		}else{
			$ins=$perm_val["content"][0]["ins"];
			$upt=$perm_val["content"][0]["upt"];
			extract($_GET, EXTR_PREFIX_ALL, "");
			if($action=="del"){
				$resultado=$data_class->delete_($_id);

				$mensaje="PLANIFICACION ELIMINADA";
				if($resultado["title"]=="SUCCESS"){
					$response['title']=$resultado["title"];
					$response["content"]=$mensaje;
				}else{
					$response['title']=$resultado["title"];
					$response["content"]=$resultado["content"];
				}
				// echo json_encode($response);
				// exit;
			}else{
				$datos = $trabajadores = array();

				$ini=setDate($_f_trab)." ".$_hora_ini.":00";
				$fin=setDate($_f_trab)." ".$_hora_fin.":00";
				$to_time = strtotime($ini);
				$from_time = strtotime($fin);
				$time_plan = round((abs($to_time - $from_time)/60)/60,2);
				$plan = ($_id==0) ? false : $_id ;
				$horas_restantes = $colacion = $trabs_plan = $trabs_cot = 0;

				$data = $cotizaciones->get_sub($_ods,true);
				if($data["cab"]["status"]!="PRO"){
					$response["title"]="ERROR";
					$response["content"]="LA PLANIFICACION AFECTA A UNA COTIZACION QUE NO PUEDE SER PLANIFICADA!";
				}else{
					//TOMO LAS HORAS QUE QUEDAN Y LO MULTIPLICO POR LA CANT DE TRABS DE LA COTIZACION (PARA OBTENER LA HORA HOMBRE)
					//$horas_restantes = ($data["title"]=="SUCCESS") ? ($data["cab"]["restante"]*$data["cab"]["trabs"])*1 : 0 ;
					$horas_restantes = ($data["title"]=="SUCCESS") ? $data["cab"]["restante"]*1 : 0 ;
					//SI ESTOY EDITANDO LAS HORAS RESTANTES SON SIN LA PLANIFICACION ACTUAL
					if($action=="save_edit"){
						$data1=$data_class->get_plan($_id);
						$horas_restantes = $horas_restantes + $data1["cab"]["duracion"];
					}
					$trabs_cot = ($data["title"]=="SUCCESS") ? $data["cab"]["trabs"]*1 : 0 ;
					$lugar = $data["cab"]["clugar"];
					$col_data = $parametros->get_(20);
					$colacion = ($col_data["title"]=="SUCCESS") ? ($col_data["content"]["valor"])/60 : 0 ;
					//VERIFICO SI EL HORARIO ELEGIDO ESTA EN RANGO COLACION
					if( (setDate($_hora_ini, "H:i") < "15:00") && (setDate($_hora_fin, "H:i") > "12:00")){
						//DE SER ASI LE RESTO LA COLACION A LA PLANIFICACION
						$time_plan = $time_plan - $colacion;
					}
					if($_ctrab1>0){
						if($_ctrab2>0){
							$trabs_plan = 2;
						}else{
							$trabs_plan = 1;
						}
					}
					//SI LA PLANIFICACION ES MAYOR A LA DISPONIBLE REBOTO
					if((($time_plan*$trabs_plan)>($horas_restantes*$trabs_cot)) && $horas_restantes>0){
						$response["title"]="ERROR";
						$response["content"]="LA CANTIDAD DE HORAS ASIGNADAS (<strong>".$time_plan."</strong>) SUPERA LAS HORAS DISPONIBLES (<strong>".$horas_restantes."</strong>)";
					}else{
						//BUSCO SI EL TRAB 1 ESTA DISPONIBLE
						$data=$data_class->get_plan_worker($_ctrab1,$ini,$plan);
						if($data["title"]=="WARNING"){
							//SI TRAB 2 ESTA SETEADO LO BUSCO DE LO CONTRARIO DEJO PASAR
							if($_GET['ctrab2']!=""){ $data=$data_class->get_plan_worker($_ctrab2,$ini,$plan); }
							else{ $data["title"]="WARNING"; }
							//VERIFICO SI VEHICULO ESTA LIBRE
							if($data["title"]=="WARNING"){
								if($lugar==2){ $data=$data_class->get_plan_vehic($_ods,$ini,$plan); }
								else{ $data["title"]="WARNING"; }
								if($data["title"]=="WARNING"){
									array_push($datos, $_ods);
									array_push($datos, $ini);
									array_push($datos, $fin);
									
									if($_GET['ctrab1']!=""){ array_push($trabajadores, $_ctrab1); }
									if($_GET['ctrab2']!=""){ array_push($trabajadores, $_ctrab2); }
	
									$horas_adic = ($horas_restantes<=0) ? 1 : 0 ;
									array_push($datos, $horas_adic);
									array_push($datos, $_notas);
									
									if($action=="save_edit"){
										if($upt!=1){
											$response['title']="ERROR";
											$response["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
										}else{
											$resultado=$data_class->edit_($_id,$datos,$trabajadores);
										}
									}else{
										if($ins!=1){
											$response['title']="ERROR";
											$response["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
										}else{
											//$data=$cotizaciones->get_sub($_ods);
											//$horas_adic = ($horas_restantes<=0) ? 1 : 0 ;
											//array_push($datos, $horas_adic);
											$resultado=$data_class->new_($datos,$trabajadores);
										}
									}
									$mensaje = ($action=="save_new") ? "ODS PLANIFICADA!" : "PLANIFICACION ACTUALIZADA!" ;
									if($resultado["title"]=="SUCCESS"){
										$response['title']=$resultado["title"];
										$response["content"]=$mensaje;
									}else{
										$response['title']=$resultado["title"];
										$response["content"]=$resultado["content"];
									}
	
								}else{
									$response["title"]="ERROR";
									$response["content"]="EL VEHICULO <strong>".$data["content"][0]["vehiculo"]."</strong> YA POSEE ACTIVIDADES PARA EL DIA / HORA SELECCIONADOS";	
								}
							}elseif($data["title"]=="SUCCESS"){
								$response["title"]="ERROR";
								$response["content"]="EL TRABAJADOR 2 <strong>".$data["content"][0]["data"]."</strong> YA POSEE ACTIVIDADES PARA EL DIA / HORA SELECCIONADOS";
							}else{
								$response["title"]="ERROR";
								$response["content"]=$data["content"];
							}
						}elseif($data["title"]=="SUCCESS"){
							$response["title"]="ERROR";
							$response["content"]="EL TRABAJADOR <strong>".$data["content"][0]["data"]."</strong> YA POSEE ACTIVIDADES PARA EL DIA / HORA SELECCIONADOS";
						}else{
							$response["title"]="ERROR";
							$response["content"]=$data["content"];
						}
					}
				}
			}			
		}
	}else{
		$response['title']="INFO";
		$response["content"]=-1;
	}
	echo json_encode($response);
}else{
	$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
	if($perm_val["title"]<>"SUCCESS"){
		alerta("NO POSEES PERMISO PARA ESTE MODULO","ERROR");
	}else{
		include_once("./class/class.cotizaciones.php");
		include_once("./class/class.planificacion.php");
		$data_class = new cotizaciones();
		$planificacion = new planificaciones();
		$modulo = $perm->get_module($_GET['submod']);
		if(Evaluate_Mod($modulo)){
			$tpl->newBlock("module");
			foreach ($modulo["content"] as $key => $value){
				//VARIABLES PARA NAVEGAR
				$var_array_nav=array();
				$var_array_nav["mod"]=$_GET['mod'];
				$var_array_nav["submod"]=$_GET['submod'];
				$var_array_nav["ref"]="PLAN_ODS_FORM";
				$var_array_nav["subref"]="NONE";

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter","NONE");
				$tpl->assign("menu_name","PLANIFICACION DE ODS");
			}
			$param=$parametros->list_all();
			$colacion		=	$param["content"][16]["valor"];
			$inicio			=	$param["content"][17]["valor"];
			$fin			=	$param["content"][18]["valor"];
			$dias_pasado	=	$param["content"][20]["valor"];
			$tpl->assign("fecha_past",setDate(date("d-m-Y"),"d-m-Y H:i","-P".$dias_pasado."D"));

			$tpl->assign("colacion",$colacion);
			if($action=="new"){
				$tpl->assign("accion",'save_new');
				$tpl->assign("id",0);
				$variables = explode(",", $_GET["id"]);

				$hini = ($variables[1]==0) ? $inicio : $variables[1] ;
				$hfin = ($variables[2]==0) ? "" : $variables[2] ;
				$hocu = 0;

				if($variables[3]>0){
					$data=$data_class->get_sub($variables[3],true);
					if($data["title"]=="SUCCESS"){
						$tpl->assign("nombre",$data["cab"]["data"]);
						$tpl->assign("ods_name",$data["cab"]["ods_full"]);
						$tpl->assign("rut",$data["cab"]["code"]);
						$tpl->assign("fllegada",$data["cab"]["llegada"]);
						$tpl->assign("fsalida",$data["cab"]["retiro"]);
						$tpl->assign("hr_total",$data["cab"]["horas"]);
						$tpl->assign("hr_ocupa",$data["cab"]["ocupado"]);
						$tpl->assign("hr_restant",$data["cab"]["restante"]);
						$tpl->assign("cliente",$data["cab"]["codigo_cliente"]);
						$tpl->assign("ods",$data["cab"]["codigo"]);
						$tpl->assign("trabs",$data["cab"]["trabs"]);
						$tpl->assign("lugar",$data["cab"]["lugar"]);
						$tpl->assign("vehiculo",$data["cab"]["transporte"]);
					}
				}							

				$time1		=	explode(':', $inicio);
				$minutes1	=	($time1[0] * 60.0 + $time1[1] * 1.0);
				$time2		=	explode(':', $fin);
				$minutes2	=	($time2[0] * 60.0 + $time2[1] * 1.0);
				$dif_hora	=	($minutes2 - $minutes1)/60;

				if($variables[3]>0){
					if($dif_hora>$data["cab"]["restante"]){
						$date = new DateTime($hini);
						$minutos = $data["cab"]["restante"]*60;
						$date->modify('+'.$minutos.' minute');
						$hfin = $date->format('H:i');

						//VERIFICO SI EL HORARIO ELEGIDO ESTA EN RANGO COLACION, SI LO ES LE SUMO LA COLACION
						if( (setDate($hini, "H:i") < "15:00") && (setDate($hfin, "H:i") > "12:00")){
							$date = new DateTime($hfin);
							$date->modify('+'.$colacion.' minute');
							$hfin = $date->format('H:i');
						}
					}else{
						$hfin = $fin;
					}					
					$time1		=	explode(':', $hini);
					$minutes1	=	($time1[0] * 60.0 + $time1[1] * 1.0);
					$time2		=	explode(':', $hfin);
					$minutes2	=	($time2[0] * 60.0 + $time2[1] * 1.0);
					$hocu		=	($minutes2 - $minutes1)/60;
				}
				$tpl->assign("hoy",$variables[0]);
				$tpl->assign("hini",$hini);
				$tpl->assign("hfin",$hfin);
				$tpl->assign("hocu",$hocu);

				$ins=$perm_val["content"][0]["ins"];
				if($ins==1){
					$tpl->newBlock("data_save");
					foreach ($var_array_nav as $key_ => $value_) {
						$tpl->assign($key_,$value_);
					}
				}else{ $tpl->assign("read",'readonly'); }

			}else if($action=="edit"){
				$tpl->assign("accion",'save_edit');
				$tpl->assign("id",$_GET["id"]);
				$data=$planificacion->get_plan($_GET['id']);
				if(Evaluate_Mod($data)){
					$cab=$data["cab"];
					$date1 = new DateTime(setDate($cab["finicio"],"Y-m-d"));
					$date2 = new DateTime(date("Y-m-d"));
					$interval = $date2->diff($date1);
					if($interval->invert==1 && $interval->days>$dias_pasado){
						echo '<script>GetModule("SERVICIOS","PLAN_ODS","NONE","NONE","CLOSE",0); dialog("NO SE PUEDE EDITAR UNA PLANIFICACION DEL PASADO","ERROR");</script>';
						exit;
					}

					$time1		=	explode(':', setDate($cab["finicio"],"H:i"));
					$minutes1	=	($time1[0] * 60.0 + $time1[1] * 1.0);
					$time2		=	explode(':', setDate($cab["ffin"],"H:i"));
					$minutes2	=	($time2[0] * 60.0 + $time2[1] * 1.0);
					$hocu		=	($minutes2 - $minutes1)/60;

					$tpl->assign("hoy",setDate($cab["finicio"],"d-m-Y"));
					$tpl->assign("hini",setDate($cab["finicio"],"H:i"));
					$tpl->assign("hfin",setDate($cab["ffin"],"H:i"));
					$tpl->assign("hocu",$hocu);
					$tpl->assign("notas",$cab["notas"]);
					if(!empty($data["det"])){
						foreach ($data["det"] as $key => $value) {
							$code = $key+1;
							$tpl->assign("trab".$code,$value["data"]);
							$tpl->assign("ctrab".$code,$value["codigo_trabajador"]);
						}
					}
					$data=$data_class->get_sub($cab["cordenservicio_sub"],true);
					if(Evaluate_Mod($data)){
						$tpl->assign("nombre",$data["cab"]["data"]);
						$tpl->assign("ods_name",$data["cab"]["ods_full"]);
						$tpl->assign("rut",$data["cab"]["code"]);
						$tpl->assign("fllegada",$data["cab"]["llegada"]);
						$tpl->assign("fsalida",$data["cab"]["retiro"]);
						$tpl->assign("hr_total",$data["cab"]["horas"]);
						$tpl->assign("hr_ocupa",$data["cab"]["ocupado"]);
						$tpl->assign("hr_restant",$data["cab"]["restante"]);
						//$tpl->assign("hr_restant",($data["cab"]["restante"]+$cab["duracion"]));
						$tpl->assign("cliente",$data["cab"]["codigo_cliente"]);
						$tpl->assign("ods",$data["cab"]["codigo"]);
						$tpl->assign("trabs",$data["cab"]["trabs"]);
						$tpl->assign("lugar",$data["cab"]["lugar"]);
						$tpl->assign("vehiculo",$data["cab"]["transporte"]);
					}
				}
				$upt=$perm_val["content"][0]["upt"];
				if($upt==1 && $cab["status"]=="PRO"){
					$tpl->newBlock("data_save");
					foreach ($var_array_nav as $key_ => $value_) {
						$tpl->assign($key_,$value_);
					}
				}else{ $tpl->assign("read",'readonly'); }
			}
		}
	}
}
?>