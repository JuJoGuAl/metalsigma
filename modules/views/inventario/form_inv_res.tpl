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
                      <input type="text" class="form-control" id="cliente" name="cliente" value="{cliente}" readonly>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_2" role="tabpanel">
                <div class="row">
                  <div class="col-lg-12">
                    <p class="text-muted mt-0"><strong>NOTA: </strong>TOME EN CUENTA QUE SI REALIZA UNA RESERVA DE UN ARTICULO YA RESERVADO ESTA SERA REEMPLAZADA</p>
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover" id="table_art">
                        <thead>
                          <tr>
                            <th>CODIGO</th>
                            <th>CODIGO INT.</th>
                            <th>ARTICULO</th>
                            <th width="100px">CANT DISP<br>(ODS)</th>
                            <th width="100px">CANT DISP<br>(STOCK) <span class="fas fa-info-circle" rel="popover" data-placement="top" data-toggle="popover" data-content="LA CANT EN STOCK TOTAL ES LA SUMA DEL STOCK MAS LA RESERVA ACTUAL"></span></th>
                            <th width="100px">RESERVA<br>ACTUAL</th>
                            <th width="100px">CANT A RESRV.</th>
                            <th>OPCIONES</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="notas" class="control-label col-form-label">NOTAS</label>
                  <textarea class="form-control ctrl" rows="3" id="notas" name="notas">{notas}</textarea>
                </div>
              </div>
            </div>
          </div>
          <hr>
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
                dialog("LA CANTIDAD A RESERVAR PARA EL ARTICULO <strong>"+art+"</strong> ES MAYOR A LA PENDIENTE EN LA ODS","ERROR");
                return false;
            }else if(cant>(cant_sotck+cant_res)){
                valido = false;
                jQuery(this).addClass("table-danger");
                dialog("LA CANTIDAD A RESERVAR PARA EL ARTICULO <strong>"+art+"</strong> ES MAYOR A LA DISPONIBLE EN STOCK","ERROR");
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
      }else if(acc=="search_almacen"){
        modal_search("SELECCIONE UN ALMACEN",'accion='+acc+'&mod='+submod,'POST',false,false);
      }
    });
    <!-- START BLOCK : val -->
    jQuery(".dates").datepicker("destroy");
    block_controls(true);
    <!-- END BLOCK : val -->
  });
</script>
<!-- END BLOCK : module -->