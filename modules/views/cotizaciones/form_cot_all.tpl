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
<div id="modal_maq_cliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">ASIGNE UN NUEVO EQUIPO AL CLIENTE</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <form role="form" name="form_eq_cli" id="form_eq_cli" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="rut_" class="control-label col-form-label">RUT</label>
                      <input type="text" class="form-control" id="rut_" name="rut_" disabled> 
                      <input type="hidden" id="ccliente_" name="ccliente_" value="">
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label for="cliente_" class="control-label col-form-label">CLIENTE</label>
                      <input type="text" class="form-control" id="cliente_" name="cliente_" disabled>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="serial_" class="control-label col-form-label">SERIAL</label>
                      <input type="text" class="form-control validar" id="serial_" name="serial_" value="">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="interno_" class="control-label col-form-label"># INTERNO</label>
                      <input type="text" class="form-control validar" id="interno_" name="interno_" value="">
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered table-hover datatables" id="eqs_cli_">
                    <thead>
                      <tr>
                        <th>CODIGO</th>
                        <th>EQUIPO</th>
                        <th>MARCA</th>
                        <th>MODELO</th>
                        <th>SEGMENTO</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- START BLOCK : equipos -->
                      <tr>
                        <td>{codigo}</td>
                        <td>{equipo}</td>
                        <td>{marca}</td>
                        <td>{modelo}</td>
                        <td>{segmento}</td>                        
                      </tr>
                      <!-- END BLOCK : equipos -->
                    </tbody>
                  </table>
                  <input type="hidden" id="equipo" name="equipo" value="">
                </div>
              </form>              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect text-left" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="SAVE_EQUIPO">ACEPTAR</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">CERRAR</button>
            </div>
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
            <h6 class="card-subtitle"></h6>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="rut" class="control-label col-form-label">RUT</label>
                  <div class="input-group">
                    <input type="text" class="form-control validar" id="rut" name="rut" placeholder="SELECCIONE UN CLIENTE" value="{code}" readonly> 
                    <input type="hidden" id="ccliente" name="ccliente" value="">
                    <div class="input-group-append"><button class="btn btn-outline-secondary ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="search_cliente"><span class="fa fa-search"></span></button></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-8">
                <div class="form-group">
                  <label for="cliente" class="control-label col-form-label">CLIENTE</label>
                  <input type="text" class="form-control" id="cliente" name="cliente" value="" readonly>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="direccion" class="control-label col-form-label">DIRECCION</label>
                  <input type="text" class="form-control" id="direccion" name="direccion" value="{direccion}" readonly>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="pago" class="control-label col-form-label">TIPO PAGO</label>
                  <input type="text" class="form-control" id="pago" name="pago" value="" readonly>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="credito" class="control-label col-form-label">MAX CREDITO</label>
                  <input type="text" class="form-control" id="credito" name="credito" value="" readonly>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="descuento" class="control-label col-form-label">MAX DESCUENTO</label>
                  <input type="text" class="form-control" id="descuento" name="descuento" value="" readonly>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover" id="table_eqs_cot">
                    <thead>
                      <tr>
                        <th>CODIGO</th>
                        <th>EQUIPO</th>
                        <th>SEGMENTO</th>
                        <th># SERIE</th>
                        <th># INTERNO</th>
                        <th>OPC</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                  <p style="text-align:left;">
                    <button id="add_eqs" class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="add_eqs_cot" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span> AGREGAR</button>
                  </p>
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
  jQuery('button').on('click', function(){
    submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
    if(acc=="SAVE"){
      if(validate("rut")){
        if(count_row("table_eqs_cot","EQUIPO")){
          jQuery(".preloader").fadeIn();
          SendForm(mod,submod,ref,subref,"#form_",false);
        }
      }
    }else if(acc=="add_eqs_cot"){
      if(validate("rut")){
        jQuery("#Modal_ #add_new div div button").attr("data-acc","NEW_MAQ_CLI");
        modal_search("SELECCIONE UN EQUIPO DEL CLIENTE",'accion='+acc+'&mod='+submod+'&cli='+jQuery("#ccliente").val(),'POST',true,false);
      }
    }else if(acc=="search_cliente"){
      modal_search("SELECCIONE UN CLIENTE",'accion='+acc+'&mod='+submod,'POST',false,false);
    }else if(acc=="NEW_MAQ_CLI"){
      jQuery("#equipo").val("");
      jQuery("#serial_").val("");
      jQuery("#interno_").val("");
      jQuery("#rut_").val(jQuery("#rut").val());
      jQuery("#ccliente_").val(jQuery("#ccliente").val());
      jQuery("#cliente_").val(jQuery("#cliente").val());
      jQuery(".modal").modal("hide");
      jQuery("#eqs_cli_").DataTable().destroy();
      jQuery("#eqs_cli_").DataTable({
        "pageLength": 10,
        initComplete: function () {
          jQuery("input[type='search']").focus();
        }
      });
      jQuery("#eqs_cli_ tbody").find(".table-success").removeClass("table-success");
      jQuery("#modal_maq_cliente").css("z-index","2500");
      jQuery("#modal_maq_cliente").modal({show:true,backdrop: 'static',keyboard: false});
    }else if(acc=="SAVE_EQUIPO"){
      if(jQuery("#equipo").val()=="" || jQuery("#equipo").val()<=0){
        dialog("DEBE SELECCIONAR UN EQUIPO!","ERROR");
      }else{
        form = "#form_eq_cli";
        if(valform(form)){
          jQuery(".preloader").fadeIn();
          jQuery.ajax({
              type: "GET",
              url: "./modules/controllers/cotizaciones/form_cot_all.php",
              data : jQuery(form).serialize() + "&mod=cotizaciones&submod=crud_cot_all&accion=new_eq_cli",
              dataType:'json',
              success: function(data){
                  if(data.title=="SUCCESS"){
                    let maquina = data.maquina;
                    var count = (jQuery("#table_eqs_cot tbody tr").length)+1;
                    tr=`<tr>
                    <td><input name="cmaquina[]" id="cmaquina[`+count+`]" type="hidden" value="`+maquina.codigo+`">`+maquina.codigo+`</td>
                    <td>`+maquina.equipo+` `+maquina.marca+` `+maquina.modelo+`</td>
                    <td>`+maquina.segmento+`</td>
                    <td>`+maquina.serial+`</td>
                    <td>`+maquina.interno+`</td>
                    <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>`;
                    jQuery("#table_eqs_cot tbody").append(tr);
                    jQuery("#add_eqs").fadeOut();
                  }else if(data.content==-1){
                      document.location.href="./?error=1";
                  }else{
                      dialog(data.content,data.title);
                  }
                  jQuery("#modal_maq_cliente").modal('hide');
                  jQuery(".preloader").fadeOut();
              },
              error: function(x,err,msj){
                jQuery(".preloader").fadeOut();
                  Modal_error(x,err,msj);
              }
          });
        }
      }
    }
  });
  jQuery("#eqs_cli_ tbody tr").on("click", function (e){
    jQuery("#eqs_cli_ tbody").find(".table-success").removeClass("table-success");
    jQuery(this).addClass("table-success");
    jQuery("#equipo").val(jQuery(this).find("td:eq(0)").text());
  });
  <!-- START BLOCK : val -->
  block_controls(true);
  <!-- END BLOCK : val -->
</script>
<!-- END BLOCK : module -->