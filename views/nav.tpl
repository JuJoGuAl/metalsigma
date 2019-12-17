<aside class="material left-sidebar">
  <div class="scroll-sidebar">
      <nav class="sidebar-nav">
          <ul id="sidebarnav">
              <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="./" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">INICIO</span></a></li>
              <!-- START BLOCK : modulo_not -->
              <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link menu" href="javascript:void(0)" aria-expanded="false" data-menu="{mod_menu}" data-mod="{mod_url}" data-acc="MODULO"><i class="{ico_modulo}"></i><span class="hide-menu">{mod_name}</span></a></li>
              <!-- END BLOCK : modulo_not -->
              <!-- START BLOCK : menu_nivel_1 -->
              <li class="sidebar-item first-parent"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="{ico_menu}"></i><span class="hide-menu">{nom_menu}</span></a>
                  <ul aria-expanded="false" class="collapse first-level">
                      <!-- START BLOCK : modulo -->
                      <li class="sidebar-item {class_sub_li}"><a href="javascript:void(0)" class="{class_sub_menu} sidebar-link {data_link_1}" data-menu="{mod_menu}" data-mod="{mod_url}" data-acc="MODULO" {data_sub_menu}><i class="{ico_modulo}"></i><span class="hide-menu"> {mod_name}</span></a>
                        <!-- START BLOCK : menu_nivel_2 -->
                        <ul aria-expanded="false" class="collapse second-level">
                          <!-- START BLOCK : submodulo -->
                          <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link {data_link_2}" data-menu="{mod_menu}" data-mod="{mod_url}" data-acc="MODULO"><i class="{ico_modulo}"></i><span class="hide-menu"> {mod_name}</span></a></li>
                          <!-- END BLOCK : submodulo -->
                        </ul>
                        <!-- END BLOCK : menu_nivel_2 -->
                      </li>
                      <!-- END BLOCK : modulo -->
                  </ul>
              </li>
              <!-- END BLOCK : menu_nivel_1 -->
          </ul>
      </nav>
  </div>
</aside>