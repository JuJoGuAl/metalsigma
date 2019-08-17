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
                      <label for="ods" class="control-label col-form-label">ODS</label>
                      <div class="input-group">
                        <input type="text" class="form-control validar" id="ods" name="ods" placeholder="SELECCIONE UNA ODS" value="{ods_pad}" readonly> 
                        <input type="hidden" id="cods" name="cods" value="{ccotizacion}">
                        <div class="input-group-append"><button class="btn btn-outline-secondary ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="search_ods"><span class="fa fa-search"></span></button></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label for="cliente" class="control-label col-form-label">CLIENTE</label>
                      <input type="text" class="form-control" id="cliente" name="cliente" value="{cot_cliente}" readonly>
                    </div>
                  </div>
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
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="f_mov" class="control-label col-form-label">FECHA CARGA</label>
                      <input type="text" class="form-control validar ctrl" id="f_mov" name="f_mov" value="{fecha_mov}" readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
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
                            <th>CODIGO INT.</th>
                            <th>ARTICULO</th>
                            <th width="100px">CANT DISP<br>(ODS)</th>
                            <th width="100px">CANT DISP<br>(STOCK) <span class="fas fa-info-circle" rel="popover" data-placement="top" data-toggle="popover" data-content="LA CANT EN STOCK TOTAL ES LA SUMA DEL STOCK MENOS LA RESERVA ACTUAL"></span></th>
                            <th width="100px">RESERVA<br>ACTUAL</th>
                            <th width="100px">CANT A DESP.</th>
                            <th>OPCION</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- START BLOCK : det_arts -->
                          <tr>
                            <td>
                              <input name="carticulo[]" id="carticulo[{count}]" type="hidden" value="{codigo_articulo}">
                              <input name="cot_det[]" id="cot_det[{count}]" type="hidden" value="{codigo_nte_det}">
                              <input name="precio[]" id="precio[{count}]" type="hidden" value="{costou}">
                              {codigo_articulo}
                            </td>
                            <td>{codigo2}</td>
                            <td>{articulo}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>{cant}</td>
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
  function check_reserva(){
    let valido = false;
    jQuery('#table_art tbody tr').each(function(){
      let cant = parseFloat(jQuery(this).find('input[id^="cant"]').val()), cant_ods = parseFloat(jQuery(this).find('td:eq(3)').text()), cant_sotck = parseFloat(jQuery(this).find('td:eq(4)').text()), cant_res = parseFloat(jQuery(this).find('td:eq(5)').text()), art = jQuery(this).find("td:eq(2)").text() ;
        if(cant<=0 || cant=="" || cant == null || cant == undefined){
            valido = false;
            jQuery(this).addClass("table-danger");
            dialog("DEBE INDICAR UNA CANTIDAD PARA EL ARTICULO <strong>"+art+"</strong>","ERROR");
            return false;
        }else{
            if(cant>cant_ods){
                valido = false;
                jQuery(this).addClass("table-danger");
                dialog("LA CANTIDAD A CONSUMIR PARA EL ARTICULO <strong>"+art+"</strong> ES MAYOR A LA PENDIENTE EN LA ODS","ERROR");
                return false;
            }else if(cant>(cant_sotck+cant_res)){
                valido = false;
                jQuery(this).addClass("table-danger");
                dialog("LA CANTIDAD A CONSUMIR PARA EL ARTICULO <strong>"+art+"</strong> ES MAYOR A LA DISPONIBLE EN STOCK","ERROR");
                return false;
            }else{
                valido = true;
                jQuery(this).removeClass("table-danger");
            }
        }
    });
    return valido;
  }
  jQuery(document).ready(function(){
    jQuery('button').on('click', function(){
      submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
      if(acc=="SAVE"){
        if(count_row("table_art","ARTICULO")){
          if(check_reserva()){
            SendForm(mod,submod,ref,subref,"#form_",false);
          }
        }
      }else if(acc=="search_ods"){
        if(validate("almacen")){
          modal_search("SELECCIONE UNA ODS A RESERVAR",'accion='+acc+'&mod='+submod,'POST',false,false);
        }
      }
    });
    <!-- START BLOCK : val -->
    jQuery(".dates").datepicker("destroy");
    block_controls(true);
    <!-- END BLOCK : val -->
  });
</script>
<!-- END BLOCK : module -->