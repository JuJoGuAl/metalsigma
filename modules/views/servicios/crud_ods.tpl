<!-- START BLOCK : module -->
<script>
  jQuery("._stats").each(function(){
    jQuery(this).popover({
      title: '<div style="font-size: 12px;">SUB COTIZACIONES: <strong>'+jQuery(this).attr("data-count")+'</strong></div>',
      content: '<div style="font-size: 12px;">'+jQuery(this).attr("data-cuerpo")+'</div>',
      trigger: 'hover',
      placement: 'left',
      container: 'body',
      html: true
    });
  });
  jQuery('.filtros').change(function(){
    let sta = new Array();
    jQuery(".preloader").fadeIn();
    sta.push(jQuery("#festatus").val());
    jQuery.ajax({
      type: "POST",
      url: "./modules/controllers/ajax.php",
      data : "accion=refresh_ods&stat="+JSON.stringify(sta)+"&mod=crud_ods",
      dataType:'json',
      success: function(data){
        table = jQuery('.datatables').DataTable();
        table.clear().draw();
        if(data.title=="SUCCESS"){
          jQuery(data.content).each(function(index,value){
            let equi_ = value.equipo+' '+value.marca+' '+value.modelo+'<br><span style="font-size: 11px">S/N: '+value.serial+'</span>';
            let stat_ = '<h3><span class="badge badge-secondary _stats" data-count="'+value.cuentas+'" data-cuerpo="'+value.sub_status+'">'+value.cuentas+'</span></h3>';
            var rowNode = table.row.add([
              value.codigo,
              value.codigo_ods,
              value.code,
              value.data,
              equi_,
              value.segmento,
              value.crea,
              stat_,
              value.boton
            ]).draw().node();
            jQuery(rowNode).find("td:eq(7)").attr("align","center");
          });
          jQuery("._stats").each(function(){
            jQuery(this).popover({
              title: '<div style="font-size: 12px;">SUB COTIZACIONES: <strong>'+jQuery(this).attr("data-count")+'</strong></div>',
              content: '<div style="font-size: 12px;">'+jQuery(this).attr("data-cuerpo")+'</div>',
              trigger: 'hover',
              placement: 'left',
              container: 'body',
              html: true
            });
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
            <div class="col-sm-4">
              <div class="form-group">
                <label for="festatus" class="control-label col-form-label">ESTATUS</label>
                <select class="form-control custom-select filtros" id="festatus" name="festatus">
                  <option value="-1">TODOS...</option>
                  <!-- START BLOCK : fstat_det -->
                  <option value="{code}" {selected}>{valor}</option>
                  <!-- END BLOCK : fstat_det -->
                </select>
              </div>
            </div>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-bordered table-hover datatables">
              <thead>
                <tr>
                  <th>COTIZACION</th>
                  <th>ODS</th>
                  <th width="75px">RUT</th>
                  <th>CLIENTE</th>
                  <th>EQUIPO</th>
                  <th>SEGMENTO</th>
                  <th>FECHA</th>
                  <th>SUB-COT</th>
                  <th>OPC</th>
                </tr>
              </thead>
              <tbody>
                <!-- START BLOCK : data -->
                <tr>
                  <td>{codigo}</td>
                  <td>{codigo_ods}</td>
                  <td>{code}</td>
                  <td>{data}</td>
                  <td>{equipo} {marca} {modelo}<br><span style="font-size: 11px">S/N: {serial}</span></td>
                  <td>{segmento}</td>
                  <td>{crea}</td>
                  <td align="center"><h3><span class="badge badge-secondary _stats" data-count="{cuentas}" data-cuerpo="{sub_status}">{cuentas}</span></h3></td>
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
<!-- END BLOCK : module -->