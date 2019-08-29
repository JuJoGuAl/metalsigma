<?php
//DEFINO CONSTANTES PARA UITILIZAR EL SISTEMA
define("_PAD_CEROS_", 6);
//HORA PREDETEMINADA PARA PHP
date_default_timezone_set('America/Santiago');
//Cargo el VENDOR con las classes descargadas
require ('vendor/autoload.php');
use Intervention\Image\ImageManagerStatic as Image;
use PhpOffice\PhpSpreadsheet\IOFactory;

//CLASSE DE PERMISOS (ASI EVITO TENER QUE INVOCARLA EN CADA MODULO)
include_once("class.permission.php");
include_once("class.parameter.php");
$perm = new permisos;
$parametros = new parametros();
$par=$parametros->list_all();
foreach ($par["content"] as $key => $value) {
	if(!defined($value["parametro"])){
        define($value["parametro"], $value["valor"]);
    }
}
$selected = 'selected="selected"';
//BOOLEANS
$array_bool=array();
$array_bool[1]="SI";
$array_bool[0]="NO";
//ESTATUS
$array_estatus=array();
$array_estatus[1]="ACTIVO";
$array_estatus[0]="INACTIVO";
//NAC
$array_nac=array();
$array_nac["N"]="NACIONAL";
$array_nac["E"]="EXTRANJERO";
//SEXO
$array_sex=array();
$array_sex["M"]="MASCULINO";
$array_sex["F"]="FEMENINO";
//ESTADO CIVIL
$array_est=array();
$array_est["S"]="SOLTERO(A)";
$array_est["C"]="CASADO(A)";
$array_est["V"]="VIUDO(A)";
//STATUS ALL
$array_all=array();
$array_all["PEN"]="PENDIENTE";
$array_all["APB"]="APROBADA";
$array_all["PRO"]="PROCESADA";
$array_all["UTI"]="UTILIZADA";
$array_all["CAN"]="CANCELADA";
$array_all["FAC"]="FACTURADA";
//STATUS COTIZACION
$array_status=array();
$array_status["PCO"]="POR COTIZAR";
$array_status["PEN"]="PENDIENTE";
$array_status["PAC"]="PEND. APROB. CEO";
$array_status["PAT"]="PEND. APROB. TALLER";
$array_status["PCL"]="PEND. APROB. CLIENTE";
$array_status["APB"]="APROBADA";
$array_status["PRO"]="PROCESADA";
$array_status["TRA"]="TRABAJANDO";
$array_status["TER"]="TERMINADA";
$array_status["FAC"]="FACTURADA";
$array_status["CAN"]="CANCELADA";
//TIPO DE COTIZACION
$array_opcion=array();
$array_opcion[1]="EQUIPO";
$array_opcion[0]="COMPONENTE";
//MOVIMIENTOS INVENTARIO
$array_movi=array();
$array_movi["SI"]="SALDO INICIAL";
$array_movi["COM"]="FACT. COMPRA";
$array_movi["NTE"]="GUIA DE DESP.";
$array_movi["AJE"]="AJUST. ENTRADA";
$array_movi["AJS"]="AJUST. SALIDA";
$array_movi["TRE"]="TRANSF. ENTRADA";
$array_movi["TRS"]="TRANSF. SALIDA";
$array_movi["DNT"]="DEV. GUIA DE DESP.";
$array_movi["DCO"]="DEV. FACT. COMPRA";
$array_movi["CSM"]="CONSUMO";
$array_movi["COI"]="CONSUMO INT.";
$array_movi["DCS"]="DEV. CONSUMO";
$array_movi["DCI"]="DEV. CONSUMO INT.";
//MESES
$array_mont=array();
$array_mont[1]="ENERO";
$array_mont[2]="FEBRERO";
$array_mont[3]="MARZO";
$array_mont[4]="ABRIL";
$array_mont[5]="MAYO";
$array_mont[6]="JUNIO";
$array_mont[7]="JULIO";
$array_mont[8]="AGOSTO";
$array_mont[9]="SEPTIEMBRE";
$array_mont[10]="OCTUBRE";
$array_mont[11]="NOVIEMBRE";
$array_mont[12]="DICIEMBRE";
//MESES CON VALORES
$array_mont_cero=array();
$array_mont_cero[1]=0;
$array_mont_cero[2]=0;
$array_mont_cero[3]=0;
$array_mont_cero[4]=0;
$array_mont_cero[5]=0;
$array_mont_cero[6]=0;
$array_mont_cero[7]=0;
$array_mont_cero[8]=0;
$array_mont_cero[9]=0;
$array_mont_cero[10]=0;
$array_mont_cero[11]=0;
$array_mont_cero[12]=0;
//ARREGLOS DE STATUS
$array_cot_all=array('PCO','PEN','PAC','PAT','PCL','APB','PRO','FAC','CAN'); //USADO PARA CONSULTAR LAS ODS (COTIZACIONES VISIBLES EN ODS)
$array_ods=array('PCL','APB','PRO','FAC'); //USADO PARA CONSULTAR LAS ODS (COTIZACIONES VISIBLES EN ODS)
$array_cot_adm=array('PAC'); //COTIZACIONES POR APROB ADMINISTRATIVAS
$array_cot_cli=array('PCL'); //COTIZACIONES POR APROB CLIENTE
$array_cot_ta=array('PAT'); //COTIZACIONES POR APROB TALLER
$array_cot_imp=array('PCL','APB','PRO','CAN'); //USADO PARA REPORTES DE COTIZACIONES
$array_odc_imp=array('PRO','UTI'); //USADO PARA REPORTES DE COTIZACIONES
$array_cot_ods=array('PRO'); //USADO PARA COTIZACIONES EN PLANIFICACION (SOLO LAS PROCESADAS)
$array_cot_fac=array('PRO','FAC'); //USADO PARA COTIZACIONES EN VENTAS/FACTURACION
$array_car_emp=array(1,2); //USADO PARA MOSTRAR LA PLANIFICACION DE ESOS CARGOS
$array_excel_rows=array('codigo','articulo','descripcion'); //GESTIONO QUE LOS CAMPOS SEAN LOS NECESARIOS
$array_cot_all_=array('PCO','PEN','PAC','PAT','PCL','APB','PRO','FAC'); //USADO PARA CONSULTAR LAS COT REALIZADAS
$array_cot_pro_=array('APB','PRO','FAC'); //USADO PARA CONSULTAR LAS COT APROBADAS
//IDENTIFICO CAMPOS NUMERICOS PARA FORMATEAR
$array_numbers=array("mar_ins","mar_rep","mar_stt","gastos","margen","salida","costo_km","costo_prom","monto_total","costou","costot","m_serv","m_rep","m_ins","m_stt","m_tra","m_misc","m_subt","m_desc","m_neto","m_imp","m_bruto");
//TIPOS DE REPUESTAS (ENCUESTA)
$array_type_ques=array();
$array_type_ques["VYF"]="VERDADERO & FALSO";
$array_type_ques["OPS"]="OPCION SENCILLA";
$array_type_ques["OPM"]="OPCIONES MULTIPLES";
$array_type_ques["TX1"]="TEXTO BREVE";
$array_type_ques["TX2"]="TEXTO LARGO";
$array_type_ques["DAT"]="FECHA";
$array_type_ques["TIM"]="HORA";
$array_type_ques["DYT"]="FECHA & HORA";
$array_type_ques["PIC"]="FOTO";

