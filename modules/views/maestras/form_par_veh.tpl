<!-- START BLOCK : module -->
<script>
jQuery('button').on('click', function(){
  submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
  if(acc=="SAVE"){
    SendForm(mod,submod,ref,subref,"#form_",false);
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
                    <li class="breadcrumb-item"><a class="menu" href="javascript:void(0)" data-menu="{mod}" data-mod="{submod}" data-acc="MODULO">{menu_ter}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">EQUIPOS</li>
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
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="valor" class="control-label col-form-label">NOMBRE DEL VEHICULO</label>
                  <input type="text" class="form-control validar" id="valor" name="valor" maxlength="100" placeholder="DESCRIBA EL VEHICULO" value="{vehiculo}" {read}>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="sal" class="control-label col-form-label">COSTO DE SALIDA</label>
                  <input type="text" class="form-control validar numeric" id="sal" name="sal" maxlength="12" value="{salida}" {read}>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="costo" class="control-label col-form-label">COSTO KM</label>
                  <input type="text" class="form-control validar numeric" id="costo" name="costo" maxlength="12" value="{costo_km}" {read}>
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