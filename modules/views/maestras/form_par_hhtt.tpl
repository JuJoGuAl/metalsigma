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
                    <li class="breadcrumb-item"><a class="menu" href="javascript:void(0)" data-menu="{mod}" data-mod="{submod}" data-acc="MODULO">{menu_sec}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{menu_ter}</li>
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
            <div class="row">
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
                  <label for="sitio" class="control-label col-form-label">SITIO</label>
                  <select class="form-control validar list" id="sitio" name="sitio">
                    <option value="-1">SELECCIONE...</option>
                    <!-- START BLOCK : lug_det -->
                    <option value="{codigo}" {selected}>{lugar}</option>
                    <!-- END BLOCK : lug_det -->
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="equipo" class="control-label col-form-label">EQUIPO DE TRABAJO</label>
                  <select class="form-control validar list" id="equipo" name="equipo">
                    <option value="-1">SELECCIONE...</option>
                    <!-- START BLOCK : equi_det -->
                    <option value="{codigo}" {selected}>{equipo}</option>
                    <!-- END BLOCK : equi_det -->
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="valor" class="control-label col-form-label">HH NORMAL</label>
                  <input type="text" class="form-control validar numeric" id="valor" name="valor" maxlength="12" value="{costo_hh_normal}" {read}>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="normal" class="control-label col-form-label">% NORMAL</label>
                  <input type="text" class="form-control validar numeric" id="normal" name="normal" maxlength="5" value="{mar_normal}" {read}>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="extra" class="control-label col-form-label">% EXTRA</label>
                  <input type="text" class="form-control validar numeric" id="extra" name="extra" maxlength="5" value="{mar_extra}" {read}>
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