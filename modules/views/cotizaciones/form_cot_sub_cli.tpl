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
              <p style="margin: .5rem 0;">EQUIPO: <strong>{equipo} {marca} {modelo}</strong></p>
              <p style="margin: .5rem 0;">SERIAL: <strong>{serial}</strong></p>
            </h6>
            <div class="d-flex no-block align-items-center pb-3">
              <div>{form_title}<strong>{id_tittle}</strong></div>
              <div class="ml-auto">ESTATUS: <span class="badge badge-pill ml-auto mr-3 font-medium px-2 py-1 {status_color}">{stats_nom}<input type="hidden" id="stats" name="stats" value="{stats_code}"></span></div>
            </div>
            <h6 class="card-subtitle"></h6>
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab_1" role="tab"><span class="hidden-xs-down">COTIZACION</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_2" role="tab"><span class="hidden-xs-down">INSUMOS</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_3" role="tab"><span class="hidden-xs-down">RESUMEN</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_4" role="tab"><span class="hidden-xs-down">APROBACION</span></a> </li>
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
                          <select class="form-control validar list ctrl" id="cotizat" name="cotizat">
                            <option value="-1">SELECCIONE...</option>
                            <!-- START BLOCK : tipo_det -->
                            <option value="{codigo}" {selected}>{tipo}</option>
                            <!-- END BLOCK : tipo_det -->
                          </select>
                        </div>
                      </div>
                      <div id="garantias" class="col-sm-6" {hide1}>
                        <div class="form-group">
                          <label for="ods_gar" class="control-label col-form-label">ODS</label>
                          <div class="input-group">
                            <input type="text" class="form-control {hide3}" id="ods_gar" name="ods_gar" placeholder="SELECCIONE UNA ODS" value="{ods_gar_full}" readonly> 
                            <input type="hidden" id="cods_gar" name="cods_gar" value="{cot_gar_full}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="lugar" class="control-label col-form-label">LUGAR</label>
                          <select class="form-control validar list ctrl" id="lugar" name="lugar">
                            <!-- START BLOCK : lugar_det -->
                            <option value="{codigo}" {selected}>{lugar}</option>
                            <!-- END BLOCK : lugar_det -->
                          </select>
                        </div>
                      </div>
                    </div>
                    <div id="terreno" class="row" {hide}>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="vehiculo" class="control-label col-form-label">VEHICULO</label>
                          <select class="form-control validar list ctrl" id="vehiculo" name="vehiculo">
                            <!-- START BLOCK : veh_det -->
                            <option value="{codigo}" {selected}>{vehiculo}</option>
                            <!-- END BLOCK : veh_det -->
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="dist" class="control-label col-form-label">DIST A TALLER</label>
                          <input type="text" id="dist" name="dist" class="form-control numeric ctrl" value="{dist}">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="viajes" class="control-label col-form-label">VIAJES</label>
                          <input type="text" id="viajes" name="viajes" class="form-control numeric ctrl" value="{viajes}">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="coteq" class="control-label col-form-label">PARTE</label>
                          <select class="form-control validar list ctrl" id="coteq" name="coteq">
                            <!-- START BLOCK : cot_equipo -->
                            <option value="{code}" {selected}>{valor}</option>
                            <!-- END BLOCK : cot_equipo -->
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="equipot" class="control-label col-form-label">EQUIPO DE TRAB</label>
                          <select class="form-control validar list ctrl" id="equipot" name="equipot">
                            <!-- START BLOCK : equipo_det -->
                            <option value="{codigo}" {selected}>{equipo}</option>
                            <!-- END BLOCK : equipo_det -->
                          </select>
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
                                <th>OBS</th>
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
                                <td>{actions}</td>
                              </tr>
                              <!-- END BLOCK : co_det -->
                              <tr id="sumary">
                                <td colspan="4"><strong>TOTALES</strong></td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td></td>
                                <td></td>
                                <td>-</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-sm-12">
                          <div class="form-group">
                            <label for="notas" class="control-label col-form-label">NOTAS</label>
                            <textarea class="form-control ctrl" rows="3" id="notas" name="notas" placeholder="DESCRIBA LAS OBSERVACIONES">{notas}</textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_2" role="tabpanel">
                <div class="card border-dark">
                  <div class="card-header bg-secondary"><h4 class="mb-0 text-white">INSUMOS</h4></div>
                  <div class="card-body">
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
                                <th>OBS</th>
                              </tr>
                            </thead>
                            <tbody>
                              <!-- START BLOCK : articulos -->
                              <tr>
                                <td>{codigo}</td>
                                <td>{codigo2}</td>
                                <td>{nombre}</td>
                                <td width="100px;">{cant}</td>
                                <td>{precio}</td>
                                <td>{clasificacion}</td>
                                <td>{actions}</td>
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
                            <td colspan="2" class="text-right"><input type="hidden" id="_serv" name="_serv" class="form-control" value="{m_serv}">{m_serv_}</td>
                          </tr>
                          <tr>
                            <th>REPUESTOS</th>
                            <td colspan="2" class="text-right"><input type="hidden" id="_rep" name="_rep" class="form-control" value="{m_rep}">{m_rep_}</td>
                          </tr>
                          <tr>
                            <th>INSUMOS</th>
                            <td colspan="2" class="text-right"><input type="hidden" id="_ins" name="_ins" class="form-control" value="{m_ins}">{m_ins_}</td>
                          </tr>
                          <tr>
                            <th>SERVICIOS TERCERIZADOS</th>
                            <td colspan="2" class="text-right"><input type="hidden" id="_stt" name="_stt" class="form-control" value="{m_stt}">{m_stt_}</td>
                          </tr>
                          <tr>
                            <th>TRASLADOS</th>
                            <td colspan="2" class="text-right"><input type="hidden" id="_tras" name="_tras" class="form-control" value="{m_tra}">{m_tra_}</td>
                          </tr>
                          <tr>
                            <th>MISCELANEOS</th>
                            <td colspan="2" class="text-right"><input type="hidden" id="_misc" name="_misc" class="form-control" value="{m_misc}">{m_misc_}</td>
                          </tr>
                          <tr>
                            <th>SUB TOTAL</th>
                            <td colspan="2" class="text-right"><input type="hidden" id="_subt" name="_subt" class="form-control" value="{m_subt}">{m_subt_}</td>
                          </tr>
                          <tr>
                            <th>DESC (%) </th>
                            <td width="150px" class="text-right" style="padding: .55rem;">
                              <div class="input-group">
                                <input type="text" id="desc" name="desc" maxlength="6" class="form-control numeric ctrl" style="height: '30px'" value="{m_descp}">
                                <div class="input-group-addon" style="padding: 0; background-color: transparent; border: none;">{porc_hist}</div>
                              </div>
                            </td>
                            <td width="150px" class="text-right"><input type="hidden" id="_desc" name="_desc" class="form-control" value="{m_desc}">{m_desc_}</td>
                          </tr>
                          <tr>
                            <th>VALOR NETO</th>
                            <td colspan="2" class="text-right"><input type="hidden" id="_neto" name="_neto" class="form-control" value="{m_neto}">{m_neto_}</td>
                          </tr>
                          <tr>
                            <th>IMPUESTOS (%) </th>
                            <td width="150px" class="text-right"><span id="imp">{m_impp}</span><input type="hidden" id="_impp" name="_impp" class="form-control" value="{m_impp}"></td>
                            <td width="150px" class="text-right"><input type="hidden" id="_imp" name="_imp" class="form-control" value="{m_imp}">{m_imp_}</td>
                          </tr>
                          <tr>
                            <th>VALOR BRUTO</th>
                            <td colspan="2" class="text-right"><input type="hidden" id="_bruto" name="_bruto" class="form-control" value="{m_bruto}">{m_bruto}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>                  
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_4" role="tabpanel">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="notas_" class="control-label col-form-label">NOTAS FINALES</label>
                    <textarea class="form-control" rows="3" id="notas_" name="notas_" placeholder="SI DESEA AGREGAR NOTAS ADICIONALES DESCRIBALAS AQUI"></textarea>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="file" class="control-label col-form-label">ADJUNTO</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file" name="file">
                        <label class="custom-file-label" for="inputGroupFile01">SELECCIONE UN ARCHIVO PARA PROCESAR LA COTIZACION</label>
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
                <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="PROC" data-id="{codigo}"><span class="btn-label"><i class="fas fa-cogs"></i></span> PROCESAR</button>
                <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="CANC" data-id="{codigo}"><span class="btn-label"><i class="fas fa-times"></i></span> RECHAZAR</button>
                <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="RECO" data-id="{codigo}"><span class="btn-label"><i class="fas fa-sync-alt"></i></span> RE-COTIZAR</button>
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
  setTimeout(function(){ calculos(); },200);
  jQuery('button').on('click', function(){
    submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc"), assoc_id = jQuery(this).attr("data-id");
    if(acc=="PROC"){ jQuery("#accion").val("proc"); }
    if(acc=="CANC"){ jQuery("#accion").val("canc"); }
    if(acc=="RECO"){ jQuery("#accion").val("reco"); }
    if(acc=="PROC" || acc=="CANC" || acc=="RECO"){
      clear_log();
      var form = jQuery("#form_")[0];
      var formdata = new FormData(form);
      formdata.append('mod',mod);
      formdata.append('submod',submod);
      formdata.append('ref',ref);
      formdata.append('subref',subref);
      if(valform("#form_")){
        jQuery(".preloader").fadeIn();
        jQuery.ajax({
            type: "POST",
            url: "./modules/controllers/"+mod.toLowerCase()+"/"+ref.toLowerCase()+".php",
            data : formdata,
            dataType:'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(data){
                if(data.title=="SUCCESS"){
                    dialog(data.content,data.title);
                    GetModule(mod,submod,"NONE","NONE","SAVE",assoc_id);
                }else if(data.content==-1){
                  jQuery(".preloader").fadeOut();
                  document.location.href="./?error=1";
                }else{
                  jQuery(".preloader").fadeOut();
                  dialog(data.content,data.title);
                }
            },
            error: function(x,err,msj){
              jQuery(".preloader").fadeOut();
              Modal_error(x,err,msj);
            }
        });
      }
    }
  });
  <!-- START BLOCK : val -->
  block_controls(true);
  <!-- END BLOCK : val -->
</script>
<!-- END BLOCK : module -->