/** Retorna un color segun el Status
* @param status: Estatus
* @param type: Tipo de classe
* @param sec: Si es True uso el Color Secundario (Para los modulos donde existen el mismo STATUS con el MISMO COLOR)
*/
function color_status($status,$type=false,$sec=false){
	$stats_color="";
	if($type){
		$stats_color .= $type."-";
	}
	//light,secondary
	switch ($status) {
		case 'CAN':
			$stats_color .= "danger";
			break;
		case 'APB':
			$stats_color .= "info";
			break;
		case 'PRO':
			$stats_color .= ($sec) ? "info" : "success" ;
			break;
		case 'PAC':
		case 'PAT':
		case 'PEN':
		case 'PCO':
		case 'PCL':
			$stats_color .= "warning";
			break;
		case 'FAC':
		case 'UTI':
			$stats_color .= "success";
			break;
		default:
			$stats_color .= "dark";
			break;
	}
	return $stats_color;
}

/** Envia una Alerta a DIALOG
* @param mensaje: Mensaje a Mostrar
* @param tipo: Tipo de Mensaje
*/
function alerta($mensaje,$tipo){
	if($mensaje){
		$mensaje=strtoupper(addslashes($mensaje));
		echo '<script>dialog(`'.$mensaje.'`,`'.$tipo.'`)</script>';
		exit;
	}
}

