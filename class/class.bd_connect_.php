<?php
// Separo la conexion de la BD de la CLASSE general, para poder cambiar los parametros sin mucho esfuerzo
function connect(){
	$bd_host =	"-";
	$bd_user =	"-";
	$bd_pass =	"-";
	$bd_dtb =	"-";
	$result=array();
	try{
		//Intento una conección,con los parametros
		$conn = new PDO("mysql:host=$bd_host;dbname=$bd_dtb;charset=utf8", $bd_user, $bd_pass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result["title"]="SUCCESS";
		$result["content"]=$conn;
	}catch(PDOException $e){
		$result["title"]="ERROR";
		$result["content"]=mb_strtoupper(utf8_encode($e->getMessage()), 'UTF-8');
	}
	return $result;
}
?>