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
        <div class="card-body">
          <div class="table-responsive">
            <table id="cot_all" class="table table-bordered table-hover datatables">
              <thead>
                <tr>
                  <th width="75px">COTIZACION</th>
                  <th width="75px">RUT</th>
                  <th>CLIENTE</th>
                  <th>EQUIPO</th>
                  <th>SEGMENTO</th>
                  <th width="80px">FECHA</th>
                  <th width="40px">SERV</th>
                  <th width="40px">OPC</th>
                </tr>
              </thead>
              <tbody>
                <!-- START BLOCK : data -->
                <tr class="{class}">
                  <td>COT-{codigo}</td>
                  <td>{code}</td>
                  <td>{data}</td>
                  <td>{equipo} {marca} {modelo}<br><span style="font-size: 11px">S/N: {serial}</span></td>
                  <td>{segmento}</td>
                  <td>{crea}</td>
                  <td align="center"><h3><span class="badge badge-secondary" data-count="{cuentas}" data-id="{codigo}">{cuentas}</span></h3></td>
                  <td>{actions}</td>
                </tr>
                <!-- END BLOCK : data -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  jQuery(document).mouseup(e => {
    if (!jQuery('span.badge').is(e.target) // if the target of the click isn't the container...
    && jQuery('span.badge').has(e.target).length === 0) // ... nor a descendant of the container
    { jQuery('.popover').popover('dispose'); }
  });
  jQuery(document).ready(function(){
    let call;
    const once = (config = {}) => {
      if (call) {
        call.cancel();
      }
      call = axios.CancelToken.source();
      config.cancelToken = call.token
      return axios(config);
    }
    jQuery("#cot_all").on("click", "span.badge", function(){
      jQuery('.popover').popover('dispose');
      code = jQuery(this).data("id");
      let options = {
        title: '<div style="font-size: 12px;">SUB COTIZACIONES: <strong>'+jQuery(this).data("count")+'</strong></div>',
        content: '<div style="font-size: 12px;" class="content-pop">ESPERE...</div>',
        placement: 'left',
        container: 'body',
        html: true
      }
      jQuery(this).popover(options)
      jQuery(this).popover("show");
      let sta = Array("-1");
      once({
        method: "post",
        url: "./modules/controllers/ajax.php",
        data: { accion: 'get_cot_all_childs', code: code, mod: 'crud_cot_cli', stat: JSON.stringify(sta), tipo: -1 }
      }).then(response => {
        let repuesta = response.data
        if(repuesta.title=="SUCCESS"){
          let contenido = repuesta.content; texto = "";
          contenido.forEach(function(element){
            texto = texto + element.correlativo+": "+element.estatus_+"<br>";
          });
          jQuery(".content-pop").html(texto);
        }else{
            dialog(repuesta.content,repuesta.title);
        }
      }).catch(error => { axios_Error(error); });
    })
  });
</script>
<!-- END BLOCK : module -->