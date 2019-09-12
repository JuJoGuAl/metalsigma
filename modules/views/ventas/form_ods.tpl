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
          <input type="hidden" id="cliente" name="cliente" value="{ccliente}">
          <input type="hidden" id="ccredito" name="ccredito" value="{cpago}">
          <input type="hidden" id="desc_percent" name="desc_percent" value="{descu}">
          <input type="hidden" id="cequipo" name="cequipo" value="{cequipo}">
          <input type="hidden" id="csegmento" name="csegmento" value="{csegmento}">
          <input type="hidden" id="cotiza" name="cotiza" value="{codigo}">
          <div class="card-body">
            <h6>
              <p style="margin: .5rem 0;">CLIENTE: <strong>{code} / {data}</strong></p>
              <p style="margin: .5rem 0;">EQUIPO: <strong>{maquina} {marca} {modelo}</strong></p>
              <p style="margin: .5rem 0;">SERIAL: <strong>{serial}</strong></p>
            </h6>
            <div class="d-flex no-block align-items-center pb-3">
              <div>{form_title}<strong>{id_tittle}</strong> - {form_title2}<strong>{id_tittle2}</strong> - {form_title3}<strong>{id_tittle3}</strong></div>
              <div class="ml-auto">ESTATUS: <span class="badge badge-pill ml-auto mr-3 font-medium px-2 py-1 {status_color}">{stats_nom}<input type="hidden" id="stats" name="stats" value="{stats_code}"></span></div>
            </div>
            <h6 class="card-subtitle"></h6>
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab_1" role="tab"><span class="hidden-xs-down">COTIZACION</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_2" role="tab"><span class="hidden-xs-down">INS / REPS / SERV</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_3" role="tab"><span class="hidden-xs-down">RESUMEN</span></a> </li>
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
                          <div id="garantias" class="col-sm-6" {hide1}>
                              <div class="form-group">
                                <label for="ods_gar" class="control-label col-form-label">ODS</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="ods_gar" name="ods_gar" value="{ods_gar_full}" disabled> 
                                  <input type="hidden" id="cods_gar" name="cods_gar" value="{cot_gar_full}">
                                </div>
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
                              <table class="table table-bordered table-hover table-m" id="table_det_cot">
                                <thead>
                                    <tr>
                                      <th rowspan="2" style="width: 26px;">#</th>
                                      <th rowspan="2">SISTEMA</th>
                                      <th rowspan="2">COMPONENTE</th>
                                      <th rowspan="2">SERVICIO</th>
                                      <th colspan="2" class="text-center">HORAS</th>
                                      <th class="text-center">DIAS</th>
                                      <th rowspan="2" class="text-center" style="width: 100px;">INICIO</th>
                                      <th rowspan="2" class="text-center" style="width: 100px;">FIN</th>
                                    </tr>
                                    <tr class="text-center">
                                      <th rowspan="2" style="width: 60px;">TALLER</th>
                                      <th rowspan="2" style="width: 60px;">TERRENO</th>
                                      <th style="width: 60px;">TALLER</th>
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
                                <th>DESCRIPCION</th>
                                <th width="100px;">CANT</th>
                                <th>PRECIO</th>
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
                              <td><span class="number_cal">{precio}</span></td>
                              <td>{clasificacion}</td>
                            </tr>
                            <!-- END BLOCK : articulos -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              <div class="tab-pane p-4" id="tab_3" role="tabpanel">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover" id="table_resumen">
                        <thead>
                          <tr>
                            <th>DESCRIPCION</th>
                            <th colspan="2">VALOR</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th>SERVICIO TECNICO</th>
                            <td colspan="2" class="text-right">
                              <div class="input-group pull-right" style="width: auto;">
                                <div class="input-group-addon" style="padding: 0; background-color: transparent; border: none; margin-right: 10px;">{hist_m_serv}</div>
                                <span class="number_cal" id="_serv">{m_serv}</span>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>REPUESTOS</th>
                            <td colspan="2" class="text-right">
                              <div class="input-group pull-right" style="width: auto;">
                                <div class="input-group-addon" style="padding: 0; background-color: transparent; border: none; margin-right: 10px;">{hist_m_rep}</div>
                                <span class="number_cal" id="_rep">{m_rep}</span>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>INSUMOS</th>
                            <td colspan="2" class="text-right">
                              <div class="input-group pull-right" style="width: auto;">
                                <div class="input-group-addon" style="padding: 0; background-color: transparent; border: none; margin-right: 10px;">{hist_m_ins}</div>
                                <span class="number_cal" id="_ins">{m_ins}</span>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>SERVICIOS TERCERIZADOS</th>
                            <td colspan="2" class="text-right">
                              <div class="input-group pull-right" style="width: auto;">
                                <div class="input-group-addon" style="padding: 0; background-color: transparent; border: none; margin-right: 10px;">{hist_m_stt}</div>
                                <span class="number_cal" id="_stt">{m_stt}</span>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>TRASLADOS</th>
                            <td colspan="2" class="text-right">
                              <div class="input-group pull-right" style="width: auto;">
                                <div class="input-group-addon" style="padding: 0; background-color: transparent; border: none; margin-right: 10px;">{hist_m_tra}</div>
                                <span class="number_cal" id="_tras">{m_tra}</span>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>MISCELANEOS</th>
                            <td colspan="2" class="text-right">
                              <div class="input-group pull-right" style="width: auto;">
                                <div class="input-group-addon" style="padding: 0; background-color: transparent; border: none; margin-right: 10px;">{hist_m_misc}</div>
                                <span class="number_cal" id="_misc">{m_misc}</span>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>SUB TOTAL</th>
                            <td colspan="2" class="text-right">
                              <div class="input-group pull-right" style="width: auto;">
                                <div class="input-group-addon" style="padding: 0; background-color: transparent; border: none; margin-right: 10px;">{hist_m_subt}</div>
                                <span class="number_cal" id="_subt">{m_subt}</span>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>DESC (%) </th>
                            <td width="150px" class="text-right" style="padding: .55rem;">
                              <div class="input-group pull-right" style="width: auto;">
                                <div class="input-group-addon" style="padding: 0; background-color: transparent; border: none; margin-right: 10px;">{hist_m_descp}</div>
                                <input type="text" id="desc" name="desc" maxlength="6" class="form-control numeric ctrl" style="height: '30px'" value="{m_descp}">
                              </div>
                            </td>
                            <td width="150px" class="text-right"><span class="number_cal" id="_desc">{m_desc}</span></td>
                          </tr>
                          <tr>
                            <th>VALOR NETO</th>
                            <td colspan="2" class="text-right">
                              <div class="input-group pull-right" style="width: auto;">
                                <div class="input-group-addon" style="padding: 0; background-color: transparent; border: none; margin-right: 10px;">{hist_m_neto}</div>
                                <span class="number_cal" id="_neto">{m_neto}</span>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>IMPUESTOS (%) </th>
                            <td width="150px" class="text-right"><span id="imp_show">{m_impp} %</span></td>
                            <td width="150px" class="text-right"><span class="number_cal" id="_imp">{m_imp}</span></td>
                          </tr>
                          <tr>
                            <th>VALOR BRUTO</th>
                            <td colspan="2" class="text-right"><span class="number_cal" id="_bruto">{m_bruto}</span></td>
                          </tr>
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
  setTimeout(function(){ calculos(); },200);
  <!-- START BLOCK : val -->
  block_controls(true);
  <!-- END BLOCK : val -->
</script>
<!-- END BLOCK : module -->