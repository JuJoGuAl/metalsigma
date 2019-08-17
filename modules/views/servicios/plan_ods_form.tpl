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
        <form role="form" name="form_" id="form_" enctype="multipart/form-data">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="rut" class="control-label col-form-label">CLIENTE</label>
                  <div class="input-group">
                    <input type="text" class="form-control validar" id="rut" name="rut" placeholder="SELECCIONE UN CLIENTE" value="{rut}" readonly> 
                    <input type="hidden" id="cliente" name="cliente" value="{cliente}">
                    <div class="input-group-append"><button class="btn btn-outline-secondary" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="search_ods_plan"><span class="fa fa-search"></span></button></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="ods_name" class="control-label col-form-label"># ODS</label>
                  <input type="text" id="ods_name" name="ods_name" class="form-control validar" value="{ods_name}" readonly>
                  <input type="hidden" id="ods" name="ods" value="{ods}">
                  <input type="hidden" id="trabs" name="trabs" value="{trabs}">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="nombre" class="control-label col-form-label">CLIENTE</label>
                  <input type="text" id="nombre" name="nombre" class="form-control" value="{nombre}" readonly>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="fllegada" class="control-label col-form-label">FECHA INICIO</label>
                  <input type="text" id="fllegada" name="fllegada" class="form-control" value="{fllegada}" readonly>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="fsalida" class="control-label col-form-label">FECHA FIN</label>
                  <input type="text" id="fsalida" name="fsalida" class="form-control" value="{fsalida}" readonly>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="hr_total" class="control-label col-form-label">HRS TOT</label>
                  <input type="text" id="hr_total" name="hr_total" class="form-control" maxlength="100" value="{hr_total}" disabled>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="hr_ocupa" class="control-label col-form-label">HRS OCUP</label>
                  <input type="text" id="hr_ocupa" name="hr_ocupa" class="form-control" maxlength="100" value="{hr_ocupa}" disabled>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="hr_restant" class="control-label col-form-label">HRS REST</label>
                  <input type="text" id="hr_restant" name="hr_restant" class="form-control" maxlength="100" value="{hr_restant}" disabled>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="lugar" class="control-label col-form-label">LUGAR</label>
                  <input type="text" id="lugar" name="lugar" class="form-control" value="{lugar}" disabled>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="vehiculo" class="control-label col-form-label">VEHICULO</label>
                  <input type="text" id="vehiculo" name="vehiculo" class="form-control" value="{vehiculo}" disabled>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="f_trab" class="control-label col-form-label">FECHA TRABAJO</label>
                  <input type="text" id="f_trab" name="f_trab" class="form-control dates validar ctrl" value="{hoy}" autocomplete="off">
                </div>
              </div> 
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="hora_ini" class="control-label col-form-label">HORA INICIO</label>
                  <input type="text" id="hora_ini" name="hora_ini" class="form-control times validar ctrl" value="{hini}" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="hora_fin" class="control-label col-form-label">HORA FIN</label>
                  <input type="text" id="hora_fin" name="hora_fin" class="form-control times validar ctrl" value="{hfin}" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="hocu" class="control-label col-form-label">HORAS A OCUPAR</label>
                  <input type="text" id="hocu" name="hocu" class="form-control" value="{hocu}" disabled>
                </div>
              </div>
              <div class="col-sm-12"><p><strong>NOTA: </strong>SI LA PLANIFICACION ESTA ENTRE LAS 12 Y LAS 15 HORAS SE CONSIDERARAN <strong>{colacion} MINUTOS</strong> DE COLACION, PARA CADA EMPLEADO (SI APLICA).</p></div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="trab1" class="control-label col-form-label">TECNICO</label>
                  <div class="input-group">
                    <input type="text" class="form-control validar" id="trab1" name="trab1" readonly value="{trab1}"> 
                    <input type="hidden" id="ctrab1" name="ctrab1" value="{ctrab1}">
                    <div class="input-group-append"><button class="btn btn-outline-secondary" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="search_trab1"><span class="fa fa-search"></span></button></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6" id="tr2"  style="display: none;">
                <div class="form-group">
                  <label for="trab2" class="control-label col-form-label">ASISTENTE</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="trab2" name="trab2" readonly value="{trab2}"> 
                    <input type="hidden" id="ctrab2" name="ctrab2" value="{ctrab2}">
                    <div class="input-group-append"><button class="btn btn-outline-secondary" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="search_trab2"><span class="fa fa-search"></span></button></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="notas" class="control-label col-form-label">NOTAS</label>
                  <textarea class="form-control" rows="3" id="notas" name="notas" placeholder="DESCRIBA LAS OBSERVACIONES">{notas}</textarea>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <!-- START BLOCK : aud_data -->
          <div class="card-body">
            <div class="row" style="font-size: 12px; text-align: justify;">
              <div class="col-sm-3"><strong>CREADO POR: </strong>{crea_user}</div>
              <div class="col-sm-3"><strong>FECHA: </strong>{crea_date}</div>
              <div class="col-sm-3"><strong>MODIFICADO POR: </strong>{mod_user}</div>
              <div class="col-sm-3"><strong>FECHA: </strong>{mod_date}</div>
            </div>
          </div>
          <hr>
          <!-- END BLOCK : aud_data -->
          <div class="card-body">
            <div class="action-form">
              <div class="form-group mb-0 text-center">
                <input type="hidden" id="accion" name="accion" value="{accion}">
                <input type="hidden" id="id" name="id" value="{id}">
                <!-- START BLOCK : data_save -->
                <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="SAVE" data-id="{codigo}"><span class="btn-label"><i class="fas fa-save"></i></span> GUARDAR</button>
                <!-- END BLOCK : data_save -->
                <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="DEL" data-id="{codigo}"><span class="btn-label"><i class="fas fa-trash-alt"></i></span> ELIMINAR</button>
                <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="CLOSE" data-id="0"><span class="btn-label"><i class="fas fa-sign-out-alt"></i></span> CERRAR</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  if(jQuery("#trabs").val()>1){
    jQuery("#tr2").show();
  }else{
    jQuery("#tr2").hide();
  }
  jQuery('#hora_ini,#hora_fin').on('blur', function(){
    let startTime=moment(jQuery("#hora_ini").val(), "HH:mm"), endTime=moment(jQuery("#hora_fin").val(), "HH:mm"), duration = moment.duration(endTime.diff(startTime)), diferencia = parseFloat(duration.asHours());
    if(isNaN(diferencia)){
      diferencia = 0;
    }
    jQuery("#hocu").val(diferencia);
  });
  jQuery('button').on('click', function(){
    submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc"), assoc_id = jQuery(this).attr("data-id");
    if(acc=="search_ods_plan"){
      modal_search("SELECCIONE UNA ODS",'accion='+acc+'&mod='+submod,'POST',false,false);
    }else if(acc=="search_trab1"){
      let non_det = new Array();
      non_det.push(jQuery("#ctrab2").val());
      modal_search("SELECCIONE UN TRABAJADOR",'accion='+acc+'&mod='+submod+'&not='+JSON.stringify(non_det),'POST',false,false);
    }else if(acc=="search_trab2"){
      let non_det = new Array();
      non_det.push(jQuery("#ctrab1").val());
      modal_search("SELECCIONE UN TRABAJADOR",'accion='+acc+'&mod='+submod+'&not='+JSON.stringify(non_det),'POST',false,false);
    }else if(acc=="SAVE"){
      if(validate("rut")){
        if(validate("hora_ini")){
          if(validate("hora_fin")){
            if(validate("trab1")){
              let startTime=moment(jQuery("#hora_ini").val(), "HH:mm"), endTime=moment(jQuery("#hora_fin").val(), "HH:mm"), dias = moment(jQuery("#f_trab").val(), "DD-MM-YYYY").diff(moment(moment(), "DD-MM-YYYY"),"days"), duration = moment.duration(endTime.diff(startTime)), diferencia = parseFloat(duration.asHours());
              if(endTime<startTime){
                dialog("NO SE PUEDE ASIGNAR UNA HORA FINAL ANTES DE LA INICIAL","ERROR");
              }else{
                //if(dias < 0){
                if(1 < 0){
                  dialog("NO SE PUEDE ASIGNAR UNA PLANIFICACION EN DIAS ANTERIORES","ERROR");
                }else{
                  let event = function (){ SendForm(mod,submod,ref,subref,"#form_",assoc_id); }
                  if(jQuery("#hr_restant").val()*1 <= 0){
                    dialog("ESTA PLANIFICACION UTILIZARA HORAS <span class='font-weight-bold'>NO COTIZADAS</span>, LO CUAL SE MARCARAN COMO HORAS ADICIONALES.<br><span class='font-weight-bold font-italic'>SI CONTINUA SE GENERARA UN AVISO AL AREA COMERCIAL!</span><br><br>¿DESEA CONTINUAR?","WARNING",event);
                  }else{
                    event();
                  }
                }
              }
            }
          }
        }
      }
    }else if(acc=="DEL"){
      jQuery("#accion").val("del");
      SendForm(mod,submod,ref,subref,"#form_",assoc_id);
    }
  });
  <!-- START BLOCK : val -->
  block_controls(true);
  <!-- END BLOCK : val -->
</script>
<!-- END BLOCK : module -->