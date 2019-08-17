<?php
$menu = $perm->get_menu($_SESSION['metalsigma_log']);
if($menu["title"]==="SUCCESS"){
	foreach ($menu["content"] as $key => $value){
		if($value['cmenu']==0){
			$mod = $perm->get_mod($_SESSION['metalsigma_log'],$value['cmenu'],0);
			foreach ($mod["content"] as $key3 => $value3){
				$tpl->newBlock("modulo_not");
				$tpl->assign("mod_name",$value3['modulo']);
				$tpl->assign("ico_modulo",$value3['mod_icon']);
				$tpl->assign("mod_menu",$value3['menu']);
				$tpl->assign("mod_url",$value3['mod_url']);
			}
		}else{
			$tpl->newBlock("menu_nivel_1");
			$tpl->assign("nom_menu",$value['menu']);
			$tpl->assign("ico_menu",$value['icon']);
			$submenu = $perm->get_submenu($_SESSION['metalsigma_log'],$value['cmenu']);
			if($submenu["title"]==="SUCCESS"){
				foreach ($submenu["content"] as $key1 => $value1){
					$mod = $perm->get_mod($_SESSION['metalsigma_log'],$value['cmenu'],$value1['csubmenu']);
					$class_sub_menu=$data_sub_menu=$data_link_1=$data_link_2="";
					if($value1['csubmenu']==0){
						$class_sub_menu=$data_sub_menu=""; $data_link_1="menu"; $data_link_2="";
						if($mod["title"]==="SUCCESS"){
							foreach ($mod["content"] as $key3 => $value3){
								$tpl->newBlock("modulo");
								$tpl->assign("class_sub_menu",$class_sub_menu);
								$tpl->assign("data_sub_menu",$data_sub_menu);
								$tpl->assign("data_link_1",$data_link_1);
								$tpl->assign("data_link_2",$data_link_2);
								$tpl->assign("mod_name",$value3['modulo']);
								$tpl->assign("ico_modulo",$value3['mod_icon']);
								$tpl->assign("mod_menu",$value3['menu']);
								$tpl->assign("mod_url",$value3['mod_url']);
								
							}
						}
					}else{
						$class_sub_menu="has-arrow";$data_sub_menu='aria-expanded="false"';$data_link_1=""; $data_link_2="menu";
						if($mod["title"]==="SUCCESS"){
							$tpl->newBlock("modulo");
							$tpl->assign("class_sub_menu",$class_sub_menu);
							$tpl->assign("data_sub_menu",$data_sub_menu);
							$tpl->assign("data_link_1",$data_link_1);
							$tpl->assign("mod_name",$value1['submenu']);
							$tpl->assign("ico_modulo",$value1['icon']);

							$tpl->newBlock("menu_nivel_2");
							foreach ($mod["content"] as $key3 => $value3){
								$tpl->newBlock("submodulo");
								$tpl->assign("data_link_2",$data_link_2);
								$tpl->assign("ico_modulo",$value3['mod_icon']);
								$tpl->assign("mod_name",$value3['modulo']);
								$tpl->assign("mod_menu",$value3['menu']);
								$tpl->assign("mod_url",$value3['mod_url']);
							}
						}
					}
				}
			}
		}
	}
}
?>