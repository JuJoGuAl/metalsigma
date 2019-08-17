<!-- START BLOCK : module -->
<script>
jQuery('button').on('click', function(){
  submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
  if(acc=="SAVE"){
    SendForm(mod,submod,ref,subref,"#form_",false);
  }else if(acc=="add_eqs"){
    modal_search("SELECCIONE UN EQUIPO PARA ASIGNAR AL CLIENTE",'accion='+acc+'&mod='+submod,'POST',false,false);
  }
});
jQuery('#rut').on("blur", function(){
  validate_data(jQuery(this).val(),"crud_clientes");
});
jQuery('#pais').change(function(){
    fill_list("region","accion=list_region&pais="+jQuery(this).val()+"&mod=crud_clientes");
});
jQuery('#region').change(function(){
    fill_list("provincia","accion=list_provincias&region="+jQuery(this).val()+"&mod=crud_clientes");
});
jQuery('#provincia').change(function(){
    fill_list("comuna","accion=list_comunas&provincia="+jQuery(this).val()+"&mod=crud_clientes");
});
jQuery("#table_det_cli").on("click",'button[id^="bt_chang"]',function(){
    var valor = jQuery(this).closest('tr').find('input[id^="status"]').val(), valor_new=1, valor_texto="SI";
    if(valor==1){ valor_new=0; valor_texto="NO"; }
    jQuery(this).closest('tr').find('input[id^="status"]').closest("td").html('<input name="status[]" id="status[]" type="hidden" value="'+valor_new+'">'+valor_texto);
});
jQuery("#table_det_cli").on("click",'button[id^="bt_del"]',function(){
    jQuery(this).closest('tr').remove();
});
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
            <h6 class="card-subtitle"></h6>
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab_1" role="tab"><span class="hidden-xs-down">INFO BASICA</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_2" role="tab"><span class="hidden-xs-down">INFO TECNICA</span></a> </li>
            </ul>
            <div class="tab-content tabcontent-border">
              <div class="tab-pane p-4 active" id="tab_1" role="tabpanel">
                <div class="row">              
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="rut" class="control-label col-form-label">RUT</label>
                      <input type="text" class="form-control validar ctrl" id="rut" name="rut" maxlength="9" placeholder="INSERTE EL RUT" value="{code}" {read}>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label for="nombre" class="control-label col-form-label">RAZON SOCIAL / NOMBRE</label>
                      <input type="text" class="form-control validar" id="nombre" name="nombre" maxlength="100" placeholder="NOMBRE O RAZON SOCIAL DEL CLIENTE" value="{data}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="email" class="control-label col-form-label">E-MAIL</label>
                      <input type="text" class="form-control" id="email" name="email" maxlength="100" placeholder="E-MAIL" value="{mail}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="pais" class="control-label col-form-label">PAIS</label>
                      <select class="form-control validar list" id="pais" name="pais">
                        <!-- START BLOCK : pais_det -->
                        <option value="{codigo}" {selected}>{pais}</option>
                        <!-- END BLOCK : pais_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="region" class="control-label col-form-label">REGION</label>
                      <select class="form-control validar list" id="region" name="region">
                        <!-- START BLOCK : region_det -->
                        <option value="{codigo}" {selected}>{region}</option>
                        <!-- END BLOCK : region_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="provincia" class="control-label col-form-label">PROVINCIA</label>
                      <select class="form-control validar list" id="provincia" name="provincia">
                        <option value="-1">SELECCIONE...</option>
                        <!-- START BLOCK : prov_det -->
                        <option value="{codigo}" {selected}>{provincia}</option>
                        <!-- END BLOCK : prov_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="comuna" class="control-label col-form-label">COMUNA</label>
                      <select class="form-control validar list" id="comuna" name="comuna">
                        <option value="-1">SELECCIONE...</option>
                        <!-- START BLOCK : com_det -->
                        <option value="{codigo}" {selected}>{comuna}</option>
                        <!-- END BLOCK : com_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label for="direccion" class="control-label col-form-label">DIRECCION</label>
                      <input type="text" class="form-control validar" id="direccion" name="direccion" maxlength="100" placeholder="DIRECCION" value="{direccion}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="tel1" class="control-label col-form-label">TEL. FIJO</label>
                      <input type="text" class="form-control" id="tel1" name="tel1" maxlength="9" placeholder="TELEFONO FIJO" value="{tel_fijo}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="tel2" class="control-label col-form-label">TEL. MOVIL</label>
                      <input type="text" class="form-control" id="tel2" name="tel2" maxlength="9" placeholder="TELEFONO MOVIL" value="{tel_movil}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="segmento" class="control-label col-form-label">SEGMENTO</label>
                      <select class="form-control validar list" id="segmento" name="segmento">
                        <option value="-1">SELECCIONE...</option>
                        <!-- START BLOCK : seg_det -->
                        <option value="{codigo}" {selected}>{segmento}</option>
                        <!-- END BLOCK : seg_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="giro" class="control-label col-form-label">GIRO</label>
                      <select class="form-control validar list" id="giro" name="giro">
                        <option value="-1">SELECCIONE...</option>
                        <!-- START BLOCK : gir_det -->
                        <option value="{codigo}" {selected}>{giro}</option>
                        <!-- END BLOCK : gir_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label for="nombre2" class="control-label col-form-label">NOMBRE FANTASIA</label>
                      <input type="text" class="form-control validar" id="nombre2" name="nombre2" maxlength="100" placeholder="NOMBRE DE FANTASIA" value="{data2}" {read}>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label for="cont" class="control-label col-form-label">NOMBRE DE CONTACTO</label>
                      <input type="text" class="form-control validar" id="cont" name="cont" maxlength="100" placeholder="NOMBRE DE CONTACTO DEL CLIENTE" value="{contacto}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="pago" class="control-label col-form-label">MODO DE PAGO</label>
                      <select class="form-control validar list" id="pago" name="pago">
                        <option value="-1">SELECCIONE...</option>
                        <!-- START BLOCK : pago_det -->
                        <option value="{codigo}" {selected}>{pago}</option>
                        <!-- END BLOCK : pago_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="cre" class="control-label col-form-label">MONTO CREDITO ($)</label>
                      <input type="text" class="form-control validar numeric" id="cre" name="cre" maxlength="12" placeholder="MONTO MAXIMO DE CREDITO" value="{credito}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="maxdesc" class="control-label col-form-label">DESCUENTO MAX (%)</label>
                      <input type="text" class="form-control validar numeric" id="maxdesc" name="maxdesc" maxlength="6" placeholder="MONTO MAXIMO DE DESCUENTO EN %" value="{descu}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="mora" class="control-label col-form-label">MORA EN OC</label>
                      <input type="text" class="form-control validar numeric" id="mora" name="mora" maxlength="3" placeholder="DIAS DE MORA EN OC" value="{mora_OC}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="mora1" class="control-label col-form-label">MORA EN PAGO</label>
                      <input type="text" class="form-control validar numeric" id="mora1" name="mora1" maxlength="3" placeholder="DIAS DE MORA EN PAGOS" value="{mora_pago}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="notas" class="control-label col-form-label">NOTAS</label>
                      <textarea class="form-control" rows="3" id="notas" name="notas" placeholder="DESCRIBA LAS OBSERVACIONES" {read}>{notas}</textarea>
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
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="maqs" class="control-label col-form-label"># MAQS</label>
                      <input type="text" class="form-control numeric" id="maqs" name="maqs" maxlength="3" value="{maqs}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="cat" class="control-label col-form-label"># CAT</label>
                      <input type="text" class="form-control numeric" id="cat" name="cat" maxlength="3" value="{cat}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="kom" class="control-label col-form-label"># KOMATSU</label>
                      <input type="text" class="form-control numeric" id="kom" name="kom" maxlength="3" value="{kom}" {read}>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover" id="table_det_cli">
                        <thead>
                          <tr>
                            <th>EQUIPO</th>
                            <th>MARCA</th>
                            <th>MODELO</th>
                            <th>SEGMENTO</th>
                            <th>Nº SERIE</th>
                            <th>Nº INTERNO</th>
                            <th>ACT</th>
                            <th>OPC</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- START BLOCK : eq_det -->
                          <tr>
                            <td><input name="cequipo[]" id="cequipo[{count}]" type="hidden" value="{codigo_equipo}"><input name="cmaquina[]" id="cmaquina[{count}]" type="hidden" value="{codigo}">{equipo}</td>
                            <td>{marca}</td>
                            <td>{modelo}</td>
                            <td>{segmento}</td>
                            <td><input type="text" id="serial[{count}]" name="serial[]" class="form-control" value="{serial}"></td>
                            <td><input type="text" id="interno[{count}]" name="interno[]" class="form-control" value="{interno}"></td>
                            <td><input name="status[]" id="status[{count}]" type="hidden" value="{status}">{ESTATUS}</td>
                            <td>{actions}</td>
                          </tr>
                          <!-- END BLOCK : eq_det -->
                        </tbody>
                      </table>
                      <p style="text-align:left;">
                        <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="add_eqs" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span> AGREGAR</button>
                      </p>
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
 <!-- START BLOCK : val -->
block_controls(true);
<!-- END BLOCK : val -->
</script>
<!-- END BLOCK : module -->