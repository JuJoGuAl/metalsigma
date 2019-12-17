<?php
session_start();
include_once("./class/class.TemplatePower.php");
include_once("./class/functions.php");
if(!isset($_SESSION['metalsigma_log'])){	
	$tpl = new TemplatePower("./views/login.tpl");
}else{
	$tpl = new TemplatePower("./views/body.tpl");
	$error="./views/mod_404.tpl";
	$tpl->assignInclude("profile","./views/profile.tpl");
	$tpl->assignInclude("nav", "./views/nav.tpl");
}
$tpl->prepare();
//Asigno el Timestamp de los archivos que mas se editan
$file="./assets/custom/functions.js";
$filemtime = filemtime($file);
$tpl->assign("functions", $file."?".$filemtime);
$file="./assets/custom/custom.min.js";
$filemtime = filemtime($file);
$tpl->assign("custom", $file."?".$filemtime);
$file="./images/logo-icon.png";
$filemtime = filemtime($file);
$tpl->assign("logo_icon", $file."?".$filemtime);
$file="./images/logo-text.png";
$filemtime = filemtime($file);
$tpl->assign("logo_text", $file."?".$filemtime);
$file="./images/logo-light-text.png";
$filemtime = filemtime($file);
$tpl->assign("logo_text_light", $file."?".$filemtime);
$file="./assets/custom/style.min.css";
$filemtime = filemtime($file);
$tpl->assign("style", $file."?".$filemtime);
$file="./images/favicon.png";
$filemtime = filemtime($file);
$tpl->assign("ico", $file."?".$filemtime);

if(isset($_SESSION['metalsigma_log'])){
	//
	include_once("./class/class.cotizaciones.php");
	include_once("./class/class.inventario.php");
	include_once("./class/class.compras.php");

	$cot = new cotizaciones();
	$com = new compras();
	$inv = new inventario();

	$mensaje='{';

	$cot_count=$cot->list_status();
	if($cot_count["title"]=="SUCCESS"){
		$mensaje.='"cot":[';
		foreach ($cot_count["content"] as $key => $value) {
			$mensaje.="{";
			foreach ($value as $key1 => $value1) {
				$mensaje.='"'.$key1.'":"'.$value1.'",';
			}
			$mensaje = substr($mensaje,0,-1);
			$mensaje.="},";
		}
		$mensaje = substr($mensaje,0,-1);
		$mensaje.="],";
	}
	$inv_count=$inv->list_status();
	if($inv_count["title"]=="SUCCESS"){
		$mensaje.='"inv":[';
		foreach ($inv_count["content"] as $key => $value) {
			$mensaje.="{";
			foreach ($value as $key1 => $value1) {
				$mensaje.='"'.$key1.'":"'.$value1.'",';
			}
			$mensaje = substr($mensaje,0,-1);
			$mensaje.="},";
		}
		$mensaje = substr($mensaje,0,-1);
		$mensaje.="],";
	}
	$com_count=$com->list_status();
	if($com_count["title"]=="SUCCESS"){
		$mensaje.='"com":[';
		foreach ($com_count["content"] as $key => $value) {
			$mensaje.="{";
			foreach ($value as $key1 => $value1) {
				$mensaje.='"'.$key1.'":"'.$value1.'",';
			}
			$mensaje = substr($mensaje,0,-1);
			$mensaje.="},";
		}
		$mensaje = substr($mensaje,0,-1);
		$mensaje.="],";
	}

	$mensaje = substr($mensaje,0,-1);
	$mensaje.="}";
	$tpl->assign("json_mensaje",$mensaje);
	
	$tpl->assign("nom_emp","HeavyTech SpA");
	$data = $perm->get_($_SESSION['metalsigma_log']);
	$perfil = $data["cab"];
	$ruta = "./images/users/";
	$foto="";
	$image_temp = str_pad($perfil["ente"], 10, "0", STR_PAD_LEFT).".jpg";

	if (!file_exists($ruta.$image_temp)){
		$foto="avatar.jpg";
	}else{
		$foto=$image_temp;
	}
	$filemtime = filemtime($ruta.$foto);
	$tpl->assign("foto", $foto."?".$filemtime);
	$tpl->assign("nombre",$perfil["nombre"]);
	$tpl->assign("cargo",$perfil["cargo"]);
	include_once('./modules/controllers/menu.php');
}
$tpl->printToScreen();
if(isset($_GET["error"])){
		alerta("SU SESION HA EXPIRADO, DEBE INICIAR SESION NUEVAMENTE","INFO");
	}
?>