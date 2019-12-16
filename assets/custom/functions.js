var mod=submod=ref=subref=element="";
//Array para imprimir Cotizaciones
var array_status_print_cot = ["PCL","APB","PRO","CAN"];
//Array para imprimir ODS
var array_status_print_ods = ["PRO","FAC"];
//Array para imprimir FAC
var array_status_print_fac = ["FAC"];
//Array para imprimir ODC
var array_status_print_odc = ["PRO","UTI"];
//Array para Calculas COT
var array_status_calc_odc = ["PCO","PEN", "PCM", "PAC","PAT"];
//Array para COT editables en ALL
var array_status_cot_all = ["PCO","PEN", "PCM"];

outdatedBrowserRework({
    fullscreen: false,
    browserSupport: {
        'Chrome': 40,
        'Edge': 12,
        'Safari': 7.2,
        'Firefox': 30,
        'Opera': 25,
        'IE': false,
        'Mobile Safari': false,
        'Samsung Browser': 5,
    },
    requireChromeOnAndroid: false,
    isUnknownBrowserOK: false, 
})

$.extend( true, $.fn.dataTable.defaults, {
    "language": {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    },
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
    "pageLength": 25,
    initComplete: function () {
        jQuery("input[type='search']").focus();
    }
});

/** Asigno el Calendario a los campos Fecha (Creo una función para poder hacerlo en los campos dinamicos)*/
function SetCalendar(){
    let options = {
        language: 'es',
        autoclose: true,
        todayHighlight: true,
        format: "dd-mm-yyyy"
    };
    //options.startDate = '0';
    jQuery(".dates").each(function(){
        let date = jQuery(this);
        date.datepicker("destroy");
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            //MOBILE
            date.attr('type', 'date');
        }else{
            //WEB
            date.attr('type', 'text');
            date.datepicker(options);
            //if(date.is("[data-date]") && (date.data("date")!==null || date.data("date")!==undefined || date.data("date")!=="")){
            if(date.val()!==null || date.val()!==undefined || date.val()!==""){
                date.datepicker("setDate",date.val());
            }
        }
    });
}
/** Todos los inputs con la clase numeric, chequeo su keydown event
*/
jQuery(document).on("keypress", ".numeric", function(e){
    //var vRegExp = /^(\d*)(.?)(\d*?)$/g, val = jQuery(this).val();
    jQuery(this).val($(this).val().replace(/[^0-9\.]/g, ''));
    if ((e.which != 46 || jQuery(this).val().indexOf('.') != -1) && (e.which < 48 || e.which > 57)) {
        e.preventDefault();
    }
});
Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}
function addcero(value) {
    let new_val = value;
    if (value<9){
        new_val="0"+value;
    }
    return new_val;
}
jQuery(document).on("blur", ".sum_dtaller", function(){
    let fecha_ini = jQuery(this).closest("tr").find("td:eq(7) input").val();
    if((parseInt(jQuery(this).val())>0) && (fecha_ini!==null || fecha_ini!=="") && (jQuery.inArray(jQuery("#stats").val(),array_status_calc_odc)!=-1)){
        let from = fecha_ini.split("-");
        let fechas = new Date(from[2], from[1] - 1, from[0]);
        //let fechas = new Date();
        fechas = fechas.addDays(parseInt(jQuery(this).val()))
        //let fecha_hoy = addcero(fechas.getDate())+"-"+(addcero(fechas.getMonth()+1))+"-"+fechas.getFullYear();
        let tr = jQuery(this).closest("tr").find("td:eq(8) input");
        tr.datepicker("setDate", new Date(fechas.getFullYear(),(addcero(fechas.getMonth())),addcero(fechas.getDate())));
        //tr.val(fecha_hoy);
    }
});
/** Limpia el Log en este TEMA CLEAR_LOG, elimina los ERRORES en INPUTS
*/
function clear_log(){
    jQuery('.is-invalid').removeClass("is-invalid");
    jQuery('.is-valid').removeClass("is-valid");
}
/** Navegacion */
jQuery(document).on("click", ".menu", function(){
    mod=jQuery(this).attr('data-menu'), submod=jQuery(this).attr('data-mod'), ref=jQuery(this).attr('data-ref'), subref=jQuery(this).attr('data-subref'), accion=jQuery(this).attr('data-acc'), id=jQuery(this).attr('data-id');
    GetModule(mod,submod,ref,subref,accion,id);
});
/** Llama un Modulo
* @param mod: posee el nombre del menu donde esta
* @param submod: modulo que se esta pidiendo
* @param ref: sub modulo de existir
* @param subref: sub sub modulo, utilizado cuando en un crud hay otro crud
* @param acc: la accion requerida
* @param id: el campo ID de existir
*/
function GetModule(mod,submod,ref,subref,acc,id){
    jQuery(".preloader").fadeIn();
    clear_log();
    if (typeof ref === "undefined" || ref === null){
        ref="NONE";
    }
    if (typeof subref === "undefined" || subref === null){
        subref="NONE";
    }
    url='./modal.php?mod='+mod+'&submod='+submod+'&ref='+ref+'&subref='+subref+'&accion='+acc+'&id='+id;  

    if(acc=="CLOSE"){
        jQuery("#form")
        .empty()
        .fadeOut();
        jQuery("#modulo").fadeIn();
        jQuery(".preloader").fadeOut();
    }else if(acc=="MODAL"){
        jQuery(".modal .modal-body .modal-body-content").empty();
        jQuery(".modal").modal('hide');
        jQuery(".preloader").fadeOut();
    }else{
        jQuery.get(url, function(){ })
        .done(function(data) {
            if(data==0){
                document.location.href="./?error=1";
            }else{
                jQuery('.modal-backdrop').remove();
                if(acc=="NEW" || acc=="EDIT"){
                    jQuery("#modulo").hide();
                    jQuery("#form")
                    .empty()
                    .html(data)
                    .fadeIn();
                }else{
                    jQuery("#form")
                    .empty()
                    .hide();
                    jQuery("#modulo")
                    .empty()
                    .hide();
                    jQuery("#modulo").html(data)
                    .fadeIn();
                }
                jQuery(document).ready(function() {
                    if(acc!="NEW" && acc!="EDIT"){
                        let table = jQuery(".datatables");
                        let options = {};
                        options.order = table.is("[data-dt_order]") ? (table.data("dt_order") == false ? [] : table.data("dt_order")) : [[0, 'desc']];
                        options.pageLength = table.is("[data-dt_page_lenght]") ? table.data("dt_page_lenght") : 10;
                        table.DataTable(options);
                    }
                    jQuery('.tooltip').tooltip("dispose");
                    jQuery('[data-toggle="tooltip"]').tooltip();
                    SetCalendar();
                    jQuery('.clockpicker-popover').remove();
                    jQuery('.times').clockpicker({
                        placement: 'top',
                        align: 'left',
                        donetext: 'Aceptar',
                        autoclose: true,
                        'default': 'now'
                    });
                    jQuery('[data-toggle="popover"]').popover('dispose');
                    jQuery('.popover').remove();
                    jQuery('[data-toggle="popover"]').popover({ container: "body", trigger: "hover", placement: 'left', html : true });
                    jQuery(".number_cal").formatCurrency();
                    // OJO ACA DEBO DE HACER ALGO SI ESTAN CERRADAS
                    if(submod!="REP_COTIZACIONES" && submod!="REP_PLAN" && ref!="FORM_COT_SUB_ALL" && ref!="FORM_COT_SUB_TALLER" && ref!="FORM_COT_SUB_CEO"){ jQuery(".preloader").fadeOut(); }                    
                });
            }
        })
        .fail(function(x,err,msj) {
            jQuery("#form")
            .empty()
            .hide();
            jQuery("#modulo")
            .empty()
            .hide()
            jQuery("#modulo").load("./views/page_500.tpl")
            .fadeIn();
            jQuery(".preloader").fadeOut();
        });
    }
    element = jQuery('ul#sidebarnav a').filter(function() {
        return (jQuery(this).attr('data-menu') === mod && jQuery(this).attr('data-mod') === submod);
    });
    //QUITO LAS CLASES ACTIVAS DE CUALQUIER ELEMENTO
    jQuery('ul#sidebarnav').find('.selected').removeClass('selected');
    jQuery('ul#sidebarnav').find('.active').removeClass('active');
    //jQuery('ul#sidebarnav').find('.in').removeClass('in');
    // SEGUN EL ELEMENTO SELECCIONADO ACTIVO SUS CLASES
    element.parentsUntil(".sidebar-nav").each(function (index){
        if(jQuery(this).is("li") && jQuery(this).children("a").length !== 0){
            jQuery(this).children("a").addClass("active");
            jQuery(this).parent("ul#sidebarnav").length === 0 ? jQuery(this).addClass("active"): jQuery(this).addClass("selected");
        }else if(!jQuery(this).is("ul") && jQuery(this).children("a").length === 0){
            jQuery(this).addClass("selected");
        }else if(jQuery(this).is("ul")){
            jQuery(this).addClass('in');
        }
    });
    element.addClass("active");
    //CIERRO EL MENU (MOVIL) LUEDO DE SELECCIONAR UN MODULO
    jQuery('#main-wrapper').removeClass('hide-sidebar');
    (jQuery('.nav-toggler i').hasClass('ti-menu')) ? '' : jQuery('.nav-toggler i').addClass('ti-menu');
    //ANIMO EL BODY HACIA ARRIBA
    jQuery("html, body").animate({ scrollTop: 0 }, "slow");
}
/** Envia por AJAX datos para guardar y retorna el Resultado
* @param menu: posee el nombre del menu donde esta
* @param mod: modulo que se esta pidiendo
* @param ref: sub modulo de existir
* @param subref: sub sub modulo, utilizado cuando en un crud hay otro crud
* @param form: Formulario a Evaluar
* @param id: Envio ID, para acceder a el si necesito la data
*/
function SendForm(menu,mod,ref,subref,form=false,id=false){
    clear_log();
    if (typeof form === "undefined" || form === null || form===false){
        form="#form_";
    }
    if (typeof ref === "undefined" || ref === null){
        ref="NONE";
    }
    if (typeof subref === "undefined" || subref === null){
        subref="NONE";
    }
    if(valform(form)){
        jQuery(".preloader").fadeIn();
        jQuery.ajax({
            type: "GET",
            url: "./modules/controllers/"+menu.toLowerCase()+"/"+ref.toLowerCase()+".php",
            data : jQuery(form).serialize() + "&mod="+menu+"&submod="+mod,
            dataType:'json',
            success: function(data){
                if(data.title=="SUCCESS"){
                    dialog(data.content,data.title);
                    GetModule(menu,mod,"NONE",subref,"SAVE",id);
                }else if(data.content==-1){
                    jQuery(".preloader").fadeOut();
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
    }
}
/** Invocado en Error, evalua el error para mostralo
* @param x: objeto con la informacion
* @param err: titulo del error
* @param msj: mensaje de error
*/
function Modal_error(x,err,msj){
    var response="";
    if(x.status==0){
        response="YOU ARE OFFLINE!\n PLEASE CHECK YOUR NETWORK.";
    }else if(x.status==404){
        response="REQUEST URL NOT FOUND!";
    }else if(x.status==500){
        response="INTERNAL SERVER ERROR.";
    }else if(err=='parsererror'){
        response="ERROR.!\n PARSING JSON REQUEST FAILED.";
    }else if(err=='timeout'){
        response="REQUEST TIME OUT.";
    }else {
        response="UNKNOW ERROR.\n"+x.responseText
    }
    dialog(response,"ERROR");
}
/** Funcion de Error para AXIOS
* @param error: objeto con la informacion
*/
function axios_Error(error){
    var response="";
    if(error.message===undefined){
        //Abortada
    }else{
        if(error.response){
            if(error.response.status==404){
                response="LA URL NO EXISTE!";
            }else if(error.response.status==500){
                response="ERROR INTERNO DEL SERVIDOR";
            }else{
                response="ERROR DESCONOCIDO:<br>"+error;
            }
        }else{
            if(error.request){
                response="ERROR DE CONEXION!<br>VERIFIQUE SU CONEXION!";
            }else{
                response="ERROR DESCONOCIDO:<br>"+error;
            }
        }
        dialog(response.toUpperCase(),"ERROR");
    }
}
/** Muestra una notificacion
* @param _msj: Mensaje a Mostrar
* @param _class: Tipo de Mensaje
* @param _funcion: Si es diferente de FALSE, sera la Funcion a ejecutar, al ser confirmado
* @param _elementsArray: array con los parametros de la funcion adjuntada(en caso de que los necesite).
*/

function dialog(_msj,_class,_funcion,_elemetsArray){
    if (typeof _funcion === "undefined" || _funcion === null || _funcion===false){
        _funcion=false;
    }
    jQuery('.jconfirm').remove();

    var clas,icon;
    if(_class=='ERROR'){
        clas="danger";
        icon="fas fa-times";
    }else if (_class=='INFO'){
        clas="info";
        icon="fas fa-exclamation-circle"
    }else if(_class=='WARNING'){
        clas="warning";
        icon="fas fa-exclamation-triangle"
    }else if(_class=='SUCCESS'){
        clas="success";
        icon="fas fa-check-circle"
    }
    let botones ="";
    if(_funcion){
        botones={OK: {btnClass: 'btn-'+clas,action: function(){_funcion.apply(null,_elemetsArray);}},CANCELAR: function (){}};
    }else{
        botones={CERRAR: {btnClass: 'btn-'+clas,action: function(){}}};
    }

    $.confirm({
        icon: icon,
        theme: 'bootstrap',
        type: clas,
        title: 'MetalSigma',
        content: _msj,
        buttons: botones,
        onContentReady: function () {
            jQuery(".jconfirm-buttons button:last").focus()
        }
    });
}
/** Valida que la lista posea un Valor
* @param _obj: Objeto a Evaluar
*/
function list(_obj){
    var label=jQuery("label[for='"+_obj+"']").text(), val=jQuery('#'+_obj).val();
    if(val=='-1'){
        jQuery('#'+_obj).addClass("is-invalid");
        dialog("DEBE SELECCIONAR UNA OPCION PARA <strong>"+label+"</strong>","ERROR");
        return false;
    }else{
        return true;
    }
}
/** Valida que un Campo no este Vacío
* @param _obj: Objeto a Evaluar
*/
function validate(_obj){
    var label=jQuery("label[for='"+_obj+"']").text(), val=jQuery('#'+_obj).val();
    if(val===''){
        jQuery('#'+_obj).addClass("is-invalid");
        dialog("EL CAMPO <strong>"+label+"</strong> ES OBLIGATORIO","ERROR");
        return false;
    }else{
        return true;
    }
}
/** Verifica que sea Numero, y mayor a 0
* @param _obj: Objeto a Evaluar
* @param _positive: Si es TRUE el Objeto debe ser mayor a 0
*/
function IsNumber(_obj,_log,_positive){
    var vRegExp = /[0-9 -()+]+$/, label=jQuery("label[for='"+_obj+"']").text(), val=jQuery('#'+_obj).val();
    if (typeof _positive === "undefined" || _positive === null){
        _positive=false;
    }
    if(val!==''){
        if(_positive && val<=0){
            jQuery('#'+_obj).addClass("is-invalid");
            dialog("EL CAMPO <strong>"+label+"</strong> DEBE SER MAYOR A 0","ERROR");
            return false;
        }else if(val.match(vRegExp)){
            return true;
        }else{
            jQuery('#'+_obj).addClass("is-invalid");
            dialog("EL CAMPO <strong>"+label+"</strong> DEBE SER NUMERICO","ERROR");
            return false;
        }
    }
}
/** Verifica que sea Fecha Válida
* @param _obj: Objeto a Evaluar
*/
function IsDate(_obj){
    var vRegExp = /^([0-9]{2})(\-)([0-9]{2})(\-)([0-9]{4})$/, label=jQuery("label[for='"+_obj+"']").text(), val=jQuery('#'+_obj).val();
    if(jQuery("#"+_obj).attr("type")=="date"){
        return true;
    }else{
        if(val!=''){
            if(val.match(vRegExp)){
                return true;
            }else{
                jQuery('#'+_obj).addClass("is-invalid");
                dialog("EL CAMPO <strong>"+label+"</strong> DEBE SER UNA FECHA VALIDA","ERROR");
                return false;
            }
        }
    }
}
/** Verifica que un Email sea valido
* @param _obj: Objeto a Evaluar
*/
function validMail(_obj) {
   var vRegExp = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
   var label=jQuery("label[for='"+_obj+"']").text(), val=jQuery('#'+_obj).val();
   if(val!=''){
        if(val.match(vRegExp)){
            return true;
        }else{
            jQuery('#'+_obj).addClass("is-invalid");
            dialog("EL CAMPO <strong>"+label+"</strong> DEBE SER UN MAIL VALIDO","ERROR");
            return false;
        }
    }
}
/** Verifica que sea RUT
* @param _obj: Objeto a Evaluar
*/
function IsRut(_obj){
    var label=jQuery("label[for='"+_obj+"']").text(), val=jQuery('#'+_obj).val(), valido=true;
    if(val.length == 0 || val.length < 8 || val.length > 10){ valido = valido && false; }
    var suma = 0;
    var caracteres = "1234567890kK";
    var contador = 0;    
    for (var i=0; i < val.length; i++){
        u = val.substring(i, i + 1);
        if (caracteres.indexOf(u) != -1)
        contador ++;
    }
    if(contador==0){ valido = valido && false; }    
    var rut = val.substring(0,val.length-1)
    var drut = val.substring( val.length-1 )
    var dvr = '0';
    var mul = 2;    
    for (i= rut.length -1 ; i >= 0; i--) {
        suma = suma + rut.charAt(i) * mul
        if (mul == 7){mul=2;}
        else{mul++;}
    }
    res = suma % 11;
    if (res==1){dvr='k';}else if (res==0) {dvr = '0';}
    else { dvi = 11-res; dvr = dvi + "";}
    if (dvr != drut.toLowerCase()) { valido = valido && false; }
    else { valido = valido && true; }
    if(valido){
        return true;
    }else{
        jQuery('#'+_obj).addClass("is-invalid");
        dialog("EL CAMPO <strong>"+label+"</strong> NO ES UN RUT VALIDO","ERROR");
        return false;
    }
}
/** Cuenta las filas de una tabla
* @param _tbl: Objeto a Evaluar
* @param _tipo: Tipo de Objeto contado, (para el mensaje)
*/
function count_row(_tbl,_tipo){
    var table=jQuery('#'+_tbl+' tbody tr').length;
    if(_tipo=="label"){
        _tipo=jQuery("label[for='"+_tbl+"']").text()
    }
    if(table<=0){
        dialog("DEBE SELECCIONAR AL MENOS UN <strong>"+_tipo+"</strong>","ERROR");
        return false;
    }else{
        return true;
    }
}
/** Verifica si se selecciono un CheckBox
* @param _obj: Objeto a Evaluar
* @param _tipo: Tipo de Objeto contado, (para el mensaje)
*/
function checkbox(_obj,_tipo){
    var number=jQuery("input[name='"+_obj+"[]']:checked").length;
    if(number<=0){
        dialog("DEBE SELECCIONAR AL MENOS <strong>"+_tipo+"</strong>","ERROR");
        jQuery("input[name='"+_obj+"[]']").addClass("is-invalid");
        return false;
    }else{
        return true;
    }
}
/** Valida un Formulario, haciendo un bucle por todos los campos que sean VALIDABLES
* @param _form: ID del Objeto a Validar
*/
function valform(_form){
    clear_log();
    if (typeof _form === "undefined" || _form === null){
        _form="#form_";
    }
    var valido=true;
    jQuery(_form+' .validar').each(function(){
        var id = jQuery(this).prop('id');
        if(!jQuery(this).hasClass("table")){
            valido = valido && validate(id);    
        }
        if(jQuery(this).hasClass("numeric") && jQuery(this).hasClass("positive")){
            valido = valido && IsNumber(id,true);
        }else if (jQuery(this).hasClass("numeric")){
            valido = valido && IsNumber(id);
        }else if(jQuery(this).hasClass("dates")){
            valido = valido && IsDate(id);
        }else if(jQuery(this).hasClass("list")){
            valido = valido && list(id);
        }else if(jQuery(this).hasClass("rut")){
            valido = valido && IsRut(id);
        }else if(jQuery(this).hasClass("mail")){
            valido = valido && validMail(id);
        }else if(jQuery(this).hasClass("table")){
            valido = valido && count_row(id,"label");
        }
    });
    return valido;
}
/** Muestra un MODAL, con los resultados de un AJAX
* @param _title: Titulo del MODAL
* @param _data: Variables a enviar en el AJAX
* @param _type: Tipo (POST / GET)
* @param _new: Si maneja el Boton Nuevo
* @param _sub: Si modal_search se ejecuta dentro de otro MODAL (NO SE UTILIZA)
*/
function modal_search(_title,_data,_type,_new=false,_sub=false){
    jQuery(".preloader").fadeIn();
    jQuery.ajax({
        url: "./modules/controllers/ajax.php",
        type: _type,
        data: _data,
        dataType:'json',
        success: function(data){
            if(data.title=="ERROR"){
                jQuery(".preloader").fadeOut();
                dialog(data.content,data.title);
            }else{
                let modal="#Modal_";
                if(_sub){
                    modal="#Modal_Sub";
                }
                jQuery(modal+" .modal-body .modal-body-content")
                    .empty()
                    .html(data);
                jQuery(modal+' #myLargeModalLabel').html(_title);
                if(_new){
                    jQuery(modal+" #add_new").show();
                }else{
                    jQuery(modal+" #add_new").hide();
                }
                jQuery(modal).css("z-index","2000");
                if(acc=="add_odc_nte_pro"){ jQuery(modal+" #modal_ok").show(); }else{ jQuery(modal+" #modal_ok").hide(); }
                jQuery(modal).modal({show:true,backdrop: 'static',keyboard: false});
                jQuery(modal+" .number_cal").formatCurrency();
                jQuery(modal+" .pop").each(function(){
                    jQuery(this).parents("td").popover({
                        title: '<div style="font-size: 12px;"><strong>'+jQuery(this).attr("data-title")+'</strong></div>',
                        content: '<div style="font-size: 12px;">'+jQuery(this).attr("data-body")+'</div>',
                        trigger: 'hover',
                        placement: 'top',
                        container: modal+' table',
                        html: true
                    });
                });
                jQuery(modal+' [data-toggle="tooltip"]').tooltip();                
                jQuery(modal+" .datatables").DataTable({"order" : [[0, 'desc']]});
                jQuery(".preloader").fadeOut();
                //Coloca en verde la fila seleccionada, luego cierra el Modal
                jQuery(modal+" .datatables tbody").on( 'click', 'tr', function (){
                    if(acc!="add_odc_nte_pro"){
                        jQuery(this).addClass('seleccionado');
                        jQuery(modal).modal('hide');
                    }
                });
            }
        },
        error: function(x,err,msj){
            jQuery(".preloader").fadeOut();
            Modal_error(x,err,msj);
        }
    });
}
/**
 * ANALIZA EL MODAL CERRADO PARA TOMAR ACCIONES, EN FUNCION A LA ACCION
 */
jQuery(document).on("hidden.bs.modal", "#Modal_", function (e){
    if (jQuery(this).find('.datatables tbody tr').hasClass('seleccionado')) {
        table = jQuery(this).find(".datatables tbody tr.seleccionado");
        code=table.find('._id').text(), nombre=table.find('._nom').text();
        if(acc=="add_eqs"){
            var count = (jQuery("#table_det_cli tbody tr").length)+1;
            mar=table.find('._mar').text(), mode=table.find('._mod').text(), seg=table.find('._seg').text();
            tr=`<tr>
            <td><input name="cequipo[]" id="cequipo[`+count+`]" type="hidden" value="`+code+`"><input name="cmaquina[]" id="cmaquina[`+count+`]" type="hidden" value="0">`+nombre+`</td>
            <td>`+mar+`</td>
            <td>`+mode+`</td>
            <td>`+seg+`</td>
            <td><input type="text" id="serial[`+count+`]" name="serial[]" class="form-control" value=""></td>
            <td><input type="text" id="interno[`+count+`]" name="interno[]" class="form-control" value=""></td>
            <td><input name="status[]" id="status[`+count+`]" type="hidden" value="1">SI</td>
            <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
            </tr>`;
            jQuery("#table_det_cli tbody").append(tr);
        }else if(acc=="search_cargo"){
            jQuery("#cargo").val(nombre);
            jQuery("#ccargo").val(code);
        }else if(acc=="search_especialidad"){
            jQuery("#especialidad").val(nombre);
            jQuery("#cespecialidad").val(code);
        }else if(acc=="search_sistema"){
            if(submod=="CRUD_EQUIPOS"){
                jQuery("#parte").val(nombre);
                jQuery("#cparte").val(code);
            }else if(mod=="COTIZACIONES"){
                var currentdate = new Date();
                var fecha_hoy = currentdate.getDate()+"-"+(currentdate.getMonth()+1)+"-"+currentdate.getFullYear();
                var count = (jQuery("#table_det_cot tbody tr").length-1)+1;
                tr=`<tr class="datas">
                <td>`+count+`<input name="c_det[]" id="c_det[]" type="hidden" value="0"></td>
                <td><input name="cparte[]" id="cparte[`+count+`]" type="hidden" value="`+code+`">`+nombre+`</td>
                <td><input name="cpieza[]" id="cpieza[`+count+`]" type="hidden" value="">
                <button class="btn btn-outline-secondary waves-effect waves-light btn-sm pieza ctrl" type="button" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`" data-acc="search_componente" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span></button></td>
                <td><input name="cservi[]" id="cservi[`+count+`]" type="hidden" value="">
                <button class="btn btn-outline-secondary waves-effect waves-light btn-sm servicio ctrl" type="button" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`" data-acc="search_servicio_propio" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span></button></td>
                <td><input name="hhtaller[]" id="hhtaller[`+count+`]" type="text" class="form-control numeric ctrl sum_hh_ta" style="width: 70px" maxlength="5" value=""></td>
                <td><input name="hhterreno[]" id="hhterreno[`+count+`]" type="text" class="form-control numeric ctrl sum_hh_te" style="width: 70px" maxlength="5" value="0"></td>
                <td><input name="dtaller[]" id="dtaller[`+count+`]" type="text" class="form-control numeric ctrl sum_dtaller" style="width: 50px" maxlength="2" value="0"></td>
                <td><input name="inicio[]" id="inicio[`+count+`]" type="text" class="form-control dates ctrl" maxlength="10" style="width:110px;" autocomplete="off" value="`+fecha_hoy+`"></td>
                <td><input name="fin[]" id="fin[`+count+`]" type="text" class="form-control dates ctrl" maxlength="10" style="width:110px;" autocomplete="off" value="`+fecha_hoy+`"></td>
                <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
                </tr>`;
                jQuery("#table_det_cot tbody tr:last").before(tr);
                SetCalendar();
            }
        }else if(acc=="add_art_cot" || acc=="add_serv_cot"){
            let tabla="";
            tabla="table_det_odc";
            var count = (jQuery("#"+tabla+" tbody tr").length)+1;
            tr=`<tr>
            <td><input name="corden_det[]" id="corden_det[`+count+`]" type="hidden" class="hidden" value="0"><input name="carticulo[]" id="carticulo[`+count+`]" type="hidden" value="`+code+`">`+code+`</td>
            <td>`+table.find('._code').text()+`</td>
            <td>`+nombre+`</td>
            <td><input type="text" id="cant[`+count+`]" name="cant[]" class="form-control numeric" maxlength="10" style="width:100px" value="" autocomplete=off></td>`;
            if(submod!="CRUD_INV_REQ"){
                tr+=`<td><input type="text" id="precio[`+count+`]" name="precio[]" class="form-control numeric" maxlength="12" style="width:100px" value="" autocomplete=off></td>
            <td><input type="text" id="imp[`+count+`]" name="imp[]" class="form-control numeric" maxlength="12" style="width:100px" value="`+table.find('input').val()+`" readonly></td>
            <td><input type="text" id="total[`+count+`]" name="total[]" class="form-control" style="width:100px" value="0" disabled></td>`;
            }
            if(submod=="CRUD_INV_REQ"){
                tr+=`<td>`+table.find('._clas').text()+`</td>`;
            }
            tr+=`<td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
            </tr>`;
            jQuery("#"+tabla+" tbody").append(tr);
            if(submod!="CRUD_INV_REQ"){ cal_odc(); }
        }else if(acc=="search_proveedor"){
            let rut=table.find('._rut').text(), dir=table.find('._dir').val();
            jQuery("#proveedor").val(nombre);
            jQuery("#cproveedor").val(code);
            jQuery("#rut").val(rut);
            jQuery("#direccion").val(dir);
            jQuery("#table_odc_nte tbody").empty();
            jQuery("#table_det_arts_nte tbody").empty();
            if (submod=="CRUD_INV_NTE"){
                acc="add_odc_nte_pro";
                let non_det = new Array();
                jQuery('#table_odc tbody tr td input[id^="corden"]').each(function(row, tr){
                    non_det.push(jQuery(this).val());
                });
                modal_search("SELECCIONE UNA ODC A AGREGAR",'accion='+acc+'&mod='+submod+'&prov='+jQuery("#cproveedor").val()+'&not='+JSON.stringify(non_det)+'&cursor=on','POST',false,false);
            }
        }else if(acc=="search_cliente"){
            let rut=table.find('._rut').text(), dir=table.find('._dir').val(), cre=table.find('._cre').val();
            let pag=table.find('._pag').val(), desc=table.find('._desc').val();
            jQuery("#cliente").val(nombre);
            jQuery("#ccliente").val(code);
            jQuery("#rut").val(rut);
            jQuery("#direccion").val(dir);
            jQuery("#table_eqs_cot tbody").empty();
            jQuery("#add_eqs").fadeIn();
        }else if(acc=="add_eqs_cot"){
            let seg=table.find('._seg').text(), ser=table.find('._ser').text(), int=table.find('._int').text();
            var count = (jQuery("#table_eqs_cot tbody tr").length)+1;
            tr=`<tr>
            <td><input name="cmaquina[]" id="cmaquina[`+count+`]" type="hidden" value="`+code+`">`+code+`</td>
            <td>`+nombre+`</td>
            <td>`+seg+`</td>
            <td>`+ser+`</td>
            <td>`+int+`</td>
            <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
            </tr>`;
            jQuery("#table_eqs_cot tbody").append(tr);
            jQuery("#add_eqs").fadeOut();
        }else if(acc=="add_ser_cot"){
            jQuery(".preloader").fadeIn();
            jQuery.ajax({
                type: "POST",
                url: "./modules/controllers/ajax.php",
                data : 'accion=add_ser_cot&code='+code+'&mod='+submod,
                dataType:'json',
                success: function(data){
                    if(data.title=="SUCCESS"){
                        let datos = data.cab;
                        var count = (jQuery("#table_add_ser tbody tr").length)+1;
                        tr=`<tr>
                        <td><input name="ccotizacion[]" id="ccotizacion[`+count+`]" type="hidden" value="`+datos.codigo+`">`+datos.codigo+`</td>
                        <td>`+datos.data+`</td>
                        <td>`+datos.fecha+`</td>
                        <td>`+datos.servicios+`</td>
                        <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>`;
                        jQuery("#table_add_ser tbody").append(tr);
                        jQuery.each(data.det, function(key,value){
                            let price = parseFloat(value.costou), new_price= parseFloat(((jQuery("#mar_stt").val() * price)/100)+price);
                            tbl_det="table_ser_ter";
                            var count = (jQuery("#"+tbl_det+" tbody tr").length)+1;
                            tr_det=`<tr>
                            <td>
                                <input name="corigen[]" id="corigen[`+count+`]" type="hidden" value="`+datos.codigo+`">
                            `+value.codigo_art+`</td>
                            <td>`+value.codigo2+`</td>
                            <td>`+value.articulo+`</td>
                            <td><input name="cant[]" id="cant[`+count+`]" type="hidden" value="`+value.cant+`">`+value.cant+`</td>
                            <td class="add_ser"><span class="number_cal">`+new_price+`</span><input name="precio[]" id="precio[`+count+`]" type="hidden" value="`+new_price+`"><input name="tipo_art[]" id="tipo_art[`+count+`]" type="hidden" value="stt"></td>
                            <td>`+datos.codigo+`</td>
                            </tr>`;
                            jQuery("#"+tbl_det+" tbody").append(tr_det);
                        });
                        jQuery(".preloader").fadeOut();
                    }else{
                        jQuery(".preloader").fadeOut();
                        dialog(data.content,data.title);
                    }
                },
                error: function(x,err){
                    jQuery(".preloader").fadeOut();
                    Modal_error(x,err);
                }
            });
        }else if(acc=="search_componente"){
            var count = (jQuery("#table_det_cot tbody tr").length)+1;
            let cell=`<input name="cpieza[]" id="cpieza[`+count+`]" type="hidden" value="`+code+`">`+nombre+
            `<button class="btn btn-outline-secondary waves-effect waves-light btn-sm pieza ctrl" type="button" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`" data-acc="search_componente" data-id="0" style="margin-left: .5rem;"><span class="btn-label"><i class="fas fa-sync"></i></span></button>`;
            jQuery('#table_det_cot tbody tr:eq('+codec+') td:eq(2)').html(cell);
        }else if(acc=="search_servicio_propio"){
            var count = (jQuery("#table_det_cot tbody tr").length)+1;
            let cell=`<input name="cservi[]" id="cservi[`+count+`]" type="hidden" value="`+code+`">`+nombre+
            `<button class="btn btn-outline-secondary waves-effect waves-light btn-sm servicio ctrl" type="button" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`" data-acc="search_servicio_propio" data-id="0" style="margin-left: .5rem;"><span class="btn-label"><i class="fas fa-sync"></i></span></button>`;
            jQuery('#table_det_cot tbody tr:eq('+codec+') td:eq(3)').html(cell);
        }else if(acc=="add_ins" || acc=="add_rep" || acc=="add_ser"){
            var count = (jQuery("#table_"+acc+" tbody tr").length)+1;
            let precio=table.find('._pri').text()*1,cod2=table.find('._code').text();
            let margen = (acc=="add_ins") ? jQuery("#mar_ins").val() : (acc=="add_rep") ? jQuery("#mar_rep").val() : (acc=="add_ser") ? jQuery("#mar_stt").val() : 0 ;
            let tipo = (acc=="add_ins") ? "ins" : (acc=="add_rep") ? "rep" : (acc=="add_ser") ? "stt" : 0 ;
            let new_price = ((margen * precio)/100)+precio;
            tr=`<tr>
            <td><input name="c_det_art[]" id="c_det_art[`+count+`]" type="hidden" value="0"><input name="carticulo[]" id="carticulo[`+count+`]" type="hidden" value="`+code+`">`+code+`</td>
            <td>`+cod2+`</td>
            <td>`+nombre+`</td>
            <td><input name="cant[]" id="cant[`+count+`]" type="text" class="form-control numeric ctrl" value="1"></td>
            <td class="`+acc+`"><span class="number_cal">`+new_price+`</span><input name="precio[]" id="precio[`+count+`]" type="hidden" value="`+new_price+`"><input name="tipo_art[]" id="tipo_art[`+count+`]" type="hidden" value="`+tipo+`"></td>
            <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
            </tr>`;
            jQuery("#table_"+acc+" tbody").append(tr);
            calculos();
        }else if(acc=="search_almacen_compra"){
            if(submod=="CRUD_INV_REQ"){
                jQuery("#almacen_ori").val(nombre);
                jQuery("#calmacen_ori").val(code);
            }else{
                jQuery("#almacen").val(nombre);
                jQuery("#calmacen").val(code);
            }
        }else if(acc=="search_almacen"){
            if(submod=="CRUD_INV_REQ"){
                jQuery("#almacen_des").val(nombre);
                jQuery("#calmacen_des").val(code);
            }else{
                jQuery("#almacen").val(nombre);
                jQuery("#calmacen").val(code);
            }
        }else if(acc=="search_almacen_user"){
            tr_=`<tr>
            <td><input name="calmacen[]" id="calmacen[`+count+`]" type="hidden" value="`+code+`">`+code+`</td>
            <td>`+nombre+`</td>
            <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
            </tr>`;
            jQuery("#table_alm_user tbody").append(tr_);
        }else if(acc=="add_odc"){
            jQuery(".preloader").fadeIn();
            jQuery.ajax({
                type: "POST",
                url: "./modules/controllers/ajax.php",
                data : 'accion='+acc+'&code='+code+'&mod='+submod,
                dataType:'json',
                success: function(data){
                    if(data.title=="SUCCESS"){
                        let tbl_cab=tbl_det=tbl_nte="";
                        cab = data.cab, det = data.det, mov = data.mov;
                        tbl_cab="table_odc";
                        var count = (jQuery("#"+tbl_cab+" tbody tr").length)+1;
                        tr_cab=`<tr>
                        <td><input name="corden[]" id="corden[`+count+`]" type="hidden" value="`+cab.codigo+`">`+cab.codigo+`</td>
                        <td>`+cab.data+`</td>
                        <td>`+cab.fecha_orden+`</td>
                        <td>`+cab.articulos+`</td>
                        <td class="number_cal">`+cab.monto_total+`</td>
                        <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>`;

                        jQuery.each(det, function(key,value){
                            tbl_det="table_art";
                            var count = (jQuery("#"+tbl_det+" tbody tr").length)+1;
                            tr_det=`<tr>
                            <td>
                                <input name="codc[]" id="codc[`+count+`]" type="hidden" value="`+value.origen+`">
                                <input name="codc_det[]" id="codc_det[`+count+`]" type="hidden" value="`+value.codigo+`">
                                <input name="carticulo[]" id="carticulo[`+count+`]" type="hidden" value="`+value.codigo_art+`">
                                <input name="cmov_det[]" id="cmov_det[`+count+`]" type="hidden" value="0">
                                <input name="costo[]" id="costo[`+count+`]" type="hidden" value="`+value.costou+`">
                                <input name="imp_p[]" id="imp_p[`+count+`]" type="hidden" value="`+value.imp_p+`">
                                `;
                                if (submod=="CRUD_INV_FAC"){
                                  tr_det+=`
                                  <input name="cnte[]" id="cnte[`+count+`]" type="hidden" value="0">
                                  <input name="cnte_det[]" id="cnte_det[`+count+`]" type="hidden" value="0">
                                  `;
                                }
                                tr_det+=value.codigo2+`
                            </td>
                            <td>`+value.articulo+`</td>
                            <td>`;
                                if (submod=="CRUD_INV_FAC"){
                                    tr_det+=value.cant_rest;
                                    tr_det+=`<input name="cant[]" id="cant[`+count+`]" type="hidden" value="`+value.cant_rest+`">`;
                                }else{
                                    tr_det+=`<input name="cant[]" id="cant[`+count+`]" type="text" style="width: 80px;" class="form-control cant numeric ctrl" value="`+value.cant_rest+`">`;
                                }
                                tr_det+=`
                            </td>
                            <td class="number_cal">`+value.costou+`</td>
                            <td>`+value.imp_p+`</td>
                            <td>`+value.costot+`</td>
                            <td>`;
                                if (submod=="CRUD_INV_FAC"){
                                    tr_det+=`ODC_`+cab.codigo;
                                }else{
                                    tr_det+=`<button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button>`;
                                }
                            tr_det+=`</td></tr>`;
                            jQuery("#"+tbl_det+" tbody").append(tr_det);
                        });
                        jQuery("#"+tbl_cab+" tbody").append(tr_cab);
                        if (submod=="CRUD_INV_FAC"){
                            tbl_nte="table_nte";
                            if(mov!=null && mov.length > 0){
                                let non_det = new Array();
                                jQuery('#table_nte tbody tr td input[id^="cnota"]').each(function(row, tr){
                                  non_det.push(jQuery(this).val());
                                });
                                if(jQuery.inArray(mov[0].codigo_cabecera,non_det)==-1){
                                    var count = (jQuery("#"+tbl_nte+" tbody tr").length)+1;
                                    tr_nte=`<tr>
                                    <td><input name="cnota[]" id="cnota[`+count+`]" type="hidden" value="`+mov[0].codigo_cabecera+`">`+mov[0].codigo_movimiento+`</td>
                                    <td>`+cab.data+`</td>
                                    <td>`+mov[0].fecha_mov+`</td>
                                    <td>`+mov[0].articulos+`</td>
                                    <td class="number_cal">`+mov[0].costot+`</td>
                                    <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
                                    </tr>`;
                                    jQuery("#"+tbl_nte+" tbody").append(tr_nte);
                                    jQuery.each(mov, function(key,value){
                                        var count = (jQuery("#"+tbl_det+" tbody tr").length)+1;
                                        tr_det=`<tr>
                                        <td>
                                            <input name="codc[]" id="codc[`+count+`]" type="hidden" value="0">
                                            <input name="codc_det[]" id="codc_det[`+count+`]" type="hidden" value="0">
                                            <input name="carticulo[]" id="carticulo[`+count+`]" type="hidden" value="`+value.codigo_articulo+`">
                                            <input name="cmov_det[]" id="cmov_det[`+count+`]" type="hidden" value="0">
                                            <input name="cnte[]" id="cnte[`+count+`]" type="hidden" value="`+value.codigo_cabecera+`">
                                            <input name="cnte_det[]" id="cnte_det[`+count+`]" type="hidden" value="`+value.codigo+`">
                                            <input name="costo[]" id="costo[`+count+`]" type="hidden" value="`+value.costou+`">
                                            <input name="imp_p[]" id="imp_p[`+count+`]" type="hidden" value="`+value.imp_p+`">
                                            `+value.codigo2+`
                                        </td>
                                        <td>`+value.articulo+`</td>
                                        <td>
                                            `+value.cant+`
                                            <input name="cant[]" id="cant[`+count+`]" type="hidden" value="`+value.cant+`">
                                        </td>
                                        <td class="number_cal">`+value.costou+`</td>
                                        <td>`+value.imp_p+`</td>
                                        <td>`+value.costot+`</td>
                                        <td>NTE_`+mov[0].codigo_movimiento+`</td>
                                        </tr>`;
                                        jQuery("#"+tbl_det+" tbody").append(tr_det);
                                    });
                                }
                            }
                        }
                        if(submod=="CRUD_INV_FAC"){
                            cal_fac();
                        }else{
                            cal_nte();
                        }
                        jQuery(".number_cal").formatCurrency();
                        jQuery(".preloader").fadeOut();
                    }else{
                        jQuery(".preloader").fadeOut();
                        dialog(data.content,data.title);
                    }
                },
                error: function(x,err){
                    jQuery(".preloader").fadeOut();
                    Modal_error(x,err);
                }
            });
        }else if(acc=="add_nte"){
            jQuery(".preloader").fadeIn();
            jQuery.ajax({
                type: "POST",
                url: "./modules/controllers/ajax.php",
                data : 'accion='+acc+'&code='+table.find('.transsa').val()+'&mod='+submod,
                dataType:'json',
                success: function(data){
                    if(data.title=="SUCCESS"){
                        cab = data.cab, det = data.det;
                        if(submod!="FRM_INV_DNT"){
                            tbl_nte="table_nte";
                            var count = (jQuery("#"+tbl_nte+" tbody tr").length)+1;
                            tr_nte=`<tr>
                            <td><input name="cnota[]" id="cnota[`+count+`]" type="hidden" value="`+cab.codigo+`">`+cab.codigo_transaccion+`</td>
                            <td>`+cab.data+`</td>
                            <td>`+cab.fecha_mov+`</td>
                            <td>`+cab.articulos+`</td>
                            <td>`+cab.monto_total+`</td>
                            <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>`;
                            jQuery("#"+tbl_nte+" tbody").append(tr_nte);
                        }else{
                            jQuery("#ctransaccion").val(cab.codigo);
                            jQuery("#transaccion").val(cab.codigo_transaccion);
                            jQuery("#proveedor").val(jQuery.formatRut(cab.code)+" "+cab.data);
                            jQuery("#calmacen").val(cab.almacen);
                            jQuery("#doc").val(cab.documento);
                            jQuery("#f_doc").val(cab.fecha_doc)
                        }
                        tbl_det="table_art";
                        if(submod=="FRM_INV_DNT"){
                            jQuery("#"+tbl_det+" tbody").empty();
                        }
                        jQuery.each(det, function(key,value){
                            var count = (jQuery("#"+tbl_det+" tbody tr").length)+1;
                            tr_det=`<tr>
                            <td>
                                <input name="codc[]" id="codc[`+count+`]" type="hidden" value="0">
                                <input name="codc_det[]" id="codc_det[`+count+`]" type="hidden" value="0">
                                <input name="carticulo[]" id="carticulo[`+count+`]" type="hidden" value="`+value.codigo_articulo+`">
                                <input name="cmov_det[]" id="cmov_det[`+count+`]" type="hidden" value="0">
                                <input name="cnte[]" id="cnte[`+count+`]" type="hidden" value="`+value.codigo_cabecera+`">
                                <input name="cnte_det[]" id="cnte_det[`+count+`]" type="hidden" value="`+value.codigo+`">
                                <input name="cant[]" id="cant[`+count+`]" type="hidden" value="`+value.cant+`">
                                <input name="costo[]" id="costo[`+count+`]" type="hidden" value="`+value.costou+`">
                                <input name="imp_p[]" id="imp_p[`+count+`]" type="hidden" value="`+value.imp_p+`">
                                `+value.codigo2+`
                            </td>
                            <td>`+value.articulo+`</td>
                            <td>`+value.cant+`</td>
                            <td class="number_cal">`+value.costou+`</td>
                            <td>`+value.imp_p+`</td>
                            <td class="number_cal">`+value.costot+`</td>`;
                            if(submod!="FRM_INV_DNT"){
                                tr_det+=`<td>NTE_`+value.codigo_movimiento+`</td>`;
                            }
                            tr_det+=`</tr>`;
                            jQuery("#"+tbl_det+" tbody").append(tr_det);
                        });
                        jQuery(".number_cal").formatCurrency();
                        if(submod!="FRM_INV_DNT"){
                            cal_fac();
                        }else{
                            cal_dnt();
                        }
                        jQuery(".preloader").fadeOut();
                    }else{
                        jQuery(".preloader").fadeOut();
                        dialog(data.content,data.title);
                    }
                },
                error: function(x,err){
                    jQuery(".preloader").fadeOut();
                    Modal_error(x,err);
                }
            });
        }else if(acc=="add_fac"){
            jQuery(".preloader").fadeIn();
            jQuery.ajax({
                type: "POST",
                url: "./modules/controllers/ajax.php",
                data : 'accion='+acc+'&code='+table.find('.transsa').val()+'&mod='+submod,
                dataType:'json',
                success: function(data){
                    if(data.title=="SUCCESS"){
                        cab = data.cab, det = data.det;
                        jQuery("#ctransaccion").val(cab.codigo);
                        jQuery("#transaccion").val(cab.codigo_transaccion);
                        jQuery("#proveedor").val(jQuery.formatRut(cab.code)+" "+cab.data);
                        jQuery("#calmacen").val(cab.almacen);
                        jQuery("#doc").val(cab.documento);
                        jQuery("#f_doc").val(cab.fecha_doc);
                        
                        tbl_det="table_art";
                        jQuery("#"+tbl_det+" tbody").empty();
                        
                        jQuery.each(det, function(key,value){
                            var count = (jQuery("#"+tbl_det+" tbody tr").length)+1;
                            tr_det=`<tr>
                            <td>
                                <input name="codc[]" id="codc[`+count+`]" type="hidden" value="0">
                                <input name="codc_det[]" id="codc_det[`+count+`]" type="hidden" value="0">
                                <input name="carticulo[]" id="carticulo[`+count+`]" type="hidden" value="`+value.codigo_articulo+`">
                                <input name="cmov_det[]" id="cmov_det[`+count+`]" type="hidden" value="0">
                                <input name="cnte[]" id="cnte[`+count+`]" type="hidden" value="`+value.codigo_cabecera+`">
                                <input name="cnte_det[]" id="cnte_det[`+count+`]" type="hidden" value="`+value.codigo+`">
                                <input name="cant[]" id="cant[`+count+`]" type="hidden" value="`+value.cant+`">
                                <input name="costo[]" id="costo[`+count+`]" type="hidden" value="`+value.costou+`">
                                <input name="imp_p[]" id="imp_p[`+count+`]" type="hidden" value="`+value.imp_p+`">
                                `+value.codigo2+`
                            </td>
                            <td>`+value.articulo+`</td>
                            <td>`+value.cant+`</td>
                            <td class="number_cal">`+value.costou+`</td>
                            <td>`+value.imp_p+`</td>
                            <td class="number_cal">`+value.costot+`</td>`;
                            tr_det+=`</tr>`;
                            jQuery("#"+tbl_det+" tbody").append(tr_det);
                        });
                        jQuery(".number_cal").formatCurrency();
                        cal_dco();
                        jQuery(".preloader").fadeOut();
                    }else{
                        jQuery(".preloader").fadeOut();
                        dialog(data.content,data.title);
                    }
                },
                error: function(x,err){
                    jQuery(".preloader").fadeOut();
                    Modal_error(x,err);
                }
            });
        }else if(acc=="search_requisicion"){
            jQuery(".preloader").fadeIn();
            jQuery("#requisicion").val(code);
            jQuery("#almacen1").val(table.find("._almdes").text());
            jQuery("#almacen2").val(table.find("._almori").text());
            jQuery.ajax({
                type: "POST",
                url: "./modules/controllers/ajax.php",
                data : 'accion='+acc+'&code='+code+'&mod='+submod,
                dataType:'json',
                success: function(data){
                    if(data.title=="SUCCESS"){
                        jQuery("#calmacen1").val(data.cab.cod_almacendes);
                        jQuery("#calmacen2").val(data.cab.cod_almacenori);
                        jQuery.each(data.det, function(key,value){
                            tbl_det="table_art";
                            var count = (jQuery("#"+tbl_det+" tbody tr").length)+1;
                            tr_det=`<tr>
                            <td>
                                <input name="codc[]" id="codc[`+count+`]" type="hidden" value="0">
                                <input name="codc_det[]" id="codc_det[`+count+`]" type="hidden" value="0">
                                <input name="carticulo[]" id="carticulo[`+count+`]" type="hidden" value="`+value.cod_articulo+`">
                                <input name="cmov_det[]" id="cmov_det[`+count+`]" type="hidden" value="0">
                                <input name="cnte[]" id="cnte[`+count+`]" type="hidden" value="0">
                                <input name="cnte_det[]" id="cnte_det[`+count+`]" type="hidden" value="0">
                                `+value.cod_articulo+`
                            </td>
                            <td>`+value.codigo2+`</td>
                            <td>`+value.articulo+`</td>
                            <td>
                                <input name="cant[]" id="cant[`+count+`]" type="text" data-max="`+value.cant+`" style="width: 80px;" class="form-control cant numeric ctrl" value="`+value.cant+`">
                            </td>
                            <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>`;
                            jQuery("#"+tbl_det+" tbody").append(tr_det);
                        });
                        jQuery(".preloader").fadeOut();
                    }else{
                        jQuery(".preloader").fadeOut();
                        dialog(data.content,data.title);
                    }
                },
                error: function(x,err){
                    jQuery(".preloader").fadeOut();
                    Modal_error(x,err);
                }
            });
        }else if(acc=="add_art"){
            if(submod!="KARDEX"){
                tbl_det="table_art";
                var count = (jQuery("#"+tbl_det+" tbody tr").length)+1;
                tr_det=`<tr>
                <td>
                    <input name="carticulo[]" id="carticulo[`+count+`]" type="hidden" value="`+code+`">
                    <input name="cmov_det[]" id="cmov_det[`+count+`]" type="hidden" value="0">`+table.find('._id2').text()+`
                </td>
                <td>`+nombre+`</td>
                <td><input name="cant[]" id="cant[`+count+`]" type="text" style="width: 100px;" class="form-control numeric ctrl" value="1"></td>            
                <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
                </tr>`;
                jQuery("#"+tbl_det+" tbody").append(tr_det);
                jQuery("#"+tbl_det+" tbody tr:last td:nth-child(3) input").focus();
            }else{
                jQuery("#articulo").val(nombre);
                jQuery("#farticulo").val(code).trigger('change');
            }
        }else if(acc=="search_ods_plan"){
            jQuery("#nombre").val(nombre);
            jQuery("#ods_name").val(code);
            jQuery("#rut").val(table.find('._code').text());
            jQuery("#fllegada").val(table.find('._fini').val());
            jQuery("#fsalida").val(table.find('._ffin').val());
            jQuery("#hr_total").val(table.find('._hr_to').val());
            jQuery("#hr_ocupa").val(table.find('._hr_ocu').val());
            jQuery("#hr_restant").val(table.find('._hr_rest').val());
            jQuery("#cliente").val(table.find('._cliente').val());
            jQuery("#lugar").val(table.find('._lugar').val());
            jQuery("#vehiculo").val(table.find('._vehiculo').val());
            jQuery("#ods").val(table.find('._ods').val());
            jQuery("#trabs").val(table.find('._trabs').val());
            jQuery("#trab1").val("");
            jQuery("#ctrabajador1").val("");
            jQuery("#trab2").val("");
            jQuery("#ctrabajador2").val("");
            if(table.find('._trabs').val()>1){
                jQuery("#tr2").show();
            }else{
                jQuery("#tr2").hide();
            }
        }else if(acc=="search_trab1"){
            jQuery("#trab1").val(nombre);
            jQuery("#ctrab1").val(code);
        }else if(acc=="search_trab2"){
            jQuery("#trab2").val(nombre);
            jQuery("#ctrab2").val(code);
        }else if(acc=="search_trab3"){
            jQuery("#nombre").val(nombre);
            jQuery("#cdata").val(code);
            jQuery("#persona").val(table.find('._code').text());
        }else if(acc=="search_ods"){
            jQuery(".preloader").fadeIn();
            if(submod!="CRUD_INV_REQ"){
                jQuery("#ods").val(table.find('._ods_pad').val());
                jQuery("#cods").val(table.find('._ods').val());
                jQuery("#cliente").val(nombre);
            }else{
                var count = (jQuery("#table_det_ods tbody tr").length)+1;
                tr_det=`<tr>
                    <td><input name="cods[]" id="cods[`+count+`]" type="hidden" value="`+table.find('._ods').val()+`">`+table.find('._ods_pad').val()+`</td>
                    <td>`+table.find('._code').text()+`</td>
                    <td>`+nombre+`</td>
                    <td>`+table.find('._fecha').text()+`</td>
                    <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
                </tr>`;
                jQuery("#table_det_ods tbody").append(tr_det);
            }
            tbl_det = (submod=="CRUD_INV_RES") ? "table_art" : "table_det_odc" ;
            tbl_det = (submod=="CRUD_INV_ODS") ? "table_art" : tbl_det ;
            tbl_det = (submod=="CRUD_INV_REQ") ? "table_det_odc" : tbl_det ;
            if(submod!="CRUD_INV_REQ"){
                jQuery("#"+tbl_det+" tbody").empty();
            }
            jQuery.ajax({
                type: "POST",
                url: "./modules/controllers/ajax.php",
                data : 'accion=get_ods_art&code='+table.find('._ods').val()+'&alm='+jQuery("#calmacen").val()+'&mod='+submod,
                dataType:'json',
                success: function(data){
                    if(data.title=="SUCCESS"){
                        jQuery.each(data.content, function(key,value){
                            var count = (jQuery("#"+tbl_det+" tbody tr").length)+1;
                            row_det = (submod=="CRUD_INV_ODS") ? `<input name="cot_det[]" id="cot_det[`+count+`]" type="hidden" value="`+value.codigo_cot+`">` : `` ;
                            row_precio = (submod=="CRUD_INV_ODS") ? `<input name="precio[]" id="precio[`+count+`]" type="hidden" value="`+value.precio+`">` : `` ;
                            row_ods = (submod=="CRUD_INV_REQ") ? `<input name="cods[]" id="cods[`+count+`]" type="hidden" value="`+table.find('._ods').val()+`">` : `` ;
                            row_odc_det = (submod=="CRUD_ODC_ODS") ? `<input name="corden_det[]" id="corden_det[`+count+`]" type="hidden" class="hidden" value="0">` : `` ;
                            tr_det=`<tr>
                            <td>
                                <input name="carticulo[]" id="carticulo[`+count+`]" type="hidden" value="`+value.codigo+`">
                                `+row_det+row_precio+row_ods+row_odc_det+`
                                `+value.codigo+`
                            </td>
                            <td>`+value.codigo2+`</td>
                            <td>`+value.articulo+`</td>`;
                            if(submod=="CRUD_INV_RES" || submod=="CRUD_INV_ODS"){
                                tr_det+=`
                                <td>`+(value.cant_ods-value.cant_ent)+`</td>
                                <td>`+(value.cant_inv-value.cant_res)+`</td>
                                <td>`+(value.cant_res)+`</td>
                                <td><input type="text" id="cant[`+count+`]" name="cant[]" class="form-control numeric" maxlength="10" style="width:100px" value=""></td>
                                <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
                                </tr>`;
                            }else{
                                if(submod=="CRUD_INV_REQ"){
                                    tr_det+=`<td><input type="text" id="cant[`+count+`]" name="cant[]" class="form-control numeric" maxlength="10" style="width:100px" value="`+(value.cant_ods-value.cant_ent)+`"></td>
                                    <td>`+value.clasificacion+`</td>
                                    <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>                                    
                                    </tr>`;
                                }else{
                                    tr_det+=`<td>`+(value.cant_inv-value.cant_res_alm)+`</td>
                                    <td>`+(value.cant_ods-value.cant_ent-value.cant_res)+`</td>
                                    <td><input type="text" id="cant[`+count+`]" name="cant[]" class="form-control numeric" maxlength="10" style="width:100px" value=""></td>
                                    <td><input type="text" id="precio[`+count+`]" name="precio[]" class="form-control numeric" maxlength="12" style="width:100px" value=""></td>
                                    <td><input type="text" id="imp[`+count+`]" name="imp[]" class="form-control numeric" maxlength="12" style="width:100px" value="`+data.imp+`" readonly></td>
                                    <td><input type="text" id="total[`+count+`]" name="total[]" class="form-control" style="width:100px" value="0" disabled></td>`;
                                    btn=`<td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>`;
                                    if(submod=="CRUD_ODC_ODS"){
                                        let cots = "";
                                        if(typeof value.ods_arts !== 'undefined'){
                                            jQuery.each(value.ods_arts, function(i,v){
                                                cots += "ODC # "+v.origen+" (<strong>"+v.status+"</strong>) - CANT: "+v.cant+"<br>";
                                            });
                                            btn=`<td>
                                                <button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button>
                                                <span class="badge badge-pill count badge-info" data-conten="`+cots+`"><i class="fas fa-star"></i></span>
                                            </td>`;
                                        }                                        
                                    }
                                    tr_det+=btn;
                                    tr_det+=`</tr>`;
                                }
                            }
                            jQuery("#"+tbl_det+" tbody").append(tr_det);
                            if(submod=="CRUD_ODC_ODS"){
                                if(typeof value.ods_arts !== 'undefined'){
                                    jQuery("#"+tbl_det+" tbody tr").last().addClass("table-warning");
                                }
                            }
                        });
                        if(submod=="CRUD_ODC_ODS"){
                            jQuery(".count").each(function(){
                                jQuery(this).popover({
                                  title: '<div style="font-size: 12px;"><strong>PROCESADO POR:</strong></div>',
                                  content: '<div style="font-size: 12px;">'+jQuery(this).attr("data-conten")+'</div>',
                                  trigger: 'hover',
                                  placement: 'left',
                                  container: 'body',
                                  html: true
                                });
                            });
                        }
                        jQuery(".preloader").fadeOut();
                    }else{
                        jQuery(".preloader").fadeOut();
                        dialog(data.content,data.title);
                    }
                },
                error: function(x,err){
                    //jQuery(".preloader").fadeOut();
                    Modal_error(x,err);
                }
            });
        }else if (acc=="search_ods_gar"){
            jQuery(".preloader").fadeIn();
            jQuery("#cods_gar").val(table.find('._ods').val());
            jQuery("#ods_gar").val("COT: "+table.find('td:eq(0)').text()+" ODS: "+table.find('td:eq(1)').text());
            jQuery.ajax({
                type: "POST",
                url: "./modules/controllers/ajax.php",
                data : 'accion='+acc+'&code='+table.find('._ods').val()+'&mod='+submod,
                dataType:'json',
                success: function(data){
                    if(data.title=="SUCCESS"){
                        jQuery.each(data.det, function(key,value){
                            var count = (jQuery("#table_det_cot tbody tr").length-1)+1;
                            tr=`<tr class="datas">
                            <td>`+count+`<input name="c_det[]" id="c_det[]" type="hidden" value="0"></td>
                            <td><input name="cparte[]" id="cparte[`+count+`]" type="hidden" value="`+value.cparte+`">`+value.parte+`</td>
                            <td><input name="cpieza[]" id="cpieza[`+count+`]" type="hidden" value="`+value.cpieza+`">`+value.pieza+`</td>
                            <td><input name="cservi[]" id="cservi[`+count+`]" type="hidden" value="`+value.cservicio+`">`+value.articulo+`</td>
                            <td><input name="hhtaller[]" id="hhtaller[`+count+`]" type="text" class="form-control numeric ctrl sum_hh_ta" style="width: 70px" maxlength="5"></td>
                            <td><input name="hhterreno[]" id="hhterreno[`+count+`]" type="text" class="form-control numeric ctrl sum_hh_te" style="width: 70px" maxlength="5"></td>
                            <td><input name="dtaller[]" id="dtaller[`+count+`]" type="text" class="form-control numeric ctrl sum_dtaller" style="width: 50px" maxlength="2"></td>
                            <td><input name="inicio[]" id="inicio[`+count+`]" type="text" class="form-control dates ctrl" maxlength="10" style="width:110px;" autocomplete="off"></td>
                            <td><input name="fin[]" id="fin[`+count+`]" type="text" class="form-control dates ctrl" maxlength="10" style="width:110px;" autocomplete="off"></td>
                            <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>`;
                            jQuery("#table_det_cot tbody tr:last").before(tr);
                        });
                        SetCalendar();
                        jQuery(".preloader").fadeOut();
                    }else{
                        jQuery(".preloader").fadeOut();
                        dialog(data.content,data.title);
                    }
                },
                error: function(x,err){
                    jQuery(".preloader").fadeOut();
                    Modal_error(x,err);
                }
            });
        }else if(acc=="search_dnt"){
            jQuery(".preloader").fadeIn();
            jQuery.ajax({
                type: "POST",
                url: "./modules/controllers/ajax.php",
                data : 'accion='+acc+'&code='+table.find('.transsa').val()+'&mod='+submod,
                dataType:'json',
                success: function(data){
                    if(data.title=="SUCCESS"){
                        cab = data.cab, det = data.det;
                        jQuery("#ctransaccion").val(cab.codigo_devolucion_trans);
                        jQuery("#transaccion").val(cab.codigo_devolucion);
                        jQuery("#anulacion").val(cab.codigo_transaccion);
                        jQuery("#canulacion").val(cab.codigo);
                        jQuery("#proveedor").val(jQuery.formatRut(cab.code)+" "+cab.data);
                        jQuery("#calmacen").val(cab.almacen);
                        jQuery("#doc").val(cab.documento);
                        jQuery("#f_doc").val(cab.fecha_origen);
                        jQuery("#f_anul").val(cab.fecha_mov)
                        jQuery("#notas").val(cab.observacion);
                        jQuery("#transaccion_").text(cab.codigo_transaccion);
                        jQuery("#status_").text(cab.status_);
                        jQuery("#stats").val(cab.status);
                        jQuery("#status_bagde").removeClass("badge-warning");
                        jQuery("#status_bagde").removeClass("badge-success");
                        jQuery("#status_bagde").addClass(cab.color);
                        jQuery("#crea_u").text(cab.crea_user);
                        jQuery("#crea_d").text(cab.crea_date);
                        jQuery("mod_u").text(cab.mod_user);
                        jQuery("mod_d").text(cab.mod_date);

                        jQuery.each(det, function(key,value){
                            tbl_det="table_art";
                            var count = (jQuery("#"+tbl_det+" tbody tr").length)+1;
                            tr_det=`<tr>
                            <td>
                                <input name="codc[]" id="codc[`+count+`]" type="hidden" value="0">
                                <input name="codc_det[]" id="codc_det[`+count+`]" type="hidden" value="0">
                                <input name="carticulo[]" id="carticulo[`+count+`]" type="hidden" value="`+value.codigo_articulo+`">
                                <input name="cmov_det[]" id="cmov_det[`+count+`]" type="hidden" value="0">
                                <input name="cnte[]" id="cnte[`+count+`]" type="hidden" value="`+value.codigo_cabecera+`">
                                <input name="cnte_det[]" id="cnte_det[`+count+`]" type="hidden" value="`+value.codigo+`">
                                <input name="cant[]" id="cant[`+count+`]" type="hidden" value="`+value.cant+`">
                                <input name="costo[]" id="costo[`+count+`]" type="hidden" value="`+value.costou+`">
                                <input name="imp_p[]" id="imp_p[`+count+`]" type="hidden" value="`+value.imp_p+`">
                                `+value.codigo2+`
                            </td>
                            <td>`+value.articulo+`</td>
                            <td>`+value.cant+`</td>
                            <td class="number_cal">`+value.costou+`</td>
                            <td>`+value.imp_p+`</td>
                            <td class="number_cal">`+value.costot+`</td>
                            </tr>`;
                            jQuery("#"+tbl_det+" tbody").append(tr_det);
                        });
                        jQuery(".number_cal").formatCurrency();
                        cal_dnt();
                        block_controls(true);
                        jQuery("#auds").show();
                        jQuery('a[href="#tab_1"]').trigger('click');
                        jQuery(".preloader").fadeOut();
                    }else{
                        jQuery(".preloader").fadeOut();
                        dialog(data.content,data.title);
                    }
                },
                error: function(x,err){
                    jQuery(".preloader").fadeOut();
                    Modal_error(x,err);
                }
            });
        }
    }
    jQuery(this).find(".modal-body .modal-body-content").empty();
});
/** Bloquea o Libera controles
* @param _acc: true para Bloquear, false para liberar
*/
function block_controls(_acc=false){
    jQuery('.ctrl').each(function(){
        var tipo = jQuery(this).prop("nodeName"), id=jQuery(this).prop("id");
        if(tipo=="INPUT" || tipo=="TEXTAREA"){
            if(jQuery(this).attr("type")=="radio"){
                if(jQuery(this).is(':not(:checked)')){
                    jQuery(this).prop('disabled',_acc);
                }
            }else if (jQuery(this).attr("type")=="checkbox"){
                jQuery(this).off('click');
            }else{
                jQuery(this).prop('readonly', _acc);
            }
        }else if(tipo=="BUTTON"){
            jQuery(this).attr("disabled",_acc);
        }else if(tipo=="SELECT"){
            //jQuery('#'+id+' option:not(:selected)').prop('disabled',_acc);
            //jQuery(this).find('option').not(':selected').remove();
            jQuery('#'+id).find('option').not(':selected').remove();
        }else{
            if(_acc){
                jQuery(this).addClass("disabled");
            }else{
                jQuery(this).removeClass("disabled");
            }
        }
    });
}
/** Llena una lista de valores traidos de Ajax
* @param _obj: Lista a llenar
* @param _data: parametros a enviar
* @param _defined: Valores definidos
*/
function fill_list(_obj,_data,_defined){
    jQuery.ajax({
        url: "./modules/controllers/ajax.php",
        type: "POST",
        data: _data,
        dataType:'json',
        success: function(data){
            jQuery("#"+_obj).empty();
            jQuery("#"+_obj).append("<option value='-1'>SELECCIONE...</option>");
            if(data.title=="SUCCESS"){
                jQuery.each(data.content, function(key,value){
                    jQuery("#"+_obj).append("<option value='"+value.codigo+"'>"+value.nombre+"</option>");
                });
                jQuery("#"+_obj+" option[value="+_defined+"]").attr('selected','selected');
            }else{
                dialog(data.content,data.title);
            }
        },
        error: function(x,err){
            Modal_error(x,err);
        }
    });
}
/** Verifica si el RUT / PASS son reales y si existen en la BD
* @param _val: Valor a Buscar
* @param _type: Tipo de Informacion
* @param _mod: Modulo que invoca la data
*/
function validate_data(_val,_mod){
    let valido=true, accion="", var_="";
    if(_mod=="crud_clientes"){ var_="cliente" }else if(_mod=="crud_proveedores"){ var_="proveedor" }
    if(_val!=""){
        if(jQuery('#accion').val()=="save_new"){
            if(valido){
                jQuery(".preloader").fadeIn();
                jQuery.ajax({
                    url: "./modules/controllers/ajax.php",
                    type: "POST",
                    data: "accion=rut_"+var_+"&rut="+_val+'&mod='+_mod,
                    dataType:'json',
                })
                .done(function(data){
                    jQuery('#nac').empty();
                    jQuery('#sex').empty();
                    jQuery('#estado').empty();
                    jQuery('#nombre').val('');
                    jQuery('#nombre2').val('');
                    jQuery('#fecha').val('');
                    jQuery('#email').val('');
                    jQuery('#pais').empty();
                    jQuery('#region').empty();
                    jQuery('#provincia').empty();
                    jQuery('#comuna').empty();
                    jQuery('#direccion').val('');
                    jQuery('#tel1').val('');
                    jQuery('#tel2').val('');
                    if(data.title=="SUCCESS"){
                        let datos=data.content, valor="";
                        jQuery('#rut').val(datos.code);
                        if(datos.nac=="N"){valor="NACIONAL"}else{valor="EXTRANJERO"}
                        jQuery('#nac').append("<option value='"+datos.nac+"'>"+valor+"</option>");
                        if(datos.sexo=="M"){valor="MASCULINO"}else{valor="FEMENINO"}
                        jQuery('#sex').append("<option value='"+datos.sexo+"'>"+valor+"</option>");
                        if(datos.estado=="S"){valor="SOLTERO(A)"}else if(datos.estado=="C"){valor="CASADO(A)"} else{valor="VIUDO(A)"}
                        jQuery('#estado').append("<option value='"+datos.estado+"'>"+valor+"</option>");
                        jQuery('#nombre').val(datos.data);
                        jQuery('#nombre2').val(datos.data2);
                        jQuery('#fecha').val(datos.fecha);
                        jQuery('#email').val(datos.mail);
                        jQuery('#pais').append("<option value='"+datos.cpais+"'>"+datos.pais+"</option>");
                        jQuery('#region').append("<option value='"+datos.cregion+"'>"+datos.region+"</option>");
                        jQuery('#provincia').append("<option value='"+datos.cprovincia+"'>"+datos.provincia+"</option>");
                        jQuery('#comuna').append("<option value='"+datos.ccomuna+"'>"+datos.comuna+"</option>");
                        jQuery('#direccion').val(datos.direccion);
                        jQuery('#tel1').val(datos.tel_fijo);
                        jQuery('#tel2').val(datos.tel_movil);
                        block_controls(true);
                    }else{
                        block_controls(false);
                        jQuery('#nac').append("<option value='N'>NACIONAL</option>");
                        jQuery('#nac').append("<option value='E'>EXTRANJERO</option>");
                        jQuery('#sex').append("<option value='M'>MASCULINO</option>");
                        jQuery('#sex').append("<option value='F'>FEMENINO</option>");
                        jQuery('#estado').append("<option value='S'>SOLTERO(A)</option>");
                        jQuery('#estado').append("<option value='C'>CASADO(A)</option>");
                        jQuery('#estado').append("<option value='V'>VIUDO(A)</option>");
                        fill_list("pais","accion=list_pais&mod="+_mod,"0000000001");
                        fill_list("region","accion=list_region&pais=1&mod="+_mod,"0000000013");
                        fill_list("provincia","accion=list_provincias&region=13&mod="+_mod);
                        jQuery('#comuna').append("<option value='-1'>SELECCIONE...</option>");
                        if(data.title!="BLANCO"){
                          dialog(data.content,data.title);
                        }
                    }
                    jQuery(".preloader").fadeOut();
                })
                .fail(function(x,err,msj){
                    jQuery(".preloader").fadeOut();
                    Modal_error(x,err,msj);
                })
            }
        }
    }    
}
/**Analiza el Boton DEL para borrar un registro
*/
jQuery(document).on("click", '.bt_del', function (e){
    var table = jQuery(this).closest("table").prop("id");
    jQuery(this).closest('tr').remove();
    if(submod=="CRUD_ODC" || submod=="CRUD_COT_SERV"){
        cal_odc();
    }else if(ref=="FORM_COT_ALL"){
        jQuery("#add_eqs").fadeIn();
    }else if(mod=="COTIZACIONES"){
        let code = jQuery(this).closest('tr').find("input").val();
        jQuery('#table_ser_ter tbody tr').each(function(index){
            if(jQuery(this).find('td:eq(0)').find("input:eq(0)").val()==code){
                jQuery(this).remove();
            }
        });
        calculos();
    }else if(ref=="FORM_INV_NTE" || ref=="FORM_INV_FAC"){
        let code = jQuery(this).closest('tr').find("input").val();
        if(table=="table_odc"){
            row = 0;
        }else if(table=="table_nte"){
            row = 4;
        }
        jQuery('#table_art tbody tr').each(function(index){
            if(jQuery(this).find('td:eq(0)').find("input:eq("+row+")").val()==code){
                jQuery(this).remove();
            }
        });
        if(ref=="FORM_INV_NTE"){ cal_nte(); } else if(ref=="FORM_INV_FAC"){ cal_fac(); }
    }else if(submod=="CRUD_INV_REQ"){
        let code = jQuery(this).closest('tr').find("input").val();
        jQuery('#table_det_odc tbody tr').each(function(index){
            if(jQuery(this).find('td:eq(0)').find("input:eq(1)").val()==code){
                jQuery(this).remove();
            }
        });
    }
});
/** Redondeo de numeros usado por la LEY de CHILE:
 * si el numero termina entre 1 - 5 se redondea a la decima anterior
 * si el numero termina entre 6 - 9 se redondea a la decima superior
 * los Decimales se eliminan por lo anterior
 * @param numero: el Numero a redondear
 */
function redondeo(numero){
    let new_number = 0;
    if(numero>=0.5){
        new_number = Math.round(numero);
        new_number = Math.round((new_number-1) / 10) * 10
    }
    return new_number;
    
}
/** Calculos de Cotizaciones usado para calcular los montos de la Cotizacion
 */
function calculos(){
    var sum_hh_te=sum_hh_ta=hh_terreno=hh_taller=valor_dia=sum_dias=sum_ins=sum_rep=sum_stt=0;
    var misc=valor_mo=valor_gf_mo=valor_mg_gasto=valor_serv=valor_gf_ins=valor_gf_rep=valor_gf_stt=valor_subtotal=valor_ins=valor_rep=valor_stt=0;
    var desc = 0, desc_t = jQuery("#desc").val(), vRegExp = /^\d+(\.\d+)?$/;

    if(jQuery('input[name="inicio[]"]').val()!=""){
        minDate = jQuery('input[name="inicio[]"]').minDate();
    }
    if(jQuery('input[name="fin[]"]').val()!=""){
        maxDate = jQuery('input[name="fin[]"]').maxDate();
    }
    jQuery("#table_det_cot tbody tr:last-child td:eq(4)").text(minDate);
    jQuery("#table_det_cot tbody tr:last-child td:eq(5)").text(maxDate);

    jQuery('.sum_hh_ta, .sum_hh_te, .sum_dtaller').each(function(){
        if (!isNaN(this.value) && this.value.length != 0) {
            if(jQuery(this).hasClass("sum_hh_ta")){
                sum_hh_ta+=parseFloat(this.value);
            }else if(jQuery(this).hasClass("sum_hh_te")){
                sum_hh_te+=parseFloat(this.value);
            }else if(jQuery(this).hasClass("sum_dtaller")){
                sum_dias+=parseFloat(this.value);
            }
        }
    });

    jQuery("#table_det_cot tbody tr:last-child td:eq(1)").text(sum_hh_ta);
    jQuery("#table_det_cot tbody tr:last-child td:eq(2)").text(sum_hh_te);
    jQuery("#table_det_cot tbody tr:last-child td:eq(3)").text(sum_dias);
    
    if(jQuery.inArray(jQuery("#stats").val(),array_status_calc_odc)!=-1){
        hh_terreno=parseFloat(sum_hh_te*jQuery("#hh_terreno").val());
        hh_taller=parseFloat(sum_hh_ta*jQuery("#hh_taller").val());
        valor_dia=parseFloat(sum_dias*jQuery("#valor_dia").val());

        jQuery('.add_ins, .add_rep, .add_ser').each(function(){
            let cant = jQuery(this).closest("tr").find("td:eq(3) input").val(), valor = jQuery(this).closest("tr").find("td:eq(4) input").val();
            if (!isNaN(valor) && valor.length != 0) {
                if(jQuery(this).hasClass("add_ins")){
                    sum_ins+=(parseFloat(valor*cant));
                }else if(jQuery(this).hasClass("add_rep")){
                    sum_rep+=(parseFloat(valor*cant));
                }else if(jQuery(this).hasClass("add_ser")){
                    sum_stt+=(parseFloat(valor*cant));
                }
            }
        });
        
        if(jQuery("#cotizat").val()*1!=5){
            tras            =   parseFloat(((jQuery("#dist").val()*jQuery("#costo_km").val())*2)+jQuery("#sal").val()*jQuery("#viajes").val());
            misc            =   parseFloat((((sum_hh_te+sum_hh_ta)/8.5)*jQuery("#trabs").val())*(jQuery("#valor_misc").val()/2));
            valor_mo        =   parseFloat(hh_terreno+hh_taller+valor_dia+tras+misc);
            valor_mg_gasto  =   parseFloat((valor_mo*jQuery("#pag_gasto").val())/100);
            valor_gf_mo     =   valor_mg_gasto+((valor_mg_gasto*jQuery("#pag_marg").val())/100);
            //valor_gf_mo     =   parseFloat(((valor_mo*jQuery("#pag_gasto").val())/100)+((((valor_mo*jQuery("#pag_gasto").val())/100)*jQuery("#pag_marg").val())/100));
            valor_serv      =   parseFloat(valor_gf_mo+hh_terreno+hh_taller+valor_dia);
            valor_ins       =   parseFloat(sum_ins);
            valor_rep       =   parseFloat(sum_rep);
            valor_stt       =   parseFloat(sum_stt);
            valor_subtotal  =   parseFloat(valor_serv+valor_rep+valor_ins+valor_stt+tras+misc);
            if(desc_t.match(vRegExp)){
                desc        =   parseFloat(((desc_t*valor_subtotal)/100)*-1);
            }

        }

        let valor_neto = parseFloat(valor_subtotal+desc); imp = parseFloat((valor_neto*jQuery("#imp").val())/100), valor_bruto = parseFloat(valor_neto+imp);  

        jQuery("#_serv").text(valor_serv);
        jQuery("#_rep").text(valor_rep);
        jQuery("#_ins").text(valor_ins);
        jQuery("#_stt").text(valor_stt);
        jQuery("#_tras").text(tras);
        jQuery("#_misc").text(misc);
        jQuery("#_subt").text(valor_subtotal);
        jQuery("#_desc").text(desc);
        jQuery("#_neto").text(redondeo(valor_neto));
        jQuery("#_imp").text(redondeo(imp));
        jQuery("#_bruto").text(redondeo(valor_bruto));
    }
    jQuery(".number_cal").formatCurrency();
}

function check_datas_cot(){
    let valido = false;
    if(jQuery('#table_det_cot .datas').length>0){
        jQuery('#table_det_cot .datas').each(function(){
            if(jQuery(this).find("td:eq(0) input").length>0){
                let date1 = jQuery(this).find(".dates:eq(0)").val(), date2 = jQuery(this).find(".dates:eq(1)").val(), vRegExp = /^([0-9]{2})(\-)([0-9]{2})(\-)([0-9]{4})$/;
                let comp = jQuery(this).find("td:eq(2) input").val(), serv = jQuery(this).find("td:eq(3) input").val(), hta = jQuery(this).find("td:eq(4) input").val();
                if(comp=="" || comp==0 || comp == null || comp == undefined){
                    valido = false;
                    jQuery(this).addClass("table-danger");
                    dialog("DEBE INDICAR UN COMPONENTE!","ERROR");
                }else{
                    if(serv=="" || serv==0 || serv == null || serv == undefined){
                        valido = false;
                        jQuery(this).addClass("table-danger");
                        dialog("DEBE INDICAR UN SERVICIO A APLICAR!","ERROR");                
                    }else{
                        if(hta=="" || hta == null || hta == undefined){
                            valido = false;
                            jQuery(this).addClass("table-danger");
                            dialog("DEBE INDICAR UNA CANTIDAD DE HORAS TALLER","ERROR");
                        }else{
                            if(date1.match(vRegExp)){
                                if(date2.match(vRegExp)){
                                    valido = true;
                                    jQuery(this).removeClass("table-danger");
                                }else{
                                    valido = false;
                                    jQuery(this).addClass("table-danger");
                                    dialog("LA FECHA DE FIN DEBE CONTENER UNA FECHA VALIDA!","ERROR");
                                }
                            }else{
                                valido = false;
                                jQuery(this).addClass("table-danger");
                                dialog("LA FECHA DE INICIO DEBE CONTENER UNA FECHA VALIDA!","ERROR");
                            }
                        }                
                    }
                }
            }
        });
    }else{
        dialog("DEBE SELECCIONAR AL MENOS UN <strong>COMPONENTE</strong>","ERROR");
    }
    return valido;
}
function check_datas_odc(){
    let valido = false;
    jQuery('#table_det_odc tbody tr').each(function(){
        let cant = jQuery(this).find('input[id^="cant"]').val(), precio = jQuery(this).find('input[id^="precio"]').val(), art = jQuery(this).find("td:eq(2)").text() ;
        if(cant<=0 || cant=="" || cant == null || cant == undefined){
            valido = false;
            jQuery(this).addClass("table-danger");
            dialog("DEBE INDICAR UNA CANTIDAD PARA EL ARTICULO <strong>"+art+"</strong>","ERROR");
            return false;
        }else{
            if(precio<=0 || precio=="" || precio == null || precio == undefined){
                valido = false;
                jQuery(this).addClass("table-danger");
                dialog("DEBE INDICAR UN PRECIO PARA EL ARTICULO <strong>"+art+"</strong>","ERROR");
                return false;
            }else{
                valido = true;
                jQuery(this).removeClass("table-danger");
            }
        }
    });
    return valido;
}
function cal_odc(){
    let cant = precio = bruto = impp = impm = total = all_sub = all_total = 0;
    if(jQuery('#table_det_odc tbody tr').length>0){
      jQuery('#table_det_odc tbody tr').each(function(index){
        cant = jQuery(this).find('input[id^="cant"]').val(), precio = jQuery(this).find('input[id^="precio"]').val(), impp = jQuery(this).find('input[id^="imp"]').val();      
        bruto = parseFloat(cant)*parseFloat(precio);
        impm = (bruto*impp)/100;
        total = bruto + impm;
        total = isNaN(total) ? 0 : total;
        all_sub = all_sub + total;
        jQuery(this).find('input[id^="total"]').val(total).formatCurrency();
      });
    }
    all_total = all_sub;
    jQuery('#table_totales tbody tr:eq(0) td:eq(0)').text(jQuery('#table_det_odc tbody tr').length);
    jQuery('#table_totales tbody tr:eq(0) td:eq(1)').text(all_sub).formatCurrency();
    jQuery('#table_totales tbody tr:eq(0) td:eq(2)').text(all_total).formatCurrency();
}
/** Crea una Ventana centrada en base a parametros
*/
function VentanaCentrada(theURL,winName,features, myWidth, myHeight, isCenter) {
  if(window.screen)if(isCenter)if(isCenter=="true"){
    var myLeft = (screen.width-myWidth)/2;
    var myTop = (screen.height-myHeight)/2;
    features+=(features!='')?',':'';
    features+=',left='+myLeft+',top='+myTop;
  }
  window.open(theURL,winName,features+((features!='')?',':'')+'width='+myWidth+',height='+myHeight);
}
/** Imprime un documento
*/
function imprimir(ruta,doc){
    VentanaCentrada(ruta,doc,'','1024','768','true');
}
/** Si un MODAL se cierra pero hay otro abierto vuelvo a aplicar la classe modal-open al BODY para permitir el Scrol en MODAL
*/
jQuery(document).on("hidden.bs.modal", function (e){
    if((jQuery("#modal_maq_cliente").data('bs.modal') || {})._isShown){
        jQuery('body').addClass('modal-open');
    }
});

/** CONTROLO EL CHANGE DE LA FECHA EN EL REPORTE DE TRABAJADORES
*/
jQuery(document).on("change", "#fecha1", function (e){
    jQuery(".preloader").fadeIn();
    jQuery.ajax({
      type: "POST",
      url: "./modules/controllers/ajax.php",
      data : "accion=refresh_rep_trabajos&date="+jQuery("#fecha").val()+"&mod=rep_plan",
      dataType:'json',
      success: function(data){
        jQuery('#trabajos tbody').empty();
        if(data.title=="SUCCESS"){
          jQuery(data.content).each(function(index,value){
            tr=`<tr>
            <td>`+value.trabajador+` (`+value.cargo+`)</td>
            <td></td>
            <td></td>
            </tr>`;
            jQuery("#trabajos tbody").append(tr);
          });
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
jQuery("#Modal_").on("click", '#add_odc_nte_pro_tbl tbody tr', function (e){
    element = jQuery(this).find('input[type="checkbox"]');
    jQuery(element).prop("checked",!jQuery(element).prop("checked"));
    if(element==true){
        jQuery(this).addClass("active");
    }else{
        jQuery(this).removeClass("active");
    }
});
/**
 * ANALIZA LA ACCION aceptar DEL MODAL PARA TOMAR ACCIONES
 */
jQuery("#modal_ok").click(function (){
    if(acc=="add_odc_nte_pro"){
        if(checkbox("odcs_","UNA ORDEN DE COMPRA!")){
          jQuery(".preloader").fadeIn();
          jQuery("#table_odc tbody").empty();
          jQuery("#table_art tbody").empty();
          let odcs = new Array();
          jQuery('input[name="odcs_[]"]:checked').each(function(){
              odcs.push(jQuery(this).val());
          });
          axios.post('./modules/controllers/ajax.php',{
            mod: 'CRUD_INV_NTE',
            accion: 'get_odc_full',
            odc: JSON.stringify(odcs)
          }).then(function (response){
            let repuesta = response.data
            if(repuesta.title=="SUCCESS"){
              jQuery(repuesta.content).each(function(index,value){
                count = index+1;
                tr_cab=`<tr>
                <td><input name="corden[]" id="corden[`+count+`]" type="hidden" value="`+value.codigo+`">`+value.codigo+`</td>
                <td>`+value.data+`</td>
                <td>`+value.fecha_orden+`</td>
                <td>`+value.articulos+`</td>
                <td class="number_cal">`+value.monto_total+`</td>
                <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td>
                </tr>`;
                jQuery(value.dets).each(function(index1,value1){
                    let count = (jQuery("#table_art tbody tr").length)+1;
                    tr_det=`<tr>
                    <td>
                        <input name="codc[]" id="codc[`+count+`]" type="hidden" value="`+value1.origen+`">
                        <input name="codc_det[]" id="codc_det[`+count+`]" type="hidden" value="`+value1.codigo+`">
                        <input name="carticulo[]" id="carticulo[`+count+`]" type="hidden" value="`+value1.codigo_art+`">
                        <input name="cmov_det[]" id="cmov_det[`+count+`]" type="hidden" value="0">
                        <input name="costo[]" id="costo[`+count+`]" type="hidden" value="`+value1.costou+`">
                        <input name="imp_p[]" id="imp_p[`+count+`]" type="hidden" value="`+value1.imp_p+`">
                        `;
                        tr_det+=value1.codigo2+`
                    </td>
                    <td>`+value1.articulo+`</td>
                    <td><input name="cant[]" id="cant[`+count+`]" type="text" style="width: 80px;" class="form-control cant numeric ctrl" value="`+value1.cant_rest+`"></td>
                    <td class="number_cal">`+value1.costou+`</td>
                    <td>`+value1.imp_p+`</td>
                    <td>`+value1.costot+`</td>
                    <td><button type="button" class="btn btn-outline-secondary btn-circle btn-sm waves-effect waves-light bt_del ctrl" data-menu="`+mod+`" data-mod="`+submod+`" data-ref="`+ref+`" data-subref="`+subref+`"><i class="fas fa-trash-alt"></i></button></td></tr>`;
                    jQuery("#table_art tbody").append(tr_det);
                });
                jQuery("#table_odc tbody").append(tr_cab);
              });
            }else{
                dialog(repuesta.content,repuesta.title);
            }
          }).catch(function (error){
            axios_Error(error);
          }).finally(function (){ jQuery(".number_cal").formatCurrency(); jQuery("#Modal_").modal('hide'); jQuery(".preloader").fadeOut(); });
        }
    }
});
/** Obtiene los parametros por URL
*/
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

$.fn.maxDate = function(){
    dates = [];
    this.each(function() {
        if ( jQuery(this).is(':input') ) {
            val = jQuery(this).val();
            if(moment(val, 'DD-MM-YYYY', true).isValid()){
                dates.push(val);
            }
        } else {
            val = jQuery(this).text();
            if(moment(val, 'DD-MM-YYYY', true).isValid()){
                dates.push(val);
            }
        }
    });
    moments = dates.map(d => moment(d, "DD-MM-YYYY"));
    date = moment.max(moments).format("DD-MM-YYYY");
    return date;
};

$.fn.minDate = function(){
    dates = [];
    this.each(function() {
        if ( jQuery(this).is(':input') ) {
            val = jQuery(this).val();
            if(moment(val, 'DD-MM-YYYY', true).isValid()){
                dates.push(val);
            }
        } else {
            val = jQuery(this).text();
            if(moment(val, 'DD-MM-YYYY', true).isValid()){
                dates.push(val);
            }
        }
    });
    moments = dates.map(d => moment(d, "DD-MM-YYYY"));
    date = moment.min(moments).format("DD-MM-YYYY");
    return date;
};