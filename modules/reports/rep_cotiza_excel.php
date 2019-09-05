<?php
require '../../class/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Color;

session_start();
include_once("../../class/class.permission.php");
include_once("../../class/class.cotizaciones.php");
include_once("../../class/class.planificacion.php");
include_once("../../class/functions.php");

$data_class = new cotizaciones;
$planes = new planificaciones;

$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');

$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
if($perm_val["title"]<>"SUCCESS"){
	Report_MSJ("NO POSEES PERMISO PARA ESTE MODULO");
}else{
	$status_ = ($_GET["estatus"]<>-1) ? array($_GET["estatus"]) : false ;
	$cliente_ = ($_GET["ccliente"]>=0) ? $_GET["ccliente"] : false ;
	$inicio_ = ($_GET["finicio"]!="") ? setDate($_GET["finicio"],"Y-m-d") : false ;
	$fin_ = ($_GET["ffin"]!="") ? setDate($_GET["ffin"],"Y-m-d") : false ;
	$cotiza=$data_class->list_sub(false,$status_,false,$cliente_,$inicio_,$fin_);
	if($cotiza["title"]<>"SUCCESS"){
		Report_MSJ("NO EXISTE INFORMACION PARA MOSTRAR");
	}else{
		try {
			$spreadsheet = new Spreadsheet();
			$spreadsheet
				->getProperties()
				->setCreator($_SESSION['metalsigma_log'])
				->setLastModifiedBy($_SESSION['metalsigma_log'])
				->setTitle('COTIZACIONES')
				->setDescription('LISTADO DE COTIZACIONES');
			$spreadsheet->getDefaultStyle()->getFont()
					->setName('Arial')
					->setSize(10);

			$drawing = new Drawing();
			$drawing->setName('Logo');
			$drawing->setDescription('Logo');
			$drawing->setPath('../../images/logo_report.png');
			$drawing->setHeight(56);
			$drawing->setCoordinates('B2');
			$drawing->setWorksheet($spreadsheet->getActiveSheet(0));

			$spreadsheet->setActiveSheetIndex(0)->mergeCells('D2:G4');
			$spreadsheet->setActiveSheetIndex(0)->setCellValue('D2', 'LISTADO DE COTIZACIONES');
			$spreadsheet->getActiveSheet(0)->getStyle('D2')->getFont()->setSize(18);
			$spreadsheet->setActiveSheetIndex(0)->getStyle('D2')->getFont()->setBold(true);
			$spreadsheet->setActiveSheetIndex(0)->getStyle('D2')->getAlignment()->setWrapText(true);
			$spreadsheet->setActiveSheetIndex(0)->getStyle('D2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$spreadsheet->setActiveSheetIndex(0)->getStyle('D2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			// ENCABEZADO
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('B8', '# COT')
				->setCellValue('C8', '# ODS')
				->setCellValue('D8', 'TIPO DE COT')
				->setCellValue('E8', 'CLIENTE')
				->setCellValue('F8', 'EQUIPO')
				->setCellValue('G8', 'ASESOR COMERCIAL')
				->setCellValue('H8', 'COORDINADOR TECNICO')
				->setCellValue('I8', 'FECHA INICIO SERVICIO')
				->setCellValue('J8', 'FECHA TERMINO SERVICIO')
				->setCellValue('K8', 'ESTADO ORDEN')				
				->setCellValue('L8', '# FACTURA')
				->setCellValue('M8', 'FECHA FAC')
				->setCellValue('N8', 'VALOR NETO')
				->setCellValue('O8', 'VALOR BRUTO')
				->setCellValue('P8', 'PAGO')
				->setCellValue('Q8', 'FECHA PAGO')
				->setCellValue('R8', 'MARGEN')
				;
			$row=8;//CONTADOR DE DONDE EMPIEZO A COLOCAR LA DATA
			//CONTENIDO
			foreach ($cotiza["content"] as $llave => $datos) {
				$planificacion=$planes->get_plan_cot($datos["codigo"]);
				$tecnico="N/A";
				if($planificacion["title"]=="SUCCESS"){
					$tecnico=$planificacion["det"][0]["data"];
					//$tecnico=$planificacion["cab"]["codigo_cabecera"];
				}
				$row++;
				$spreadsheet->setActiveSheetIndex(0)
					//->setCellValue('A'.$row, $datos["codigo"])
					->setCellValue('B'.$row, $datos["cot_full"])
					->setCellValue('C'.$row, $datos["ods_full"])
					->setCellValue('D'.$row, $datos["tipo"])
					->setCellValue('E'.$row, $datos["data"])
					->setCellValue('F'.$row, $datos["maquina"]." ".$datos["marca"]." ".$datos["modelo"]." S/N: ".$datos["serial"])
					->setCellValue('G'.$row, $datos["crea_user"])
					->setCellValue('H'.$row, $tecnico)
					->setCellValue('I'.$row, ($datos["llegada"]=="00-00-0000") ? "-" : "=".date_excel($datos["llegada"]))
					->setCellValue('J'.$row, ($datos["retiro"]=="00-00-0000") ? "-" : "=".date_excel($datos["retiro"]))
					->setCellValue('K'.$row, $array_status[$datos["status"]])
					->setCellValue('L'.$row, $datos["cfactura"])				
					->setCellValue('M'.$row, ($datos["fecha_fac"]=="N/A") ? "-" : "=".date_excel($datos["fecha_fac"]))
					->setCellValue('N'.$row, $datos["m_neto"])
					->setCellValue('O'.$row, $datos["m_bruto"])
					->setCellValue('P'.$row, "")
					->setCellValue('Q'.$row, "")
					->setCellValue('R'.$row, "")
					;
			}
			//FORMATOS/ESTILOS
			$spreadsheet->getActiveSheet(0)->getStyle('B8:R8')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB('FFC000');
			$spreadsheet->setActiveSheetIndex(0)->getStyle('B8:R8')->getFont()->setBold(true);
			$spreadsheet->setActiveSheetIndex(0)->getStyle('B8:R8')->getAlignment()->setWrapText(true);
			$spreadsheet->setActiveSheetIndex(0)->getStyle('B8:R8')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$spreadsheet->setActiveSheetIndex(0)->getStyle('B8:R8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(13);
			$spreadsheet->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(13);
			$celda_auto=array('I','J','K','L','M','N','O','P','Q','R');
			foreach($celda_auto as $columnID){
				$spreadsheet->setActiveSheetIndex(0)->getColumnDimension($columnID)->setWidth(15);
			}
			$celda_auto=array('D','E','F','G','H','K');
			foreach($celda_auto as $columnID){
				$spreadsheet->setActiveSheetIndex(0)->getColumnDimension($columnID)->setAutoSize(true);
			}
			$spreadsheet->setActiveSheetIndex(0)
					->getStyle('M9:R'.$row)
					->getNumberFormat()
					->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED3);
			$spreadsheet->setActiveSheetIndex(0)
					->getStyle('I9:J'.$row)
					->getNumberFormat()
					->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYYYY);
			$spreadsheet->setActiveSheetIndex(0)
					->getStyle('M9:M'.$row)
					->getNumberFormat()
					->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYYYY);
			$spreadsheet->setActiveSheetIndex(0)
					->getStyle('Q9:Q'.$row)
					->getNumberFormat()
					->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYYYY);
			// RENOMBRO LA HOJA
			$spreadsheet->getActiveSheet()->setTitle('PROGRAMACION');
			$spreadsheet->setActiveSheetIndex(0);
			//NOMBRE DEL DOCUMENTO
			$nombreDelDocumento = "CONTROL DE ODS ".date('d-m-Y').".xlsx";

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
			header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header('Pragma: public'); // HTTP/1.0
			 
			$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
			$writer->save('php://output');
			exit;
		}catch (Exception $e){
			$mensaje=strtoupper($e->getMessage());
			Report_MSJ($mensaje);
		}		
	}
}
?>