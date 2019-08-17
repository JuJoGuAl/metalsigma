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
          <br>
          <div class="table-responsive">
            <table class="table table-bordered table-hover datatables">
              <thead>
                <tr>
                  <th>ODC</th>
                  <th>COT</th>
                  <th>RUT</th>
                  <th>PROVEEDOR</th>
                  <th>FECHA</th>
                  <th>SERV</th>
                  <th>MONTO</th>
                  <th>ESTATUS</th>
                  <th>OPCIONES</th>
                </tr>
              </thead>
              <tbody>
                <!-- START BLOCK : data -->
                <tr class="{estatus}">
                  <td>{codigo}</td>
                  <td><span class="_stats" data-title="{cot_pad}" data-cuerpo="{cuerpo}">{cot_pad}</span></td>
                  <td>{code}</td>
                  <td>{data}</td>
                  <td>{fecha_orden}</td>
                  <td>{articulos}</td>
                  <td>{monto_total}</td>
                  <td>{ESTATUS}</td>
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
  jQuery("._stats").each(function(){
    jQuery(this).popover({
      title: '<div style="font-size: 12px;">COTIZACION: <strong>'+jQuery(this).attr("data-title")+'</strong></div>',
      content: '<div style="font-size: 12px;">'+jQuery(this).attr("data-cuerpo")+'</div>',
      trigger: 'hover',
      placement: 'left',
      container: 'body',
      html: true
    });
  });
</script>
<!-- END BLOCK : module -->