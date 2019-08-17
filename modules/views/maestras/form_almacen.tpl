<!-- START BLOCK : module -->
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
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab_1" role="tab"><span class="hidden-xs-down">INFO BASICA</span></a> </li>
            </ul>
            <div class="tab-content tabcontent-border">
              <div class="tab-pane p-4 active" id="tab_1" role="tabpanel">
                <div class="row">              
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="dato" class="control-label col-form-label">ALMACEN</label>
                      <input type="text" class="form-control validar" id="dato" name="dato" maxlength="50" placeholder="ASIGNE UN NOMBRE PARA EL ALMACEN" value="{almacen}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="compra" class="control-label col-form-label pop" data-title="ALMACEN PARA COMPRA" data-body="ESTA OPCION DELIMITA SI EL ALMACEN SERA LISTADO EN EL MODULO DE COMPRAS PARA RECIBIR FACTURAS DE COMPRA">COMPRA</label>
                      <select name="compra" id="compra" class="form-control custom-select validar list">
                        <!-- START BLOCK : comp_det -->
                        <option value="{code}" {selected}>{valor}</option>
                        <!-- END BLOCK : comp_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="sto" class="control-label col-form-label pop" data-title="ALMACEN PARA GUARDAR" data-body="DELIMITA SI EL ALMACEN DEBE MANTENER UN STOCK (MANTENER UNA CANTIDAD DELIMITADA DE ARTICULOS EN UN RANGO DE TIEMPO)">STOCK</label>
                      <select name="sto" id="sto" class="form-control custom-select validar list">
                        <!-- START BLOCK : stock_det -->
                        <option value="{code}" {selected}>{valor}</option>
                        <!-- END BLOCK : stock_det -->
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
  jQuery('button').on('click', function(){
    submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
    if(acc=="SAVE"){
      SendForm(mod,submod,ref,subref,"#form_",false);
    }
  });
  jQuery(".pop").each(function(){
    jQuery(this).popover({
      title: '<div style="font-size: 12px;"><strong>'+jQuery(this).attr("data-title")+'</strong></div>',
      content: '<div style="font-size: 12px;">'+jQuery(this).attr("data-body")+'</div>',
      trigger: 'hover',
      placement: 'top',
      container: 'body',
      html: true
    });
  });
  <!-- START BLOCK : val -->
  block_controls(true);
  <!-- END BLOCK : val -->
</script>
<!-- END BLOCK : module -->