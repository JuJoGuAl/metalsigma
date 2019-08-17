<?php
//session_start();
include_once("../../class/functions.php");
include_once("../../class/class.permission.php");
include_once("../../class/class.planificacion.php");
include_once("../../class/class.cotizaciones.php");
include_once("../../class/class.bd_connect.php");

$response=array();

$perm = new permisos;
$planificaciones = new planificaciones;
$cotizaciones = new cotizaciones;
$result = connect();
$result = $result["content"];

$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$user = $obj['userName'];
$permiso = $obj['permiso'];
$username = mb_strtoupper($user);
$permiso = "RN";
$username = "ELIO";
/*if(isset($username)){
    session_start();
    $_SESSION['metalsigma_log'] = mb_strtoupper($username);
}

if (!isset($_SESSION['metalsigma_log'])){
	$response['title']="ERROR";
	$response["content"]="ACCESO DENEGADO";
}else{*/
	
	if($permiso == "RN"){ $perm_val["title"]="SUCCESS"; }

	if($perm_val["title"]<>"SUCCESS"){
		$response['title']="ERROR";
		$response["content"]="ACCESO DENEGADO! NO POSEE PERMISO PARA EL MODULO";
	}else{

		$accion=(isset($_REQUEST['accion'])?$_REQUEST['accion']:'');
		//ACCIONES
		if($accion=="val_log"){
		    
    		$json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            $pass = $obj["pass"];
    		try {
    			//$user = $perm->val_log($_SESSION['metalsigma_log'],$pass);
                $user = $perm->val_log($username,$pass);
    			$response['title']="ERROR";
    			switch ($user) {
    				case 1:
    					$response['title']="SUCCESS";
    					$response["content"]=1;
    				break;
    				case 2:
    					$response["content"]="USUARIO INVALIDO!";
    				break;
    				case 3:
    					$response["content"]="CLAVE INVALIDA!";
    				break;
    				case 4:
    					$response["content"]="USUARIO SIN PRIVILEGIOS";
    				break;
    				case 5:
    					$response["content"]="USUARIO INACTIVO";
    				break;
    			}
    		} catch (PDOException $Exception) {
    			$response['title']="ERROR";
    			$response["content"]=$Exception->getMessage();
    		}
	    }else if($accion=="get_trabajos"){
	        
	        $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            $myDate = $obj['date'];
            $myDate = "2019-07-01";

            $data_=$perm->get_($username);
            $cab = $data_["cab"];
            $fecha = setDate($myDate,"Y-m-d");
	        $planes = $planificaciones->get_plan_worker($cab["ctrabajador"],false,false,$fecha);
            if($planes["title"]=="SUCCESS"){
                $trabajos=$servicios=array();
                foreach ($planes["content"] as $key1 => $value1){
                        $minutes2   =   (12 * 60.0 + 0 * 1.0);
                        $time2      =   explode(':', $planes["content"][$key1]["inicio"]);
                        $minutes1   =   ($time2[0] * 60.0 + $time2[1] * 1.0);
                        $dif_hora   =   ($minutes2 - $minutes1);
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
                    $data=$trabajos;
                    $response["title"]="SUCCESS";
                    $response["content"] = $data;
            }else{
                $response["title"]="ERROR";
                $response["content"]="NO EXISTE INFORMACION PARA MOSTRAR";  
            }
			
		}else if($accion=="get_hjob"){
            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            $date = $obj["date"]; //Saber en que fecha el usuario esta iniciando o finalizando su trabajo
            $codigo = $obj["codigo"];
            //Traer horas de trabajo
            $checkSQL = $result->query("SELECT hjob FROM rn_geomap WHERE cplanificacion_det='$codigo'");
            $check = $checkSQL->fetch(PDO::FETCH_ASSOC);

            if($check >= 1){
                $response["title"] = "SUCCESS";
                $response["content"] = $check;
            }else{
                $response["title"] = "ERROR";
                $response["content"] = 0;
            }

        }else if($accion=="init_job"){
            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            $description=$obj["description"];
            $longitud=$obj["longitud"];
            $latitud=$obj["latitud"];
            $maquina=$obj["maquina"];
            $hini=$obj["hini"];
            $hfin=$obj["hfin"];
            $hjob=$obj["hjob"];
            $codigo=$obj["codigo"];
            $date=$obj["date"];
            $run=$obj["run"];
            $run = $run == true ? 1 : 0;

            //Si el usuario no existe
            $checkSQL = $result->query("SELECT *FROM rn_geomap WHERE cplanificacion_det='$codigo'");
            $check = $checkSQL->fetch(PDO::FETCH_ASSOC);

            if($check >= 1){
                $sql = "UPDATE rn_geomap SET username=:username,description=:description,longitud=:longitud,latitud=:latitud,
                     maquina=:maquina,hini=:hini,hfin=:hfin,hjob=:hjob,cplanificacion_det=:codigo,date_job=:myDate,run=:run 
                     WHERE cplanificacion_det='$codigo'";
            }else{ 
                $sql = "INSERT INTO rn_geomap(username,description,longitud,latitud,maquina,hini,hfin,hjob,cplanificacion_det,date_job,run) 
                        VALUES (:username,:description,:longitud,:latitud,:maquina,:hini,:hfin,:hjob,:codigo,:myDate,:run)";
            }
            $query = $result->prepare($sql);
            $res = $query->execute([
            "username" => $username,
            "description" => $description,
            "longitud" => $longitud,
            "latitud" => $latitud,
            "maquina" => $maquina,
            "hini" => $hini,
            "hfin" => $hfin,
            "hjob" => $hjob,
            "codigo" => $codigo,
            "myDate" => $date,
            "run" => $run
            ]);
            if($res){
                $response["title"] = "SUCCESS";
                $response["content"] = "Trabajo iniciado";
            }else{
                $response["title"] = "ERROR";
                $response["content"] = "Error. Verifique sus datos";
            } 
        }
	}
//}
//if(isset($_GET["userEmail"])){ unset($_SESSION["metalsigma_log"]); }
echo json_encode($response);

?>