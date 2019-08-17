<!-- START BLOCK : module -->
<script>
jQuery('button').on('click', function(){
  submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
  if(acc=="SAVE"){
    SendForm(mod,submod,ref,subref,"#form_",false);
  }
});
jQuery('#rut').on("blur", function(){
  validate_data(jQuery(this).val(),"crud_proveedores");
});
jQuery('#pais').change(function(){
    fill_list("region","accion=list_region&pais="+jQuery(this).val()+"&mod=crud_proveedores");
});
jQuery('#region').change(function(){
    fill_list("provincia","accion=list_provincias&region="+jQuery(this).val()+"&mod=crud_proveedores");
});
jQuery('#provincia').change(function(){
    fill_list("comuna","accion=list_comunas&provincia="+jQuery(this).val()+"&mod=crud_proveedores");
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
                      <input type="text" class="form-control validar" id="email" name="email" maxlength="100" placeholder="E-MAIL" value="{mail}" {read}>
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
                      <input type="text" class="form-control validar" id="tel1" name="tel1" maxlength="9" placeholder="TELEFONO FIJO" value="{tel_fijo}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="tel2" class="control-label col-form-label">TEL. MOVIL</label>
                      <input type="text" class="form-control validar" id="tel2" name="tel2" maxlength="9" placeholder="TELEFONO MOVIL" value="{tel_movil}" {read}>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label for="nombre2" class="control-label col-form-label">NOMBRE FANTASIA</label>
                      <input type="text" class="form-control validar" id="nombre2" name="nombre2" maxlength="100" placeholder="NOMBRE DE FANTASIA" value="{data2}" {read}>
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