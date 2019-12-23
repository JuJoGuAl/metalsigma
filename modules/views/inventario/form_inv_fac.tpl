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
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_2" role="tab"><span class="hidden-xs-down">ORDENES DE 
              COMPRA</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_3" role="tab"><span class="hidden-xs-down">GUIAS DE DESPACHO</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_4" role="tab"><span class="hidden-xs-down">ARTICULOS</span></a> </li>
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
                      <label for="doc" class="control-label col-form-label">DOCUMENTO</label>
                      <input type="text" class="form-control numeric validar ctrl" id="doc" name="doc" value="{documento}" maxlength="10">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="f_doc" class="control-label col-form-label">FECHA DOCUMENTO</label>
                      <input type="text" class="form-control validar dates ctrl" id="f_doc" name="f_doc" value="{fecha_doc}">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="f_mov" class="control-label col-form-label">FECHA CARGA</label>
                      <input type="text" class="form-control validar ctrl" id="f_mov" name="f_mov" value="{fecha_mov}" readonly>
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
                      <table class="table table-bordered table-hover" id="table_odc">
                        <thead>
                          <tr>
                            <th>CODIGO</th>
                            <th>PROVEEDOR</th>
                            <th>FECHA</th>
                            <th>ARTS</th>
                            <th>MONTO</th>
                            <th>OPCION</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- START BLOCK : det_odc -->
                          <tr>
                            <td>
                              <input name="corden[]" id="corden[{count}]" type="hidden" value="{codigo}">{codigo}
                            </td>
                            <td>{data}</td>
                            <td>{fecha_orden}</td>
                            <td>{articulos}</td>
                            <td class="number_cal">{monto_total}</td>
                            <td>{actions}</td>
                          </tr>
                          <!-- END BLOCK : det_odc -->
                        </tbody>
                      </table>
                      <p style="text-align:left;">
                        <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="add_odc" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span> AGREGAR</button>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_3" role="tabpanel">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover" id="table_nte">
                        <thead>
                          <tr>
                            <th>CODIGO</th>
                            <th>PROVEEDOR</th>
                            <th>FECHA</th>
                            <th>ARTS</th>
                            <th>MONTO</th>
                            <th>OPCION</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- START BLOCK : det_nte -->
                          <tr>
                            <td>
                              <input name="cnota[]" id="cnota[{count}]" type="hidden" value="{codigo_cab}">{codigo_cab}
                            </td>
                            <td>{data}</td>
                            <td>{fecha_mov}</td>
                            <td>{articulos}</td>
                            <td>{monto_total}</td>
                            <td>{actions}</td>
                          </tr>
                          <!-- END BLOCK : det_nte -->
                        </tbody>
                      </table>
                      <p style="text-align:left;">
                        <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="add_nte" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span> AGREGAR</button>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_4" role="tabpanel">
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
                            <th>ORIGEN</th>
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
                                <input name="cnte[]" id="cnte[{count}]" type="hidden" value="{codigo_nte_cab}">
                                <input name="cnte_det[]" id="cnte_det[{count}]" type="hidden" value="{codigo_nte_det}">
                                <input name="costo[]" id="costo[{count}]" type="hidden" value="{costou}">
                                <input name="imp_p[]" id="imp_p[{count}]" type="hidden" value="{imp_p}">
                                {codigo2}
                              </td>
                              <td>{articulo}</td>
                              <td>
                                {cant}
                                <input name="cant[]" id="cant[{count}]" type="hidden" value="{cant}">
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
  function cal_fac(){
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
    cal_fac();
    jQuery('#form_ button').click(function(){
      submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
      if(acc=="SAVE" || acc=="PROC"){
        if(validate("rut")){
          if(count_row("table_art","ARTICULO")){
            if(acc=="PROC"){ jQuery("#accion").val("proc"); }
            SendForm(mod,submod,ref,subref,"#form_",false);
          }
        }
      }else if(acc=="add_odc" || acc=="add_nte"){
        if(validate("rut")){
          if(validate("almacen")){
            if(acc=="add_odc"){
              table ="table_odc";
              campo="corden";
            }else{
              table ="table_nte";
              campo="cnota";
            }
            let non_det = new Array();
            jQuery('#'+table+' tbody tr td input[id^="'+campo+'"]').each(function(row, tr){
              non_det.push(jQuery(this).val());
            });
            if(acc=="add_odc"){
              modal_search("SELECCIONE UNA ODC A AGREGAR",'accion='+acc+'&mod='+submod+'&prov='+jQuery("#cproveedor").val()+'&not='+JSON.stringify(non_det),'POST',false,false);
            }else{
              modal_search("SELECCIONE UNA GUIA A AGREGAR",'accion='+acc+'&mod='+submod+'&prov='+jQuery("#cproveedor").val()+'&alm='+jQuery("#calmacen").val()+'&not='+JSON.stringify(non_det),'POST',false,false);
            }        
          }else{ jQuery('a[href="#tab_1"]').trigger('click'); }      
        }else{ jQuery('a[href="#tab_1"]').trigger('click'); }
      }else if(acc=="search_proveedor"){
        modal_search("SELECCIONE UN PROVEEDOR",'accion='+acc+'&mod='+submod,'POST',false,false);
      }else if(acc=="search_almacen_compra"){
        modal_search("SELECCIONE UN ALMACEN",'accion='+acc+'&mod='+submod,'POST',false,false);
      }
    });
    <!-- START BLOCK : val -->
    block_controls(true);
    setTimeout(function() { jQuery(".dates").datepicker("destroy"); }, 100);
    <!-- END BLOCK : val -->
  });
</script>
<!-- END BLOCK : module -->