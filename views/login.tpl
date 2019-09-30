<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{ico}">
    <title>MetalSigma - Inicie Seccion</title>
    <link href="./assets/jquery-confirm/css/jquery-confirm.css" rel="stylesheet">
    <link href="./assets/outdatedbrowser/outdatedbrowser.css" rel="stylesheet">
    <link href="{style}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(./images/background/login.jpg) no-repeat; background-size: cover;">
        <div class="auth-box on-sidebar">
            <div id="loginform">
                <div class="logo">
                    <span class="db"><img src="{logo_icon}" alt="logo" /></span>
                    <h5 class="font-medium mb-3">MetalSigma</h5>
                </div>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <form class="form-horizontal mt-3" id="loginform">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                </div>
                                <input type="text" id="user" class="form-control form-control-lg" placeholder="Usuario" aria-label="Usuario" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                                </div>
                                <input type="password" id="pass" class="form-control form-control-lg" placeholder="Clave" aria-label="Clave" aria-describedby="basic-addon1">
                            </div>
                            <!-- <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Remember me</label>
                                        <a href="javascript:void(0)" id="to-recover" class="text-dark float-right"><i class="fa fa-lock mr-1"></i> Forgot pwd?</a>
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group text-center">
                                <div class="col-xs-12 pb-3">
                                    <button class="btn btn-block btn-lg btn-info" type="submit">ENTRAR</button>
                                </div>
                            </div>
                            <div id="log" class="alert"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="outdated"></div>
    <script src="./assets/jquery/jquery.min.js"></script>
    <script src="./assets/axios/axios.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="./assets/popper.js/popper.min.js"></script>
    <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="./assets/bootstrap/js/bootstrap-notify.js"></script>
    <!-- jquery-confirm -->
    <script src="./assets/jquery-confirm/js/jquery-confirm.js"></script>
    <!--DataTable -->
    <script src="./assets/datatables/datatables.js"></script>
    <script src="./assets/outdatedbrowser/outdatedbrowser.js"></script>
    <script src="{functions}"></script>
    <script>
    $(".preloader").fadeOut();
    $(document).ready(function(){            
            $("#loginform").submit(function(e){
                e.preventDefault();             
                clear_log();
                var username = $('#user').val(), pass = $('#pass').val();
                if (username==''){
                    $('#user').focus();
                    $('#user').addClass("is-invalid");
                    dialog("DEBE DE INGRESAR EL USUARIO","ERROR");
                }else if(pass==''){
                    $('#pass').focus();
                    $('#pass').addClass("is-invalid");
                    dialog("DEBE DE INGRESAR LA CLAVE","ERROR");
                }
                else{
                    axios.get('./modules/controllers/configuracion/form_usuarios.php',{
                        params:{
                            username: username,
                            pass :pass,
                            accion: 'val_log'
                        }
                    }).then(function (data) {
                        let repuesta = data.data
                        if(repuesta.title=="SUCCESS"){
                            document.location.href="./";
                        }else{
                            dialog(repuesta.content,repuesta.title);
                        }
                    }).catch(function (error) {
                        axios_Error(error);
                       
                    });/*
                    .finally(function () {
                        // always executed
                        console.log("finally")
                    });*/
                }
                return false;
            });
        });
    </script>
</body>
</html>