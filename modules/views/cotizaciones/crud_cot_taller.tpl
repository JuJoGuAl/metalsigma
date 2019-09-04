<!-- START BLOCK : module -->
<script>
  jQuery("._stats").each(function(){
    jQuery(this).popover({
      title: '<div style="font-size: 12px;">SUB COTIZACIONES: <strong>'+jQuery(this).attr("data-count")+'</strong></div>',
      content: '<div style="font-size: 12px;">'+jQuery(this).attr("data-cuerpo")+'</div>',
      trigger: 'hover',
      placement: 'top',
      container: 'body',
      html: true
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
          <h4 class="card-title">{mod_name}</h4>
          <div class="button-group">
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-bordered table-hover datatables">
              <thead>
                <tr>
                  <th>COTIZACION</th>
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
                <tr class="{class}">
                  <td>{codigo}</td>
                  <td>{code}</td>
                  <td>{data}</td>
                  <td>{equipo} {marca} {modelo}</td>
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