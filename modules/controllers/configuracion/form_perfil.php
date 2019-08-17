<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new"){
	include_once("../../../class/functions.php");
	include_once("../../../class/class.personas.php");
	$personas = new personas;
	session_start();
	$response=array();
	if(isset($_SESSION["wellfit_user"])){
		extract($_GET, EXTR_PREFIX_ALL, "");
		$persona=array();

		array_push($persona, $_rut);
		array_push($persona, $_pass);
		array_push($persona, $_nombre);
		array_push($persona, "");
		array_push($persona, $_nac);
		array_push($persona, $_sex);
		array_push($persona, setDate($_fecha));
		array_push($persona, $_direccion);
		array_push($persona, $_tel1);
		array_push($persona, $_tel2);
		array_push($persona, $_estado);
		array_push($persona, $_comuna);
		array_push($persona, $_email);

		$resultado=$personas->edit_persona($_id,$persona);	
	
		if($resultado["title"]=="SUCCESS"){
			$response['title']="SUCCESS";		
		}else{
			$response['title']=$resultado["title"];
			$response["content"]=$resultado["content"];
		}
	}else{
		$response['title']="INFO";
		$response["content"]=-1;
	}
	echo json_encode($response);
}else{
	include_once("./class/class.trabajadores.php");
	include_once("./class/class.zonas.php");
	include_once("./class/class.permission.php");;
	$personas = new trabajadores;
	$permisos = new permisos;
	$zonas = new zonas;
	$tpl->newBlock("module");
	//VARIABLES PARA NAVEGAR
	$var_array_nav=array();
	$var_array_nav["mod"]=$_GET['mod'];
	$var_array_nav["submod"]=$_GET['submod'];
	$var_array_nav["ref"]="FORM_PERFIL";
	$var_array_nav["subref"]="NONE";
	foreach ($var_array_nav as $key_ => $value_) {
		$tpl->assign($key_,$value_);
	}
	//VARIABLES VISUALES
	$mod = ($_GET['mod']=="NONE") ? "HOME" : $_GET['mod'] ;
	$tpl->assign("menu_pri",$mod);
	$tpl->assign("menu_sec","PERFIL");
	$tpl->assign("menu_name","MI PERFIL");
	$data_=$permisos->get_($_SESSION['metalsigma_log']);
	$ctrabajador = $data_["cab"]["ctrabajador"];
	if($_SESSION['metalsigma_log']=="ADMINISTRADOR"){
		echo "<script>dialog('EL ADMINISTRADOR DEL SISTEMA NO POSEE PERFIL EDITABLE','ERROR')</script>";
	}elseif($ctrabajador==0){
		echo "<script>dialog('EL USUARIO NO POSEE PERFIL ASOCIADO!','ERROR')</script>";
	}else{
		$data=$personas->get_trabajador($ctrabajador);
		if($data["title"]=="SUCCESS"){
			$cab=$data["content"];
			foreach ($cab as $llave => $datos) {
				$tpl->assign($llave,$datos);
			}
			$foto = str_pad($cab["ente"], 10, "0", STR_PAD_LEFT).".jpg";
			if(!file_exists("./images/users/".$foto)){
				$foto="avatar.jpg";
			}
			$filemtime = filemtime("./images/users/".$foto);
			$tpl->assign("foto", $foto."?".$filemtime);
			$telefono = ($cab['tel_fijo']=="") ? "+".$cab['cod_pais']." ".$cab['tel_movil'] : "+".$cab['cod_pais']." (".$cab['tel_fijo']." / ".$cab['tel_movil'].")" ;
			$tpl->assign("telefonos",$telefono);
			$pasaporte = ($cab['code2']=="0" || $cab['code2']=="") ? "-" : $cab['code2'] ;
			$tpl->assign("pasaporte",$pasaporte);
		}
	}
}
?>