/** Evalua si el ARRAY $modulo, trajo data, de ser asi la deja pasar, de lo contrario muestra el mensaje
* @param modulo: Mensaje a Mostrar
*/
function Evaluate_Mod($modulo){
	$tipo=$mensaje="";
	if($modulo["title"]==="SUCCESS"){
		return true;
	}else{
		$tipo = $modulo["title"];
		$mensaje=strtoupper(addslashes($modulo["content"]));
		echo '<script>dialog(`'.$mensaje.'`,`'.$tipo.'`)</script>';
		return false;
	}
}
/** Formateo cifras
* @param num: Cifra a Formatear
* @param dec: Numero de Decimales
*/
function numeros($num,$dec=0){
	$num_fix=number_format($num, $dec, ',', '.');
	return $num_fix;
}
/** Formateo RUTS
* @param _rut: Rut a Formatear
*/
function formatRut($_rut){
    $rutSin=numeros(substr($_rut, 0, -1),0);
    $rutIden=substr($_rut, -1);
    return $rutSin."-".$rutIden;
}
/** Formateo Numeros de Telf
* @param _phone: Numero a Formatear
*/
function formatPhone($_phone){
    $str1 = substr($_phone, -4);
    $str2 = substr($_phone, 1, -4);
    $str3 = substr($_phone, 0, 1);
    $str = $str3." ".$str2." ".$str1;
    return $str;
}
/** Convierte Fecha DD/MM/YYYY a YYYYMMDD
* @param date: date a Formatear
* @param opc: Operacion a realizar, 0/false: nada, 1/true: add, -1: subtrac
* @param inter: Intervalo a modificar
*/
function setDate($datetime,$format=false,$inter=false){
	$d = new DateTime($datetime);
	if($inter){
		$opt = preg_match('/([\-])/', $inter);
		if(empty($opt)){
			$d->add(new DateInterval($inter));
		}else{
			$inter = preg_replace('/([\-])/', '$2', $inter);
			$d->sub(new DateInterval($inter));
		}
	}
	$new_format = ($format) ? $format : "Y-m-d" ;
	return $d->format($new_format);
}
/** Sube una Imagen con caracteristicas
* @param input: Input que contiene la Imagen a Subir
* @param carpeta: Destino donde será alojada la Imagen
* @param ancho_: Ancho de la Imagen final
* @param alto_: Alto de la Imagen Final
* @param name: Posee el Nombre de la Imagen (si existe se elimina)
*/
function SubirImg($input,$carpeta,$ancho_=600, $alto_=600,$name){
	$folder=__DIR__.$carpeta;
	$ext = "jpg";
	$nombre = $name.".".$ext;
	if (file_exists("../..".$carpeta.$nombre)){
		unlink("../..".$carpeta.$nombre);
	}
	$img = Image::make($_FILES[$input]['tmp_name']);
	$img->fit($ancho_, $alto_, function ($constraint) {
	});
	if($img->save($folder.$nombre)){
		return $nombre;
	}else{
		return null;
	}
}
/** Comprueba que existe un fichero para luego Insertarlo
* @param file: Archivo para insetar
*/
function Include_File($file){
	if(is_file($file)){
		ob_start();
		include_once($file);
		return;
	}else{
		throw new \Exception("ERROR AL INCLUIR EL ARCHIVO, NO SE ENCUENTRA EL ARCHIVO O EL DIRECTORIO");
	}
}
/** Al invocar una libreria o algun Sitio fuera del Site arrojo el mensaje con un ALERT
* @param mensaje: Mensaje a Mostrar
*/
function Report_MSJ($mensaje){
	if($mensaje){
		$mensaje=strtoupper(addslashes($mensaje));
		echo "<script>alert('$mensaje')</script>";
		echo "<script>window.close();</script>";
		exit;
	}
}
/** Recibe un archivo de Excel y procesa todas las columnas devolviendo un array con los valores
* @param file: Archivo a Leer
*/
function readExcel($file){
	$spreadsheet = IOFactory::load($file);
	$sheetData = $spreadsheet->getSheet(0)->toArray(null, true, false, true);
	$headings = array_shift($sheetData);
	$row = array();
	array_walk(
		$sheetData,
		function (&$row) use ($headings) {
			$row = array_combine($headings, $row);
		}
	);
	return $sheetData;
}
/** Recibe una Fecha y la convierte a un formato que sea leible para Excel
* @param _date: Fecha a convertir
*/
function date_excel($_date){
	$date = explode ("-", $_date);
	$date_new = "DATE(".$date[2].",".$date[1].",".$date[0].")";
	return $date_new;
}