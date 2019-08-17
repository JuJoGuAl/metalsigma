<?php
require '../../class/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

session_start();
include_once("../../class/class.permission.php");
include_once("../../class/class.cotizaciones.php");
include_once("../../class/functions.php");

$data_class = new cotizaciones;
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="imp"){
	$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
	if($perm_val["title"]<>"SUCCESS"){
		Report_MSJ("NO POSEES PERMISO PARA ESTE MODULO");
	}else{
		$cotiza=$data_class->get_sub($_GET["code"],true);
		if($cotiza["title"]<>"SUCCESS"){
			Report_MSJ("TRANSACCION: ".$_GET['code']." NO ENCONTRADA!");
		}elseif(in_array($cotiza["cab"]["status"], $array_cot_imp)!=1){
			Report_MSJ("LA TRANSACCION NO PUEDE SER MOSTRADA");
		}else{
			try {
				$datos_origen=$data_class->get_all($cotiza["cab"]["origen"]);
				$html2pdf = new Html2Pdf('P', 'LETTER', 'EN', true, 'UTF-8', array(0, 0, 0, 0));
				$html2pdf->pdf->SetDisplayMode('fullpage');
				ob_start();
				$titulo="<h3>COTIZACION DE SERVICIOS</h3>";
				$ntran="COTIZACION N°";
				$ftran=date("d-m-Y");
				$dtran=$_GET['code'];
				Include_File("./html/rep_cot_sub.php");
				$content = ob_get_clean();
				$html2pdf->writeHTML($content);
				$html2pdf->output('REP_COTIZACION_SUB_.pdf');
			}catch(Exception $e){
				Report_MSJ($e->getMessage());
				exit;
			}
		}
	}
}
?>