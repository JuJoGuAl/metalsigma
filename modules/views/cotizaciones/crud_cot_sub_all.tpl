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
                    <li class="breadcrumb-item"><a class="menu" href="javascript:void(0)" data-menu="{mod}" data-mod="{submod}" data-acc="MODULO">{menu_sec}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">SUB-COTIZACIONES</li>
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
          <h6>
            <p style="margin: .5rem 0;">CLIENTE: <strong>{code} / {data}</strong></p>
            <p style="margin: .5rem 0;">EQUIPO: <strong>{equipo} {marca} {modelo}</strong></p>
            <p style="margin: .5rem 0;">SERIAL: <strong>{serial}</strong></p>
          </h6>
          <div class="d-flex no-block align-items-center pb-3"><div>COTIZACION: <strong>COT-{codigo}</strong></div></div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <label for="none" class="control-label col-form-label"><br></label>
              <div class="button-group">
                <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="NONE" data-subref="{subref}" data-acc="MODULO" data-id="0"><span class="btn-label"><i class="fas fa-arrow-left"></i></span> VOLVER</button>
                <!-- START BLOCK : data_new -->
                <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="NEW" data-id="{codigo}"><span class="btn-label"><i class="fas fa-plus"></i></span> NUEVO</button>
                <!-- END BLOCK : data_new -->
              </div>
            </div>
          </div>          
          <br>
          <div class="table-responsive">
            <table class="table table-bordered table-hover datatables">
              <thead>
                <tr>
                  <th style="width: 90px;">SERVICIO</th>
                  <th>TIPO</th>
                  <th>LUGAR</th>
                  <th>EQUIPO TRAB.</th>
                  <th>TOTAL NETO</th>
                  <th>EJECUTIVO</th>
                  <th style="width: 100px;">ESTATUS</th>
                  <th>OPC</th>
                </tr>
              </thead>
              <tbody>
                <!-- START BLOCK : data -->
                <tr class="{estatus}">
                  <td>{correlativo}</td>
                  <td>{tipo}{gar}</td>
                  <td>{lugar}</td>
                  <td>{equipo}</td>
                  <td class="number_cal">{m_neto}</td>
                  <td>{crea_user}</td>
                  <td>{estatus_}</td>
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
  jQuery('.filtros').change(function(){
    let code = jQuery("#fid").val(), sta = new Array();
    jQuery(".preloader").fadeIn();
    sta.push(jQuery("#festatus").val());
    jQuery.ajax({
      type: "POST",
      url: "./modules/controllers/ajax.php",
      data : "accion=refresh_cotizaciones&stat="+JSON.stringify(sta)+"&code="+code+"&mod=crud_cot_all",
      dataType:'json',
      success: function(data){
        table = jQuery('.datatables').DataTable();
        table.clear();
        if(data.title=="SUCCESS"){
          jQuery(data.content).each(function(index,value){
            var rowNode = table.row.add([
              value.correlativo,
              value.tipo,
              value.lugar,
              value.equipo,
              value.m_neto,
              value.crea_user,
              value.status_,
              value.boton
            ]).draw().node();
            jQuery(rowNode).addClass(value.estatus);
          });
        }else if(data.content==-1){
          document.location.href="./?error=1";
        }
        jQuery('.tooltip').tooltip("dispose");
        jQuery('[data-toggle="tooltip"]').tooltip();
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