<!-- START BLOCK : module -->
<script>
  var myChart = option = graf = "";
  function chartBar(target_,legend_,color_,ejex_,series_) {
    var myChart = echarts.init(document.getElementById(target_));
    var option = {
      grid: {
        left: '0%',
        right: '0%',
        bottom: '0%',
        containLabel: true
      },
      tooltip : {
        trigger: 'item'
      },     
      toolbox: {
        show : true,
        feature : {
          magicType : {show: true, type: ['line', 'bar']},
          saveAsImage : {show: true}
        }
      },      
      calculable : true,
      legend: {
        data:legend_
      },
      color: color_,
      xAxis : [{
        type : 'category',
        data : ejex_
      }],
      yAxis : [{
        type : 'value'
      }],
      series : series_
    };
    myChart.setOption(option);
  }
  function pieBar(target_,legend_,color_,series_) {
    var myChart = echarts.init(document.getElementById(target_));
    var option = {
      tooltip: {
        trigger: 'item',
        //formatter: "{a} <br/>{b}: {c} ({d}%)"
      },
      legend: {
        orient: 'vertical',
        x: 'left',
        data: legend_
      },
      color: color_,
      toolbox: {
        show : true,
        feature : {
          saveAsImage : {show: true}
        }
      },
      calculable: true,
      series: [{
        name: 'ITEMS APROBADOS',
        type: 'pie',
        radius: '70%',
        center: ['50%', '57.5%'],
        data: series_
      }]
    };
    myChart.setOption(option);
  }
  jQuery(function(){
    jQuery('#form_').trigger("change");
  });
  jQuery(".nav-tabs a[href='#tab_1']").on('shown.bs.tab', function (e){
    chartBar("cot_cant",graf.chart1.legenda,graf.chart1.color,graf.chart1.ejex,graf.chart1.series);
    chartBar("cot_mont",graf.chart2.legenda,graf.chart2.color,graf.chart2.ejex,graf.chart2.series);
    chartBar("cot_vend_cant",graf.chart3.legenda,graf.chart3.color,graf.chart3.ejex,graf.chart3.series);
    chartBar("cot_vend_mont",graf.chart4.legenda,graf.chart4.color,graf.chart4.ejex,graf.chart4.series);
    
  });
  jQuery(".nav-tabs a[href='#tab_2']").on('shown.bs.tab', function (e){
    chartBar("cot_ver_cant",graf.chart5.legenda,graf.chart5.color,graf.chart5.ejex,graf.chart5.series);
    chartBar("cot_ver_monto",graf.chart6.legenda,graf.chart6.color,graf.chart6.ejex,graf.chart6.series);
    
  });
  jQuery(".nav-tabs a[href='#tab_3']").on('shown.bs.tab', function (e){
    pieBar("cot_item_cant",graf.chart7.legenda,graf.chart7.color,graf.chart7.series);
  });
  jQuery('#form_').on('change', function(){
   let form = jQuery(this).serializeArray();
   param = new Array(form[0].value,form[1].value,form[2].value);
   jQuery(".preloader").fadeIn();
   jQuery.ajax({
     type: "POST",
     url: "./modules/controllers/ajax.php",
     data : "accion=refresh_cot_graficos&stat="+JSON.stringify(param)+"&mod=rep_cotizaciones",
     dataType:'json',
     success: function(data){      
       if(data.title=="SUCCESS"){
        graf = data.content;
        let tab = jQuery("ul#tabs_ li a.active").attr("href");
        jQuery(".nav-tabs a[href='"+tab+"']").trigger('shown.bs.tab');
       }else if(data.content==-1){
        document.location.href="./?error=1";
       }
       jQuery(".preloader").fadeOut();
     },
     error: function(x,err,msj){
         jQuery(".preloader").fadeOut();
         Modal_error(x,err,msj);
     }
   });
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
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="year" class="control-label col-form-label">AÑO</label>
                  <select class="form-control custom-select filtros" id="year" name="year">
                    <option value="-1">TODOS...</option>
                    <!-- START BLOCK : det_year -->
                    <option value="{valor}" {selected}>{valor}</option>
                    <!-- END BLOCK : det_year -->
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="mes" class="control-label col-form-label">MES</label>
                  <select class="form-control custom-select filtros" id="mes" name="mes">
                    <option value="-1">TODOS...</option>
                    <!-- START BLOCK : det_mont -->
                    <option value="{valor}" {selected}>{dato}</option>
                    <!-- END BLOCK : det_mont -->
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="vend" class="control-label col-form-label">VENDEDOR</label>
                  <select class="form-control custom-select filtros" id="vend" name="vend">
                    <option value="-1">TODOS...</option>
                    <!-- START BLOCK : det_vend -->
                    <option value="{valor}" {selected}>{dato}</option>
                    <!-- END BLOCK : det_vend -->
                  </select>
                </div>
              </div>
            </div>
            <ul class="nav nav-tabs" role="tablist" id="tabs_">
              <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab_1" role="tab"><span class="hidden-xs-down">COTIZACIONES</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_2" role="tab"><span class="hidden-xs-down">APRO-REAL</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_3" role="tab"><span class="hidden-xs-down">ITEMS</span></a> </li>
            </ul>
            <div class="tab-content tabcontent-border">
              <div class="tab-pane p-4 active" id="tab_1" role="tabpanel">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="material-card card">
                      <div class="card-body analytics-info">
                        <h4 class="card-title" style="text-align: center;">COTIZACIONES (CANT)</h4>
                        <div id="cot_cant" style="height:500px;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="material-card card">
                      <div class="card-body analytics-info">
                        <h4 class="card-title" style="text-align: center;">COTIZACIONES (MONTO)</h4>
                        <div id="cot_mont" style="height:500px;"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="material-card card">
                      <div class="card-body analytics-info">
                        <h4 class="card-title" style="text-align: center;">COTIZACIONES POR VENDEDOR (CANT)</h4>
                        <div id="cot_vend_cant" style="height:500px;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="material-card card">
                      <div class="card-body analytics-info">
                        <h4 class="card-title" style="text-align: center;">COTIZACIONES POR VENDEDOR (MONTO)</h4>
                        <div id="cot_vend_mont" style="height:500px;"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_2" role="tabpanel">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="material-card card">
                      <div class="card-body analytics-info">
                        <h4 class="card-title" style="text-align: center;">COTIZACIONES REAL VS APRO (CANT)</h4>
                        <div id="cot_ver_cant" style="height:500px;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="material-card card">
                      <div class="card-body analytics-info">
                        <h4 class="card-title" style="text-align: center;">COTIZACIONES REAL VS APRO (MONTO)</h4>
                        <div id="cot_ver_monto" style="height:500px;"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane p-4" id="tab_3" role="tabpanel">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="material-card card">
                      <div class="card-body analytics-info">
                        <h4 class="card-title" style="text-align: center;">COTIZACIONES POR ITEM (MONTO)</h4>
                        <div id="cot_item_cant" style="height:500px;"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- END BLOCK : module -->