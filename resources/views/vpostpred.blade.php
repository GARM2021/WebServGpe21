@extends('layout_pagos')
@section('header')
    <div class="row" id="div_contenido">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="breadcomb-list">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div class="row consulta_header_background">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <div class="row consulta_header">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <table>
                                            <tr>
                                                <td class="numero numero1">1</td>
                                                <td class="pasos"><span>UBICA</span><br>tu predio</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <table>
                                            <tr>
                                                <td class="numero numero2">2</td>
                                                <td class="pasos"><span>CONSULTA</span><br>tu adeudo</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <table>
                                            <tr>
                                                <td class="numero numero3">3</td>
                                                <td class="pasos"><span>PAGA</span><br>en línea</td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br></div>


                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <div class="row consulta_header_forma">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                        <h4>Consulta y Paga tu predial</h4>
                                        <br>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>

                                    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                                        <label class="container_check">Por número de expediente
                                            <input type="radio" checked="checked" name="buscar" id="bexp" onclick="buscarPor('exp')">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                                        <label class="container_check">Por dirección del predio
                                            <input type="radio" name="buscar" id="bdir" onclick="buscarPor('dir')">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="div_buscar_expediente">
                                        <div class="col">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                # Expediente Catastral
                                                <input type="text" class="form-control forma_busqueda" id="expediente" name="expediente" autocomplete="false">
                                            </div>


                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center" style="padding: 10px;">
                                                <small style="margin-top: 20px;">EJEMPLO. 01001001<br>
                                                    (Región-Manzana-Lote)</small>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12  text-center">
                                                <!-- en caso de desactivar el pago en linea, se desactiva el siguiente boton -->
                                                <button type="text" class="btn btnBuscar" onclick="consultar()" id="btnConsultar">Consultar</button>
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-weight: 200; font-style: italic;">
                                                * Puedes obtener el número de expediente revisando en un recibo de pago anterior
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="div_buscar_direccion" style="display: none;">
                                        <div class="col">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                Calle y número
                                                <input type="text" class="form-control forma_busqueda" id="calle">
                                            </div>


                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                Colonia
                                                <input type="text" class="form-control forma_busqueda" id="colonia">
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                                                <!-- en caso de desactivar el pago en linea, se desactiva el siguiente boton -->
                                                <button type="text" class="btn btnBuscar" onclick="buscarDireccion()" id="btnDireccion">Consultar</button>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>


                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12" style="height: 5px;">&nbsp;</div>
                </div>
                <div class="row">

                    <div class="col-lg-12" style="height: 50px;">&nbsp;</div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
                    <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12" style="font-size: 16px;">
                        @if(date("n") <= 3)
                            <b>Paga en ventanilla virtual o en tiendas de conveniencia y Oxxo</b>
                            <p>y ahorra hasta un {{ env('DESCUENTO') }}% en el pago de impuesto predial 2021 Pagando en el mes de enero</p>
                            <p><small>Aplica solo para contribuyente que cumplieron con el pago de sus contribuciones al 31 de diciembre 2020</small></p>
                        @endif

                        La transacción es fácil y segura. Al finalizar podrás descargar tu recibo de pago virtual.<br>
                        Aceptamos tarjetas de crédito y débito visa y master card.
                    </div>
                    <div class="col-lg-4 col-md-2 col-sm-12 col-xs-12">
                        <img src="{{ asset("tmpl/visa.jpg") }}" style="width: 100%; max-width: 350px;" alt="">
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('tmpl/swal/sweetalert2.min.css') }}">
    <style>
        .tablaCuenta.table-condensed > tbody > tr > td, .tablaCuenta.table-condensed > tbody > tr > th, .tablaCuenta.table-condensed > tfoot > tr > td, .tablaCuenta.table-condensed > tfoot > tr > th, .tablaCuenta.table-condensed > thead > tr > td, .tablaCuenta.table-condensed > thead > tr > th {
            border-top: 1px solid #F5F5F5;
            font-size: 13px;
            color: #333;
            padding: 5px;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('tmpl/swal/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript">
        function consultar() {
            let exp = jQuery("#expediente").val();
            if (exp == "") {
                Swal.fire({
                    icon: 'warning',
                    text: 'Favor de ingresar el Número de Expediente Catastral'
                });

                return;
            } else {
                jQuery("#btnConsultar").html('Espere un momento...');
                jQuery("#btnConsultar").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "{{ asset('predial/consulta') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "exp": exp},
                    success: function (data) {
                        jQuery("#btnConsultar").html('Consultar');
                        jQuery("#btnConsultar").prop("disabled", false);
                        jQuery("#div_contenido").html(data);
                    }, error: function () {
                        Swal.fire({
                            icon: 'error',
                            text: 'Lo sentimos, ha ocurrido un error, favor de intentarlo mas tarde'
                        });

                        jQuery("#btnConsultar").html('Consultar');
                        jQuery("#btnConsultar").prop("disabled", false);
                    }
                });
            }

        }

        function seleccionar(exp) {
            if (exp == "") {
                Swal.fire({
                    icon: 'warning',
                    text: 'Favor de ingresar el Número de Expediente Catastral'
                });

                return;
            } else {
                jQuery("#btnConsultar"+exp).html('Espere un momento...');
                jQuery(".btnConsultar").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "{{ asset('predial/consulta') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "exp": exp},
                    success: function (data) {
                        jQuery("#btnConsultar"+exp).html(exp);
                        jQuery(".btnConsultar").prop("disabled", false);
                        jQuery("#div_contenido").html(data);
                    }, error: function () {
                        Swal.fire({
                            icon: 'error',
                            text: 'Lo sentimos, ha ocurrido un error, favor de intentarlo mas tarde'
                        });

                        jQuery("#btnConsultar"+exp).html(exp);
                        jQuery(".btnConsultar").prop("disabled", false);
                    }
                });
            }

        }

        function buscarDireccion() {
            let calle = jQuery("#calle").val();
            let colonia = jQuery("#colonia").val();
            if (calle == "" || colonia == "") {
                Swal.fire({
                    icon: 'warning',
                    text: 'Favor de ingresar la dirección del predio (Calle, número y colonia)'
                });

                return;
            } else {
                jQuery("#btnDireccion").html('Espere un momento...');
                jQuery("#btnDireccion").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "{{ asset('predial/direccion') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "domicilio": calle, "colonia": colonia},
                    success: function (data) {
                        jQuery("#btnDireccion").html('Consultar');
                        jQuery("#btnDireccion").prop("disabled", false);
                        jQuery("#div_contenido").html(data);
                    }, error: function () {
                        Swal.fire({
                            icon: 'error',
                            text: 'Lo sentimos, ha ocurrido un error, favor de intentarlo mas tarde'
                        });
                        jQuery("#btnConsultar").html('Consultar');
                        jQuery("#btnConsultar").prop("disabled", false);
                    }
                })
            }

        }

        function imprimir(exp) {
            if (exp == "") {
                return;
            } else {
                jQuery("#btnImprimir").html('<i class="notika-icon notika-print"></i> Espere un momento...');
                jQuery("#btnImprimir").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "{{ asset('predial/imprimir') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "expediente": exp},
                    success: function (data) {
                        jQuery("#btnImprimir").html('<i class="notika-icon notika-print"></i> Imprimir');
                        jQuery("#btnImprimir").prop("disabled", false);
                        if (data != "ERROR") {
                            window.open(data);
                        }
                    }
                })
            }
        }


        function imprimirPaynet(exp) {
            if (exp == "") {
                return;
            } else {
                jQuery("#btnPaynet").html('<i class="notika-icon notika-print"></i> Espere un momento...');
                jQuery("#btnPaynet").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "{{ asset('predial/paynet') }}",
                    data: 
                    {
                        "_token": "{{ csrf_token() }}",
                        "expediente": exp},
                    success: function (data) {
                        jQuery("#btnPaynet").html('<i class="notika-icon notika-print"></i> Imprimir Paynet');
                        jQuery("#btnPaynet").prop("disabled", false);
                        if (data != "ERROR") {
                            window.open(data);
                        }
                    },
                    error: (function () {
                        jQuery("#btnPaynet").html('<i class="notika-icon notika-print"></i> Imprimir Paynet');
                        jQuery("#btnPaynet").prop("disabled", false);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Error',
                            text: 'Algo ha salido mal, favor de intentarlo mas tarde',
                        });
                    })
                })
            }
        }

        function imprimirOxxo(exp) {
            if (exp == "") {
                return;
            } else {
                jQuery("#btnOxxo").html('<i class="notika-icon notika-print"></i> Espere un momento...');
                jQuery("#btnOxxo").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "{{ asset('predial/oxxo') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "expediente": exp},
                    success: function (data) {
                        jQuery("#btnOxxo").html('<i class="notika-icon notika-print"></i> Imprimir OXXO');
                        jQuery("#btnOxxo").prop("disabled", false);
                        if (data != "ERROR") {
                            window.open(data);
                        }
                    },
                    error: (function () {
                        jQuery("#btnOxxo").html('<i class="notika-icon notika-print"></i> Imprimir OXXO');
                        jQuery("#btnOxxo").prop("disabled", false);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Error',
                            text: 'Algo ha salido mal, favor de intentarlo mas tarde, o favor de comunicarse con tesoreria municipal',
                        });
                    })
                })
            }
        }

        function imprimirAzteca(exp) {
            if (exp == "") {
                return;
            } else {
                jQuery("#btnAzteca").html('<i class="notika-icon notika-print"></i> Espere un momento...');
                jQuery("#btnAzteca").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "{{ asset('predial/azteca') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "expediente": exp},
                    success: function (data) {
                        jQuery("#btnAzteca").html('<i class="notika-icon notika-print"></i> Imprimir Banco Azteca');
                        jQuery("#btnAzteca").prop("disabled", false);
                        if (data != "ERROR") {
                            window.open(data);
                        }
                    },
                    error: (function () {
                        jQuery("#btnAzteca").html('<i class="notika-icon notika-print"></i> Imprimir Banco Azteca');
                        jQuery("#btnAzteca").prop("disabled", false);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Error',
                            text: 'Algo ha salido mal, favor de intentarlo mas tarde, o favor de comunicarse con tesoreria municipal',
                        });
                    })
                })
            }
        }

        function buscarPor(tipo) {
            if (tipo == 'exp') {
                jQuery("#div_buscar_expediente").css("display", "");
                jQuery("#div_buscar_direccion").css("display", "none");
            } else {
                jQuery("#div_buscar_expediente").css("display", "none");
                jQuery("#div_buscar_direccion").css("display", "");

            }
        }

    </script>
@endsection