<?php
session_start();
include_once("./class/functions.php");
if(isset($_SESSION["metalsigma_log"])){

	$almacenes = array("-1");
	$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
	if(!empty($perm_val["content"][0]["alm"])){
		foreach ($perm_val["content"][0]["alm"] as $key => $value) {
			$almacenes[] .= $perm_val["content"][0]["alm"][$key]["calmacen"];
		}
	}

	include_once("./class/class.TemplatePower.php");	
	$mod=strtolower($_GET['mod']);
	$submod=strtolower($_GET['submod']);
	$ref=strtolower($_GET['ref']);
	$subref=strtolower($_GET['subref']);
	$accion=strtolower($_GET['accion']);
	if($_GET['accion']=="MODAL"){
		$_GET['accion']="NEW";
		$_GET['accion2']="MODAL";
	}
	$modulo = ($_GET['ref']!="NONE") ? $ref : $submod ;
	$modulo = ($_GET['subref']!="NONE") ? $subref : $modulo ;
	$file_tpl="./modules/views/".$mod."/".$modulo.".tpl";
	$file_php="./modules/controllers/".$mod."/".$modulo.".php";
	//echo $file_tpl;
	$error="./views/page_404.tpl";
	//RASTREO SI EXISTE EL TPL, DE NO INSERTO EL ERROR
	if (file_exists($file_tpl)) {
		$tpl = new TemplatePower($file_tpl);
	} else {
		$tpl = new TemplatePower($error);
	}
	$tpl->prepare();
	//SI EXISTE EL CONTROLADOR DE LA VISTA LO INSERTO
	if (file_exists($file_php)) {
		include($file_php);
	}
	$tpl->printToScreen();
}else{
	echo 0;
}

?>