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
                    <li class="breadcrumb-item active" aria-current="page">{menu_ter}</li>
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
              <!-- START BLOCK : data_new -->
              <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="NEW" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span> NUEVO</button>
              <form role="form" name="subida" id="subida" enctype="multipart/form-data" style="display: inline-block; padding-right: 5px">
                <input type="file" class="custom-file-input" style="width: 1px;" id="excel" name="excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                <button class="btn btn-outline-secondary waves-effect waves-light ctrl" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="add_art_cot_excel" data-id="0"><span class="btn-label"><i class="fas fa-upload"></i></span> EXCEL</button>
              </form>
              <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="DWN" data-id="0"><span class="btn-label"><i class="fas fa-download"></i></span> BAJAR DEMO EXCEL</button>
              <!-- END BLOCK : data_new -->
              <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="CRUD_ART_CLASIF" data-subref="{subref}" data-acc="MODULO" data-id="0"><span class="btn-label"><i class="fas fa-arrow-right"></i></span> ART. CLASIFICACION</button>
              <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="CRUD_INV_UND" data-subref="{subref}" data-acc="MODULO" data-id="0"><span class="btn-label"><i class="fas fa-arrow-right"></i></span> UNIDADES</button>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-bordered table-hover datatables">
              <thead>
                <tr>
                  <th>CODIGO</th>
                  <th>CODE</th>
                  <th>ARTICULO</th>
                  <th>DESCRIPCION</th>
                  <th>CLASIFICACION</th>
                  <th>CANT</th>
                  <th>COSTO</th>
                  <th>ESTATUS</th>
                  <th>OPC</th>
                </tr>
              </thead>
              <tbody>
                <!-- START BLOCK : data -->
                <tr>
                  <td>{codigo}</td>
                  <td>{codigo2}</td>
                  <td>{articulo}</td>
                  <td>{desc}</td>
                  <td>{clasificacion}</td>
                  <td>{cant}</td>
                  <td>{costo_prom}</td>
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
  jQuery('button').on('click', function(){
    submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc");
    if(acc=="add_art_cot_excel"){
      jQuery('#excel').trigger('click');
    }else if(acc=="DWN"){
      var newwindow = window.open("./assets/files/ejemplo_subida_maestras.xlsx");
      newwindow.focus();
      newwindow.onblur = function() {
        newwindow.close();
      }
    }
  });
  $("#excel").change(function(e) {
    clear_log();
    jQuery(".preloader").fadeIn();
    let file = this.files[0];
    let form = jQuery('#form_')[0];
    let formdata = new FormData(form);
    formdata.append('media', file);
    formdata.append('mod',"crud_articulos");
    formdata.append('accion',"upload_excel");
    jQuery.ajax({
        type: "POST",
        url: "./modules/controllers/ajax.php",
        data : formdata,
        dataType:'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            if(data.title=="SUCCESS"){
              jQuery("#excel").val(null);
              let msj = "";
              if(data.ins>0){
                msj += `ARTICULOS CREADOS: <strong>`+data.ins+`</strong><br>`;
              }
              if(data.upt>0){
                msj += `ARTICULOS ACTUALIZADOS: <strong>`+data.upt+`</strong><br>`;
              }
              GetModule("MAESTRAS","CRUD_ARTICULOS","NONE","NONE","MODULO",0);
              dialog(msj,"SUCCESS");
            }else if(data.content==-1){
                document.location.href="./?error=1";
            }else{
                jQuery(".preloader").fadeOut();
                dialog(data.content,data.title);
            }
        },
        error: function(x,err,msj){
          jQuery(".preloader").fadeOut();
            Modal_error(x,err,msj);
        }
    });
  });
</script>
<!-- END BLOCK : module -->