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
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_2" role="tab"><span class="hidden-xs-down">SERVICIOS</span></a> </li>
            </ul>
            <div class="tab-content tabcontent-border">
              <div class="tab-pane p-4 active" id="tab_1" role="tabpanel">
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="rut" class="control-label col-form-label">RUT</label>
                      <div class="input-group">
                        <input type="text" class="form-control validar" id="rut" name="rut" placeholder="SELECCIONE UN PROVEEDOR" value="{code}" readonly> 
                        <input type="hidden" id="cproveedor" name="cproveedor" value="{codigo_proveedor}">
                        <div class="input-group-append"><button class="btn btn-outline-secondary ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="search_proveedor"><span class="fa fa-search"></span></button></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label for="proveedor" class="control-label col-form-label">PROVEEDOR</label>
                      <input type="text" class="form-control" id="proveedor" name="proveedor" value="{data}" readonly>
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
                      <label for="fecha" class="control-label col-form-label">FECHA</label>
                      <input type="text" class="form-control validar dates ctrl" id="fecha" name="fecha" value="{fecha}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_2" role="tabpanel">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover" id="table_det_odc">
                        <thead>
                          <tr>
                            <th>CODIGO</th>
                            <th>CODE</th>
                            <th>SERVICIO</th>
                            <th>CANT</th>
                            <th>PRECIO</th>
                            <th>IMP</th>
                            <th>TOTAL</th>
                            <th>OPC</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- START BLOCK : art_det -->
                          <tr>
                            <td>
                              <input name="corden_det[]" id="corden_det[{count}]" type="hidden" class="hidden" value="{codigo}">
                              <input name="carticulo[]" id="carticulo[{count}]" type="hidden" class="hidden" value="{codigo_art}">
                              {codigo_art}
                            </td>
                            <td>{codigo2}</td>
                            <td>{articulo}</td>
                            <td><input type="text" id="cant[{count}]" name="cant[]" class="form-control numeric ctrl" maxlength="10" style="width:100px" value="{cant}"></td>
                            <td><input type="text" id="precio[{count}]" name="precio[]" class="form-control numeric ctrl" maxlength="12" style="width:100px" value="{costou}"></td>
                            <td><input type="text" id="imp[{count}]" name="imp[]" class="form-control" maxlength="5" style="width:100px" value="{imp_p}" readonly></td>
                            <td><input type="text" id="total[{count}]" name="total[]" class="form-control" maxlength="12" style="width:100px" value="{costot}" readonly></td>
                            <td>{actions}</td>
                          </tr>
                          <!-- END BLOCK : art_det -->
                        </tbody>
                      </table>
                      <input type="hidden" id="accion" name="accion" value="{accion}">
                      <input type="hidden" id="id" name="id" value="{codigo}">
                      <div class="button-group">
                        <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="add_serv_cot" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span> AGREGAR</button>
                        <form role="form" name="subida" id="subida" enctype="multipart/form-data">
                          <input type="file" class="custom-file-input" style="width: 1px;" id="excel" name="excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                          <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="add_art_cot_excel" data-id="0"><span class="btn-label"><i class="fas fa-upload"></i></span> EXCEL</button>
                        </form>
                        <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="DWN" data-id="0"><span class="btn-label"><i class="fas fa-download"></i></span> BAJAR DEMO EXCEL</button>
                      </div>
                      <table class="table" id="table_totales">
                        <thead>
                          <tr>
                            <th>ARTICULOS</th>
                            <th>SUB TOTAL</th>
                            <th>TOTAL</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
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
  cal_odc();
  jQuery("#form_").on("keypress, keyup",function(){
    cal_odc();
  });
  jQuery('button').on('click', function(){
    submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
    if(acc=="SAVE"){
      if(check_datas_odc()){
        SendForm(mod,submod,ref,subref,"#form_",false);
      }
    }else if(acc=="PROC"){
      jQuery('#accion').val("proc");
      if(check_datas_odc()){
        SendForm(mod,submod,ref,subref,"#form_",false);
      }
    }else if(acc=="add_serv_cot"){
      let non_det = new Array();
      jQuery('#table_det_odc tbody tr td input[id^="carticulo"]').each(function(row, tr){
        non_det.push(jQuery(this).val());
      });
      modal_search("SELECCIONE UN SERVICIO",'accion='+acc+'&mod='+submod+'&not='+JSON.stringify(non_det),'POST',false,false);
    }else if(acc=="search_proveedor"){
      modal_search("SELECCIONE UN PROVEEDOR",'accion='+acc+'&mod='+submod,'POST',false,false);
    }else if(acc=="add_art_cot_excel"){
      jQuery('#excel').trigger('click');
    }else if(acc=="DWN"){
      var newwindow = window.open("./assets/files/ejemplo_subida_compras.xlsx");
      newwindow.focus();
      newwindow.onblur = function() {
        newwindow.close();
      }
    }
  });
  $("#excel").change(function(e) {
    clear_log();
    jQuery(".preloader").fadeIn();
    var file = this.files[0];
    let form = jQuery('#form_')[0];
    var formdata = new FormData(form);
    formdata.append('media', file);
    formdata.append('mod',"crud_odc");
    formdata.append('accion',"upload_excel");
    jQuery.ajax({
        type: "POST",
        url: "./modules/controllers/ajax.php",
        data : formdata,
        dataType:'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            if(data.title=="SUCCESS"){
              jQuery("#excel").val(null);
              jQuery.each(data.content, function(key,value){
                tabla="table_det_odc";
                var count = (jQuery("#"+tabla+" tbody tr").length)+1;
                tr=`<tr>
                <td>
                  <input name="corden_det[]" id="corden_det[`+count+`]" type="hidden" class="hidden" value="0">
                  <input name="carticulo[]" id="carticulo[`+count+`]" type="hidden" value="`+value.codigo+`">`+value.codigo+`</td>
                <td>`+value.codigo2+`</td>
                <td>`+value.articulo+`</td>
                <td><input type="text" id="cant[`+count+`]" name="cant[]" class="form-control numeric" maxlength="10" style="width:100px" value="`+value.cant_+`"></td>
                <td><input type="text" id="precio[`+count+`]" name="precio[]" class="form-control numeric" maxlength="12" style="width:100px" value="`+value.precio_+`"></td>
                <td><input type="text" id="imp[`+count+`]" name="imp[]" class="form-control numeric" maxlength="12" style="width:100px" value="`+data.imp+`" readonly></td>
                <td><input type="text" id="total[`+count+`]" name="total[]" class="form-control" style="width:100px" value="0" disabled></td>
                <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
                </tr>`;              
                jQuery("#"+tabla+" tbody").append(tr);
              });
              cal_odc();
              jQuery(".preloader").fadeOut();
            }else if(data.content==-1){
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
  });
  <!-- START BLOCK : val -->
  block_controls(true);
  <!-- END BLOCK : val -->
</script>
<!-- END BLOCK : module -->