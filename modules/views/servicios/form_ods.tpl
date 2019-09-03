<!-- START BLOCK : module -->
<script>
  var sum_hh_ta=sum_hh_te=sum_dias=0;
  jQuery('#table_det_cot .datas').each(function(){
    sum_hh_ta += parseFloat(jQuery(this).find("td:eq(4)").text());
    sum_hh_te += parseFloat(jQuery(this).find("td:eq(5)").text());
    sum_dias += parseFloat(jQuery(this).find("td:eq(6)").text());
    jQuery("#table_det_cot tbody tr:last-child td:eq(1)").text(sum_hh_ta);
    jQuery("#table_det_cot tbody tr:last-child td:eq(2)").text(sum_hh_te);
    jQuery("#table_det_cot tbody tr:last-child td:eq(3)").text(sum_dias);
  });
  jQuery('button').on('click', function(){
    submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc"), assoc_id = jQuery(this).attr("data-id");
    if(acc=="PROC"){
      jQuery("#accion").val("proc");
      SendForm(mod,submod,ref,subref,"#form_",assoc_id);
    }else if(acc=="IMP"){
      if(jQuery.inArray(jQuery("#stats").val(),array_status_print_ods)!=-1){
        imprimir("./modules/reports/rep_ods.php?code="+jQuery('#id').val()+"&accion="+acc+"&submod="+submod);
      }else{
        dialog("LA TRANSACCION NO CUMPLE CON LOS REQUISITOS PARA GENERAR EL PDF","ERROR");
      }
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
                    <li class="breadcrumb-item active" aria-current="page">SUB-COTIZACIONES</li>
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
          <input type="hidden" id="origen" name="origen" class="form-control" value="{codigo_origen}">
          <div class="card-body">
            <h6>
              <p style="margin: .5rem 0;">CLIENTE: <strong>{code} / {data}</strong></p>
              <p style="margin: .5rem 0;">EQUIPO: <strong>{equipo} {marca} {modelo}</strong></p>
              <p style="margin: .5rem 0;">SERIAL: <strong>{serial}</strong></p>
            </h6>
            <div class="d-flex no-block align-items-center pb-3">
              <div>{form_title}<strong>{id_tittle}</strong> - {form_title2}<strong>{id_tittle2}</strong></div>
              <div class="ml-auto">ESTATUS: <span class="badge badge-pill ml-auto mr-3 font-medium px-2 py-1 {status_color}">{stats_nom}<input type="hidden" id="stats" name="stats" value="{stats_code}"></span></div>
            </div>
            <h6 class="card-subtitle"></h6>
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab_1" role="tab"><span class="hidden-xs-down">COTIZACION</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_2" role="tab"><span class="hidden-xs-down">DETALLES</span></a> </li>
            </ul>
            <div class="tab-content tabcontent-border">
              <div class="tab-pane p-4 active" id="tab_1" role="tabpanel">
                <div class="card border-dark">
                  <div class="card-header bg-secondary"><h4 class="mb-0 text-white">DETALLE DE COTIZACION</h4></div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="cotizat" class="control-label col-form-label">TIPO DE COTIZACION</label>
                          <input type="text" id="cotizat" name="cotizat" class="form-control" value="{tipo}" disabled>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="lugar" class="control-label col-form-label">LUGAR</label>
                          <input type="text" id="lugar" name="lugar" class="form-control" value="{lugar}" disabled>
                        </div>
                      </div>
                    </div>
                    <div id="terreno" class="row" {hide}>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="vehiculo" class="control-label col-form-label">VEHICULO</label>
                          <input type="text" id="vehiculo" name="vehiculo" class="form-control" value="{vehiculo}" disabled>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="dist" class="control-label col-form-label">DIST A TALLER</label>
                          <input type="text" id="dist" name="dist" class="form-control" value="{dist}" disabled>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="viajes" class="control-label col-form-label">VIAJES</label>
                          <input type="text" id="viajes" name="viajes" class="form-control" value="{viajes}" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="coteq" class="control-label col-form-label">PARTE</label>
                          <input type="text" id="coteq" name="coteq" class="form-control" value="{coteq}" disabled>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="equipot" class="control-label col-form-label">EQUIPO DE TRAB</label>
                          <input type="text" id="equipot" name="equipot" class="form-control" value="{equipo}" disabled>
                        </div>
                      </div>                        
                    </div>
                  </div>
                </div>
                <div class="card border-dark">
                  <div class="card-header bg-secondary"><h4 class="mb-0 text-white">COMPONENTES / SERVICIOS A COTIZAR</h4></div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="table-responsive">
                          <table class="table table-bordered table-hover" id="table_det_cot">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>SISTEMA</th>
                                <th>COMPONENTE</th>
                                <th>SERVICIO</th>
                                <th>HH TA</th>
                                <th>HH TE</th>
                                <th>DIAS TA</th>
                                <th>INICIO</th>
                                <th>FIN</th>
                              </tr>
                            </thead>
                            <tbody>
                              <!-- START BLOCK : co_det -->
                              <tr class="datas">
                                <td>{count}</td>
                                <td>{parte}</td>
                                <td>{pieza}</td>
                                <td>{articulo}</td>
                                <td>{hh_taller}</td>
                                <td>{hh_terreno}</td>
                                <td>{dias_taller}</td>
                                <td>{finicio}</td>
                                <td>{ffin}</td>
                              </tr>
                              <!-- END BLOCK : co_det -->
                              <tr id="sumary">
                                <td colspan="4"><strong>TOTALES</strong></td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td></td>
                                <td></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-sm-12">
                          <div class="form-group">
                            <label for="notas" class="control-label col-form-label">NOTAS</label>
                            <textarea class="form-control" rows="3" id="notas" name="notas" disabled>{notas}</textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_2" role="tabpanel">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover" id="table_add_ins">
                        <thead>
                          <tr>
                            <th>CODIGO</th>
                            <th>COD. INT</th>
                            <th>ARTICULO</th>
                            <th width="100px;">CANT</th>
                            <th>TIPO</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- START BLOCK : articulos -->
                          <tr>
                            <td>{codigo}</td>
                            <td>{codigo2}</td>
                            <td>{articulo}</td>
                            <td width="100px;">{cant}</td>
                            <td>{clasificacion}</td>
                          </tr>
                          <!-- END BLOCK : articulos -->
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
                <input type="hidden" id="id" name="id" value="{id}">
                <!-- START BLOCK : data_save -->
                <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="PROC" data-id="{codigo}"><span class="btn-label"><i class="fas fa-cogs"></i></span> CREAR ODS</button>
                <!-- END BLOCK : data_save -->
                <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="IMP" data-id="0"><span class="btn-label"><i class="fas fa-print"></i></span> IMPRIMIR</button>
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