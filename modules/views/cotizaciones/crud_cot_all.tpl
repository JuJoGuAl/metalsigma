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
          <div class="row">
            <div class="col-sm-3">
              <label for="none" class="control-label col-form-label"><br></label>
              <div class="button-group">
                <!-- START BLOCK : data_new -->
                <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="NEW" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span> NUEVO</button>
                <!-- END BLOCK : data_new -->
              </div>
            </div>
            <div class="col-sm-9">
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="festatus" class="control-label col-form-label">ESTATUS</label>
                    <input type="hidden" id="fid" name="fid" value="{id}">
                    <select class="form-control custom-select filtros" id="festatus" name="festatus">
                      <option value="-1">TODOS...</option>
                      <!-- START BLOCK : fstat_det -->
                      <option value="{code}" {selected}>{valor}</option>
                      <!-- END BLOCK : fstat_det -->
                    </select>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="ftipo" class="control-label col-form-label">TIPO DE COTIZACION</label>
                    <select class="form-control custom-select filtros" id="ftipo" name="ftipo">
                      <option value="-1">TODAS...</option>
                      <!-- START BLOCK : tipo_det -->
                      <option value="{codigo}" {selected}>{tipo}</option>
                      <!-- END BLOCK : tipo_det -->
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br>
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
                  <th>SERV</th>
                  <th width="50px">OPC</th>
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
        title: '<div style="font-size: 12px;">SERVICIOS: <strong>'+jQuery(this).data("count")+'</strong></div>',
        content: '<div style="font-size: 12px;" class="content-pop">ESPERE...</div>',
        placement: 'left',
        container: 'body',
        html: true
      }
      jQuery(this).popover(options)
      jQuery(this).popover("show");
      let sta = new Array();
      sta.push(jQuery("#festatus").val());
      once({
        method: "post",
        url: "./modules/controllers/ajax.php",
        data: { accion: 'get_cot_all_childs', code: code, mod: 'crud_cot_all', stat: JSON.stringify(sta), tipo: jQuery("#ftipo").val() }
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
  jQuery('.filtros').change(function(){
    let sta = new Array();
    jQuery(".preloader").fadeIn();
    sta.push(jQuery("#festatus").val());
    jQuery.ajax({
      type: "POST",
      url: "./modules/controllers/ajax.php",
      data : "accion=refresh_cotizaciones&stat="+JSON.stringify(sta)+"&tipo="+jQuery("#ftipo").val()+"&mod=crud_cot_all",
      dataType:'json',
      success: function(data){
        table = jQuery('.datatables').DataTable();
        table.clear().draw();
        if(data.title=="SUCCESS"){
          jQuery(data.content).each(function(index,value){
            let equi_ = value.equipo+' '+value.marca+' '+value.modelo+'<br><span style="font-size: 11px">S/N: '+value.serial+'</span>';
            let stat_ = '<h3><span class="badge badge-secondary" data-count="'+value.cuentas+'" data-id="'+value.codigo+'">'+value.cuentas+'</span></h3>';
            var rowNode = table.row.add([
              "COT-"+value.codigo,
              value.code,
              value.data,              
              equi_,
              value.segmento,
              value.crea,
              stat_,
              value.boton
            ]).draw().node();
            jQuery(rowNode).find("td:eq(6)").attr("align","center");
            //jQuery(rowNode).addClass(value.class);
          });
        }else if(data.content==-1){
          document.location.href="./?error=1";
        }        
        jQuery('[data-toggle="popover"]').popover('dispose');
        jQuery('.popover').remove();
        jQuery('[data-toggle="popover"]').popover({ container: "body", trigger: "hover", html : true });
        jQuery(".preloader").fadeOut();
      },
      error: function(x,err,msj){
          jQuery(".preloader").fadeOut();
          Modal_error(x,err,msj);
      }
    });
  });
</script>
<!-- END BLOCK : module -->