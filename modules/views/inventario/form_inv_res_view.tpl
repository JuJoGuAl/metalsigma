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
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="ods" class="control-label col-form-label">ODS</label>
                      <div class="input-group">
                        <input type="text" class="form-control validar" id="ods" name="ods" value="{ods_pad}" disabled> 
                        <input type="hidden" id="cods" name="cods" value="{ccotizacion}" disabled>                        
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label for="cliente" class="control-label col-form-label">CLIENTE</label>
                      <input type="text" class="form-control" id="cliente" name="cliente" value="{data}" disabled>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="almacen" class="control-label col-form-label">ALMACEN</label>
                      <div class="input-group">
                        <input type="text" class="form-control validar" id="almacen" name="almacen" value="{almacen}" disabled> 
                        <input type="hidden" id="calmacen" name="calmacen" value="{codigo_almacen}" disabled>                        
                      </div>
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
                            <th width="100px">CANT RESRV.</th>
                            <th>NOTAS</th>
                            <th>EST.</th>
                            <th>CREADOR</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- START BLOCK : art_det -->
                          <tr>
                            <td>
                              <input name="carticulo[]" id="carticulo[{count}]" type="hidden" class="hidden" value="{carticulo}">
                              {carticulo}
                            </td>
                            <td>{codigo2}</td>
                            <td>{articulo}</td>
                            <td>{cant}</td>
                            <td>{notas_par}</td>
                            <td>{esta_}</td>
                            <td>{crea_user}</td>
                          </tr>
                          <!-- END BLOCK : art_det -->
                        </tbody>
                      </table>
                    </div>
                  </div>
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
      let cant = parseFloat(jQuery(this).find('input[id^="cant"]').val()), cant_ods = parseFloat(jQuery(this).find('td:eq(3)').text()), art = jQuery(this).find("td:eq(2)").text() ;
        if(cant<=0 || cant=="" || cant == null || cant == undefined){
            valido = false;
            jQuery(this).addClass("table-danger");
            dialog("DEBE INDICAR UNA CANTIDAD PARA EL ARTICULO <strong>"+art+"</strong>","ERROR");
            return false;
        }else{
            if(cant>cant_ods){
                valido = false;
                jQuery(this).addClass("table-danger");
                dialog("LA CANTIDAD A RESERVAR PARA EL ARTICULO <strong>"+art+"</strong> ES MAYOR A LA PENDIENTE","ERROR");
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
    jQuery(".pop").each(function(){
      jQuery(this).popover({
        title: '<div style="font-size: 12px;"><strong>OBSERVACIONES</strong></div>',
        content: '<div style="font-size: 12px;">'+jQuery(this).attr("data-body")+'</div>',
        trigger: 'hover',
        placement: 'left',
        container: 'body',
        html: true
      });
    });
    jQuery('button').on('click', function(){
      submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
      if(acc=="SAVE"){
        if(count_row("table_art","ARTICULO")){
          if(check_reserva()){
            SendForm(mod,submod,ref,subref,"#form_",false);
          }
        }
      }else if(acc=="search_ods"){
        modal_search("SELECCIONE UNA ODS A RESERVAR",'accion='+acc+'&mod='+submod,'POST',false,false);
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