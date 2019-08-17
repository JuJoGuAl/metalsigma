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
            <div class="col-sm-4">
              <div class="form-group">
                <label for="falmacen" class="control-label col-form-label">ALMACEN</label>
                <select class="form-control" id="falmacen" name="falmacen">
                  <option value="-1">TODOS...</option>
                  <!-- START BLOCK : falmacen -->
                  <option value="{codigo}">{almacen}</option>
                  <!-- END BLOCK : falmacen -->
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="articulo" class="control-label col-form-label">ARTICULO</label>
                <div class="input-group">
                  <input type="text" class="form-control validar" id="articulo" name="articulo" value="TODOS..." readonly> 
                  <input type="hidden" id="farticulo" name="farticulo" value="-1">
                  <div class="input-group-append"><button class="btn btn-outline-secondary" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="add_art"><span class="fa fa-search"></span></button></div>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="ftipo" class="control-label col-form-label">MOVIMIENTO</label>
                <select class="form-control" id="ftipo" name="ftipo">
                  <option value="-1">TODOS...</option>
                  <!-- START BLOCK : ftipo -->
                  <option value="{code}">{valor}</option>
                  <!-- END BLOCK : ftipo -->
                </select>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-group">
                <label for="fini" class="control-label col-form-label">FECHA INICIAL</label>
                <input type="text" class="form-control dates" id="fini" name="fini" maxlength="10" autocomplete="off" >
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-group">
                <label for="ffin" class="control-label col-form-label">FECHA FIN</label>
                <input type="text" class="form-control dates" id="ffin" name="ffin" maxlength="10" autocomplete="off" >
              </div>
            </div>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-bordered table-hover datatables">
              <thead>
                <tr>
                  <th>FECHA</th>
                  <th>TIPO</th>
                  <th>CARTICULO</th>
                  <th>ARTICULO</th>
                  <th># DOC</th>
                  <th>CANT</th>
                  <th>COSTO U</th>
                  <th>COSTO T</th>
                </tr>
              </thead>
              <tbody>
                <!-- START BLOCK : data -->
                <tr>
                  <td>{fecha_doc}</td>
                  <td>{tipo}</td>
                  <td>{carticulo}</td>
                  <td>{articulo}</td>
                  <td>{documento}</td>
                  <td>{cant}</td>
                  <td>{costou}</td>
                  <td>{costo_total}</td>
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
  jQuery('button').on('click', function(){
    submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
    if(acc=="add_art"){
      let non_det = new Array();
      modal_search("SELECCIONE UN ARTICULO A CONSULTAR",'accion='+acc+'&mod='+submod+'&not='+JSON.stringify(non_det),'POST',false,false);
    }
  });
  function refreshKardex() {
    let alm = jQuery("#falmacen").val(), art = jQuery("#farticulo").val(), tip = jQuery("#ftipo").val(), ini = jQuery("#fini").val(), fin = jQuery("#ffin").val();
    jQuery(".preloader").fadeIn();
    jQuery.ajax({
      type: "POST",
      url: "./modules/controllers/ajax.php",
      data : "accion=kardex&alm="+alm+"&art="+art+"&tip="+tip+"&ini="+ini+"&fin="+fin+"&mod=kardex",
      dataType:'json',
      success: function(data){
        table = jQuery('.datatables').DataTable();
        table.clear();
        if(data.title=="SUCCESS"){
          jQuery(data.content).each(function(index,value){
            table.row.add([
              value.fecha_doc,
              value.tipo,
              value.carticulo,
              value.articulo,
              value.documento,
              value.cant,
              value.costou,
              value.costo_total
            ]);
          });            
        }else if(data.content==-1){
          document.location.href="./?error=1";
        }
        table.draw();
        jQuery(".preloader").fadeOut();
      },
      error: function(x,err,msj){
        jQuery(".preloader").fadeOut();
        Modal_error(x,err,msj);
      }
    });
  }
  jQuery(document).ready(function(){
    jQuery(".dates").on('changeDate', function(e) {
      refreshKardex();
    });
    jQuery('#falmacen, #farticulo, #ftipo').change(function(){
      refreshKardex();
    });
  });
</script>
<!-- END BLOCK : module -->