<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Guadalupe N.L. @yield('titulo')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <link rel="stylesheet" href="{{ asset('tmpl/custom.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
    @yield('styles')
</head>

<body>
<!-- Start Header Top Area -->
<div class="header-top-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="logo-area">
                    <a href="http://www.guadalupe.gob.mx/"><img src="http://www.guadalupe.gob.mx/wp-content/uploads/2021/03/logo_guadalupe_gris_198x100.png" alt=""/></a>
                    <!-- http://www.guadalupe.gob.mx/wp-content/uploads/2019/01/logo-gpe.png -->
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 text-right">
                <br><br>
                <h4 class="align-middle"><b>Atención Ciudadana:</b>&nbsp;<a href="tel:999999">81 8030-6000</a></h4>
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
        @yield('header')
    </div>
</div>
<!-- Breadcomb area End-->
<!-- Normal Table area Start-->
<div class="breadcomb-area">
    <div class="container">
        @yield('content')
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
                    Bomberos: 9999999999<br>
                    Protección Civil: 81 1771-8801<br>
                    Cruz Verde: 81 4040-9080<br>
                    Seguridad Pública: 999999999
                </p>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <br><br>
                <!--img src="http://www.guadalupe.gob.mx/wp-content/uploads/2019/01/footer-1.png" style="height: 200px;" alt=""-->
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
@yield('scripts')
</body>

</html>