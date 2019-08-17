<!-- START BLOCK : module -->
</script>
<div class="page-breadcrumb bg-white">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
            <h5 class="font-medium text-uppercase mb-0">{menu_name}</h5>
        </div>
        <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
            <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                <ol class="breadcrumb mb-0 justify-content-end p-0 bg-white">
                    <li class="breadcrumb-item"><a class="menu" href="javascript:void(0)" data-menu="{mod}" data-mod="{submod}" data-acc="MODULO">{menu_pri}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{menu_sec}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="page-content container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="material-card card">
        <form role="form" name="form_" id="form_" enctype="multipart/form-data">
          <div class="card-body">
            <div class="d-flex no-block align-items-center"><h4 class="card-title">{mod_name}</h4></div>
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab_1" role="tab"><span class="hidden-xs-down">CUENTA</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_2" role="tab"><span class="hidden-xs-down">PERMISOS</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_3" role="tab"><span class="hidden-xs-down">ALMACEN</span></a> </li>
            </ul>
            <div class="tab-content tabcontent-border">
              <div class="tab-pane p-4 active" id="tab_1" role="tabpanel">
                <div class="row">
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label for="usuario" class="control-label col-form-label">USUARIO</label>
                      <input type="text" class="form-control validar ctrl" id="usuario" name="usuario" maxlength="50" value="{codigo}" {read} autofocus autocomplete="off">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label for="persona" class="control-label col-form-label">TRABAJADOR</label>
                      <div class="input-group">
                        <input type="text" class="form-control ctrl" id="persona" name="persona" placeholder="SELECCIONE UN TRABAJADOR PARA EL USUARIO" value="{code}" disabled> 
                        <input type="hidden" id="cdata" name="cdata" value="{ctrabajador}">
                        <div class="input-group-append"><button class="btn btn-outline-secondary" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="search_trab3"><span class="fa fa-search"></button></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label for="clave" class="control-label col-form-label">CONTRASEÑA</label>
                      <input type="password" class="form-control {val}" id="clave" name="clave" maxlength="50">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label for="nombre" class="control-label col-form-label">NOMBRE</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" value="{nombre}" maxlength="50">
                    </div>
                  </div>
                  <!-- START BLOCK : st_block -->
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label for="estatus">ESTATUS</label>
                      <select class="form-control validar list" id="estatus" name="estatus">
                        <option value="-1">SELECCIONE...</option>
                        <!-- START BLOCK : st_det -->
                        <option value="{code}" {selected}>{valor}</option>
                        <!-- END BLOCK : st_det -->
                      </select>
                    </div>
                  </div>
                  <!-- END BLOCK : st_block -->
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_2" role="tabpanel">
                <br>
                <div class="row">
                  <!-- START BLOCK : modulo_menu -->
                  <div class="col-lg-4 col-md-6">
                    <div class="material-card card scroll">
                      <div class="p-1" style="background-color: var(--{color})">
                        <div class="text-center text-white">
                          <p class="my-1"><i class="{icon}"></i> {menu}</p>
                        </div>
                      </div>
                      <div class="table-responsive border-top manage-table px-2 py-1">
                        <table class="table no-wrap">
                          <thead style="font-size: small;">
                            <tr>
                              <th scope="col" class="border-0">MODULO</th>
                              <th scope="col" class="border-0">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input allVer" id="av_{cmenu}">
                                  <label class="custom-control-label" for="av_{cmenu}">VER</label>
                                </div>
                              </th>
                              <th scope="col" class="border-0">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input allIns" id="ai_{cmenu}">
                                  <label class="custom-control-label" for="ai_{cmenu}">CRE</label>
                                </div>
                              </th>
                              <th scope="col" class="border-0">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input allUpt" id="au_{cmenu}">
                                  <label class="custom-control-label" for="au_{cmenu}">ACT</label>
                                </div>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- START BLOCK : modulo_modulo -->
                            <tr>
                              <td class="h6"> 
                                <i class="{mod_icon}"></i> {modulo}
                              </td>
                              <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input ver" name="ch_ver[{cmodulo}]" id="cv_{cmodulo}" {ch_ver}>
                                  <label class="custom-control-label" for="cv_{cmodulo}">&nbsp;</label>
                                </div>
                              </td>
                              <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input ins" name="ch_ins[{cmodulo}]" id="ci_{cmodulo}" {ch_ins}>
                                  <label class="custom-control-label" for="ci_{cmodulo}">&nbsp;</label>
                                </div>
                              </td>
                              <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input upt" name="ch_upt[{cmodulo}]" id="cu_{cmodulo}" {ch_upt}>
                                  <label class="custom-control-label" for="cu_{cmodulo}">&nbsp;</label>
                                </div>
                              </td>
                            </tr>
                            <!-- END BLOCK : modulo_modulo -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>                  
                  <!-- END BLOCK : modulo_menu -->
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_3" role="tabpanel">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover" id="table_alm_user">
                        <thead>
                          <tr>
                            <th>CODIGO</th>
                            <th>ALMACEN</th>                            
                            <th>OPCION</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- START BLOCK : alm_det -->
                          <tr>
                            <td>
                              <input name="calmacen[]" id="calmacen[{count}]" type="hidden" class="hidden" value="{calmacen}">
                              {calmacen}
                            </td>
                            <td>{almacen}</td>                            
                            <td>{actions}</td>
                          </tr>
                          <!-- END BLOCK : alm_det -->
                        </tbody>
                      </table>
                      <div class="button-group">
                        <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="search_almacen_user" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span> AGREGAR</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <!-- START BLOCK : aud_data -->
          <div class="card-body">
            <div class="row" style="font-size: 12px; text-align: justify;">
              <div class="col-sm-3"><strong>CREADO POR: </strong>{crea_user}</div>
              <div class="col-sm-3"><strong>FECHA: </strong>{crea_date}</div>
              <div class="col-sm-3"><strong>MODIFICADO POR: </strong>{mod_user}</div>
              <div class="col-sm-3"><strong>FECHA: </strong>{mod_date}</div>
            </div>
          </div>
          <hr>
          <!-- END BLOCK : aud_data -->
          <div class="card-body">
            <div class="action-form">
              <div class="form-group mb-0 text-center">
                <input type="hidden" id="accion" name="accion" value="{accion}">
                <input type="hidden" id="id" name="id" value="{codigo}">
                <input type="hidden" id="clave2" name="clave2" value="{clave}">
                <!-- START BLOCK : data_save -->
                <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="SAVE" data-id="0"><span class="btn-label"><i class="fas fa-save"></i></span> GUARDAR</button>
                <!-- END BLOCK : data_save -->
                <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="CLOSE" data-id="0"><span class="btn-label"><i class="fas fa-sign-out-alt"></i></span> CERRAR</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  jQuery('button').on('click', function(){
    submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
    if(acc=="search_trab3"){
      let non_det = new Array();
      modal_search("SELECCIONE UNA PERSONA PARA ASIGNARLE UN USUARIO",'accion='+acc+'&mod='+submod+'&sede='+jQuery("#csede").val()+'&not='+JSON.stringify(non_det),'POST',false,false);
    }else if(acc=="SAVE"){
      SendForm(mod,submod,ref,subref,"#form_",false);
    }else if(acc=="search_almacen_user"){
      let non_det = new Array();
      jQuery('#table_alm_user tbody tr td input[id^="calmacen"]').each(function(row, tr){
        non_det.push(jQuery(this).val());
      });
      modal_search("SELECCIONE UN ALMACEN",'accion='+acc+'&mod='+submod+'&not='+JSON.stringify(non_det),'POST',false,false);
    }
  });
  jQuery(document).on('change', '.allVer, .allIns, .allUpt', function(){
    var checkbox = jQuery(this);
    var tipoCheck = checkbox.hasClass('allVer') ? '.ver' : checkbox.hasClass('allIns') ? '.ins' : checkbox.hasClass('allUpt') ? '.upt' : 'error' ;
    if(jQuery(this).is(':checked')){
      checkbox.parents('table').find('tbody '+tipoCheck).prop('checked', true);
    }else{
      checkbox.parents('table').find('tbody '+tipoCheck).prop('checked', false);
    }
  });

  jQuery(document).on('change','.ver, .ins, .upt', function(){
    var tipo = jQuery(this).hasClass('ver') ? '.ver' : jQuery(this).hasClass('ins') ? '.ins' : jQuery(this).hasClass('upt') ? '.upt' : 'error' ;
    var all = jQuery(this).hasClass('ver') ? '.allVer' : jQuery(this).hasClass('ins') ? '.allIns' : jQuery(this).hasClass('upt') ? '.allUpt' : 'error' ;
    var element = jQuery(this), valido=true;
    element.parents('tbody').find(tipo).each(function(){
      valido=valido&&jQuery(this).is(':checked');
    });
    element.parents('table').find(all).prop('checked',valido);
    valido ? element.parents('table').find(all).trigger('change') : '';
  });

  jQuery(document).on('change','.allVer, .ver',function(){
    let valido=true;
    (jQuery(this).is(':checked')) ? valido=false : valido=true;
    if(jQuery(this).hasClass('allVer')){
    jQuery(this).parents('table').find('.allIns, .allUpt, .ins, .upt').prop('disabled',valido);
    }else{
    jQuery(this).parents('tr').find('.allIns, .allUpt, .ins, .upt').prop('disabled',valido);
    }
  });
  jQuery(document).ready(function() {
    jQuery('.allVer, .ver').each(function(){
      let valido=true;
      (jQuery(this).is(':checked')) ? valido=false : valido=true;
      jQuery(this).parents('tr').find('.allIns, .allUpt, .ins, .upt').prop('disabled',valido);
    });
    jQuery(".ver, .ins, .upt").trigger('change');
  });
  <!-- START BLOCK : val -->
  block_controls(true);
  <!-- END BLOCK : val -->
</script>
<!-- END BLOCK : module -->