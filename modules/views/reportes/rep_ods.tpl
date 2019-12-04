<!-- START BLOCK : module -->
<style>
    .ui-autocomplete {
        max-height: 200px;
        overflow: hidden auto;
    }
</style>
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
            <div class="row">
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="cliente" class="control-label col-form-label">CLIENTE</label>
                  <input type="text" class="form-control" id="cliente" name="cliente" placeholder="TODOS" data-mod="{submod}"> 
                  <input type="hidden" id="ccliente" name="ccliente">
                </div>
                <div id="results" style="max-height: 300px;"></div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="estatus" class="control-label col-form-label">ESTATUS</label>
                  <select class="form-control custom-select" id="estatus" name="estatus">
                    <option value="-1">TODAS</option>
                    <!-- START BLOCK : fstat_det -->
                    <option value="{code}" {selected}>{valor}</option>
                    <!-- END BLOCK : fstat_det -->
                  </select>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="finicio" class="control-label col-form-label">FECHA INICIO</label>
                  <input type="text" class="form-control dates" id="finicio" name="finicio" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="ffin" class="control-label col-form-label">FECHA FIN</label>
                  <input type="text" class="form-control dates" id="ffin" name="ffin" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-0 text-center">
                  <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="GENERAR" data-id="0"><span class="btn-label"><i class="fas fa-cogs"></i></span> GENERAR</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="material-card card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive">
                  <table id="cotizaciones" class="table table-bordered table-hover">
                    <thead>
                      <tr class="text-center">
                        <th colspan="7">COTIZACION</th>
                        <th colspan="5">PLANIFICACION</th>
                        <th colspan="3">HORAS</th>
                        <th colspan="4">FACTURACION</th>
                      </tr>
                      <tr class="align-middle">
                        <th width="80px"># COT</th>
                        <th width="80px"># ODS</th>
                        <th width="200px">TIPO DE COT</th>
                        <th>CLIENTE</th>
                        <th>EQUIPO</th>
                        <th>ASESOR COMERCIAL</th>
                        <th>ESTADO ORDEN</th>
                        <th>COORDINADOR TECNICO</th>
                        <th>FECHA INICIO PROG</th>
                        <th>FECHA FIN PROG</th>
                        <th>FECHA INICIO SERV</th>
                        <th>FECHA ULTIMO SERV</th>
                        <th>AVANCE</th>
                        <th>COT</th>
                        <th>UTIL</th>
                        <th>ADIC</th>
                        <th>FACTURA</th>
                        <th>FECHA FAC</th>
                        <th>VALOR NETO</th>
                        <th>VALOR BRUTO</th>
                      </tr>
                    </thead>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  var call;
  var axio_call = (config = {}) => {
    if (call) {
      call.cancel();
    }
    call = axios.CancelToken.source();
    config.cancelToken = call.token
    return axios(config);
  }
  var event = function () {
    jQuery(".ui-autocomplete-loading").removeClass("ui-autocomplete-loading");
    jQuery("#ccliente").val("");
    jQuery("#cliente").val("").focus();
  }
  jQuery("#cliente").autocomplete({
      source: function (request, response) {
        axio_call({
          method: "post",
          url: "./modules/controllers/ajax.php",
          data: { accion: 'search_cliente_auto', mod: jQuery("#cliente").attr("data-mod"), condition: request.term }
        }).then(data_response => {
          let repuesta = data_response.data
          if(repuesta.title=="SUCCESS"){
            response(repuesta.content);
          }else{
              event();
              dialog(repuesta.content,repuesta.title);
          }
        }).catch(error => { event(); axios_Error(error); });
      },
      autoFocus: true,
      minLength: 3,
      appendTo: "#results",
      select: function (event, ui) {
        event.preventDefault();
        jQuery("#cliente").val(ui.item.label);
        jQuery("#ccliente").val(ui.item.value);
      },
  });
  jQuery('button').on('click', function(){
    submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc"), id = jQuery(this).attr("data-id");
    if(acc=="GENERAR"){
      if(jQuery("#cliente").val()===""){
        jQuery("#ccliente").val("");
      }
      $(".preloader").fadeIn();
      axio_call({
        method: "post",
        url: "./modules/controllers/ajax.php",
        data: { accion: 'rep_gen_cots', mod: submod, cliente: jQuery("#ccliente").val(), status: jQuery("#estatus").val(), fini: jQuery("#finicio").val(), ffin: jQuery("#ffin").val() }
      }).then(data_response => {
        let repuesta = data_response.data
        if(repuesta.title=="SUCCESS"){
          var currentdate = new Date();
          var mensaje_print = "GENERADO EL " + currentdate.getDate() + "/"
            + (currentdate.getMonth()+1)  + "/"
            + currentdate.getFullYear() + " " 
            + currentdate.getHours() + ":" 
            + currentdate.getMinutes() + ":"
            + currentdate.getSeconds();
          table = jQuery('#cotizaciones').DataTable({
            destroy: true,
            dom: 'Bfrtip',
            order: [],
            pageLength: 10,
            buttons: [
              { extend: 'print',text: '<i class="fas fa-print"></i> IMPRIMIR', titleAttr: 'IMPRIMIR', className: 'btn-outline-secondary waves-effect waves-light mr-2', orientation: 'landscape', title: 'LISTADO DE COTIZACIONES', messageBottom: mensaje_print,
              customize: function(win){
                $(win.document.body).css('font-size','10pt');
                $(win.document.body).find('table').addClass('compact').css('font-size','inherit');
                var last = null;
                var current = null;
                var bod = [];
                var css = '@page { size: landscape; }',
                    head = win.document.head || win.document.getElementsByTagName('head')[0],
                    style = win.document.createElement('style');

                style.type = 'text/css';
                style.media = 'print';
                if (style.styleSheet){
                  style.styleSheet.cssText = css;
                }else{
                  style.appendChild(win.document.createTextNode(css));
                }
                head.appendChild(style);
              } },
              { extend: 'pdfHtml5', text: '<i class="fas fa-file-pdf"></i> PDF', orientation: 'landscape', messageBottom: mensaje_print,
              pageSize: 'LETTER',
              customize: function (doc) {
                doc.defaultStyle.fontSize = 6;
                doc.styles.tableHeader.fontSize = 6;
                doc.pageMargins = [5, 10, 5, 10];
              }, titleAttr: 'EXPORTAR A PDF', className: 'btn-outline-secondary waves-effect waves-light mr-2', title: 'LISTADO DE COTIZACIONES' },
              { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> EXCEL', titleAttr: 'EXPORTAR A EXCEL', className: 'btn-outline-secondary waves-effect waves-light mr-2', title: 'LISTADO DE COTIZACIONES',messageBottom: mensaje_print },],
            scrollX: true
          });
          table.clear();
          jQuery(repuesta.content).each(function(index,value){
            let maquina = value.maquina+" "+value.marca+" "+value.modelo+" S/N: "+value.serial;
            table.row.add([
              value.cot_full,
              value.ods_full,
              value.tipo,
              value.data,
              maquina,
              value.crea_user,
              value.estatus_,
              value.tecnico,
              value.fecha_ini_pro,
              value.fecha_fin_pro,
              value.fecha_ini_plan,
              value.fecha_fin_plan,
              value.avance,
              value.horas,
              value.ocupado,
              value.adic,
              value.cfactura,
              value.fecha_fac,
              value.m_neto,
              value.m_bruto
            ]);
          });
        }else{
          dialog(repuesta.content,repuesta.title);
        }
      }).catch(error => { axios_Error(error); })
      .finally(function () {
        table.draw();
        jQuery(".btn-secondary").removeClass("btn-secondary");
        $(".preloader").fadeOut();
      });
    }else if(acc=="EXCEL"){
      var form = jQuery("#form_").serialize();
      form+="&mod="+mod+"&submod="+submod;
      var newwindow = window.open("./modules/reports/rep_cotiza_excel.php?"+form);
      newwindow.focus();
      newwindow.onblur = function() {
      newwindow.close();
      }
    }
  });
</script>
<!-- END BLOCK : module -->