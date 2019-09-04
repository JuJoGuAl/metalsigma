<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{ico}">
    <title>MetalSigma - {nom_emp}</title>
    <link href="./assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="./assets/bootstrap/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="./assets/clockpicker/clockpicker.css" rel="stylesheet">
    <link href="./assets/fullcalendar/css/fullcalendar.min.css" rel="stylesheet">
    <link href="./assets/fullcalendar/css/calendar.css" rel="stylesheet">
    <link href="./assets/jquery-confirm/css/jquery-confirm.css" rel="stylesheet">
    <link href="./assets/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet">
    <link href="{style}" rel="stylesheet">
    <!-- jQuery -->
    <script src="./assets/jquery/jquery.min.js"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <a class="navbar-brand d-block d-md-none" href="./">
                        <b class="logo-icon">
                            <img src="{logo_icon}" alt="homepage" class="dark-logo" />
                            <img src="{logo_icon}" alt="homepage" class="light-logo" />
                        </b>
                        <span class="logo-text">
                             <img src="{logo_text}" alt="homepage" class="dark-logo" />
                             <img src="{logo_text_light}" alt="homepage" class="light-logo" />
                        </span>
                    </a>
                    <div class="d-none d-md-block text-center">
                        <a class="sidebartoggler waves-effect waves-light d-flex align-items-center side-start" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                            <i class="mdi mdi-menu"></i>
                            <span class="navigation-text ml-3"> METALSIGMA</span>
                        </a>
                    </div>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item">
                            <a class="nav-link navbar-brand d-none d-md-block" href="./">
                                <b class="logo-icon">
                                    <img src="{logo_icon}" alt="homepage" class="dark-logo" />
                                    <img src="{logo_icon}" alt="homepage" class="light-logo" />
                                </b>
                                <span class="logo-text">
                                     <img src="{logo_text}" alt="homepage" class="dark-logo" />
                                     <img src="{logo_text_light}" alt="homepage" class="light-logo" />
                                </span>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav float-right">
                        <!-- INCLUDE BLOCK : profile -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- INCLUDE BLOCK : nav -->
        <div class="page-wrapper">
            <!-- CONTENIDO -->
            <div id="Modal_" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="row" id="add_new" style="margin-bottom: 18px;">
                                <div class="col-sm-3">
                                    <div class="button-group">
                                        <button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="NEW" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span> NUEVO</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body-content"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success waves-effect text-left" style="display: none" id="modal_ok">ACEPTAR</button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">CERRAR</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="modalPassword" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">CAMBIO DE CONTRASEÑA</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form role="form" name="form_password" id="form_password" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="passwordActual" class="control-label col-form-label">CONTRASEÑA ACTUAL</label>
                                            <input type="password" class="form-control validar" id="passwordActual" name="passwordActual" maxlength="50" placeholder="INSERTE LA CLAVE ACTUAL" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="passwordNew" class="control-label col-form-label">NUEVA CONTRASEÑA</label>
                                            <input type="password" class="form-control validar" id="passwordNew" name="passwordNew" maxlength="50" placeholder="INSERTE LA CLAVE A UTILIZAR" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="passwordNew2" class="control-label col-form-label">REPETIR CONTRASEÑA</label>
                                            <input type="password" class="form-control validar" id="passwordNew2" name="passwordNew2" maxlength="50" placeholder="REPITA LA CLAVE A UTILIZAR" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success waves-effect text-left" id="btn_save_password">GUARDAR</button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">CERRAR</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="modulo"></div>
            <div id="form"></div>
            <footer class="footer text-center">Todos los derechos reservados. Diseñado y Desarrollado por <a href="http://ipas-ig.com/" target="_blank">IPAS-IG</a>.</footer>
        </div>
    </div>
    <!-- jQuery -->
    <script src="./assets/jquery/jquery-ui.min.js"></script>
    <script src="./assets/jquery/jquery.formatCurrency-1.4.0.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="./assets/popper.js/popper.min.js"></script>
    <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="./assets/bootstrap/js/bootstrap-notify.js"></script>
    <script src="./assets/bootstrap/js/bootstrap-datepicker.js"></script>
    <!-- apps -->
    <script src="./assets/app/app.min.js"></script>
    <script src="./assets/app/app.init.material.js"></script>
    <script src="./assets/app/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="./assets/perfect-scrollbar/perfect-scrollbar.js"></script>
    <!--Wave Effects -->
    <script src="./assets/waves/waves.js"></script>
    <!--DataTable -->
    <script src="./assets/datatables/datatables.js"></script>
    <!-- ClockPicker -->
    <script src="./assets/clockpicker/clockpicker.js"></script>
    <!-- Moment -->
    <script src="./assets/moment/moment.js"></script>
    <!-- FullCalendar -->
    <script src="./assets/fullcalendar/js/fullcalendar.min.js"></script>
    <!-- jquery-confirm -->
    <script src="./assets/jquery-confirm/js/jquery-confirm.js"></script>
    <!-- Echarts -->
    <script src="./assets/echarts/echarts-en.min.js"></script>
    <!--Custom JavaScript -->
    <script src="{custom}"></script>
    <script src="{functions}"></script>
    <script>
        jQuery.get("./views/home.tpl", function(){ })
        .done(function(data) {
            jQuery("#modulo").html(data);
        });
        jQuery(".preloader").fadeOut();
        jQuery('#password_change').on('click', function(){
            jQuery("#modalPassword").modal({show:true,backdrop: 'static',keyboard: false});
            jQuery('#form_password')[0].reset();
            clear_log();
        });
        jQuery(document).on('click','#btn_save_password',function(){
            if(validate('passwordActual')){
                if(validate('passwordNew')){
                    if(validate('passwordNew2')){
                        if(jQuery('#passwordNew').val()!=jQuery('#passwordNew2').val() && jQuery('#passwordNew2').val()!=""){
                            dialog('LAS CONTRASEÑAS NUEVAS DEBEN COINCIDIR','ERROR');
                            jQuery('#passwordNew2').val('');
                            jQuery('#passwordNew').val('').focus();
                        }else{
                            jQuery.ajax({
                                type: "GET",
                                url: "./modules/controllers/configuracion/form_usuarios.php",
                                data: "old_pass="+jQuery('#passwordActual').val()+"&new_pass="+jQuery('#passwordNew').val()+"&accion=change_pass",
                                dataType:'json',
                                success: function(data){
                                    if(data.title=="SUCCESS"){
                                        dialog("CONTRASEÑA ACTUALIZADA","SUCCESS");
                                        jQuery("#modalPassword").modal("hide");
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
                    }
                }
            }

        });
    </script>
</body>
</html>