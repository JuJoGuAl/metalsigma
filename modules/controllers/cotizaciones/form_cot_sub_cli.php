<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
$action=(isset($_POST['accion'])?strtolower($_POST['accion']):$action);
if($action=="proc" || $action=="canc" || $action=="reco"){
	include_once("../../../class/functions.php");
	include_once("../../../class/class.cotizaciones.php");
	$data_class = new cotizaciones;
	session_start();
	$response=array();
	if(isset($_SESSION["metalsigma_log"])){
		$mod=(isset($_GET['submod'])?$_GET['submod']:$_POST['submod']);
		$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$mod);
		if($perm_val["title"]<>"SUCCESS"){
			$response['title']="ERROR";
			$response["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA EL MODULO</strong>";
		}else{
			$ins=$perm_val["content"][0]["ins"];
			$upt=$perm_val["content"][0]["upt"];
			extract($_POST, EXTR_PREFIX_ALL, "");
			$datos = array();
			$status_cot="";
			switch ($action) {
				case 'proc':
					$status_cot="APB";
					break;
				case 'reco':
					$status_cot="PEN";
					break;
				case 'canc':
					$status_cot="CAN";
					break;
				default:
					$status_cot="NONES";
					break;
			}
			$carpeta = "/../../../images/files/";
			$file_name=NULL;
			if($_FILES["file"]['name']){
				$extension = explode(".", $_FILES["file"]['name']);
				$directorio=__DIR__.$carpeta;
				$ext = end($extension);
				$nombre =$_id.".".$ext;
				$files = glob($directorio.$_id.".*");
				//SI LA COT POSEE ARCHIVOS LOS BORRO
				foreach ($files as $file) {
					unlink($file);
				}
				if (move_uploaded_file($_FILES["file"]['tmp_name'], $directorio.$nombre)){
					$file_name=$nombre;
				}
			}
			array_push($datos, $status_cot);
			array_push($datos, $_notas);
			array_push($datos, $file_name);
			array_push($datos, $_notas_);

			if($upt!=1){
				$resultado['title']="ERROR";
				$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
			}else{
				$resultado=$data_class->pro_co_sub($_id,$datos);
			}
			$mensaje="SIN MENSAJE";
			switch ($action) {
				case "proc":
					$mensaje="COTIZACION PROCESADA";
				break;
				case "canc":
					$mensaje="COTIZACION ANULADA";
				break;
				case "reco":
					$mensaje="COTIZACION ENVIADA A RE - COTIZACION";
				break;
			}
			if($resultado["title"]=="SUCCESS"){
				$response['title']=$resultado["title"];
				$response["content"]=$mensaje;
			}else{
				$response['title']=$resultado["title"];
				$response["content"]=$resultado["content"];
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
				$quien="CLI";
				$var_array_nav=array();
				$var_array_nav["mod"]=$_GET['mod'];
				$var_array_nav["submod"]=$_GET['submod'];
				$var_array_nav["ref"]="FORM_COT_SUB_".$quien;
				$var_array_nav["subref"]="CRUD_COT_SUB_".$quien;

				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter","NONE");
				$tpl->assign("menu_name","APROBACIONES - CLIENTES");
				$tpl->assign("form_title","COTIZACION: ");
			}
			if($action=="edit"){
				$tpl->assign("accion",'save_edit');
				$tpl->assign("id",$_GET["id"]);
				$cotiza=$data_class->get_sub($_GET["id"],true);
				$cab=$cotiza["cab"];
				$cab_cli=$cotiza["datos"];
				$det=$cotiza["det"];
				$art=$cotiza["art"];
				$cots=$cotiza["cot"];
				$style = ($cab["clugar"]=="0000000001") ? 'style="display:none;"' : '' ;
				$codigo_origen=$cab["origen"];
				$tpl->assign("id_tittle",$cab["cot_full"]);
				$tpl->assign("status_color",color_status($cab['status'],"badge"));
				$tpl->assign("hide",$style);
				$style1 = ($cab["cot_gar_full"]=="N/A") ? 'style="display:none;"' : '' ;
				$tpl->assign("hide1",$style1);
				$style2 = ($cab["ctipo"]==5) ? 'disabled="disabled" style="display:none;"' : '' ;
				$style3 = ($cab["ctipo"]==5) ? 'validar' : '' ;
				$tpl->assign("hide3",$style3);
				$csegmento2 = ($cab["parte"]==0) ? 6 : $csegmento ;
				$cpago=$cab_cli["cpago"];
				$cequipo=$cab["cequipo"];
				$cvehiculo=$cab["cvehiculo"];
				foreach ($cab as $key => $value){
					$campos = array("m_serv","m_rep","m_ins","m_stt","m_tra","m_misc","m_subt","m_desc","m_neto","m_imp","m_bruto");
					$value = (in_array($key, $campos)) ? numeros($value,0)." $" : $value ;
					$tpl->assign($key,$value);
					$tpl->assign($key."_",$value);
					$porc="";
					if($cab["ultima_edicion"]>0){
						$cotiza_hist=$data_class->get_hcs($cab["ultima_edicion"]);
						$historia=$cotiza_hist["content"][0];
						if($cab["m_descp"]!=$historia["m_descp"]){
							$porc='<span class="badge badge-pill count badge-info" data-content="Valor anterior: <strong>'.$historia["m_descp"].'</strong><br>Cambiado por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
						}
					}
					$tpl->assign("porc_hist",$porc);
				}
				$garantia = ($cab["cot_gar_full"]!="N/A") ? "COT: ".$cab["cot_full_gar"]." ODS: ".$cab["ods_full_gar"] : "" ;
				$tpl->assign("ods_gar_full",$garantia);
				foreach ($cab_cli as $key => $value){
					$value = ($key=="code") ? formatRut($value) : $value ;
					$tpl->assign($key,$value);
				}
				if(!empty($array_status)){
					foreach ($array_status as $llave => $datos){
						if($llave==$cab["status"]){
							$tpl->assign("stats_code",$llave);
							$tpl->assign("stats_nom",$datos);
						}
					}
				}
				$tipo=$data_class->list_();
				foreach ($tipo["content"] as $key => $value) {
					$tpl->newBlock("tipo_det");
					if($value["codigo"]==$cab["ctipo"]){
						$tpl->assign("selected",$selected);
					}
					foreach ($tipo["content"][$key] as $key1 => $value1){
						$tpl->assign($key1,$value1);
					}
				}
				$lugares=$param->list_l();
				foreach ($lugares["content"] as $key => $value) {
					$tpl->newBlock("lugar_det");
					if($value["codigo"]==$cab["clugar"]){
						$tpl->assign("selected",$selected);
					}
					foreach ($lugares["content"][$key] as $key1 => $value1){
						$tpl->assign($key1,$value1);
					}
				}
				$vehiculos=$param->list_v();
				foreach ($vehiculos["content"] as $key => $value) {
					$tpl->newBlock("veh_det");
					if($value["codigo"]==$cab["cvehiculo"]){
						$tpl->assign("selected",$selected);
					}
					foreach ($vehiculos["content"][$key] as $key1 => $value1){
						$tpl->assign($key1,$value1);
					}
				}
				if(!empty($array_opcion)){
					foreach ($array_opcion as $llave => $datos){
						$tpl->newBlock("cot_equipo");
						if($llave==$cab["parte"]){
							$tpl->assign("selected",$selected);
						}
						$tpl->assign("code",$llave);
						$tpl->assign("valor",$datos);
					}
				}
				$equipost=$param->list_e();
				if(!empty($equipost)){
					foreach ($equipost["content"] as $llave => $datos){
						$tpl->newBlock("equipo_det");
						if($datos["codigo"]==$cab["cequipo"]){
							$cequipo=$datos["codigo"];
							$tpl->assign("selected",$selected);
						}
						foreach ($equipost["content"][$llave] as $key => $value){
							$tpl->assign($key,$value);
						}
					}
				}
				if(!empty($det)){
					$count=0;
					foreach ($det as $key => $value) {
						$tpl->newBlock("co_det");
						$count++;
						$count;
						if($value["del"]==0){
							$codigo =		$count;
							$parte = 		$value["parte"];
							$pieza = 		$value["pieza"];
							$articulo = 	$value["articulo"];
							$hh_taller =	'<input name="hhtaller[]" id="hhtaller[]" type="hidden" class="ctrl sum_hh_ta" value="'.$value["hh_taller"].'">'.$value["hh_taller"];
							$hh_terreno =	'<input name="hhterreno[]" id="hhterreno[]" type="hidden" class="ctrl sum_hh_te" value="'.$value["hh_terreno"].'">'.$value["hh_terreno"];
							$dias_taller =	'<input name="dtaller[]" id="dtaller[]" type="hidden" class="sum_dtaller" value="'.$value["dias_taller"].'">'.$value["dias_taller"];
							$finicio = 		'<input name="inicio[]" id="inicio[]" type="hidden" value="'.setDate($value["finicio"],"d-m-Y").'">'.setDate($value["finicio"],"d-m-Y");
							$ffin = 		'<input name="fin[]" id="fin[]" type="hidden" value="'.setDate($value["ffin"],"d-m-Y").'">'.setDate($value["ffin"],"d-m-Y");
							$actions = 		'-';
							//REVISO SI TIENE CAMBIOS ANTERIORES
							if($value["ultima_edicion"]>0){
								$cotiza_hist=$data_class->get_hcsd($value["ultima_edicion"]);
								$historia=$cotiza_hist["content"][0];
								if($value["cparte"]!=$historia["cparte"]){
									$parte.='<span class="badge badge-pill count badge-info" data-content="Valor anterior: <strong>'.$historia["parte"].'</strong><br>Cambiado por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
								}
								if($value["cpieza"]!=$historia["cpieza"]){
									$pieza.='<span class="badge badge-pill count badge-info" data-content="Valor anterior: <strong>'.$historia["parte"].'</strong><br>Cambiado por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
								}
								if($value["cservicio"]!=$historia["cservicio"]){
									$articulo.='<span class="badge badge-pill count badge-info" data-content="Valor anterior: <strong>'.$historia["parte"].'</strong><br>Cambiado por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
								}
								if($value["hh_taller"]!=$historia["hh_taller"]){
									$hh_taller.='<span class="badge badge-pill count badge-info" data-content="Valor anterior: <strong>'.$historia["hh_taller"].'</strong><br>Cambiado por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
								}
								if($value["hh_terreno"]!=$historia["hh_terreno"]){
									$hh_terreno.='<span class="badge badge-pill count badge-info" data-content="Valor anterior: <strong>'.$historia["hh_terreno"].'</strong><br>Cambiado por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
								}
								if($value["dias_taller"]!=$historia["dias_taller"]){
									$dias_taller.='<span class="badge badge-pill count badge-info" data-content="Valor anterior: <strong>'.$historia["dias_taller"].'</strong><br>Cambiado por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
								}
								if($value["finicio"]!=$historia["finicio"]){
									$finicio.='<span class="badge badge-pill count badge-info" data-content="Valor anterior: <strong>'.setDate($historia["finicio"],"d-m-Y").'</strong><br>Cambiado por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
								}
								if($value["ffin"]!=$historia["ffin"]){
									$ffin.='<span class="badge badge-pill count badge-info" data-content="Valor anterior: <strong>'.setDate($historia["ffin"],"d-m-Y").'</strong><br>Cambiado por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
								}
							}

						}else{
							$codigo = 		"-";
							$parte = 		$value["parte"];
							$pieza = 		$value["pieza"];
							$articulo = 	$value["articulo"];
							$hh_taller = 	$value["hh_taller"];
							$hh_terreno = 	$value["hh_terreno"];
							$dias_taller = 	$value["dias_taller"];
							$finicio = 		setDate($value["finicio"],"d-m-Y");
							$ffin = 		setDate($value["ffin"],"d-m-Y");
							$actions = 		'<span class="badge badge-pill count badge-danger" data-content="Eliminado por: <strong>'.$value["mod_user"].'</strong><br>Fecha: <strong>'.setDate($value["mod_date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
						}
						
						$tpl->assign("count",$codigo);
						$tpl->assign("parte",$parte);
						$tpl->assign("pieza",$pieza);
						$tpl->assign("articulo",$articulo);
						$tpl->assign("hh_taller",$hh_taller);
						$tpl->assign("hh_terreno",$hh_terreno);
						$tpl->assign("dias_taller",$dias_taller);
						$tpl->assign("finicio",$finicio);
						$tpl->assign("ffin",$ffin);
						$tpl->assign("actions",$actions);
					}
				}
				if(!empty($art)){
					foreach ($art as $key => $value) {
						$tpl->newBlock("articulos");
						if($value["del"]==0){
							$codigo =			$value["carticulo"];
							$codigo2 =			$value["codigo2"];
							$nombre =			$value["articulo"];
							$cant =				$value["cant"];
							$precio =			$value["precio"];
							$clasificacion =	$value["clasificacion"];
							$actions =			'-';

							if($value["ultima_edicion"]>0){
								$cotiza_hist=$data_class->get_hcsa($value["ultima_edicion"]);
								$historia=$cotiza_hist["content"][0];
								if($value["carticulo"]!=$historia["carticulo"]){
									$codigo.='<span class="badge badge-pill count badge-info" data-content="Valor anterior: <strong>'.$historia["carticulo"].'</strong><br>Cambiado por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
									$nombre.='<span class="badge badge-pill count badge-info" data-content="Valor anterior: <strong>'.$historia["articulo"].'</strong><br>Cambiado por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
								}
								if($value["cant"]!=$historia["cant"]){
									$cant.='<span class="badge badge-pill count badge-info" data-content="Valor anterior: <strong>'.$historia["cant"].'</strong><br>Cambiado por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
								}
								if($value["precio"]!=$historia["precio"]){
									$precio.='<span class="badge badge-pill count badge-info" data-content="Valor anterior: <strong>'.$historia["precio"].'</strong><br>Cambiado por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
								}
							}
						}else{
							$codigo =			$value["carticulo"];
							$codigo2 =			$value["codigo2"];
							$nombre =			$value["articulo"];
							$cant =				$value["cant"];
							$precio =			$value["precio"];
							$clasificacion =	$value["clasificacion"];
							$actions = '<span class="badge badge-pill count badge-danger" data-content="Eliminado por: <strong>'.$value["mod_user"].'</strong><br>Fecha: <strong>'.setDate($value["mod_date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
						}
						$tpl->assign("codigo",$codigo);
						$tpl->assign("codigo2",$codigo2);
						$tpl->assign("nombre",$nombre);
						$tpl->assign("cant",$cant);
						$tpl->assign("precio",$precio);
						$tpl->assign("clasificacion",$clasificacion);
						$tpl->assign("actions",$actions);
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
							$tpl->assign("nombre",$detalles["content"][$key]["articulo"]);
							$tpl->assign("cant",$detalles["content"][$key]["cant"]);
							$tpl->assign("precio",$precio);
							$tpl->assign("clasificacion","SERVICIOS TERCERIZADOS");
							$tpl->assign("actions","-");
						}
					}
				}
				
				if($cab["status"]!="PEN"){
					$tpl->newBlock("val");
				}
			}
			$upt=$perm_val["content"][0]["upt"];
			if($upt==1){
				$tpl->newBlock("data_save");
				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}
				$tpl->assign("codigo",$codigo_origen);
			}else{ $tpl->assign("read",'readonly'); }
		}
	}
}
?>