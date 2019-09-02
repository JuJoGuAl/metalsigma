<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new" || $action=="save_edit" || $action=="proc"){
	include_once("../../../class/functions.php");
	include_once("../../../class/class.cotizaciones.php");
	$data_class = new cotizaciones;
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
			if($action=="proc"){
				extract($_GET, EXTR_PREFIX_ALL, "");
				$datos = $detalles = $articulos = $cotizaciones = $det_det = $det_det_art = $det_sist = $det_comp = $det_serv = $det_servp = $det_hhta = $det_hhte = $det_day = $det_ini = $det_fin = $det_art = $det_precio = $det_cant = array();
				array_push($datos, $_cotizat);
				array_push($datos, $_lugar);
				array_push($datos, $_vehiculo);
				array_push($datos, $_dist);
				array_push($datos, $_viajes);
				array_push($datos, $_coteq);
				array_push($datos, $_equipot);
				array_push($datos, "PCL");//STATUS
				array_push($datos, $__serv);
				array_push($datos, $__rep);
				array_push($datos, $__ins);
				array_push($datos, $__stt);
				array_push($datos, $__tras);
				array_push($datos, $__misc);
				array_push($datos, $__subt);
				array_push($datos, $_desc);
				array_push($datos, $__desc);
				array_push($datos, $__neto);
				array_push($datos, $__impp);
				array_push($datos, $__imp);
				array_push($datos, $__bruto);
				array_push($datos, $_notas);

				if(!empty($_GET['cparte'])){
					for ($i=0; $i<sizeof($_GET['cparte']); $i++){
						array_push($det_det, $_c_det[$i]);
						array_push($det_sist, $_cparte[$i]);
						array_push($det_comp, $_cpieza[$i]);
						array_push($det_hhta, $_hhtaller[$i]);
						array_push($det_hhte, $_hhterreno[$i]);
						array_push($det_day, $_dtaller[$i]);
						array_push($det_serv, $_cservi[$i]);
						array_push($det_servp, 0);//EL SERVICIO POR COT NO TIENE PRECIO (SE COBRAN LAS HORAS)
						array_push($det_ini, setDate($_inicio[$i]));
						array_push($det_fin, setDate($_fin[$i]));
					}
				}
				if(!empty($_GET['carticulo'])){
					for ($i=0; $i<sizeof($_GET['carticulo']); $i++){
						array_push($det_det_art, $_c_det_art[$i]);
						array_push($det_art, $_carticulo[$i]);
						array_push($det_cant, $_cant[$i]);
						array_push($det_precio, $_precio[$i]);
					}
				}
				array_push($detalles, $det_det);
				array_push($detalles, $det_sist);
				array_push($detalles, $det_comp);
				array_push($detalles, $det_hhta);
				array_push($detalles, $det_hhte);
				array_push($detalles, $det_day);
				array_push($detalles, $det_serv);
				array_push($detalles, $det_servp);
				array_push($detalles, $det_ini);
				array_push($detalles, $det_fin);

				array_push($articulos, $det_det_art);
				array_push($articulos, $det_art);
				array_push($articulos, $det_cant);
				array_push($articulos, $det_precio);
				if(isset($_GET['ccotizacion'])){
					for ($i=0; $i<sizeof($_GET['ccotizacion']); $i++){
						array_push($cotizaciones, $_ccotizacion[$i]);
					}
				}
				if($action=="proc"){
					if($upt!=1){
						$resultado['title']="ERROR";
						$resultado["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
					}else{
						$resultado=$data_class->edit_co_sub($_id,$datos,$detalles,$articulos,$cotizaciones);
					}
				}

				$mensaje="SIN MENSAJE";
				switch ($action) {
					case "proc":
						$mensaje="COTIZACION ENVIADA A APROBACION DE CLIENTE!";
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
				$quien="CEO";
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
				$tpl->assign("menu_name","APROBACIONES - ".$quien);
				$tpl->assign("form_title","COTIZACION: ");
			}
			if($action=="edit"){
				$tpl->assign("accion",'save_edit');
				$tpl->assign("id",$_GET["id"]);
				$cotiza=$data_class->get_sub($_GET["id"]);
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
				$csegmento=$cab_cli["csegmento"];
				$csegmento2 = ($cab["parte"]==0) ? 6 : $csegmento ;
				$cpago=$cab_cli["cpago"];
				$cequipo=$cab["cequipo"];
				$cvehiculo=$cab["cvehiculo"];
				//CONSULTO LOS DATOS NECESARIOS PARA LOS CALCULOS
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
							$porc='<span class="badge badge-pill count badge-info" data-content="Valor anterior: <strong>'.$historia["m_descp"].'</strong><br>Cambiado por: <strong>'.$historia["user"].'</strong><br>Fecha: <strong>'.setDate($historia["date"],"d/m/Y").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
						}
					}
					$tpl->assign("porc_hist",$porc);
				}
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
						$codigo=$count;
						if($value["del"]==0){
							$codigo.='<input name="c_det[]" id="c_det[]" type="hidden" value="'.$value["codigo"].'">';
							$parte = '<input name="cparte[]" id="cparte[]" type="hidden" value="'.$value["cparte"].'">'.$value["parte"];
							$pieza = '<input name="cpieza[]" id="cpieza[]" type="hidden" value="'.$value["cpieza"].'">'.$value["pieza"].'<button class="btn btn-outline-secondary waves-effect waves-light btn-sm pieza ctrl" type="button" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref"].'" data-subref="'.$var_array_nav["subref"].'" data-acc="search_componente" data-id="0" style="margin-left: .5rem;"><span class="btn-label"><i class="fas fa-sync"></i></span></button>';
							$articulo = '<input name="cservi[]" id="cservi[]" type="hidden" value="'.$value["cservicio"].'"><input name="price[]" id="price[]" type="hidden" value="'.$value["precio"].'">'.$value["articulo"].'<button class="btn btn-outline-secondary waves-effect waves-light btn-sm servicio ctrl" type="button" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref"].'" data-subref="'.$var_array_nav["subref"].'" data-acc="search_servicio_propio" data-id="0" style="margin-left: .5rem;"><span class="btn-label"><i class="fas fa-sync"></i></span></button>';
							$hh_taller = '<input name="hhtaller[]" id="hhtaller[]" type="text" class="form-control numeric ctrl sum_hh_ta" style="width: 60px" maxlength="5" value="'.$value["hh_taller"].'">';
							$hh_terreno = '<input name="hhterreno[]" id="hhterreno[]" type="text" class="form-control numeric ctrl sum_hh_te" style="width: 60px" maxlength="5" value="'.$value["hh_terreno"].'">';
							$dias_taller = '<input name="dtaller[]" id="dtaller[]" type="text" class="form-control numeric ctrl sum_dtaller" style="width: 50px" maxlength="2" value="'.$value["dias_taller"].'">';
							$finicio = '<input name="inicio[]" id="inicio[]" type="text" class="form-control dates ctrl" maxlength="10" style="width:100px;" value="'.setDate($value["finicio"],"d-m-Y").'">';
							$ffin = '<input name="fin[]" id="fin[]" type="text" class="form-control dates ctrl" maxlength="10" style="width:100px;" value="'.setDate($value["ffin"],"d-m-Y").'">';
							$actions = '<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref"].'" data-subref="'.$var_array_nav["subref"].'"><i class="fas fa-trash-alt"></i></button>';
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
							$parte = $value["parte"];
							$pieza = $value["pieza"];
							$articulo = $value["articulo"];
							$hh_taller = $value["hh_taller"];
							$hh_terreno = $value["hh_terreno"];
							$dias_taller = $value["dias_taller"];
							$finicio = setDate($value["finicio"],"d-m-Y");
							$ffin = setDate($value["ffin"],"d-m-Y");
							$actions = '<span class="badge badge-pill count badge-danger" data-content="Eliminado por: <strong>'.$value["mod_user"].'</strong><br>Fecha: <strong>'.setDate($value["mod_date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
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
						$bloque="";
						$class="";
						switch ($value["cclasificacion"]) {
							case '0000000001':
								$bloque="co_det_rep";
								$class="add_rep";
								break;
							case '0000000002':
								$bloque="co_det_ins";
								$class="add_ins";
								break;
							/*case '0000000003':
								$bloque="co_det_stt";
								$class="add_ser";
								break;*/
							default:
							$bloque="";
								break;
						}
						$tpl->newBlock($bloque);
						if($value["del"]==0){
							$codigo='<input name="c_det_art[]" id="c_det_art[]" type="hidden" value="'.$value["codigo"].'"><input name="carticulo[]" id="carticulo[]" type="hidden" class="form-control ctrl" value="'.$value["carticulo"].'">'.$value["carticulo"];
							$codigo2=$value["codigo2"];
							$nombre=$value["articulo"];
							$cant='<input name="cant[]" id="cant[]" type="text" style="display: inline-block; width: 60px" maxlength="5" class="form-control numeric ctrl" value="'.$value["cant"].'">';
							$precio='<input name="precio[]" id="precio[]" type="hidden" class="form-control ctrl" value="'.$value["precio"].'">'.$value["precio"];
							$actions='<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref"].'" data-subref="'.$var_array_nav["subref"].'"><i class="fas fa-trash-alt"></i></button>';

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
							$codigo=$value["carticulo"];
							$codigo2=$value["codigo2"];
							$nombre=$value["articulo"];
							$cant = $value["cant"];
							$precio = $value["precio"];
							$actions = '<span class="badge badge-pill count badge-danger" data-content="Eliminado por: <strong>'.$value["mod_user"].'</strong><br>Fecha: <strong>'.setDate($value["mod_date"],"d/m/Y H:i:s").'</strong>" rel="popover" data-placement="top" data-toggle="popover"><i class="fas fa-star"></i></span>';
						}
						$tpl->assign("codigo",$codigo);
						$tpl->assign("codigo2",$codigo2);
						$tpl->assign("nombre",$nombre);
						$tpl->assign("cant",$cant);
						$tpl->assign("classe",$class);
						$tpl->assign("precio",$precio);
						$tpl->assign("actions",$actions);
					}
				}
				if(!empty($cots)){
					$ccot_com[]=array();
					foreach ($cots as $key => $value) {
						$ccot_com[$key]=$value["codigo"];
						$tpl->newBlock("co_det_stt");
						$actions='<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref"].'" data-subref="'.$var_array_nav["subref"].'"><i class="fas fa-trash-alt"></i></button>';
						foreach ($cots[$key] as $key1 => $value1){
							$tpl->assign($key1,$value1);
						}
						$tpl->assign("count",$key);
						$tpl->assign("actions",$actions);
					}
					$detalles=$compras->get_cot_det_array($ccot_com);
					if($detalles["title"]=="SUCCESS"){
						foreach ($detalles["content"] as $key => $value) {
							$tpl->newBlock("det_ser_ter");
							$costo = $detalles["content"][$key]["costou"];
							$precio = (($data_seg["content"]["mar_stt"]*$costo)/100)+$costo;
							foreach ($detalles["content"][$key] as $key1 => $value1){
								$tpl->assign($key1,$value1);
							}
							$tpl->assign("count",$key);
							$tpl->assign("precio",$precio);
						}
					}
				}
		
				$tpl->newBlock("dats");
				$tpl->assign("hh_taller",$data_mo["content"][0]["hh_normal_taller"]);
				$tpl->assign("hh_terreno",$data_mo["content"][0]["hh_normal_terreno"]);
				$tpl->assign("trabs",$data_eq["content"]["trabs"]);
				$tpl->assign("valor_dia",$valor_peso_dia);
				$tpl->assign("valor_misc",constant("MISCELANEOS"));
				$tpl->assign("imp",constant("IMPUESTOS"));
				$tpl->assign("pag_gasto",$data_cli["content"]["gastos"]);
				$tpl->assign("pag_marg",$data_cli["content"]["margen"]);
				$tpl->assign("mar_ins",$data_seg["content"]["mar_ins"]);
				$tpl->assign("mar_rep",$data_seg["content"]["mar_rep"]);
				$tpl->assign("mar_stt",$data_seg["content"]["mar_stt"]);
				$tpl->assign("sal",$data_VE["content"]["salida"]*1);
				$tpl->assign("costo_km",$data_VE["content"]["costo_km"]*1);
				$tpl->newBlock("aud_data");
				$tpl->assign("crea_user",$cab['crea_user']);
				$tpl->assign("mod_user",$cab['mod_user']);
				$tpl->assign("crea_date",$cab['crea_date']);
				$tpl->assign("mod_date",$cab['mod_date']);
				if($cab["status"]!="PAC"){
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