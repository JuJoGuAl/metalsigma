<?php
session_start();
include_once("../../class/functions.php");
include_once("../../class/class.permission.php");
include_once("../../class/class.clientes.php");
include_once("../../class/class.zonas.php");
include_once("../../class/class.equipos.php");
include_once("../../class/class.proveedores.php");
include_once("../../class/class.trabajadores.php");
include_once("../../class/class.inventario.php");
include_once("../../class/class.par_admin.php");
include_once("../../class/class.compras.php");
include_once("../../class/class.cotizaciones.php");
include_once("../../class/class.planificacion.php");

$table="";
$titles="";
$response=array();
$almacenes = array();

$perm = new permisos;
$clientes = new clientes();
$zonas = new zonas();
$equipos = new equipos();
$proveedores = new proveedores();
$trabajadores = new trabajadores();
$inventario = new inventario();
$admin = new paradm;
$compras = new compras;
$cotizaciones = new cotizaciones;
$planificaciones = new planificaciones;

if (!isset($_SESSION['metalsigma_log'])){
	$response['title']="ERROR";
	$response["content"]="ACCESO DENEGADO: <strong>SU SESION HA EXPIRADO!</strong>";
}else{
	if($_POST["mod"]=="noperm"){
		$perm_val["title"]="SUCCESS";
	}else{
		$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_POST['mod']);
	}
	if($perm_val["title"]<>"SUCCESS"){
		$response['title']="ERROR";
		$response["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA EL MODULO</strong>";
	}else{
		if(!empty($perm_val["content"][0]["alm"])){
			foreach ($perm_val["content"][0]["alm"] as $key => $value) {
				$almacenes[] .= $perm_val["content"][0]["alm"][$key]["calmacen"];
			}
		}
		$accion=(isset($_REQUEST['accion'])?$_REQUEST['accion']:'');
		switch ($accion){
			case 'add_eqs':
			$titles='<tr><th>CODIGO</th><th>EQUIPO</th><th>MARCA</th><th>MODELO</th><th>SEGMENTO</th></tr>';
			break;
			case 'search_cargo':
			case 'search_especialidad':
			$titles='<tr><th>CODIGO</th><th>DESCRIPCION</th></tr>';
			break;
			case 'search_sistema':
			case 'search_componente':
			$titles='<tr><th>CODIGO</th><th>COD. INTERNO</th><th>DESCRIPCION</th></tr>';
			break;
			case 'add_art_cot':
			case 'add_serv_cot':
			$titles='<tr><th>CODIGO</th><th>CODE</th><th>DESCRIPCION</th><th>CLASIFICACION</th></tr>';
			break;
			case 'search_proveedor':
			$titles='<tr><th>CODIGO</th><th>CODE</th><th>PROVEEDOR</th></tr>';
			break;
			case 'search_almacen_compra':
			case 'search_almacen':
			case 'search_almacen_user':
			$titles='<tr><th>CODIGO</th><th>ALMACEN</th></tr>';
			break;
			case 'search_cliente':
			$titles='<tr><th>CODIGO</th><th>CODE</th><th>CLIENTE</th><th>CONTACTO</th></tr>';
			break;
			case 'add_eqs_cot':
			$titles='<tr><th>CODIGO</th><th>EQUIPO</th><th>SEGMENTO</th><th>SERIAL</th><th>INTERNO</th></tr>';
			break;
			case 'search_servicio_propio':
			$titles='<tr><th>CODIGO</th><th>CODE</th><th>NOMBRE</th><th>DESCRIPCION</th></tr>';
			break;
			case 'add_ins':
			case 'add_rep':
			case 'add_ser':
			$titles='<tr><th>CODIGO</th><th>CODE</th><th>NOMBRE</th><th>DESCRIPCION</th><th>COSTO</th></tr>';
			break;
			case 'add_ser_cot':
			$titles='<tr><th>CODIGO</th><th>RUT</th><th>PROVEEDOR</th><th>FECHA</th><th>SERVS.</th><th>MONTO</th></tr>';
			break;
			case 'add_odc':
			$titles='<tr><th>CODIGO</th><th>PROVEEDOR</th><th>ART. PEND</th><th>MONTO ODC</th></tr>';
			break;
			case 'add_nte':
			$titles='<tr><th>CODIGO</th><th>PROVEEDOR</th><th>ART.</th><th>MONTO</th></tr>';
			break;			
			case 'add_art':
			$titles='<tr><th>COD. INT</th><th>CODIGO</th><th>ARTICULO</th><th>CLASIFICACION</th></tr>';
			break;
			case 'search_ods_plan':
			$titles='<tr><th>ODS</th><th>RUT</th><th>CLIENTE</th><th>HORAS DISP</th><th>LLEGADA</th><th>RETIRO</th></tr>';
			break;
			case 'search_ods':
			$titles='<tr><th>ODS</th><th>RUT</th><th>CLIENTE</th><th>FECHA</th></tr>';
			break;
			case 'search_trab1':
			case 'search_trab2':
			case 'search_trab3':
			$titles='<tr><th>CODIGO</th><th>RUT</th><th>TRABAJADOR</th><th>CARGO</th></tr>';
			break;
			case 'search_requisicion':
			$titles='<tr><th>CODIGO</th><th>ALMACEN SOL.</th><th>ALMACEN REQ.</th><th>FECHA</th></tr>';
			break;
			case 'search_ods_gar':
			$titles='<tr><th>COT</th><th>ODS</th><th>FAC</th><th>FECHA FAC</th><th>TIPO COT</th><th>LUGAR</th><th>EQUIPO</th></tr>';
			break;
		}
		$table.='<div class="table-responsive"><table class="table table-bordered table-hover datatables" id="'.$accion.'_tbl"><thead>'.$titles.'</thead><tbody>';
		if($accion=="add_eqs"){
			$data=$equipos->list_();
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value){
					$table.='<tr><td class="_id">'.$value["codigo"].'</td><td class="_nom">'.$value['equipo'].'</td><td class="_mar">'.$value['marca'].'</td><td class="_mod">'.$value['modelo'].'</td><td class="_seg">'.$value['segmento'].'</td></tr>';
				}
				$table.="</tbody></table></div>";
				$response=$table;
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}else if($accion=="rut_cliente"){
			$data=$clientes->get_rut($_POST["rut"]);
			if($data["title"]=="SUCCESS"){
				if($data["content"]["cliente"]>0){
					$response["title"]="ERROR";
					$response["content"]="EL RUT INGRESADO YA ESTA REGISTRADO COMO CLIENTE!";
				}else{
					$response["title"]="SUCCESS";
					$response["content"]=$data["content"];
				}
			}elseif($data["title"]=="WARNING"){
				//EL RUT NO HA SIDO USADO
				$response["title"]="BLANCO";
				$response["content"]=1;
			}
		}else if($accion=="rut_proveedor"){
			$data=$proveedores->get_rut($_POST["rut"]);
			if($data["title"]=="SUCCESS"){
				if($data["content"]["proveedor"]>0){
					$response["title"]="ERROR";
					$response["content"]="EL RUT INGRESADO YA ESTA REGISTRADO COMO PROVEEDOR!";
				}else{
					$response["title"]="SUCCESS";
					$response["content"]=$data["content"];
				}
			}elseif($data["title"]=="WARNING"){
				//EL RUT NO HA SIDO USADO
				$response["title"]="BLANCO";
				$response["content"]=1;
			}
		}elseif($accion=="list_pais"){
			$data=$zonas->list_p();
			if($data["title"]=="SUCCESS"){
				$response["title"]="SUCCESS";
				$response["content"]=$data["content"];
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTEN PAISES PARA MOSTRAR";
			}
		}elseif($accion=="list_region"){
			$code = (isset($_POST["pais"])) ? $_POST["pais"] : false ;
			$data=$zonas->list_r($code);
			if($data["title"]=="SUCCESS"){
				$response["title"]="SUCCESS";
				$response["content"]=$data["content"];
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTEN REGIONES PARA MOSTRAR";
			}
		}elseif($accion=="list_provincias"){
			$code = (isset($_POST["region"])) ? $_POST["region"] : false ;
			$data=$zonas->list_pr($code);
			if($data["title"]=="SUCCESS"){
				$response["title"]="SUCCESS";
				$response["content"]=$data["content"];
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTEN PROVINCIAS PARA MOSTRAR";
			}
		}elseif($accion=="list_comunas"){
			$code = (isset($_POST["provincia"])) ? $_POST["provincia"] : false ;
			$data=$zonas->list_c($code);
			if($data["title"]=="SUCCESS"){
				$response["title"]="SUCCESS";
				$response["content"]=$data["content"];
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTEN COMUNAS PARA MOSTRAR";
			}
		}else if($accion=="search_cargo"){
			$data=$trabajadores->list_car();
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value){
					$table.='<tr><td class="_id">'.$value["codigo"].'</td><td class="_nom">'.$value['cargo'].'</td></tr>';
				}
				$table.="</tbody></table></div>";
				$response=$table;
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}else if($accion=="search_especialidad"){
			$data=$trabajadores->list_esp();
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value){
					$table.='<tr><td class="_id">'.$value["codigo"].'</td><td class="_nom">'.$value['especialidad'].'</td></tr>';
				}
				$table.="</tbody></table></div>";
				$response=$table;
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}else if($accion=="search_sistema"){
			$data=$equipos->list_pa();
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value){
					$table.='<tr><td class="_id">'.$value["codigo"].'</td><td>'.$value["code"].'</td><td class="_nom">'.$value['parte'].'</td></tr>';
				}
				$table.="</tbody></table></div>";
				$response=$table;
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}else if($accion=="search_componente"){
			$data=$equipos->list_pi($_POST["part"]);
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value){
					$table.='<tr><td class="_id">'.$value["codigo"].'</td><td>'.$value["code"].'</td><td class="_nom">'.$value['pieza'].'</td></tr>';
				}
				$table.="</tbody></table></div>";
				$response=$table;
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}else if($accion=="search_servicio_propio"){
			$servicio=array(4);
			$data=$inventario->list_($servicio);
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value){
					$desc = ($value['descripcion']=="") ? "" : $value['descripcion'] ;
					$desc = (strlen($value['descripcion'])>=45) ? '<span href="#" data-placement="top" data-toggle="tooltip" title="" data-original-title="'.$value['descripcion'].'">'.substr($value['descripcion'], 0, 45).'...</span>' : $value['descripcion'] ;
					$table.='<tr><td class="_id">'.$value["codigo"].'</td><td>'.$value["codigo2"].'</td><td class="_nom">'.$value['articulo'].'</td><td>'.$desc.'</td></tr>';
				}
				$table.="</tbody></table></div>";
				$response=$table;
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}else if($accion=="add_art_cot" || $accion=="add_serv_cot"){
			if(isset($_POST['code'])){
				$data=$inventario->get_($_POST['code']);
				if($data["title"]=="SUCCESS"){
					$response["title"]="SUCCESS";
					$response["content"]=$data["content"];
					$response["imp"]=constant("IMPUESTOS");
				}else{
					$response["title"]="ERROR";
					$response["content"]="ERROR AL OBTENER LOS DATOS DEL ITEM SELECCIONADO";
				}
			}else{
				if($_POST["mod"]=="CRUD_INV_REQ"){
					$clasif	= array (2);
				}else{
					$clasif = ($accion=="add_art_cot") ? false : array(3) ;
				}
				$tipo = ($accion=="add_art_cot") ? 1 : 0 ;
				$data=$inventario->list_($clasif,$tipo,json_decode($_POST["not"]));
				if($data["title"]=="SUCCESS"){
					foreach ($data["content"] as $key => $value){
						$table.='<tr><td class="_id"><input class="_imp" type="hidden" value="'.constant("IMPUESTOS").'">'.$value["codigo"].'</td><td class="_code">'.$value["codigo2"].'</td><td class="_nom">'.$value['articulo'].'</td><td class="_clas">'.$value['clasificacion'].'</td></tr>';
					}
					$table.="</tbody></table></div>";
					$response=$table;
				}else{
					$response["title"]="ERROR";
					$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
				}
			}
		}else if($accion=="search_proveedor"){
			$data=$proveedores->list_p(1);
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value){
					$table.='<tr><td class="_id">'.$value["codigo"].'</td><td class="_rut">'.formatRut($value["code"]).'</td><td class="_nom">'.$value['data'].'<input class="_dir" type="hidden" value="'.$value["direccion"].'"></td></tr>';
				}
				$table.="</tbody></table></div>";
				$response=$table;
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}else if($accion=="search_almacen_compra" || $accion=="search_almacen" || $accion=="search_almacen_user"){
			$compra = ($accion=="search_almacen" || $accion=="search_almacen_user") ? false : true ;
			$stock = ($accion=="search_almacen") ? true : false ;
			$non = ($accion=="search_almacen_user") ? json_decode($_POST["not"]) : false ;
			$almacenes = ($accion=="search_almacen_compra") ? false : $almacenes ;
			$data=$inventario->list_a(1,$compra,$stock,$non,$almacenes);
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value){
					$table.='<tr><td class="_id">'.$value["codigo"].'</td><td class="_nom">'.$value['almacen'].'</td></tr>';
				}
				$table.="</tbody></table></div>";
				$response=$table;
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}else if($accion=="search_cliente"){
			$data=$clientes->list_c(1);
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value){
					$table.='<tr><td class="_id">'.$value["codigo"].'</td><td class="_rut">'.formatRut($value["code"]).'</td><td class="_nom">'.$value['data'].'<input class="_dir" type="hidden" value="'.$value["direccion"].'"><input class="_pag" type="hidden" value="'.$value["pago"].'"><input class="_cre" type="hidden" value="'.$value["credito"].'"><input class="_desc" type="hidden" value="'.$value["descu"].'"></td><td>'.$value["contacto"].'</td></tr>';
				}
				$table.="</tbody></table></div>";
				$response=$table;
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}
		else if($accion=="add_eqs_cot"){
			$data=$equipos->list_eq($_POST["cli"],true);
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value){
					$table.='<tr><td class="_id">'.$value["codigo"].'</td><td class="_nom">'.$value['equipo'].' '.$value['marca'].' '.$value['modelo'].'</td><td class="_seg">'.$value["segmento"].'</td><td class="_ser">'.$value["serial"].'</td><td class="_int">'.$value["interno"].'</td></tr>';
				}
				$table.="</tbody></table></div>";
				$response=$table;
			}else{
				/*$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";*/
				$table.="</tbody></table></div>";
				$response=$table;
			}
		}elseif($accion=="calculos_"){
			$valores=array();
			$salida=$costo_km=$hh_taller=$hh_terreno=$trabs=$valor_peso_dia=0;
			$arriendot=constant("ARRIENDO TALLER (EN UF)");
			$naves=constant("N° NAVES");
			$factor=constant("FACTOR DE UTILIZACION (%)");
			$uf=constant("VALOR UF");
			$data_VE=$admin->get_v($_POST["vehiculo"]);
			if($data_VE["title"]=="SUCCESS"){
				$salida=$data_VE["content"]["salida"]*1;
				$costo_km=$data_VE["content"]["costo_km"]*1;
			}
			$data_mo=$admin->list_vh($_POST["csegmento"],$_POST["equipot"]);
			if($data_mo["title"]=="SUCCESS"){
				$hh_taller=$data_mo["content"][0]["hh_normal_taller"]*1;
				$hh_terreno=$data_mo["content"][0]["hh_normal_terreno"]*1;
			}
			$data_eq=$admin->get_e($_POST["equipot"]);
			if($data_eq["title"]=="SUCCESS"){
				$trabs=$data_eq["content"]["trabs"]*1;
			}
			$segmento = ($_POST['coteq']==0) ? 6 :$_POST['csegmento'] ;
			$data_ar=$admin->list_a($segmento);
			if($data_ar["title"]=="SUCCESS"){
				$costo_mes_nave=(($arriendot/$naves)*100)/$factor;
				$costo_dia_nave=$costo_mes_nave/30;
				$espacio=$data_ar["content"][0]["espacio"];
				$mar_uf=$data_ar["content"][0]["mar_uf"];
				$costo_uf=$costo_dia_nave*$espacio;
				$valor_uf_dia=(($costo_uf*$mar_uf)/100)+$costo_uf;
				$valor_peso_dia=$valor_uf_dia*$uf;
			}
			if($data_VE["title"]=="ERROR" || $data_mo["title"]=="ERROR" || $data_eq["title"]=="ERROR" || $data_ar["title"]=="ERROR"){
				$response["title"]="ERROR";
				$response["content"]="ERROR AL OBTENER LOS DATOS DE LA BASE DE DATOS";
			}else{
				$valores["salida"]=$salida;
				$valores["costo_km"]=$costo_km;
				$valores["hh_taller"]=$hh_taller;
				$valores["hh_terreno"]=$hh_terreno;
				$valores["trabs"]=$trabs;
				$valores["valor_peso_dia"]=$valor_peso_dia;

				$response["title"]="SUCCESS";
				$response["content"]=$valores;
			}
		}else if($accion=="add_ins" || $accion=="add_rep" || $accion=="add_ser"){
			switch ($accion) {
				case 'add_ins':
					$tipo=array(2);
					break;
				case 'add_rep':
					$tipo=array(1);
					break;
				case 'add_ser':
					$tipo=3;
					break;
			}
			$data=$inventario->list_($tipo,false,json_decode($_POST["not"]));
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value){
					$descripcion = (strlen($value['descripcion'])>35) ? substr($value['descripcion'],0,35).' <span class="fas fa-info-circle pop" data-body="'.$value['descripcion'].'" data-title="DESCRIPCION"></span>' : $value['descripcion'] ;
					$table.='<tr><td class="_id">'.$value["codigo"].'</td><td class="_code">'.$value['codigo2'].'</td><td class="_nom">'.$value['articulo'].'</td><td>'.$descripcion.'</td><td class="_pri">'.($value['costo_prom']).'</td></tr>';
				}
				$table.="</tbody></table></div>";
				$response=$table;
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}elseif($accion=="add_odc"){
			if(isset($_POST['code'])){
				$data=$compras->get_odc($_POST['code']);
				if($data["title"]=="SUCCESS"){
					$response["title"]="SUCCESS";
					$response["cab"]=$data["cab"];
					$response["det"]=$data["det"];
					$response["mov"]=$data["mov"];
					$response["imp"]=constant("IMPUESTOS");
				}else{
					$response["title"]="ERROR";
					$response["content"]="ERROR AL OBTENER LOS DATOS LA ODC SELECCIONADA";
				}
			}else{
				$data=$compras->list_odc("PRO",true,$_POST["prov"],json_decode($_POST["not"]));
				if($data["title"]=="SUCCESS"){
					foreach ($data["content"] as $key => $value){
						$table.='<tr><td class="_id">'.$value["codigo"].'</td><td class="_nom">'.$value['data'].'</td><td class="_art">'.($value['pendientes']).'</td><td class="_mon">'.($value['monto_total']).'</td></tr>';
					}
					$table.="</tbody></table></div>";
					$response=$table;
				}else{
					$response["title"]="ERROR";
					$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
				}
			}
		}elseif($accion=="add_nte"){
			if(isset($_POST['code'])){
				$data=$inventario->get_mov($_POST['code']);
				if($data["title"]=="SUCCESS"){
					$response["title"]="SUCCESS";
					$response["cab"]=$data["cab"];
					$response["det"]=$data["det"];
					$response["imp"]=constant("IMPUESTOS");
				}else{
					$response["title"]="ERROR";
					$response["content"]="ERROR AL OBTENER LOS DATOS LA ODC SELECCIONADA";
				}
			}else{
				$data=$inventario->list_mov("NTE",$_POST["alm"],$_POST["prov"],"PRO",json_decode($_POST["not"]),-1);
				if($data["title"]=="SUCCESS"){
					foreach ($data["content"] as $key => $value){
						$table.='<tr><td class="_id">'.$value["codigo_transaccion"].'</td><td class="_nom">'.$value['data'].'</td><td class="_art">'.($value['articulos']).'</td><td class="_mon">'.($value['monto_total']).'</td></tr>';
					}
					$table.="</tbody></table></div>";
					$response=$table;
				}else{
					$response["title"]="ERROR";
					$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
				}
			}
		}elseif($accion=="add_art"){
			if(isset($_POST['code'])){
				$data=$inventario->get_mov($_POST['code']);
				if($data["title"]=="SUCCESS"){
					$response["title"]="SUCCESS";
					$response["cab"]=$data["cab"];
					$response["det"]=$data["det"];
					$response["imp"]=constant("IMPUESTOS");
				}else{
					$response["title"]="ERROR";
					$response["content"]="ERROR AL OBTENER LOS DATOS LA ODC SELECCIONADA";
				}
			}else{
				$data=$inventario->list_(false,1,json_decode($_POST["not"]));
				if($data["title"]=="SUCCESS"){
					$table .= ($_POST["mod"]=="KARDEX") ? '<tr><td class="_id">-1</td><td class="_id2">0</td><td class="_nom">TODOS...</td><td>-</td></tr>' : '' ;
					foreach ($data["content"] as $key => $value){
						$table.='<tr><td class="_id">'.$value["codigo"].'</td><td class="_id2">'.$value["codigo2"].'</td><td class="_nom">'.$value['articulo'].'</td><td>'.$value['clasificacion'].'</td></tr>';
					}
					$table.="</tbody></table></div>";
					$response=$table;
				}else{
					$response["title"]="ERROR";
					$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
				}
			}
		}elseif($accion=="kardex"){
			$alm = ($_POST["alm"]==-1 || $_POST["alm"]=="undefined") ? false : $_POST["alm"] ;
			$art = ($_POST["art"]==-1 || $_POST["art"]=="undefined") ? false : $_POST["art"] ;
			$tip = ($_POST["tip"]==-1 || $_POST["tip"]=="undefined") ? false : $_POST["tip"] ;
			$ini = ($_POST["ini"]==NULL || $_POST["ini"]=="undefined") ? false : $_POST["ini"] ;
			$fin = ($_POST["fin"]==NULL || $_POST["fin"]=="undefined") ? false : $_POST["ini"] ;
			$data=$inventario->kardex($alm,$ini,$fin,$art,$tip);
			if($data["title"]=="SUCCESS"){
				$response["title"]="SUCCESS";
				foreach ($data["content"] as $key => $value){
					$data["content"][$key]["costo_total"] = ($value['costou']>0) ? $value['cant']*$value['costou'] : 0 ;
				}				
				$response["content"]=$data["content"];
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}elseif($accion=="search_ods_plan"){
			$data=$cotizaciones->list_sub(false,$array_cot_fac,">= 0");
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value){
					$table.='<tr><td class="_id"><input class="_fini" type="hidden" value="'.$value["llegada"].'"><input class="_ffin" type="hidden" value="'.$value["retiro"].'"><input class="_hr_to" type="hidden" value="'.$value["horas"].'"><input class="_hr_rest" type="hidden" value="'.$value["restante"].'"><input class="_hr_ocu" type="hidden" value="'.$value["ocupado"].'">'.$value["ods_full"].'</td><td class="_code">'.formatRut($value["code"]).'</td><td class="_nom">'.$value['data'].'</td><td>'.$value['restante'].'</td><td>'.$value['llegada'].'</td><td>'.$value['retiro'].'<input class="_cliente" type="hidden" value="'.$value["codigo_cliente"].'"><input class="_ods" type="hidden" value="'.$value["codigo"].'"><input class="_trabs" type="hidden" value="'.$value["trabs"].'"><input class="_lugar" type="hidden" value="'.$value["lugar"].'"><input class="_vehiculo" type="hidden" value="'.$value["transporte"].'"></td></tr>';
				}
				$table.="</tbody></table></div>";
				$response=$table;
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}elseif($accion=="search_trab1" || $accion=="search_trab2" || $accion=="search_trab3"){
			$filtro = ($accion=="search_trab3") ? false : array(1,2) ;
			$data=$trabajadores->list_t(1,$filtro,json_decode($_POST["not"]));
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value){
					$table.='<tr><td class="_id">'.$value["codigo"].'</td><td class="_code">'.formatRut($value["code"]).'</td><td class="_nom">'.$value['data'].'</td><td>'.$value['cargo'].'</td></tr>';
				}
				$table.="</tbody></table></div>";
				$response=$table;
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}elseif($accion=="upload_excel"){
			header('Content-type:application/json;charset=utf-8');
			try {
				if (!isset($_FILES['media']['error']) || is_array($_FILES['media']['error'])){
					throw new RuntimeException('PARAMETROS INVALIDOS');
				}
				switch ($_FILES['media']['error']) {
					case UPLOAD_ERR_OK:
					break;
					case UPLOAD_ERR_NO_FILE:
					throw new RuntimeException('EL ARCHIVO NO SE PROCESO');
					case UPLOAD_ERR_INI_SIZE:
					case UPLOAD_ERR_FORM_SIZE:
					throw new RuntimeException('SE HA EXCEDIDO EL LIMITE');
					default:
					throw new RuntimeException('ERROR DESCONOCIDO');
				}
				$file = $_FILES['media']['tmp_name'];
				$dataExcel = readExcel($file);
				if (!array_key_exists("codigo", $dataExcel[0])) {
					throw new RuntimeException('LA HOJA ACTIVA NO POSEE LOS CAMPOS PARA LA CARGA MASIVA, POR FAVOR CARGUE NUEVAMENTE EL ARCHIVO');
				}
				if(array_key_exists($array_excel_rows[0], $dataExcel[0])){
					$data=$precios=array();
					foreach ($dataExcel as $key => $value) {
						if($value["codigo"]!=""){
							//SI ESTOY EN MAESTRAS/ARTICULOS TOMO EL COSTO DE RESTO LO DEJO EN 0
							$costo = (strtolower($_POST["mod"])=="crud_articulos") ? $value["costo"] : 0 ;
							$data[0][$key] = $value["codigo"];
							$data[1][$key] = $value["articulo"];
							$data[2][$key] = $value["descripcion"];
							$data[3][$key] = $value["categoria"];
							$data[4][$key] = $costo;
							if(strtolower($_POST["mod"])!="crud_articulos"){
								$precios["cant"][$key] = $value["cant"];
								$precios["precio"][$key] = $value["costo"];
							}
						}
					}
					$result = $inventario->setArticulos($data);
					if($result["title"]=="SUCCESS"){
						if(strtolower($_POST["mod"])!="crud_articulos"){
							foreach ($result["content"] as $key => $value) {
								$result["content"][$key]["cant_"] = $precios["cant"][$key];
								$result["content"][$key]["precio_"] = $precios["precio"][$key];
							}
						}						
						$response = $result;
						$response["imp"]=constant("IMPUESTOS");;
					}else{
						$response = $result;
					}
				}else{
					throw new RuntimeException('EL ARCHIVO NO POSEE LAS COLUMNAS NECESARIAS PARA LA IMPORTACION');
				}				
			} catch (RuntimeException $e) {
				$response["title"]="ERROR";
				$response["content"]=$e->getMessage();
			}
		}elseif($accion=="refresh_cotizaciones"){
			$arr = json_decode($_POST["stat"]);
			$fstat = ($arr[0]=="-1") ? false : json_decode($_POST["stat"]);
			$ftipo = ($_POST["tipo"]=="-1") ? false : $_POST["tipo"];
			$data=$cotizaciones->list_all($fstat,false,$ftipo);
			if($data["title"]=="SUCCESS"){
				$response["title"]="SUCCESS";
				foreach ($data["content"] as $key => $datos){
					$data["content"][$key]["code"]=formatRut($data["content"][$key]["code"]);
					$id=$datos['codigo'];
					$cadena_acciones='
					<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light menu" data-menu="COTIZACIONES" data-mod="CRUD_COT_ALL" data-ref="CRUD_COT_SUB_ALL" data-subref="NONE" data-acc="MODULO" data-id="'.$id.'"><i class="fas fa-arrow-right"></i></button>
					';
					$detalles=$cotizaciones->list_sub($datos['codigo'],$array_cot_all);
					$sub_status = "";
					$contador = 0;
					$class = "";
					if($detalles["title"]=="SUCCESS"){
						foreach ($detalles["content"] as $llave1 => $datos1) {
							$contador++;
							$clas_="";
							if($arr[0]!="-1"){
								$clas_ .= ($datos1["status"]==$fstat[0]) ? "font-weight-bold" : "" ;
							}
							$estatus_=$array_status[$datos1["status"]];
							if($_POST["tipo"]!="-1"){
								$estatus_ .= ($datos1["ctipo"]==$_POST["tipo"]) ? " <strong>(".$datos1["tipo"].")</strong>" : "" ;
							}
							$class = ($datos1["ctipo"]==5) ? "table-warning" : $class ;
							$sub_status .= "<span class='".$clas_."'>".$datos1["correlativo"].": ".$estatus_."</span><br>";
						}

					}
					$data["content"][$key]["boton"] = $cadena_acciones;
					$data["content"][$key]["cuentas"] = $contador;
					$data["content"][$key]["class"] = $class;
					$data["content"][$key]["sub_status"] = $sub_status;
				}
				$response["content"]=$data["content"];
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}elseif($accion=="refresh_ods"){
			$arr = json_decode($_POST["stat"]);
			$fstat = ($arr[0]=="-1") ? $array_ods : json_decode($_POST["stat"]) ;
			$ftipo = ($_POST["tipo"]=="-1") ? false : $_POST["tipo"];
			$data=$cotizaciones->list_all($fstat,false,$ftipo);
			if($data["title"]=="SUCCESS"){
				$response["title"]="SUCCESS";
				foreach ($data["content"] as $key => $datos){
					$id=$datos['codigo'];
					$cadena_acciones='
					<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light menu" data-toggle="tooltip" data-placement="top" title="DETALLES" data-menu="SERVICIOS" data-mod="CRUD_ODS" data-ref="CRUD_ODS_SUB" data-subref="NONE" data-acc="MODULO" data-id="'.$id.'"><i class="fas fa-arrow-right"></i></button>';					
					$detalles=$cotizaciones->list_sub($datos['codigo'],$array_ods);
					$sub_status = "";
					$contador = 0;
					$class = "";
					if($detalles["title"]=="SUCCESS"){
						foreach ($detalles["content"] as $llave1 => $datos1) {
							$contador++;
							$clas_="";
							if($arr[0]!="-1"){
								$clas_ .= ($datos1["status"]==$fstat[0]) ? "font-weight-bold" : "" ;
							}
							$estatus_=$array_status[$datos1["status"]];
							if($_POST["tipo"]!="-1"){
								$estatus_ .= ($datos1["ctipo"]==$_POST["tipo"]) ? " <strong>(".$datos1["tipo"].")</strong>" : "" ;
							}
							$class = ($datos1["ctipo"]==5) ? "table-warning" : $class ;
							$sub_status .= "<span class='".$clas_."'>".$datos1["correlativo"].": ".$estatus_."</span><br>";
						}

					}
					$data["content"][$key]["boton"] = $cadena_acciones;
					$data["content"][$key]["cuentas"] = $contador;
					$data["content"][$key]["sub_status"] = $sub_status;
					$data["content"][$key]["code"] = formatRut($datos['code']);
					$data["content"][$key]["class"] = $class;
				}
				$response["content"]=$data["content"];
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}elseif($accion=="set_pic"){
			extract($_POST, EXTR_PREFIX_ALL, "");
			$carpeta = "/../images/users/";
			$input="foto";
			if($_FILES[$input]['name']){
				$img=subirImg($input,$carpeta,600,600,str_pad($_ente, 10, "0", STR_PAD_LEFT));
			}
			if($img){
				$response['title']="SUCCESS";
			}
		}else if ($accion=="refresh_cot_graficos"){
			$arr = json_decode($_POST["stat"]);
			$content = array();
			$colores=array();
			$año = $arr[0]=="-1" ? false : $arr[0];
			$mes = $arr[1]=="-1" ? false : str_pad($arr[1], 2, "0", STR_PAD_LEFT);
			$seller = $arr[2]=="-1" ? false : $arr[2];
			$chartData1=$chartData2=$chartData3=$chartData4=$chartData5=$chartData6=$chartData7=array();

			//COTIZACIONES
			$data = $cotizaciones->list_sub_group("DATE_FORMAT(co.crea_date, '%m-%Y')","DATE_FORMAT(co.crea_date, '%m-%Y') AS periodo, COUNT(*) AS cuenta, IFNULL(SUM(co.m_bruto),0) AS monto, MONTH(co.crea_date) AS mes, YEAR(co.crea_date) AS year",$array_cot_all_,$seller,$mes,$año);
			//COTIZACIONES (CANT)
			$ejeX=$datos_x=$legend_=array();
			foreach ($array_mont as $key => $value) {
				$ejeX[] .= substr($array_mont[$key], 0, 3);
			}
			$legenda="CANT";
			$legend_[]=$legenda;
			if(empty($colores)){
				$colores=array("#707cd2","#ffc36d","#2cabe3","#ff5050","#2cd07e","#8898aa");
			}
			$color_new=array_rand($colores,1);
			$color = $colores[$color_new];
			unset($colores[$color_new]);
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value) {
					//AL ARREGLO DE MESES LE PASO EL VALOR DE CUENTA A LOS MESES ENCONTRADOS
					$array_mont_cero[$value["mes"]]=$value["cuenta"];
				}
			}
			//AL EJEX QUE DEBE TENER LOS MESES LE PONGO LOS VALORES OBTENIDOS
			foreach ($array_mont_cero as $key => $value) {
				$datos_x[] .= $array_mont_cero[$key];
			}
			$chartData1["series"]=[
				"name"=>$legenda,
				"type"=>"bar",
				"data"=> $datos_x];
			$chartData1["legenda"]=$legend_;
			$chartData1["color"]=$color;
			$chartData1["ejex"]=$ejeX;
			$content["chart1"]= $chartData1;

			//COTIZACIONES (MONTO)
			$datos_x=$legend_=array();
			$legenda="MONTO";
			$legend_[]=$legenda;
			if(empty($colores)){
				$colores=array("#707cd2","#ffc36d","#2cabe3","#ff5050","#2cd07e","#8898aa");
			}
			$color_new=array_rand($colores,1);
			$color = $colores[$color_new];
			unset($colores[$color_new]);
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value) {
					//AL ARREGLO DE MESES LE PASO EL VALOR DE CUENTA A LOS MESES ENCONTRADOS
					$array_mont_cero[$value["mes"]]=$value["monto"];
				}
			}
			//AL EJEX QUE DEBE TENER LOS MESES LE PONGO LOS VALORES OBTENIDOS
			foreach ($array_mont_cero as $key => $value) {
				$datos_x[] .= $array_mont_cero[$key];
			}
			$chartData2["series"]=[
				"name"=>$legenda,
				"type"=>"bar",
				"data"=> $datos_x];
			$chartData2["legenda"]=$legend_;
			$chartData2["color"]=$color;
			$chartData2["ejex"]=$ejeX;
			$content["chart2"]= $chartData2;

			//COTIZACIONES POR VENDEDOR
			$data = $cotizaciones->list_sub_group("co.crea_user","COUNT(*) AS cuenta, IFNULL(SUM(co.m_bruto),0) AS monto, (CASE WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS trabajador, co.crea_user",$array_cot_all_,$seller,$mes,$año);
			//COTIZACIONES POR VENDEDOR (CANT)
			$datos_x=$ejeX=$legend_=array();
			$legenda="CANT";
			$legend_[]=$legenda;
			if(empty($colores)){
				$colores=array("#707cd2","#ffc36d","#2cabe3","#ff5050","#2cd07e","#8898aa");
			}
			$color_new=array_rand($colores,1);
			$color = $colores[$color_new];
			unset($colores[$color_new]);
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value) {
					$ejeX[] .= substr($value["trabajador"], 0, 3);
					$datos_x[] .= $value["cuenta"];
				}
			}
			$chartData3["series"]=[
				"name"=>$legenda,
				"type"=>"bar",
				"data"=> $datos_x];
			$chartData3["legenda"]=$legend_;
			$chartData3["color"]=$color;
			$chartData3["ejex"]=$ejeX;
			$content["chart3"]= $chartData3;

			//COTIZACIONES POR VENDEDOR (MONTO)
			$datos_x=$ejeX=$legend_=array();
			$legenda="MONTO";
			$legend_[]=$legenda;
			if(empty($colores)){
				$colores=array("#707cd2","#ffc36d","#2cabe3","#ff5050","#2cd07e","#8898aa");
			}
			$color_new=array_rand($colores,1);
			$color = $colores[$color_new];
			unset($colores[$color_new]);
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value) {
					$ejeX[] .= substr($value["trabajador"], 0, 3);
					$datos_x[] .= $value["monto"];
				}
			}
			$chartData4["series"]=[
				"name"=>$legenda,
				"type"=>"bar",
				"data"=> $datos_x];
			$chartData4["legenda"]=$legend_;
			$chartData4["color"]=$color;
			$chartData4["ejex"]=$ejeX;
			$content["chart4"]= $chartData4;
			
			//APROBADAS VS REALIZADAS
			$data = $cotizaciones->list_sub_group("co.crea_user","SUM(CASE WHEN (co.ccotizacion>0) THEN 1 ELSE 0 END) AS cot_rea, SUM(CASE WHEN (co.status IN ('PCL','PRO','FAC')) THEN 1 ELSE 0 END) AS cot_pro, SUM(CASE WHEN (co.ccotizacion>0) THEN co.m_bruto ELSE 0 END) AS cot_rea_m, SUM(CASE WHEN (co.status IN ('PCL','PRO','FAC')) THEN co.m_bruto ELSE 0 END) AS cot_pro_m, (CASE WHEN u1.ctrabajador=0 THEN u1.nombres ELSE d1.data END) AS trabajador, co.crea_user",$array_cot_all_,$seller,$mes,$año);
			//COTIZACIONES REALIZADAS VS APROBADAS (CANT)
			$legend=array();
			$legend[0]="REALIZADAS";
			$legend[1]="APROBADAS";
			$ejeX_1=$ejeX_2=$ejeX=$color=array();
			for ($i=0; $i <2 ; $i++) {
				if(empty($colores)){
					$colores=array("#707cd2","#ffc36d","#2cabe3","#ff5050","#2cd07e","#8898aa");
				}
				//ASIGNO 2 COLORES
				$color_new=array_rand($colores,1);
				$color[] .= $colores[$color_new];
				unset($colores[$color_new]);
			}
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value) {
					$ejeX[] .= substr($value["trabajador"], 0, 3);
					$ejeX_1[] .= $value["cot_rea"];
					$ejeX_2[] .= $value["cot_pro"];
				}
			}
			$chartData5["legenda"]=$legend;
			$chartData5["ejex"]=$ejeX;
			$chartData5["color"]=$color;
			$series=array();
			for ($i=0; $i <2 ; $i++) {
				$serie_name = ($i==0) ? 'REALIZADAS' : 'APROBADAS' ;
				$serie_valor = ($i==0) ? $ejeX_1 : $ejeX_2;
				$series[$i] = [
				 	"name"=>$serie_name,
				 	"type"=>"bar",
				 	"data"=> $serie_valor
				];
			}
			$chartData5["series"] =$series;
			$content["chart5"]= $chartData5;

			//COTIZACIONES REALIZADAS VS APROBADAS (MONTO)
			$legend=array();
			$legend[0]="REALIZADAS";
			$legend[1]="APROBADAS";
			$ejeX_1=$ejeX_2=$ejeX=$color=array();
			for ($i=0; $i <2 ; $i++) {
				if(empty($colores)){
					$colores=array("#707cd2","#ffc36d","#2cabe3","#ff5050","#2cd07e","#8898aa");
				}
				//ASIGNO 2 COLORES
				$color_new=array_rand($colores,1);
				$color[] .= $colores[$color_new];
				unset($colores[$color_new]);
			}
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value) {
					$ejeX[] .= substr($value["trabajador"], 0, 3);
					$ejeX_1[] .= $value["cot_rea_m"];
					$ejeX_2[] .= $value["cot_pro_m"];
				}
			}
			$chartData6["legenda"]=$legend;
			$chartData6["ejex"]=$ejeX;
			$chartData6["color"]=$color;
			$series=array();
			for ($i=0; $i <2 ; $i++) {
				$serie_name = ($i==0) ? 'REALIZADAS' : 'APROBADAS' ;
				$serie_valor = ($i==0) ? $ejeX_1 : $ejeX_2;
				$series[$i] = [
				 	"name"=>$serie_name,
				 	"type"=>"bar",
				 	"data"=> $serie_valor
				];
			}
			$chartData6["series"] =$series;
			$content["chart6"]= $chartData6;
			
			//COTIZACIONES POR ITEM
			$data = $cotizaciones->list_sub_group(false,"SUM(co.m_serv) AS mano_obra, SUM(co.m_rep) AS repuestos, SUM(co.m_ins) AS insumos, SUM(co.m_misc) AS misc, SUM(co.m_serv+co.m_rep+co.m_ins+co.m_misc) AS total",$array_cot_pro_,$seller,$mes,$año);
			$cab = $data["content"][0];
			//COTIZACIONES POR ITEM (MONTO)
			$legend=array();
			$legend[0]="MANO DE OBRA";
			$legend[1]="REPUESTOS";
			$legend[2]="INSUMOS";
			$legend[3]="MISCELANEOS";
			$series=$color=array();

			for ($i=0; $i <4 ; $i++) {
				if(empty($colores)){
					$colores=array("#707cd2","#ffc36d","#2cabe3","#ff5050","#2cd07e","#8898aa");
				}
				//ASIGNO 2 COLORES
				$color_new=array_rand($colores,1);
				$color[] .= $colores[$color_new];
				unset($colores[$color_new]);
				$campo=$valor="";
				switch ($i) {
					case 0:
						$campo="mano_obra";
						$valor="MANO DE OBRA";
						break;
					case 1:
						$campo="repuestos";
						$valor="REPUESTOS";
						break;
					case 2:
						$campo="insumos";
						$valor="INSUMOS";
						break;
					case 3:
						$campo="misc";
						$valor="MISCELANEOS";
						break;
				}
				$series[$i]["value"] = $cab[$campo];
				$series[$i]["name"] = $valor;
			}				
			$chartData7["series"]=$series;
			$chartData7["color"]=$color;
			$chartData7["legenda"]=$legend;
			$content["chart7"]= $chartData7;
			
			$response["title"]="SUCCESS";
			$response["content"]=$content;
		}else if ($accion=="refresh_rep_trabajos"){
			$fecha = setDate($_POST["date"],"Y-m-d");
			$data = $planificaciones->list_ocupa_plan("nt.ctrabajador",$fecha,$fecha);
			//print_r($data);
			if($data["title"]=="SUCCESS"){
				$response["title"]="SUCCESS";
				foreach ($data["content"] as $key => $value) {
					$planes = $planificaciones->get_plan_worker($data["content"][$key]["codigo_trabajador"],false,false,$fecha);
					if($planes["title"]=="SUCCESS"){
						$trabajos=$servicios=array();
						foreach ($planes["content"] as $key1 => $value1){
								$minutes2	=	(12 * 60.0 + 0 * 1.0);
								$time2		=	explode(':', $planes["content"][$key1]["inicio"]);
								$minutes1	=	($time2[0] * 60.0 + $time2[1] * 1.0);
								$dif_hora	=	($minutes2 - $minutes1);
								$bloque = ($dif_hora>0) ? "man" : "tar" ;																
								$trabajos[$key1]["bloque"]=$bloque;
								foreach ($planes["content"][$key1] as $key2 => $value2){
									$trabajos[$key1][$key2]=$value2;
								}
								$trabajos_ = $cotizaciones->get_sub($planes["content"][$key1]["cordenservicio_sub"]);
								if($trabajos_["title"]=="SUCCESS"){
									$cab=$trabajos_["cab"];
									$det=$trabajos_["det"];
									$art=$trabajos_["art"];
									if(!empty($det)){
										foreach ($det as $key3 => $value3){
											$servicios[$key3]=$value3;
										}
										$trabajos[$key1]["servicios"]=$servicios;
									}
								}
							}
							$data["content"][$key]["trabajos"]=$trabajos;
					}
				}				
				$response["content"]=$data["content"];
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";	
			}
		}else if ($accion=="refresh_rep_ocupacion"){
			$fini = setDate($_POST["fini"],"Y-m-d");
			$ffin = setDate($_POST["ffin"],"Y-m-d");
			$data = $trabajadores->list_t(1,$array_car_emp);
			//$data = $planificaciones->list_ocupa_plan("nt.ctrabajador",$fini,$ffin,false,$array_trabs);
			if($data["title"]=="SUCCESS"){
				$prom = 0;
				$ocupacion = array();
				foreach ($data["content"] as $key => $value) {
					$ocup = 0;
					$ocupacion[$key]["trabajador"] = $data["content"][$key]["data"];
					$ocupacion[$key]["cargo"] = $data["content"][$key]["cargo"];
					$trabajos = $planificaciones->list_ocupa_plan("nt.ctrabajador",$fini,$ffin,false,$data["content"][$key]["codigo"]);
					if($trabajos["title"]=="SUCCESS"){
						$ocup = $trabajos["content"][0]["ocupa"];
						$prom = $prom + $ocup;
					}
					$ocupacion[$key]["ocupa"] = $ocup;
					$ocupacion[$key]["ocupa_"] = numeros($ocup,2);
				}
				$prom = $prom / count($data["content"]);
				$response["title"]="SUCCESS";
				$response["content"]=$ocupacion;
				$response["ocupa_prom"]=$prom;
				$response["ocupa_prom_"]=numeros($prom,2);
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}else if($accion=="search_ods"){
			$not = ($_POST['mod']=="CRUD_INV_REQ") ? json_decode($_POST["not"]) : false ;
			$data=$cotizaciones->list_sub(false,$array_cot_ods,false,false,false,false,true,$not);
			if($data["title"]=="SUCCESS"){
				foreach ($data["content"] as $key => $value){
					$table.='<tr><td class="_id"><input class="_ods" type="hidden" value="'.$value["codigo"].'"><input class="_ods_pad" type="hidden" value="'.$value["ods_full"].'">'.$value["ods_full"].'</td><td class="_code">'.formatRut($value["code"]).'</td><td class="_nom">'.$value['data'].'</td><td class="_fecha">'.$value['fecha'].'</td></tr>';
				}
				$table.="</tbody></table></div>";
				$response=$table;
			}else{
				$response["title"]="ERROR";
				$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
			}
		}else if($accion=="get_ods_art"){
			$f_alm = ($_POST['mod']=="CRUD_INV_RES" || $_POST['mod']=="CRUD_INV_ODS") ? $_POST["alm"] : false ;
			$data=$cotizaciones->list_art_ods($_POST["code"],$f_alm);
			if($data["title"]=="SUCCESS"){
				$response["title"]="SUCCESS";
				$response["imp"]=constant("IMPUESTOS");
				if($_POST['mod']=="CRUD_ODC_ODS"){
					foreach ($data["content"] as $key => $value) {
						$art_comp=$compras->get_art_odc_used($value["codigo"],$_POST["code"]);
						//print_r($art_comp);
						if($art_comp["title"]=="SUCCESS"){
							$data["content"][$key]["ods_arts"]=$art_comp["content"];
						}
					}
				}
				$response["content"]=$data["content"];
			}
		}else if($accion=="add_ser_cot"){
			if(isset($_POST['code'])){
				$data=$compras->get_cot($_POST['code']);
				if($data["title"]=="SUCCESS"){
					$response["title"]="SUCCESS";
					$response["cab"]=$data["cab"];
					$response["det"]=$data["det"];
					$response["imp"]=constant("IMPUESTOS");
				}else{
					$response["title"]="ERROR";
					$response["content"]="ERROR AL OBTENER LOS DATOS LA COTIZACION SELECCIONADA";
				}
			}else{
				$data=$compras->list_cot('PRO',false,json_decode($_POST["not"]),true);
				if($data["title"]=="SUCCESS"){
					foreach ($data["content"] as $key => $value){
						$table.='<tr><td class="_id">'.$value["codigo"].'</td><td class="_code">'.formatRut($value["code"]).'</td><td class="_nom">'.$value['data'].'</td><td>'.$value['fecha'].'</td><td>'.$value['servicios'].'</td><td>'.numeros($value['monto_total']).'</td></tr>';
					}
					$table.="</tbody></table></div>";
					$response=$table;
				}else{
					$response["title"]="ERROR";
					$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
				}
			}
		}else if($accion=="search_requisicion"){
			if(isset($_POST['code'])){
				$data=$inventario->get_req($_POST['code']);
				if($data["title"]=="SUCCESS"){
					$response["title"]="SUCCESS";
					$response["cab"]=$data["cab"];
					$response["det"]=$data["det"];
				}else{
					$response["title"]="ERROR";
					$response["content"]="ERROR AL OBTENER LOS DATOS LA REQUISICION SELECCIONADA";
				}
			}else{
				$data=$inventario->list_req('PRO',false,$almacenes);
				if($data["title"]=="SUCCESS"){
					foreach ($data["content"] as $key => $value){
						$table.='<tr><td class="_id">'.$value["codigo"].'</td><td class="_almdes">'.$value["alm_des"].'</td><td class="_almori">'.$value['alm_ori'].'</td><td>'.$value['fecha'].'</td></tr>';
					}
					$table.="</tbody></table></div>";
					$response=$table;
				}else{
					$response["title"]="ERROR";
					$response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";
				}
			}

		}else if ($accion=="geomap"){
			include_once("../../class/class.bd_connect.php");
			$result = connect();
			$result = $result["content"];
			$worker = $_GET["worker"];
			$sql = "SELECT username,hini,hfin,longitud,latitud,address FROM co_planificacion_maphist, co_planificacion_map
			WHERE co_planificacion_maphist.id_map = co_planificacion_map.id and run = 1 and date_job = CURDATE()
			and co_planificacion_maphist.id in (SELECT MAX(id) FROM `co_planificacion_maphist` GROUP BY id_map)";

			if($worker != "all"){
				$sql .= " AND username='$worker'";
			}
			$cont = 0;
			$query = $result->query($sql);
			$count = $query->rowCount();

			if($count > 0){
				while($data = $query->fetch(PDO::FETCH_ASSOC)){
					$geojson[$cont] = $data;
					$cont++;
				}
			}else{
				$geojson[0] = 0;
			}
			$response = $geojson;
		}else if ($accion=="search_ods_gar"){
			if(isset($_POST["code"])){
				$data=$cotizaciones->get_sub($_POST['code']);
				if($data["title"]=="SUCCESS"){
					//print_r($data);
					$response["title"]="SUCCESS";
					$response["cab"]=$data["cab"];
					$response["datos"]=$data["datos"];
					$response["det"]=$data["det"];
					$response["art"]=$data["art"];
					$response["cot"]=$data["cot"];
				}else{
					$response["title"]="ERROR";
					$response["content"]="ERROR AL OBTENER LOS DATOS LA ODS SELECCIONADA";
				}
			}else{
				$status_ = array("FAC");
				$data=$cotizaciones->list_sub($_POST["codigo"],$status_,false,false,false,false,false,false,constant("MAX_DIAS_GAR"));
				if($data["title"]=="SUCCESS"){
					foreach ($data["content"] as $key => $value){
						$table.='<tr><td><input class="_ods" type="hidden" value="'.$value["codigo"].'">'.$value["cot_full"].'</td><td>'.$value["ods_full"].'</td><td>'.$value['cfactura'].'</td><td>'.$value['fecha_fac'].'</td><td>'.$value['tipo'].'</td><td>'.$value['lugar'].'</td><td>'.$value['equipo'].'</td></tr>';
					}
					$table.="</tbody></table></div>";
					$response=$table;
				}else{
					$response["title"]="ERROR";
					$response["content"]="NO EXISTEN ODS QUE CUMPLAN CON LOS REQUERIMIENTOS";
				}
			}

		}
	}
}
echo json_encode($response);
?>