<?php
$action=(isset($_GET['accion'])?strtolower($_GET['accion']):'');
if($action=="save_new" || $action=="save_edit" || $action=="val_log" || $action == "logout" || $action == "change_status" || $action=="change_pass"){
	session_start();
	include_once("../../../class/class.permission.php");
	include_once("../../../class/functions.php");
	$perm = new permisos;	
	if($action=="val_log"){
		include_once("../../../class/class.permission.php");
		try {
			$perm = new permisos;
			$user = $perm->val_log($_GET['username'],$_GET['pass']);
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
	}elseif($action == "logout"){
		ob_start();
		session_start();
		session_destroy();
		echo "success";
	}elseif($action=="save_new" || $action=="save_edit" || $action=="change_status"){
		$response=array();
		$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
		if($perm_val["title"]<>"SUCCESS"){
			$response['title']="ERROR";
			$response["content"]="ACCESO DENEGADO AL MODULO.";
		}else{
			if(isset($_SESSION["metalsigma_log"])){
				$ins=$perm_val["content"][0]["ins"];
				$upt=$perm_val["content"][0]["upt"];
				extract($_GET, EXTR_PREFIX_ALL, "");
				if($action=="change_status"){
					$resultado=$perm->change_status($_id);
					$mensaje="ESTATUS ACTUALIZADO!";
					if($resultado["title"]=="SUCCESS"){
						$response['title']=$resultado["title"];
						$response["content"]=$mensaje;
					}else{
						$response['title']=$resultado["title"];
						$response["content"]=$resultado["content"];
					}
				}else{
					$datos=$permisos=$almacen=$mod=$mod_usu=$mod_ins=$mod_upt=array();
					$status_ = ($action=="save_edit") ? $_estatus : 1;
					$clave = ($_clave!="") ? md5($_clave) : $_clave2 ;
					$test=$perm->get_($_usuario);
					if($test["title"]=="SUCCESS" && $action=="save_new"){
						$response['title']="ERROR";
						$response["content"]="EL NOMBRE DE USUARIO: <strong>".$_usuario."</strong> NO ESTA DISPONIBLE</strong>";
						echo json_encode($response);
						exit();
					}
					array_push($datos, $clave);
					array_push($datos, $status_);
					array_push($datos, $_cdata);
					array_push($datos, $_nombre);
					if($action=="save_new") { array_push($datos, $_usuario); }
					
					if(!empty($_GET['ch_ver'])){
						foreach ($_GET['ch_ver'] as $key => $value) {
							array_push($mod, $key);
							array_push($mod_usu, $_usuario);
							array_push($mod_ins, (!empty($_GET['ch_ins']) && (array_key_exists($key,$_GET['ch_ins']))) ? 1 : 0);
							array_push($mod_upt, (!empty($_GET['ch_upt']) && (array_key_exists($key,$_GET['ch_upt']))) ? 1 : 0);
						}
					}
					if(!empty($_GET['calmacen'])){
						foreach ($_GET['calmacen'] as $key => $value) {
							array_push($almacen, $_calmacen[$key]);	
						}
					}
					array_push($permisos, $mod);
					array_push($permisos, $mod_ins);
					array_push($permisos, $mod_upt);
					if($action=="save_new") { array_push($permisos, $mod_usu); }
					if($action=="save_edit"){
						if($upt!=1){
							$response['title']="ERROR";
							$response["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
						}else{
							$resultado=$perm->edit_user($_id,$datos,$permisos,$almacen);
						}
					}else{						
						if($ins!=1){
							$response['title']="ERROR";
							$response["content"]="ACCESO DENEGADO: <strong>NO POSEE PERMISO PARA LA ACCION</strong>";
						}else{
							$resultado=$perm->new_user($datos,$permisos,$almacen);
						}
					}
					$mensaje="SIN MENSAJE";
					switch ($action) {
						case "save_new":
							$mensaje="USUARIO CREADO CON EXITO!";
						break;
						case "save_edit":
							$mensaje="DATOS DEL USUARIO ACTUALIZADOS!";
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
			}else{
				$response['title']="INFO";
				$response["content"]=-1;
			}						
		}
	}elseif($action=="change_pass"){
		include_once("../../../class/class.permission.php");
		$perm = new permisos;
		try {
			$perm = new permisos;
			if(isset($_SESSION["metalsigma_log"])){
				$user = $perm->change_pass($_GET['old_pass'],$_GET['new_pass']);
				$response['title']="ERROR";
				switch ($user) {
					case 1:
						$response['title']="SUCCESS";
						$response["content"]=1;
					break;
					case 2:
						$response["content"]="LA CONTRASEÑA ACTUAL ES INVALIDA!";
					break;
					case 3:
						$response["content"]="LA CONTRASEÑA ACTUAL ES INVALIDA!";
					break;
				}
			}else{
				$response['title']="INFO";
				$response["content"]=-1;
			}
		} catch (PDOException $Exception) {
			$response['title']="ERROR";
			$response["content"]=$Exception->getMessage();
		}
	}
	echo json_encode($response);
}else{
	$perm_val = $perm->val_mod($_SESSION['metalsigma_log'],$_GET['submod']);
	$mod=strtolower($_GET['mod']);
	if($perm_val["title"]<>"SUCCESS"){
		alerta("NO POSEES PERMISO PARA ESTE MODULO","ERROR");
	}else{
		include_once("./class/class.clientes.php");
		$clientes = new clientes;
		$modulo = $perm->get_module($_GET['submod']);
		$tpl->newBlock("module");
		if(Evaluate_Mod($modulo)){
			foreach ($modulo["content"] as $key => $value){
				//VARIABLES PARA NAVEGAR
				$var_array_nav=array();
				$var_array_nav["mod"]=$_GET['mod'];
				$var_array_nav["submod"]=$_GET['submod'];
				$var_array_nav["ref"]="FORM_USUARIOS";
				$var_array_nav["subref"]="NONE";
				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}

				//VARIABLES VISUALES
				$tpl->assign("menu_pri",$value['menu']);
				$tpl->assign("menu_sec",$value['modulo']);
				$tpl->assign("menu_ter","NONE");
				$tpl->assign("menu_name",$value['modulo']);
			}
		}
		if($action=="new"){
			$tpl->assign("accion",'save_new');
			$tpl->assign("val","validar");
			$menu=$perm->get_menu("ADMINISTRADOR");
			if(Evaluate_Mod($menu)){
				$menus=$menu["content"];
				$colores=array();
				foreach ($menus as $llave => $datos){
					$tpl->newBlock("modulo_menu");
					foreach ($menus[$llave] as $key => $value){
						$value = ($value=="NONE") ? "MISC" : $value ;
						$tpl->assign($key,$value);
					}
					$color_new="";
					if(empty($colores)){
						$colores=array("primary","warning","info","danger","success","secondary");
					}
					$color_new=array_rand($colores,1);
					$tpl->assign("color",$colores[$color_new]);
					unset($colores[$color_new]);
					$mods=$perm->get_mod("ADMINISTRADOR",$datos["cmenu"],false);
					if(Evaluate_Mod($mods)){
						$modulos=$mods["content"];
						foreach ($modulos as $llave1 => $datos1){
							$tpl->newBlock("modulo_modulo");
							foreach ($modulos[$llave1] as $key1 => $value1){
								$tpl->assign($key1,$value1);
							}
						}
					}
				}
			}
			$ins=$perm_val["content"][0]["ins"];
			if($ins==1){
				$tpl->newBlock("data_save");
				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}
			}else{ $tpl->assign("read",'readonly'); }
		}elseif($action=="edit"){
			$tpl->assign("accion",'save_edit');
			$tpl->assign("id",$_GET['id']);
			$data=$perm->get_($_GET['id']);
			$menu=$perm->get_menu("ADMINISTRADOR");
			$mods_usu=$perm->list_mod_usu($_GET['id']);
			if(Evaluate_Mod($data)){
				$cab=$data["cab"];
				$alm=$data["alm"];
				foreach ($cab as $llave => $datos) {
					$tpl->assign($llave,$datos);
				}
				if(!empty($array_estatus)){
					$tpl->newBlock("st_block");
					foreach ($array_estatus as $llave => $datos){
						$tpl->newBlock("st_det");
						if($llave==$cab['status']){
							$tpl->assign("selected",$selected);
						}
						$tpl->assign("code",$llave);
						$tpl->assign("valor",$datos);
					}
				}
				if(Evaluate_Mod($menu)){
					$menus=$menu["content"];
					$colores=array();
					foreach ($menus as $llave => $datos){
						$tpl->newBlock("modulo_menu");
						foreach ($menus[$llave] as $key => $value){
							$value = ($value=="NONE") ? "MISC" : $value ;
							$tpl->assign($key,$value);
						}
						$color_new="";
						if(empty($colores)){
							$colores=array("primary","warning","info","danger","success","secondary");
						}
						$color_new=array_rand($colores,1);
						$tpl->assign("color",$colores[$color_new]);
						unset($colores[$color_new]);
						$mods=$perm->get_mod("ADMINISTRADOR",$datos["cmenu"],0);
						if(Evaluate_Mod($mods)){
							$modulos=$mods["content"];
							$mod_user = ($mods_usu["title"]=="SUCCESS") ? $mods_usu["content"] : array() ;
							foreach ($modulos as $llave1 => $datos1){
								$tpl->newBlock("modulo_modulo");
								if(!empty($mod_user)){
									foreach ($mod_user as $key1 => $value1){
										if($value1['cmodulo'] == $datos1['cmodulo']){
											$tpl->assign("ch_ver","checked");
											if($value1["ins"]==1){
												$tpl->assign("ch_ins","checked");
											}
											if($value1["upt"]==1){
												$tpl->assign("ch_upt","checked");
											}
										}
									}
								}
								foreach ($modulos[$llave1] as $key1 => $value1){
									$tpl->assign($key1,$value1);
								}
							}
						}
					}
				}
				if(!empty($alm)){
					foreach ($alm as $llave => $datos) {
						$tpl->newBlock("alm_det");
						foreach ($alm[$llave] as $key => $value){
							$tpl->assign($key,$value);
						}
						$actions='<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del" data-menu="'.$var_array_nav["mod"].'" data-mod="'.$var_array_nav["submod"].'" data-ref="'.$var_array_nav["ref"].'" data-subref="'.$var_array_nav["subref"].'"><i class="fas fa-trash-alt"></i></button>';
						$tpl->assign("count",$llave);
						$tpl->assign("actions",$actions);
					}
				}
			}
			$tpl->newBlock("aud_data");
			$tpl->assign("crea_user",$cab['crea_user']);
			$tpl->assign("mod_user",$cab['mod_user']);
			$tpl->assign("crea_date",$cab['crea_date']);
			$tpl->assign("mod_date",$cab['mod_date']);
			$tpl->newBlock("val");

			$upt=$perm_val["content"][0]["upt"];
			if($upt==1){
				$tpl->newBlock("data_save");
				foreach ($var_array_nav as $key_ => $value_) {
					$tpl->assign($key_,$value_);
				}
			}else{ $tpl->assign("read",'readonly'); }
		}
	}
}
?>