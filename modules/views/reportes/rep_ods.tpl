<!-- START BLOCK : module -->
<script>
  jQuery('button').on('click', function(){
    submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc"), id = jQuery(this).attr("data-id");
    if(acc=="search_cliente"){
      modal_search("SELECCIONE UN CLIENTE",'accion='+acc+'&mod='+submod,'POST',false,false);
    }else if(acc=="EXCEL"){
      var form = jQuery("#form_").serialize();
      form+="&mod="+mod+"&submod="+submod;
      var newwindow = window.open("./modules/reports/rep_cotiza_excel.php?"+form);
      newwindow.focus();
      newwindow.onblur = function() {
        newwindow.close();
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

<div class="page-content container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="material-card card">
        <form role="form" name="form_" id="form_" enctype="multipart/form-data">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-5">
                <div class="form-group">
                  <label for="rut" class="control-label col-form-label">RUT</label>
                  <div class="input-group">
                    <input type="text" class="form-control validar" id="rut" name="rut" placeholder="TODOS" readonly> 
                    <input type="hidden" id="ccliente" name="ccliente">
                    <div class="input-group-append"><button class="btn btn-outline-secondary ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="search_cliente"><span class="fa fa-search"></span></button></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-7">
                <div class="form-group">
                  <label for="cliente" class="control-label col-form-label">CLIENTE</label>
                  <input type="text" class="form-control" id="cliente" name="cliente" placeholder="TODOS" readonly>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="estatus">ESTATUS</label>
                  <select class="form-control custom-select" id="estatus" name="estatus">
                    <option value="-1">TODAS</option>
                    <!-- START BLOCK : fstat_det -->
                    <option value="{code}" {selected}>{valor}</option>
                    <!-- END BLOCK : fstat_det -->
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="finicio" class="control-label col-form-label">FECHA INICIO</label>
                  <input type="text" class="form-control dates" id="finicio" name="finicio" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="ffin" class="control-label col-form-label">FECHA FIN</label>
                  <input type="text" class="form-control dates" id="ffin" name="ffin" autocomplete="off">
                </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="card-body">
            <div class="action-form">
              <div class="form-group mb-0 text-center">                
                <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="EXCEL" data-id="0"><span class="btn-label"><i class="fas fa-download"></i></span> EXCEL</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- END BLOCK : module -->