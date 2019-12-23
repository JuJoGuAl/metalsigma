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
          <div class="button-group">
              <!-- START BLOCK : data_new -->
              <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="NEW" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span> NUEVO</button>
              <!-- END BLOCK : data_new -->
          </div>
          <br>
          <div class="table-responsive">
            <table id="movimientos" class="table table-bordered table-hover datatables" data-dt_order='[[0,"desc"]]'>
              <thead>
                <tr>
                  <th>CODIGO</th>
                  <th>RUT</th>
                  <th>PROVEEDOR</th>
                  <th>ALMACEN</th>
                  <th>FECHA</th>
                  <th>ARTS</th>
                  <th>MONTO</th>
                  <th>ESTATUS</th>
                  <th>OPC</th>
                </tr>
              </thead>
              <tbody>
                <!-- START BLOCK : data -->
                <tr class="{estatus}">
                  <td>{codigo_transaccion}</td>
                  <td>{code}</td>
                  <td>{data}</td>
                  <td>{almacen}</td>
                  <td>{fecha_mov}</td>
                  <td>{articulos}</td>
                  <td class="number_cal">{monto_total}</td>
                  <td class="{isdev}" data-dev="{cod_dev}">{ESTATUS}</td>
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
  jQuery(document).ready(function(){
    jQuery("#movimientos .isdev").each(function (){
      jQuery(this).popover({
        content: '<div style="font-size: 12px;" class="content-pop">CANCELADA POR: <strong>'+jQuery(this).data("dev")+'</strong></div>',
        trigger: 'hover',
        placement: 'left',
        container: 'body',
        html: true
      });
    });
  });
</script>
<!-- END BLOCK : module -->