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
            <div class="d-flex no-block align-items-center pb-3">
              <div>{form_title}<strong>{id_tittle}</strong></div>
              <div class="ml-auto">ESTATUS: <span class="badge badge-pill ml-auto mr-3 font-medium px-2 py-1 {status_color}">{stats_nom}<input type="hidden" id="stats" name="stats" value="{stats_code}"></span></div>
            </div>
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab_1" role="tab"><span class="hidden-xs-down">INFO BASICA</span></a> </li>              
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_2" role="tab"><span class="hidden-xs-down">ARTICULOS</span></a> </li>
            </ul>
            <div class="tab-content tabcontent-border">
              <div class="tab-pane p-4 active" id="tab_1" role="tabpanel">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="calmacen" class="control-label col-form-label">ALMACEN</label>
                        <select class="form-control validar list ctrl" id="calmacen" name="calmacen">
                          <!-- START BLOCK : alm_det -->
                          <option value="{codigo}" {selected}>{almacen}</option>
                          <!-- END BLOCK : alm_det -->
                        </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="f_doc" class="control-label col-form-label">FECHA DOCUMENTO</label>
                      <input type="text" class="form-control validar dates ctrl" id="f_doc" name="f_doc" value="{fecha_doc}">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="f_mov" class="control-label col-form-label">FECHA CARGA</label>
                      <input type="text" class="form-control validar ctrl" id="f_mov" name="f_mov" value="{fecha_mov}" readonly>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="notas" class="control-label col-form-label">NOTAS</label>
                      <textarea class="form-control ctrl" rows="3" id="notas" name="notas">{observacion}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_2" role="tabpanel">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover" id="table_art">
                        <thead>
                          <tr>
                            <th>CODIGO</th>
                            <th>ARTICULO</th>
                            <th width="100px">CANT</th>
                            <th>OPCION</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- START BLOCK : det_arts -->
                            <tr>
                              <td>
                                <input name="carticulo[]" id="carticulo[{count}]" type="hidden" value="{codigo_articulo}">
                                <input name="cmov_det[]" id="cmov_det[{count}]" type="hidden" value="{codigo}">
                                {codigo2}
                              </td>
                              <td>{articulo}</td>
                              <td>
                                <input name="cant[]" id="cant[{count}]" type="text" style="width: 100px;" class="form-control cant numeric ctrl" value="{cant}">
                              </td>
                              <td>{actions}</td>
                            </tr>
                            <!-- END BLOCK : det_arts -->
                        </tbody>
                      </table>
                      <p style="text-align:left;">
                        <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="add_art" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span> AGREGAR</button>
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
                <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="SAVE" data-id="0"><span class="btn-label"><i class="fas fa-save"></i></span> GUARDAR</button>
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
  jQuery(document).ready(function(){
    jQuery('button').on('click', function(){
      submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
      if(acc=="SAVE"){
        if(count_row("table_art","ARTICULO")){
          SendForm(mod,submod,ref,subref,"#form_",false);
        }
      }else if(acc=="add_art"){
        let non_det = new Array();
        jQuery('#table_art tbody tr td input[id^="carticulo"]').each(function(row, tr){
          non_det.push(jQuery(this).val());
        });
        modal_search("SELECCIONE UN ARTICULO A AGREGAR",'accion='+acc+'&mod='+submod+'&not='+JSON.stringify(non_det),'POST',false,false);
      }
    });
    <!-- START BLOCK : val -->
    jQuery(".dates").datepicker("destroy");
    block_controls(true);
    <!-- END BLOCK : val -->
  });
</script>
<!-- END BLOCK : module -->