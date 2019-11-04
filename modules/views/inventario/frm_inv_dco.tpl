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
            <div>{form_title}<strong><span id="transaccion_">{id_tittle}</span></strong></div>
            <div class="ml-auto">ESTATUS: <span id="status_bagde" class="badge badge-pill ml-auto mr-3 font-medium px-2 py-1 {status_color}"><span id="status_">{stats_nom}</span><input type="hidden" id="stats" name="stats" value="{stats_code}"></span></div>
          </div>
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab_1" role="tab"><span class="hidden-xs-down">INFO BASICA</span></a> </li>
            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_2" role="tab"><span class="hidden-xs-down">ARTICULOS</span></a> </li>
            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_3" role="tab"><span class="hidden-xs-down">CONSULTAR</span></a> </li>
          </ul>
          <div class="tab-content tabcontent-border">
            <div class="tab-pane p-4 active" id="tab_1" role="tabpanel">
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="transaccion" class="control-label col-form-label">RECEP. FACTURAS</label>
                    <div class="input-group">
                      <input type="text" class="form-control validar" id="transaccion" name="transaccion" placeholder="SELECCIONE UNA RECEPCION A ANULAR" value="{codigo_}" readonly> 
                      <input type="hidden" id="ctransaccion" name="ctransaccion" >
                      <!-- START BLOCK : data_save_search -->
                      <div class="input-group-append"><button class="btn btn-outline-secondary ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="add_fac"><span class="fa fa-search"></button></div>
                        <!-- END BLOCK : data_save_search -->
                    </div>
                  </div>
                </div>
                <div class="col-sm-8">
                  <div class="form-group">
                    <label for="proveedor" class="control-label col-form-label">PROVEEDOR</label>
                    <input type="text" class="form-control" id="proveedor" name="proveedor" value="{data}" disabled>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="calmacen" class="control-label col-form-label">ALMACEN</label>
                    <input type="text" class="form-control" id="calmacen" name="calmacen" value="{almacen}" disabled>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="doc" class="control-label col-form-label">DOCUMENTO</label>
                    <input type="text" class="form-control" id="doc" name="doc" value="{documento}" disabled>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="f_doc" class="control-label col-form-label">FECHA DOCUMENTO</label>
                    <input type="text" class="form-control" id="f_doc" name="f_doc" value="{fecha_doc}" disabled>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="f_anul" class="control-label col-form-label">FECHA ANULACION</label>
                    <input type="text" class="form-control" id="f_anul" name="f_anul" value="{fecha_anul}" disabled>
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
                          <th>ARTICULO</th>
                          <th width="80px">CANT</th>
                          <th>PRECIO</th>
                          <th>IMP (%)</th>
                          <th>TOTAL</th>
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
                              <input name="costo[]" id="costo[{count}]" type="hidden" value="{costou}">
                              <input name="imp_p[]" id="imp_p[{count}]" type="hidden" value="{imp_p}">
                              {codigo2}
                            </td>
                            <td>{articulo}</td>
                            <td>
                              <input name="cant[]" id="cant[{count}]" type="text" style="width: 80px;" class="form-control cant numeric ctrl" value="{cant}">
                            </td>
                            <td class="number_cal">{costou}</td>
                            <td>{imp_p}</td>
                            <td>{costot} $</td>
                            <td>{actions}</td>
                          </tr>
                          <!-- END BLOCK : det_arts -->
                      </tbody>
                    </table>
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
            <div class="tab-pane p-4" id="tab_3" role="tabpanel">
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                      <label for="anulacion" class="control-label col-form-label">CONSULTAR ANULACION</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="anulacion" name="anulacion" placeholder="SELECCIONE UNA ANULACION A CONSULTAR" value="{codigo_}" readonly> 
                        <input type="hidden" id="canulacion" name="canulacion">
                        <div class="input-group-append"><button class="btn btn-outline-secondary" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="search_dnt"><span class="fa fa-search"></button></div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div id="auds" style="display: none;">
          <div class="card-body">
            <div class="row" style="font-size: 12px; text-align: justify;">
              <div class="col-sm-3"><strong>CREADO POR: </strong><span id="crea_u"></span></div>
              <div class="col-sm-3"><strong>FECHA: </strong><span id="crea_d"></span></div>
              <div class="col-sm-3"><strong>MODIFICADO POR: </strong><span id="mod_u"></span></div>
              <div class="col-sm-3"><strong>FECHA: </strong><span id="crea_d"></span></div>
            </div>
          </div>
          <hr>
        </div>
        <div class="card-body">
          <div class="action-form">
            <div class="form-group mb-0 text-center">
              <input type="hidden" id="accion" name="accion" value="{accion}">
              <input type="hidden" id="id" name="id" value="{codigo}">
              <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="MODULO" data-id="0"><span class="btn-label"><i class="fas fa-file"></i></span> NUEVO</button>
              <!-- START BLOCK : data_save -->
              <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="SAVE" data-id="0"><span class="btn-label"><i class="fas fa-save"></i></span> GUARDAR</button>
              <!-- END BLOCK : data_save -->
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<script>
  function cal_dco(){
    let cant = precio = bruto = impp = impm = total = all_sub = all_desc = all_total = 0, valido=true;
    if(jQuery('#table_art tbody tr').length>0){
      jQuery('#table_art tbody tr').each(function(index){
        cant = parseFloat(jQuery(this).find('input[id^="cant"]').val()), precio = parseFloat(jQuery(this).find('input[id^="costo"]').val()), impp = parseFloat(jQuery(this).find('input[id^="imp_p"]').val()), art = jQuery(this).find('td:eq(1)').text();
        if(cant<=0){
          dialog("LA CANTIDAD DEL ARTICULO <strong>"+art+"</strong> DEBE SER MAYOR A 0","ERROR");
          valido = valido && false;
          return false;
        }else{
          bruto = cant*precio;
          impm = (bruto*impp)/100;
          total = bruto + impm;
          all_sub = all_sub + total;
          jQuery(this).find('td:eq(5)').text(total).formatCurrency();
          valido = valido && true;
        }
      });
    }
    all_total = all_sub;
    jQuery('#table_totales tbody tr:eq(0) td:eq(0)').text(jQuery('#table_art tbody tr').length);
    jQuery('#table_totales tbody tr:eq(0) td:eq(1)').text(all_sub).formatCurrency();
    jQuery('#table_totales tbody tr:eq(0) td:eq(2)').text(all_total).formatCurrency();
    return valido;
  }
  jQuery(document).ready(function(){
    jQuery('#form_ button').click(function(){
      submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
      if(acc=="SAVE"){
        if(validate("transaccion")){
          if(count_row("table_art","ARTICULO")){
            SendForm(mod,submod,ref,subref,"#form_",false);
          }
        }
      }else if(acc=="add_fac"){
        modal_search("SELECCIONE UNA RECEP. DE FACTURA A ANULAR",'accion='+acc+'&mod='+submod,'POST',false,false);
      }else if(acc=="search_dco"){
        modal_search("SELECCIONE UNA CANCELACION A CONSULTAR",'accion='+acc+'&mod='+submod,'POST',false,false);
      }
    });
  });
</script>
<!-- END BLOCK : module -->