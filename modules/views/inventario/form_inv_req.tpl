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
              <li class="nav-item {vis}"> <a class="nav-link" data-toggle="tab" href="#tab_2" role="tab"><span class="hidden-xs-down">ODS</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_3" role="tab"><span class="hidden-xs-down">ARTICULOS</span></a> </li>
            </ul>
            <div class="tab-content tabcontent-border">
              <div class="tab-pane p-4 active" id="tab_1" role="tabpanel">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="calmacen_des" class="control-label col-form-label">ALMACEN SOLICITANTE</label>
                        <select class="form-control validar list ctrl" id="calmacen_des" name="calmacen_des">
                          <!-- START BLOCK : alm_det_des -->
                          <option value="{codigo}" {selected}>{almacen}</option>
                          <!-- END BLOCK : alm_det_des -->
                        </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="calmacen_ori" class="control-label col-form-label">ALMACEN ENTREGANTE</label>
                        <select class="form-control validar list ctrl" id="calmacen_ori" name="calmacen_ori">
                          <!-- START BLOCK : alm_det_ent -->
                          <option value="{codigo}" {selected}>{almacen}</option>
                          <!-- END BLOCK : alm_det_ent -->
                        </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="fecha" class="control-label col-form-label">FECHA</label>
                      <input type="text" class="form-control" id="fecha" name="fecha" value="{fecha}" readonly>
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
                      <table class="table table-bordered table-hover" id="table_det_ods">
                        <thead>
                          <tr>
                            <th>ODS</th>
                            <th>RUT</th>
                            <th>CLIENTE</th>
                            <th>FECHA</th>
                            <th>OPCION</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- START BLOCK : det_ods -->
                            <tr>
                              <td>
                                <input name="cods[]" id="cods[{count}]" type="hidden" value="{codigo}">
                                {ods_full}
                              </td>
                              <td>{code}</td>
                              <td>{data}</td>
                              <td>{fecha}</td>
                              <td>{actions}</td>
                            </tr>
                            <!-- END BLOCK : det_ods -->
                        </tbody>
                      </table>
                      <div class="button-group">
                        <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="search_ods" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span> AGREGAR</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_3" role="tabpanel">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover" id="table_det_odc">
                        <thead>
                          <tr>
                            <th>CODIGO</th>
                            <th>CODIGO INT</th>
                            <th>ARTICULO</th>
                            <th width="80px">CANT</th>
                            <th>TIPO</th>
                            <th>OPC</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- START BLOCK : det_arts -->
                            <tr>
                              <td>
                                <input name="corden_det[]" id="corden_det[{count}]" type="hidden" value="{codigo}">
                                <input name="carticulo[]" id="carticulo[{count}]" type="hidden" value="{cod_articulo}">
                                {cod_articulo}
                              </td>
                              <td>{codigo2}</td>
                              <td>{articulo}</td>
                              <td><input name="cant[]" id="cant[{count}]" class="form-control numeric ctrl" maxlength="10" style="width:100px" value="{cant}"></td>
                              <td>{clasificacion}</td>
                              <td>{actions}</td>
                            </tr>
                            <!-- END BLOCK : det_arts -->
                        </tbody>
                      </table>
                      <div class="button-group">
                        <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="add_art_cot" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span> AGREGAR</button>
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
                <!-- START BLOCK : data_save -->
                <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="SAVE" data-id="0"><span class="btn-label"><i class="fas fa-save"></i></span> GUARDAR</button>
                <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="PROC" data-id="0"><span class="btn-label"><i class="fas fa-cogs"></i></span> PROCESAR</button>
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
      if(acc=="SAVE" || acc=="PROC"){
        if(count_row("table_det_odc","ARTICULO")){
          if(acc=="PROC"){ jQuery("#accion").val("proc"); }
          SendForm(mod,submod,ref,subref,"#form_",false);
        }
      }else if(acc=="search_almacen_compra"){
        modal_search("SELECCIONE UN ALMACEN",'accion='+acc+'&mod='+submod,'POST',false,false);
      }else if(acc=="search_almacen"){
        modal_search("SELECCIONE UN ALMACEN",'accion='+acc+'&mod='+submod,'POST',false,false);
      }else if(acc=="search_ods"){
        let non_det = new Array();
        jQuery('#table_det_ods tbody tr td input[id^="cods"]').each(function(row, tr){
          non_det.push(jQuery(this).val());
        });
        modal_search("SELECCIONE UNA ODS PARA GESTIONAR",'accion='+acc+'&mod='+submod+'&not='+JSON.stringify(non_det),'POST',false,false);
      }else if(acc=="add_art_cot"){
        let non_det = new Array();
        jQuery('#table_det_odc tbody tr td input[id^="carticulo"]').each(function(row, tr){
          non_det.push(jQuery(this).val());
        });
        modal_search("SELECCIONE UN ARTICULO",'accion='+acc+'&mod='+submod+'&not='+JSON.stringify(non_det),'POST',false,false);
      }
    });
    <!-- START BLOCK : val -->
    block_controls(true);;
    <!-- END BLOCK : val -->
  });
</script>
<!-- END BLOCK : module -->