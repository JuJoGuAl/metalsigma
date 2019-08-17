<!-- START BLOCK : module -->
<script>
  jQuery('.open_modal').on('click', function(){
    jQuery("#id").val(jQuery(this).attr("data-id"));
    jQuery("#modal_factura").modal({show:true,backdrop: 'static',keyboard: false});
  });
  jQuery('#fac_ok').on('click', function(){
    if(validate("factura")){
      if(validate("fecha")){
        jQuery(".modal").modal('hide');        
        SendForm("VENTAS","CRUD_VENTAS","CRUD_VENTAS","NONE","#form_",0);
      }
    }
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
<div id="modal_factura" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">INDIQUE # DE FACTURA Y LA FECHA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <form role="form" name="form_" id="form_" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="factura" class="control-label col-form-label">Nº FACTURA</label>
                      <input type="text" id="factura" name="factura" class="form-control validar" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="fecha" class="control-label col-form-label">FECHA</label>
                      <input type="text" id="fecha" name="fecha" class="form-control dates validar" autocomplete="off">
                    </div>
                  </div>
                </div>
                <input type="hidden" id="accion" name="accion" value="SAVE_NEW">
                <input type="hidden" id="id" name="id">
              </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="fac_ok" class="btn btn-success waves-effect text-left">ACEPTAR</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">CERRAR</button>
            </div>
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
                  <th>ODS</th>
                  <th>FACTURA</th>
                  <th>FECHA FAC</th>
                  <th>RUT</th>
                  <th>CLIENTE</th>
                  <th>EQUIPO</th>
                  <th>NETO</th>
                  <th>ESTATUS</th>
                  <th>OPCS</th>
                </tr>
              </thead>
              <tbody>
                <!-- START BLOCK : data -->
                <tr class="{estatus}">
                  <td>{ods_full}</td>
                  <td>{cfactura}</td>
                  <td>{fecha_fac}</td>
                  <td>{code}</td>
                  <td>{data}</td>
                  <td>{maquina} {marca} {modelo} S/N: {serial}</td>
                  <td>{m_neto}</td>
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
<!-- END BLOCK : module -->