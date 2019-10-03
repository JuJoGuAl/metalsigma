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
    <div class="col-md-6 col-lg-4">
        <div class="card material-card">
            <div class="card-body">
                <h5 class="card-title text-uppercase">CLIENTES CON ODS</h5>
                <div class="d-flex align-items-center mb-2 mt-4">
                    <h2 class="mb-0 display-5"><i class="icon-people text-info"></i></h2>
                    <div class="ml-auto">
                        <h2 class="mb-0 display-6"><span class="font-normal">{clientes}</span></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card material-card">
            <div class="card-body">
                <h5 class="card-title text-uppercase">ODS CREADAS</h5>
                <div class="d-flex align-items-center mb-2 mt-4">
                    <h2 class="mb-0 display-5"><i class="icon-note text-primary"></i></h2>
                    <div class="ml-auto">
                        <h2 class="mb-0 display-6"><span class="font-normal">{ods}</span></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card material-card">
            <div class="card-body">
                <h5 class="card-title text-uppercase">ODS PLANIFICADAS</h5>
                <div class="d-flex align-items-center mb-2 mt-4">
                    <h2 class="mb-0 display-5"><i class="icon-calender text-success"></i></h2>
                    <div class="ml-auto">
                        <h2 class="mb-0 display-6"><span class="font-normal">{plan}</span></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="card">
        <div id="calendar-events" class="card-body" style="height: 700px; position: relative; padding: 0.5rem; padding-top: 1.57rem;">
          <!-- START BLOCK : ods -->
          <div class="col-md-12 calendar-events" style="padding: 0px 10px;" data-codigo="{codigo}">
            <div class="card material-card {bg}">
              <div class="card-body" style="padding: 0.7rem;">
                <h6 class="text-uppercase" style="font-size: 0.8rem;"><i class="fa fa-circle text-{color} mr-2"></i> {ods_full}: <strong>{data}</strong></h6>
                <p>{maquina} {marca} {modelo}</p>
                <div class="d-flex align-items-center">
                  <div class="col-12">
                    <h5>DISP: {restante}<span class="pull-right">{avance}%</span></h5>
                    <div class="progress">
                      <div class="progress-bar bg-primary" role="progressbar" style="width: {avance}%" aria-valuenow="{avance}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END BLOCK : ods -->
        </div>
      </div>
    </div>
    <div class="col-md-9"><div id="calendar"></div></div>
  </div>
</div>
<script>
  var ini_,fin_;
  var events_ = new Array();
  events_ = [
  <!-- START BLOCK : events -->
  {
    {id},
    {title},
    {ods},
    {status},
    {transporte},
    {start},
    {end},
    <!-- START BLOCK : trabs -->
    {trabajador},
    {cargo},
    <!-- END BLOCK : trabs -->
    {color}
    },
  <!-- END BLOCK : events -->
  ];
  !function($) {
    "use strict";
    var CalendarApp = function() {
      this.$calendar = $('#calendar'),
      this.$event = ('#calendar-events div.calendar-events'),
      this.$calendarObj = null
    };

    CalendarApp.prototype.onDrop = function (eventObj, date){
      if((moment(date.format("DD-MM-YYYY HH:mm"),"DD-MM-YYYY HH:mm").diff(moment("{fecha_past}","DD-MM-YYYY HH:mm")))>=0){
        let variables = [];
        variables.push(moment(date).format('DD-MM-YYYY'));
        variables.push(0);
        variables.push(0);
        variables.push(eventObj.attr('data-codigo'));
        GetModule("SERVICIOS","PLAN_ODS","PLAN_ODS_FORM","NONE","NEW",variables);
      }else{
        dialog("NO SE PUEDEN CREAR PLANIFICACIONES EN EL PASADO!","ERROR");
      }
    },
    CalendarApp.prototype.onEventClick =  function (calEvent, jsEvent, view){
      if((moment(calEvent.start.format("DD-MM-YYYY HH:mm"),"DD-MM-YYYY HH:mm").diff(moment("{fecha_past}","DD-MM-YYYY HH:mm")))>=0){
        GetModule("SERVICIOS","PLAN_ODS","PLAN_ODS_FORM","NONE","EDIT",calEvent.id);
      }else{
        dialog("NO SE PUEDE EDITAR UNA PLANIFICACION DEL PASADO","ERROR");
      }
    },
    CalendarApp.prototype.onSelect = function (start, end, jsEvent, view){
      if((moment(start.format("DD-MM-YYYY HH:mm"),"DD-MM-YYYY HH:mm").diff(moment("{fecha_past}","DD-MM-YYYY HH:mm")))>=0){
        let variables = [];
        ini_ = moment(start).format('HH:mm');
        fin_ = moment(end).format('HH:mm');
        if(view.name=="month"){
          ini_=fin_=0;
        }
        variables.push(moment(start).format('DD-MM-YYYY'));
        variables.push(ini_);
        variables.push(fin_);
        variables.push(0);
        GetModule("SERVICIOS","PLAN_ODS","PLAN_ODS_FORM","NONE","NEW",variables);
      }else{
        dialog("NO SE PUEDEN CREAR PLANIFICACIONES EN EL PASADO!","ERROR");
      }
      var $this = this;
      $this.$calendarObj.fullCalendar('unselect');
    },
    CalendarApp.prototype.enableDrag = function(){
      $(this.$event).each(function (){
        $(this).draggable({
          zIndex: 999,
          revert: true,
          revertDuration: 0
        });
      });
    }
    CalendarApp.prototype.init = function(){
      this.enableDrag();
      var $this = this;
      $this.$calendarObj = $this.$calendar.fullCalendar({
        slotDuration: '00:30:00',
        minTime: '{inicio}',
        maxTime:  moment('2010-10-01 {fin}').add(1,'hours').format('HH:mm'),
        defaultView: 'month',
        handleWindowResize: true,
        header:{
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        locale: 'es',
        events: events_,
        editable: false,
        droppable: true,
        eventLimit: true,
        selectable: true,
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
        },
        drop: function(date) { $this.onDrop($(this), date); },
        select: function (start, end, jsEvent, view) { $this.onSelect(start, end, jsEvent, view); },
        eventClick: function(calEvent, jsEvent, view) { $this.onEventClick(calEvent, jsEvent, view); }
      });
    },
    $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
  }(window.jQuery),
  function($){
    "use strict";
    $.CalendarApp.init();
  }(window.jQuery);
  setTimeout("jQuery('#calendar').fullCalendar('render'); jQuery('#calendar-events').height(jQuery('#calendar .fc-view-container').height()+jQuery('#calendar .fc-header-toolbar').height()); new PerfectScrollbar('#calendar-events');",100);
</script>
<!-- END BLOCK : module -->