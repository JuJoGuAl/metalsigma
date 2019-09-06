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
          <br>
          <div class="table-responsive">
            <table class="table table-bordered table-hover datatables" data-dt_order='[[0,"desc"]]'>
              <thead>
                <tr>
                  <th>ODS</th>
                  <th>FACTURA</th>
                  <th>FECHA FAC</th>
                  <th>RUT</th>
                  <th>CLIENTE</th>
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
                  <td><strong>{data}</strong><br>{maquina} {marca} {modelo} <br><small>S/N: {serial}</small></td>
                  <td>{m_neto} $</td>
                  <td>{ESTATUS}<br>{gar}</td>
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
    jQuery('.filtros').change(function(){
      let sta = new Array();
      jQuery(".preloader").fadeIn();
      sta.push(jQuery("#festatus").val());
      jQuery.ajax({
        type: "POST",
        url: "./modules/controllers/ajax.php",
        data : "accion=refresh_ven&stat="+JSON.stringify(sta)+"&tipo="+jQuery("#ftipo").val()+"&mod=crud_ventas",
        dataType:'json',
        success: function(data){
          table = jQuery('.datatables').DataTable();
          table.clear().draw();
          if(data.title=="SUCCESS"){
            jQuery(data.content).each(function(index,value){
              let equi_ = '<strong>'+value.data+'</strong><br>'+value.maquina+' '+value.marca+' '+value.modelo+'<br><small>S/N: '+value.serial+'</small>';
              let valor_ = value.m_neto+' $';
              let status_ = value.status_+'<br>'+value.gar;
              var rowNode = table.row.add([
                value.ods_full,
                value.cfactura,
                value.fecha_fac,
                value.code,
                equi_,
                valor_,
                status_,
                value.boton
              ]).draw().node();
              //jQuery(rowNode).find("td:eq(7)").attr("align","center");
              jQuery(rowNode).addClass(value.class);
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
<!-- END BLOCK : module -->