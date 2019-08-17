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
              <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab_1" role="tab"><span class="hidden-xs-down">OCUPACION</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_2" role="tab"><span class="hidden-xs-down">TRABAJOS</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_3" role="tab"><span class="hidden-xs-down">AVANCE</span></a> </li>
            </ul>
            <div class="tab-content tabcontent-border">
              <div class="tab-pane p-4 active" id="tab_1" role="tabpanel">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="finicio" class="control-label col-form-label">FECHA INICIO</label>
                      <input type="text" class="form-control dates" id="finicio" name="finicio" autocomplete="off" value="{fecha}">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="ffin" class="control-label col-form-label">FECHA FIN</label>
                      <input type="text" class="form-control dates" id="ffin" name="ffin" autocomplete="off" value="{fecha}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <br>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="ocupacion">
                      <thead>
                        <tr>
                          <th width="40%">TRABAJADOR / CARGO</th>
                          <th width="60%">OCUPACION</th>                          
                        </tr>
                      </thead>
                      <tbody>
                        <!-- START BLOCK : data -->
                        <tr>
                          <td>{trabajador} ({cargo})</td>
                          <td>
                            <div class="progress" style="height: 20px; position: relative;">
                              <div class="d-flex no-block align-items-center" style="position: absolute; width: 100%;"><span class="mx-auto" style="font-size: 0.8rem; color: #000;">{ocupa%}%</span></div>
                              <div class="progress-bar bg-success" role="progressbar" style="width: {ocupa}%; height: 20px;"></div>
                            </div>
                          </td>
                        </tr>
                        <!-- END BLOCK : data -->
                        <!-- START BLOCK : prom -->
                        <tr class="table-primary">
                          <td>PROMEDIO OCUPACION</td>
                          <td>
                            <div class="progress" style="height: 20px; position: relative;">
                              <div class="d-flex no-block align-items-center" style="position: absolute; width: 100%;"><span class="mx-auto" style="font-size: 0.8rem; color: #000;">{ocupa%_prom}%</span></div>
                              <div class="progress-bar bg-success" role="progressbar" style="width: {ocupa_prom}%; height: 20px;"></div>
                            </div>
                          </td>
                        </tr>
                        <!-- END BLOCK : prom -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_2" role="tabpanel">
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="fecha" class="control-label col-form-label">FECHA</label>
                      <input type="text" class="form-control dates" id="fecha" name="fecha" autocomplete="off" value="{fecha}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <br>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="trabajos">
                      <thead>
                        <tr>
                          <th width="30%">TRABAJADOR / CARGO</th>
                          <th width="35%">MAÑANA</th>
                          <th width="35%">TARDE</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- START BLOCK : trabajos -->
                        <tr>
                          <td style="vertical-align: middle;">{trabajador} ({cargo})</td>
                          <td>
                          <!-- START BLOCK : trabajos_det_man -->
                          <span class="font-weight-bold">{inicio} - {fin}</span> {codigo_ods}: {equipo} {marca} {modelo} de {cli_data} ({lugar})
                          <ul>
                            <!-- START BLOCK : listados_man -->
                            <li>{tarea}</li>
                            <!-- END BLOCK : listados_man -->
                          </ul>
                          <br>
                          <!-- END BLOCK : trabajos_det_man -->
                          </td>
                          <td>
                          <!-- START BLOCK : trabajos_det_tar -->
                          <span class="font-weight-bold">{inicio} - {fin}</span> {codigo_ods}: {equipo} {marca} {modelo} de {cli_data} ({lugar})
                          <ul>
                            <!-- START BLOCK : listados_tar -->
                            <li>{tarea}</li>
                            <!-- END BLOCK : listados_tar -->
                          </ul>
                          <br>
                          <!-- END BLOCK : trabajos_det_tar -->
                          </td>
                        </tr>
                        <!-- END BLOCK : trabajos -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_3" role="tabpanel">
                <div class="row">
                  <br>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped datatables" id="avance">
                      <thead>
                        <tr>
                          <th rowspan="2" style="vertical-align: middle;" width="5%">COT</th>
                          <th rowspan="2" style="vertical-align: middle;"  width="5%">ODS</th>
                          <th rowspan="2" style="vertical-align: middle;"  width="20%">EQUIPO</th>
                          <th rowspan="2" style="vertical-align: middle;"  width="20%">CLIENTE</th>
                          <th rowspan="2" style="vertical-align: middle;"  width="20%">TRABAJOS</th>
                          <th rowspan="2" style="vertical-align: middle;"  width="15%">EDO. AVANCE</th>
                          <th colspan="3" style="vertical-align: middle; text-align: center;"  width="15%">HORAS</th>                          
                        </tr>
                        <tr>
                          <th width="5%">COT.</th>
                          <th width="5%">UTIL.</th>
                          <th width="5%">ADIC.</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- START BLOCK : avance -->
                        <tr>
                          <td style="vertical-align: middle;">{cot_full}</td>
                          <td style="vertical-align: middle;">{ods_full}</td>
                          <td style="vertical-align: middle;">{equipo} {marca} {modelo}<br><span style="font-size: 11px">S/N: {serial}</span></td>
                          <td style="vertical-align: middle;">{data}</td>
                          <td>
                            <ul>
                              <!-- START BLOCK : trabajos -->
                              <li>{tarea}</li>
                              <!-- END BLOCK : trabajos -->
                            </ul>
                          </td>
                          <td style="vertical-align: middle;">{avance} %</td>
                          <td style="vertical-align: middle;">{horas}</td>
                          <td style="vertical-align: middle;">{ocupado}</td>
                          <td style="vertical-align: middle;">{adic}</td>
                        </tr>
                        <!-- END BLOCK : avance -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  jQuery('#fecha').datepicker().on('changeDate', function(){
    jQuery(".preloader").fadeIn();
      jQuery.ajax({
        type: "POST",
        url: "./modules/controllers/ajax.php",
        data : "accion=refresh_rep_trabajos&date="+jQuery("#fecha").val()+"&mod=rep_plan",
        dataType:'json',
        success: function(data){
          jQuery('#trabajos tbody').empty();
          if(data.title=="SUCCESS"){
            jQuery(data.content).each(function(index,value){
              tr=`<tr>
              <td>`+value.data+` (`+value.cargo+`)</td>`;
              let td_man = td_tar = ``;
              jQuery(value.trabajos).each(function(index1,value1){
                let lista = `<ul>`;
                jQuery(value1.servicios).each(function(index2,value2){
                  lista += `<li>`+value2.articulo+`</li>`;
                });
                lista += `</ul>`;

                eval("td_"+value1.bloque+ "+=`" + `<span class="font-weight-bold">`+value1.inicio+` - `+value1.fin+`</span> `+value1.codigo_ods+`: `+value1.equipo+` `+value1.marca+` `+value1.modelo+` de `+value1.cli_data+` (`+value1.lugar+`)`+lista+"`;");
              });
              tr +=`<td>`+td_man+`</td><td>`+td_tar+`</td>`;
              tr +=`</tr>`;
              jQuery("#trabajos tbody").append(tr);
            });
          }else if(data.content==-1){
            document.location.href="./?error=1";
          }
          jQuery(".preloader").fadeOut();
        },
        error: function(x,err,msj){
            jQuery(".preloader").fadeOut();
            Modal_error(x,err,msj);
        }
      });
  });
  jQuery('#finicio, #ffin').datepicker().on('changeDate', function(){
    let startTime=moment(jQuery("#finicio").val(), "DD-MM-YYYY"), endTime=moment(jQuery("#ffin").val(), "DD-MM-YYYY");
    if(endTime<startTime){
      dialog("LA FECHA FIN DEBE SER MAYOR O IGUAL A LA FECHA DE INICIO","ERROR");
    }else{
      jQuery(".preloader").fadeIn();
      jQuery.ajax({
        type: "POST",
        url: "./modules/controllers/ajax.php",
        data : "accion=refresh_rep_ocupacion&fini="+jQuery("#finicio").val()+"&ffin="+jQuery("#ffin").val()+"&mod=rep_plan",
        dataType:'json',
        success: function(data){
          jQuery('#ocupacion tbody').empty();
          if(data.title=="SUCCESS"){
            jQuery(data.content).each(function(index,value){
              tr=`<tr>
              <td>`+value.trabajador+` (`+value.cargo+`)</td>`;
              tr +=`<td>
              <div class="progress" style="height: 20px; position: relative;">
                <div class="d-flex no-block align-items-center" style="position: absolute; width: 100%;"><span class="mx-auto" style="font-size: 0.8rem; color: #000;">`+value.ocupa_+`%</span></div>
                <div class="progress-bar bg-success" role="progressbar" style="width: `+value.ocupa+`%; height: 20px;"></div>
              </div></td>
              `;
              tr +=`</tr>`;
              jQuery("#ocupacion tbody").append(tr);
            });
            tr=`<tr>
            <td><strong>PROMEDIO OCUPACION</strong></td>`;
            tr +=`<td>
              <div class="progress" style="height: 20px; position: relative;">
                <div class="d-flex no-block align-items-center" style="position: absolute; width: 100%;"><span class="mx-auto" style="font-size: 0.8rem; color: #000;">`+data.ocupa_prom_+`%</span></div>
                <div class="progress-bar bg-success" role="progressbar" style="width: `+data.ocupa_prom+`%; height: 20px;"></div>
              </div></td>
              `;
              tr +=`</tr>`;
              jQuery("#ocupacion tbody").append(tr);
              jQuery(".preloader").fadeOut();
          }else if(data.content==-1){
            jQuery(".preloader").fadeOut();
            document.location.href="./?error=1";
          }
        },
        error: function(x,err,msj){
            jQuery(".preloader").fadeOut();
            Modal_error(x,err,msj);
        }
      });
    }
  });
</script>
<!-- END BLOCK : module -->