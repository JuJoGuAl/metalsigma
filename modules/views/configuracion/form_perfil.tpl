<!-- START BLOCK : module -->
<script>
  jQuery('#searchFoto').on('click',function(){
    jQuery('#foto').trigger('click');
  });
  $("#foto").change(function(e) {
    clear_log();
    jQuery(".preloader").fadeIn();
    for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
      var file = e.originalEvent.srcElement.files[i];
      var img = jQuery('#fotoPerfil')
      var reader = new FileReader();
      reader.onloadend = function() {
           img.attr('src', reader.result);
      }
      reader.readAsDataURL(file);
    }
    var form = jQuery("#pic_")[0];
    var formdata = new FormData(form);
    formdata.append('mod',"noperm");
    formdata.append('accion',"set_pic");
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
              jQuery(".preloader").fadeOut();
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
  jQuery("#edit_perfil").on('click', function(){
    clear_log();
    jQuery('a[href="#tab_2"]').trigger('click');
  });
  jQuery("#edt_close").on('click', function(){
    clear_log();
    jQuery('a[href="#tab_1"]').trigger('click');
  });
  jQuery("#edt_save").on('click', function(){
    clear_log();
    form = "#form_";
    if(valform(form)){
        jQuery.ajax({
            type: "GET",
            url: "./modules/controllers/none/form_perfil.php",
            data : jQuery(form).serialize(),
            dataType:'json',
            success: function(data){
                if(data.title=="SUCCESS"){
                    GetModule("NONE","FORM_PERFIL","NONE","NONE","MODULO",0);
                }else if(data.content==-1){
                    document.location.href="./?error=1";
                }else{
                    dialog(data.content,data.title);
                }
            },
            error: function(x,err,msj){
                Modal_error(x,err,msj);
            }
        });
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
  <div class="row el-element-overlay">
    <div class="col-lg-4 col-xlg-3 col-md-5">
      <div class="material-card card">
        <div class="card-body">
          <center class="mt-4"> 
            <div class="el-card-item">
              <div class="el-card-avatar el-overlay-1"><img src="images/users/{foto}" id="fotoPerfil" alt="" class="rounded-circle" width="150">
                <div class="el-overlay">
                  <ul class="list-style-none el-info">
                    <li class="el-item"><a class="btn default btn-outline image-popup-vertical-fit el-link" id="searchFoto"><i class="fas fa-image fa-3x"></i></a></li>
                  </ul>
                </div>
              </div>
              <h4 class="card-title mt-2">{data}</h4>
              <h6 class="card-subtitle">{cargo}</h6>
            </div>
          </center>
        </div>
        <hr>
        <div class="card-body">
          <small class="text-muted pt-4 db">MIEMBRO DESDE </small><h6>{crea_date}</h6>
          <small class="text-muted pt-4 db">TELEFONO(S)</small><h6>{telefonos}</h6>
          <small class="text-muted pt-4 db">DIRECCION</small><h6>{direccion}</h6>
          <form role="form" name="pic_" id="pic_" enctype="multipart/form-data">
            <input type="file" class="custom-file-input" id="foto" name="foto" accept="image/*">
            <input type="hidden" id="ente" name="ente" value="{ente}">
          </form>
        </div>
      </div>
    </div>
    <div class="col-lg-8 col-xlg-9 col-md-7">
      <div class="material-card card">
        <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist" style="display: none;">
          <li class="nav-item">
            <a class="nav-link active" id="perfil" data-toggle="pill" href="#tab_1" role="tab" aria-controls="pills-timeline" aria-selected="true">PERFIL</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="data" data-toggle="pill" href="#tab_2" role="tab" aria-controls="pills-profile" aria-selected="false">INFO</a>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade" id="tab_2" role="tabpanel" aria-labelledby="data">
            <form role="form" name="form_" id="form_" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="rut" class="control-label col-form-label">RUT</label>
                      <input type="text" class="form-control" id="rut" name="rut" maxlength="9" value="{code}" readonly>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="pass" class="control-label col-form-label">PASSAPORTE</label>
                      <input type="text" class="form-control" id="pass" name="pass" maxlength="9" value="{code2}" readonly>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="nac" class="control-label col-form-label">NAC</label>
                      <select class="form-control validar list" id="nac" name="nac">
                        <!-- START BLOCK : nac_det -->
                        <option value="{code}" {selected}>{valor}</option>
                        <!-- END BLOCK : nac_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="sex" class="control-label col-form-label">SEXO</label>
                      <select class="form-control validar list" id="sex" name="sex">
                        <!-- START BLOCK : sex_det -->
                        <option value="{code}" {selected}>{valor}</option>
                        <!-- END BLOCK : sex_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="estado" class="control-label col-form-label">ESTADO CIVIL</label>
                      <select class="form-control" id="estado" name="estado">
                        <!-- START BLOCK : est_det -->
                        <option value="{code}" {selected}>{valor}</option>
                        <!-- END BLOCK : est_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label for="nombre" class="control-label col-form-label">NOMBRES</label>
                      <input type="text" class="form-control validar" id="nombre" name="nombre" maxlength="100" placeholder="NOMBRE DEL ALUMNO" value="{data}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="fecha" class="control-label col-form-label">FECHA NACIMIENTO</label>
                      <input type="text" class="form-control validar dates" id="fecha" name="fecha" maxlength="10" min="{fecha_now}" placeholder="FECHA DE NACIMIENTO" value="{fecha}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="email" class="control-label col-form-label">E-MAIL</label>
                      <input type="text" class="form-control" id="email" name="email" maxlength="100" value="{mail}" readonly>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="pais" class="control-label col-form-label">PAIS</label>
                      <select class="form-control" id="pais" name="pais">
                        <!-- START BLOCK : pais_det -->
                        <option value="{codigo}" {selected}>{pais}</option>
                        <!-- END BLOCK : pais_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="region" class="control-label col-form-label">REGION</label>
                      <select class="form-control" id="region" name="region">
                        <!-- START BLOCK : region_det -->
                        <option value="{codigo}" {selected}>{region}</option>
                        <!-- END BLOCK : region_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="provincia" class="control-label col-form-label">PROVINCIA</label>
                      <select class="form-control" id="provincia" name="provincia">
                        <option value="-1">SELECCIONE...</option>
                        <!-- START BLOCK : prov_det -->
                        <option value="{codigo}" {selected}>{provincia}</option>
                        <!-- END BLOCK : prov_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="comuna" class="control-label col-form-label">COMUNA</label>
                      <select class="form-control" id="comuna" name="comuna">
                        <option value="-1">SELECCIONE...</option>
                        <!-- START BLOCK : com_det -->
                        <option value="{codigo}" {selected}>{comuna}</option>
                        <!-- END BLOCK : com_det -->
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label for="direccion" class="control-label col-form-label">DIRECCION</label>
                      <input type="text" class="form-control" id="direccion" name="direccion" maxlength="100" placeholder="DIRECCION" value="{direccion}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="tel1" class="control-label col-form-label">TEL. FIJO</label>
                      <input type="text" class="form-control" id="tel1" name="tel1" maxlength="9" placeholder="TELEFONO FIJO" value="{tel_fijo}" {read}>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="tel2" class="control-label col-form-label">TEL. MOVIL</label>
                      <input type="text" class="form-control validar numeric" id="tel2" name="tel2" maxlength="9" placeholder="TELEFONO MOVIL" value="{tel_movil}" {read}>
                    </div>
                  </div>
                </div>
              </div>
               <div class="card-body">
                <div class="action-form">
                  <div class="form-group mb-0 text-center">
                    <input type="hidden" id="accion" name="accion" value="save_new">
                    <input type="hidden" id="id" name="id" value="{ente}">
                    <button id="edt_save" class="btn btn-outline-secondary btn-rounded waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="SAVE" data-id="0"><span class="btn-label"><i class="fas fa-save"></i></span> GUARDAR</button>
                    <button id="edt_close" class="btn btn-outline-secondary btn-rounded waves-effect waves-light" type="button"><span class="btn-label"><i class="fas fa-sign-out-alt"></i></span> CERRAR</button>
                  </div>
                </div>
              </div>
            </form>            
          </div>
          <div class="tab-pane fade show active" id="tab_1" role="tabpanel" aria-labelledby="perfil">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12 col-xs-6 b-r"><strong>NOMBRES</strong>
                  <br><p class="text-muted">{data}</p>
                </div>
                <div class="col-md-4 col-xs-6 b-r"><strong>RUT</strong>
                  <br><p class="text-muted">{code}</p>
                </div>
                <div class="col-md-4 col-xs-6 b-r"><strong>PASAPORTE</strong>
                  <br><p class="text-muted">{pasaporte}</p>
                </div>
                <div class="col-md-4 col-xs-6 b-r"><strong>SEXO</strong>
                  <br><p class="text-muted">{sexo}</p>
                </div>
                <div class="col-md-4 col-xs-6 b-r"><strong>NACIMIENTO</strong>
                  <br><p class="text-muted">{fecha}</p>
                </div>
                <div class="col-md-4 col-xs-6 b-r"><strong>TELF. FIJO</strong>
                  <br><p class="text-muted">{tel_fijo}</p>
                </div>
                <div class="col-md-4 col-xs-6 b-r"><strong>TELF. MOVIL</strong>
                  <br><p class="text-muted">{tel_movil}</p>
                </div>
                <div class="col-md-4 col-xs-6 b-r"> <strong>EMAIL</strong>
                  <br><p class="text-muted">{mail}</p>
                </div>
                <div class="col-md-8 col-xs-6 b-r"> <strong>DIRECCION</strong>
                  <br><p class="text-muted">{direccion}</p>
                </div>
                <div class="col-md-4 col-xs-6"> <strong>REGION</strong>
                  <br><p class="text-muted">{region}</p>
                </div>
                <div class="col-md-4 col-xs-6"> <strong>PROVINCIA</strong>
                  <br><p class="text-muted">{provincia}</p>
                </div>
                <div class="col-md-4 col-xs-6"> <strong>COMUNA</strong>
                  <br><p class="text-muted">{comuna}</p>
                </div>
              </div>
              <hr>              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END BLOCK : module -->