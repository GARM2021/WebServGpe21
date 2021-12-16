<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Guadalupe N.L. | Multas de Transito</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('tmpl/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tmpl/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tmpl/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('tmpl/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('tmpl/css/owl.transitions.css') }}">
    <link rel="stylesheet" href="{{ asset('tmpl/css/meanmenu/meanmenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tmpl/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('tmpl/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('tmpl/css/wave/waves.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tmpl/css/wave/button.css') }}">
    <link rel="stylesheet" href="{{ asset('tmpl/css/scrollbar/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tmpl/css/notika-custom-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('tmpl/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('tmpl/style.css') }}">
    <link rel="stylesheet" href="{{ asset('tmpl/css/responsive.css') }}">
    <script src="{{ asset('tmpl/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('tmpl/custom.css') }}">
</head>

<body>
<!-- Start Header Top Area -->
<div class="header-top-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="logo-area">
                    <a href="http://www.guadalupe.gob.mx/"><img src="http://www.guadalupe.gob.mx/wp-content/uploads/2019/01/logo-gpe.png" alt=""/></a>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 text-right">
                <br><br>
                <h4 class="align-middle"><b>Atención Ciudadana:</b>&nbsp;<a href="tel:8030-6000">81 8030-6000</a></h4>
            </div>
        </div>
    </div>
</div>
<!-- End Header Top Area -->
<!-- Main Menu area start-->
<div class="main-menu-area" style="padding: 10px;">
    <div class="container">
    </div>
</div>
<!-- Main Menu area End-->
<!-- Breadcomb area Start-->
<div class="breadcomb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcomb-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcomb-wp">
                                <div class="breadcomb-icon">
                                    <i class="notika-icon notika-search"></i>
                                </div>
                                <div class="breadcomb-ctn">
                                    <h2>Multas de Tránsito</h2>
                                </div>
                            </div>

                            <p>
                                Municipio de Guadalupe N.L.<br>
                                Secretaría de Finanzas y Tesorería<br>
                                Dirección de Ingresos
                            </p>

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                            <a href="javascript:consulta();" class="btn btn-success"><i class="notika-icon notika-search"></i> Nueva Consulta</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcomb area End-->
<!-- Normal Table area Start-->
<div class="breadcomb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcomb-list" id="div_contenido">
                    {!! view('transito_forma_busqueda') !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Normal Table area End-->
<!-- Start Footer area-->
<div class="footer-copyright-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left">
                <br>
                <br>
                <h4>Presidencia Municipal</h4>
                <p class="text-left">
                    Av. Morones Prieto y Barbadillo s/n<br>
                    Colonia Centro<br>
                    67100, Guadalupe<br>
                    Nuevo León, México
                </p>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left">
                <br>
                <br>
                <h4>Emergencias</h4>
                <p class="text-left">
                    Bomberos: 81 4040-0021<br>
                    Protección Civil: 81 1771-8801<br>
                    Cruz Verde: 81 4040-9080<br>
                    Seguridad Pública: 81 8135-5900
                </p>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <br><br>
                <img src="http://www.guadalupe.gob.mx/wp-content/uploads/2019/01/footer-1.png" style="height: 200px;" alt="">
            </div>


        </div>
    </div>
</div>
<script src="{{ asset('tmpl/js/vendor/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('tmpl/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('tmpl/js/jquery.scrollUp.min.js') }}"></script>
<script src="{{ asset('tmpl/js/meanmenu/jquery.meanmenu.js') }}"></script>
<script src="{{ asset('tmpl/js/counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('tmpl/js/counterup/waypoints.min.js') }}"></script>
<script src="{{ asset('tmpl/js/counterup/counterup-active.js') }}"></script>
<script src="{{ asset('tmpl/js/scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('tmpl/js/todo/jquery.todo.js') }}"></script>
<script src="{{ asset('tmpl/js/plugins.js') }}"></script>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">

    // jQuery('#btnConsultar').on('click', function(){
    //     consultar();
    // });



    function consulta() {
        jQuery.ajax({
            type: "GET",
            url: "{{ asset('multas/forma') }}",
            success: function (data) {
                jQuery("#div_contenido").html(data);
            }
        })
    }

    function consultar() {
        
      
      let placa = jQuery("#placa").val();
       //let placa = "SRG8392";
        
        if (placa == "") {
            alert('Favor de teclar la placa a consultar');
            return false;
        }
        jQuery("#btnConsultar").html('Espere un momento...');
        jQuery("#btnConsultar").prop("disabled", true);
        //var paso = {{ asset('multas/buscar') }};
        jQuery.ajax({
            type: "POST",
            url: "{{ asset('multas/buscar') }}",
            data: {"placa": placa},
            success: function (data) {
                jQuery("#btnConsultar").html('Consultar');
                jQuery("#btnConsultar").prop("disabled", false);
                jQuery("#div_contenido").html(data);
            }
        })
    }
</script>
</body>

</html>