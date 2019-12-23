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
                  <label for="ods" class="control-label col-form-label">ODS</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="ods" name="ods" placeholder="SELECCIONE UNA ODS" readonly> 
                    <input type="hidden" id="cods" name="cods">
                    <div class="input-group-append"><button class="btn btn-outline-secondary" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="search_ods"><span class="fa fa-search"></span></button></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="cliente" class="control-label col-form-label">CLIENTE</label>
                  <input type="text" class="form-control" id="cliente" name="cliente" readonly>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-0 text-center">
                  <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="GET_ODS_PLAN" data-id="0"><span class="btn-label"><i class="fas fa-cogs"></i></span> GENERAR</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12"><div id="calendar"></div></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  var events_ = events_padre = new Array(), date_ = "";
  var CalendarApp = function() {
      this.jQuerycalendar = jQuery('#calendar'),
      this.jQuerycalendarObj = null
    };
  jQuery('button').click(function(){
    submod = jQuery(this).attr("data-mod"), mod = jQuery(this).attr("data-menu"), ref = jQuery(this).attr("data-ref"), subref = jQuery(this).attr("data-subref"), acc = jQuery(this).attr("data-acc"), assoc_id = jQuery(this).attr("data-id");
    if(acc=="search_ods"){
      modal_search("SELECCIONE UNA ODS",'accion='+acc+'&mod='+submod,'POST',false,false);
    }else if(acc=="GET_ODS_PLAN"){
      if(validate("ods")){
        jQuery(".preloader").fadeIn();
        clear_log();
        axios({
            method: "post",
            url: "./modules/controllers/ajax.php",
            data: { accion: acc, mod: submod, ods: jQuery("#cods").val() }
          }).then(data_response => {
            let repuesta = data_response.data
            if(repuesta.title=="SUCCESS"){
              jQuery('#calendar').fullCalendar('destroy');
              jQuery(repuesta.content).each(function(index,value){
                if(index==0){
                  date_ = value.start;
                }
                events_padre =
                {
                  ["id"]: value.id,
                  ["title"]: value.title,
                  ["ods"]: value.ods,
                  ["status"]: value.status,
                  ["transporte"]: value.transporte,
                  ["start"]: value.start,
                  ["end"]: value.end,
                  ["color"]: value.color
                  };
                  let cuenta = 0;
                  jQuery(value.det_plan).each(function(index1,value1){
                    cuenta++;
                    events_padre ["trabajador_"+cuenta]= value1["trabajador_"+cuenta];
                    events_padre ["cargo_"+cuenta]= value1["cargo_"+cuenta];
                });
                events_[index]=events_padre;
              });

              CalendarApp.prototype.init = function(){
                var jQuerythis = this;
                jQuerythis.jQuerycalendarObj = jQuerythis.jQuerycalendar.fullCalendar({
                  slotDuration: '00:30:00',
                  minTime: '{inicio}',
                  maxTime:  moment('2010-10-01 {fin}').add(2,'hours').format('HH:mm'),
                  defaultView: 'month',
                  defaultDate: date_,
                  handleWindowResize: true,
                  header:{
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                  },
                  locale: 'es',
                  events: events_,
                  editable: false,
                  droppable: false,
                  eventLimit: false,
                  selectable: false,
                  eventRender: function(event, element, view){
                    let cuerpo = `<div style="font-size: 12px;">`;
                    if ( typeof event["trabajador_1"] !== 'undefined' ) {
                      cuerpo += `<strong>PRINCIPAL: </strong>`+event.trabajador_1+` (`+event.cargo_1+`)<br>`;
                    }
                    if ( typeof event["trabajador_2"] !== 'undefined' ) {
                      cuerpo += `<strong>AYUDANTE 1: </strong>`+event.trabajador_2+` (`+event.cargo_2+`)<br>`;
                    }
                    cuerpo += `<strong>VEHICULO: </strong>`+event.transporte+`<br>`;
                    cuerpo += `</div>`;
                    element.popover({
                      title: '<div style="font-size: 12px;"><strong>'+event.title+'</strong></div>',
                      content: cuerpo,
                      trigger: 'hover',
                      placement: 'top',
                      container: 'body',
                      html: true
                    });
                  }
                });
              },
              jQuery.CalendarApp = new CalendarApp, jQuery.CalendarApp.Constructor = CalendarApp
              $.CalendarApp.init();
              jQuery(".preloader").fadeOut();
            }else{
                dialog(repuesta.content,repuesta.title);
            }
          }).catch(error => { axios_Error(error); });
      }
    }
  });
</script>
<!-- END BLOCK : module -->