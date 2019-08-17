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
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="requisicion" class="control-label col-form-label">REQUISICION</label>
                      <div class="input-group">
                        <input type="text" class="form-control validar" id="requisicion" name="requisicion" placeholder="SELECCIONE UNA REQUISICION" value="{corigen}" readonly> 
                        <div class="input-group-append"><button class="btn btn-outline-secondary ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="search_requisicion"><span class="fa fa-search"></button></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="almacen1" class="control-label col-form-label">ALMACEN SOLICITANTE</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="almacen1" name="almacen1" value="{almacen_ori}" readonly> 
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="almacen2" class="control-label col-form-label">ALMACEN QUE ENTREGA</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="almacen2" name="almacen2" value="{almacen_des}" readonly> 
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="fecha_mov" class="control-label col-form-label">FECHA ENTREGA</label>
                      <input type="text" class="form-control validar ctrl" id="fecha_mov" name="fecha_mov" value="{fecha_mov}" readonly>
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
                            <th>CODIGO INT</th>
                            <th>ARTICULO</th>
                            <th width="80px">CANT</th>                            
                            <th>OPCION</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- START BLOCK : det_arts -->
                            <tr>
                              <td>
                                <input name="codc[]" id="codc[{count}]" type="hidden" value="{codigo_odc}">
                                <input name="codc_det[]" id="codc_det[{count}]" type="hidden" value="{corden_det}">
                                <input name="carticulo[]" id="carticulo[{count}]" type="hidden" value="{codigo_articulo}">
                                <input name="cmov_det[]" id="cmov_det[{count}]" type="hidden" value="{codigo}">
                                {codigo}
                              </td>
                              <td>{codigo2}</td>
                              <td>{articulo}</td>
                              <td>
                                <input name="cant[]" id="cant[{count}]" data-max="{cant}" type="text" style="width: 80px;" class="form-control cant numeric ctrl" value="{cant}">
                              </td>                              
                              <td>{actions}</td>
                            </tr>
                            <!-- END BLOCK : det_arts -->
                        </tbody>
                      </table>
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
                <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="SAVE" data-id="0"><span class="btn-label"><i class="fas fa-cogs"></i></span> PROCESAR</button>
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
  function check_recep(){
    let valido = false;
    jQuery('#table_art tbody tr').each(function(){
      let cant_desp = jQuery(this).find("td:eq(3) input").val(), cant_max = jQuery(this).find("td:eq(3) input").attr("data-max"), row = jQuery(this).find("td:eq(2)").text();
      if(cant_desp=="" || cant_desp==0 || cant_desp == null || cant_desp == undefined){
        valido = false;
        jQuery(this).addClass("table-danger");
        dialog("DEBE INDICAR UNA CANTIDAD A DESPACHAR PARA EL ARTICULO <strong>"+row+"</strong>","ERROR");
        return valido;
      }else{
        valido = true;
      }
    });
    return valido;
  }
  jQuery(document).ready(function(){
    jQuery('button').on('click', function(){
      submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
      if(acc=="SAVE"){
        if(count_row("table_art","ARTICULO")){
          if(check_recep()){
            SendForm(mod,submod,ref,subref,"#form_",false);
          }
        }
      }else if(acc=="search_requisicion"){
        modal_search("SELECCIONE UNA REQUISICION A PROCESAR",'accion='+acc+'&mod='+submod,'POST',false,false);
      }
    });
    <!-- START BLOCK : val -->
    block_controls(true);
    <!-- END BLOCK : val -->
  });
</script>
<!-- END BLOCK : module -->