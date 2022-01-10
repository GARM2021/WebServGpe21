<div class="row" id="div_contenido">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="breadcomb-list">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <ul class="breadcrumbPago">
                        <li class="completed"><a href="{{ asset('predial') }}">Busqueda</a></li>
                        <li class="completed"><a href="#">Consulta</a></li>
                        <li class="active"><a href="#pago">Pago</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right" style="display: none">
                    <a href="{{ asset('predial') }}" class="btn btn-success"><i class="notika-icon notika-search"></i> Nueva Consulta</a>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><br><br>
                    <div class="breadcomb-wp">

                        <table class="table table-condensed table-striped table-bordered">
                            <tr>
                                <td>Expediente Catastral</td>
                                <td>{{ $info->exp }}</td>
                            </tr>
                            <tr>
                                <td>Ubicación del predio</td>
                                <td>{{ @$info->domubi }}</td>
                            </tr>

                            <tr>
                                <td>Colonia</td>
                                <td>{{ @$info->colubi }}</td>
                            </tr>

                            <tr>
                                <td>Valor Catastral 20220110</td>
                              
                                <td>{{  number_format(@$info->valcat,2) }}</td>
                            </tr>

                        </table>

                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right">
                    @if(count($cuenta->adeudos) > 0)
                        <button type="button" onclick="imprimir('{{ $info->exp }}')" id="btnImprimir" class="btn btn-warning"><i class="notika-icon notika-print"></i> Imprimir</button>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="breadcomb-list">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcomb-wp">
                        <div class="breadcomb-ctn" style="width: 100%;"><br><br>
                            @if(count($cuenta->adeudos) > 0)
                                <div class="table-responsive">
                                    <table class="table table-condensed table-striped table-bordered table-responsive tablaCuenta">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Año Bim</th>
                                            <th class="text-center">>Concepto</th>
                                            <th class="text-center">Fecha</th>
                                            <th class="text-right">Importe</th>
                                            <th class="text-right">Saldo</th>
                                            <th class="text-right">Bon. Imp.</th>
                                            <th class="text-right">Subsidio</th>
                                            <th class="text-right">Recargos</th>
                                            <th class="text-right">Bon. Rec.</th>
                                            <th class="text-right">Neto a Pagar</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $total1 = 0;
                                            $total2 = 0;
                                            $total3 = 0;
                                            $total4 = 0;
                                            $total5 = 0;
                                            $total6 = 0;
                                            $total7 = 0;
                                        @endphp
                                        @foreach($cuenta->adeudos as $rowAdeudo)
                                            @php
                                                $total1 += round($rowAdeudo["montoimp"],2);
                                                $total2 += round($rowAdeudo["salsub"],2);
                                                $total3 += round($rowAdeudo["saldo"],2);
                                                // $bonImp5 = $rowAdeudo["saldo"]*.15;
                                                // $total4 += $bonImp5;
                                               // $total4 += round($rowAdeudo["bonImp"],2);
                                                $total4 += round($rowAdeudo["bonImpI"],2);

                                               
                                                $total5 += round($rowAdeudo["recargos"],2);
                                                $total6 += round($rowAdeudo["bonRec"],2);
                                                // $bonImpN5 = round($rowAdeudo["saldo"],2) - round($rowAdeudo["salsub"],2) - $bonImp5  + round($rowAdeudo["recargos"],2) - round($rowAdeudo["bonRec"],2);

                                                // $total7 += $bonImpN5;
                                               // $total7 += round($rowAdeudo["neto"],2);
                                                $total7 += round($rowAdeudo["netoI"],2);

                                               
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $rowAdeudo["yearbim"] }}</td>
                                                <td>{{ $rowAdeudo["descripcion"] }}</td>
                                                <td class="text-center">{{ $rowAdeudo["fechaven"] }}</td>
                                                <td class="text-right">{{ number_format($rowAdeudo["montoimp"],2) }}</td>
                                                <td class="text-right">{{ number_format($rowAdeudo["saldo"],2) }}</td>
                                                 {{-- <td class="text-right">{{ number_format($rowAdeudo["bonImp"],2) }}</td> --}}
                                                 <td class="text-right">{{ number_format($rowAdeudo["bonImpI"],2) }}</td>
                                                 {{-- <td class="text-right">{{$bonImp5}}</td> --}}
                                                 
                                                <td class="text-right">{{ number_format($rowAdeudo["salsub"],2) }}</td>
                                                <td class="text-right">{{ number_format($rowAdeudo["recargos"],2) }}</td>
                                                <td class="text-right">{{ number_format($rowAdeudo["bonRec"],2) }}</td>
                                                {{-- <td class="text-right">{{ number_format($rowAdeudo["neto"],2) }}</td> --}}
                                                <td class="text-right">{{ number_format($rowAdeudo["netoI"],2) }}</td>
                                                {{-- <td class="text-right">{{$bonImpN5}}</td> --}}
                                                {{-- <td class="text-right">{{$bonImpN5}}</td> --}}
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        @if(count($cuenta->adeudos) > 0)
                                            <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-right">Totales</th>
                                                <th class="text-right">{{ number_format($total1,2) }}</th>
                                                <th class="text-right">{{ number_format($total3,2) }}</th>
                                                <th class="text-right">{{ number_format($total4,2) }}</th>
                                                <th class="text-right">{{ number_format($total2,2) }}</th>
                                                <th class="text-right">{{ number_format($total5,2) }}</th>
                                                <th class="text-right">{{ number_format($total6,2) }}</th>
                                                <th class="text-right">{{ number_format($total7,2) }}</th>
                                            </tr>
                                          
                                            </tfoot>
                                        @endif
                                    </table>
                                </div>
                                @php
                                    $totalLetra = "TOTAL A PAGAR";
                                @endphp
                                @if($cuenta->bonEnero > 0)
                                    @php
                                        $totalLetra = "TOTAL";
                                        $totalLetraBonLin = "DESCUENTO PAGO EN LINEA ";
                                        /*$total = round($total7 - $cuenta->bonEnero,2);*/
                                        $total = round($total7,2);
                                    @endphp
                                @else
                                    @php
                                        $total = round($total7,2);
                                    @endphp
                                @endif
                                <table class="table table-striped">
                                    <tr>
                                        <th colspan="3" class="text-right"></th>
                                        
                                                                            
                                        <th  class="text-right">DESCUENTO PAGO EN LINEA</th>
                                        <th  class="text-right" >${{ number_format($rowAdeudo["tbonlinea"],2) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-right"></th>
                                       
                                       
                                        <th   class="text-right">TOTAL A PAGAR</th>
                                        {{-- <th class="text-right" style="width: 120px;">${{ number_format($total7,2) }}</th> --}}
                                        <th  class="text-right" >${{ number_format($rowAdeudo["totalAdeudo"],2) }}</th>

                                    </tr>
                                   
                                    <tr>
                                        <!--th colspan="2" class="text-right">
                                        HDT: se comentan los descuentos (esta nota debera eliminarse, fecha de modificacion abril 2021
                                            NOTA: EL TOTAL A PAGAR INCLUYE EL 10% ADICIONAL PARA LAS PERSONAS QUE CUMPLIERON CON EL PAGO DEL IMPUESTO PREDIAL 2020 Y ANTERIORES HASTA EL 31 DE DICIEMBRE 2020. Y UN 3% ADICIONAL AL PAGAR EN VENTANILLA VIRTUAL O TIENDA DE CONVENIENCIA.
                                        </th-->
                                        <th colspan="2" class="text-right">
                                            NOTA: SE APLICA  UN DESCUENTO DEL (15% ENERO, 10% FEBRERO Y 5% MARZO), ADICIONAL UN SUBSIDIO DEL  10% SOBRE EL INCREMENTO DEL IMPUESTO PREDIAL.
                                        </th>

                                    </tr>
                                    {{--
                                    @if($cuenta->bonEnero > 0)
                                        <tr>
                                            <th class="text-right">{{ env('DESCUENTO') }}% Descuento al IMPUESTO PREDIAL {{ date("Y") }}:</th>
                                            <th class="text-right">${{ number_format($cuenta->bonEnero,2) }}</th>
                                        </tr>
                                        <tr>
                                            <th class="text-right">TOTAL A PAGAR:</th>
                                            <th class="text-right">${{ number_format($total,2) }}</th>
                                        </tr>
                                    @endif
                                    --}}
                                </table>
                            @endif
                            @if(count($cuenta->pagos->conceptos)>0)
                                <div class="table-responsive">
                                    <table class="table table-condensed table-striped table-bordered tablaCuenta">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Año Bim</th>
                                            <th>Concepto</th>
                                            <th class="text-center">Recibo</th>
                                            <th class="text-right">Fecha Pago</th>
                                            <th class="text-right">Importe</th>
                                            <th class="text-right">Subsidio</th>
                                            <th class="text-right">Bon. Imp</th>
                                            <th class="text-right">Recargos</th>
                                            <th class="text-right">Bon. Rec.</th>
                                            <th class="text-right">Neto Pagado</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($cuenta->pagos->conceptos as $concepto)
                                            <tr>
                                                <td>{{ $concepto->yearBim }}</td>
                                                <td>{{ $concepto->descripcion }}</td>
                                                <td>{{ $concepto->recibo }}</td>
                                                <td>{{ $concepto->fechaPago }}</td>
                                                <td class="text-right">{{ $concepto->importe}}</td>
                                                <td class="text-right">{{ $concepto->subsidio }}</td>
                                                <td class="text-right">{{ $concepto->bonif }}</td>
                                                <td class="text-right">{{ $concepto->recargos }}</td>
                                                <td class="text-right">{{ $concepto->bonrec }}</td>
                                                <td class="text-right">{{ $concepto->neto }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th colspan="9" class="text-right">Total Pagado</th>
                                            <th class="text-right">{{ $cuenta->pagos->totalNeto }}</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="height: 50px;">&nbsp;</div>
            </div>

        </div>
    </div>
    @if(count($cuenta->adeudos) > 0)
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="breadcomb-list">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <h3>Paga en línea de forma segura<br>
                            con tu tarjeta de crédito o débito visa o masterd card.</h3><br>
                        <img src="{{ asset("tmpl/visa.jpg") }}" style="width: 100%; max-width: 220px;" alt="">
                        <br><br>
                        <form method="post" action="https://www.adquiramexico.com.mx/clb/endpoint/gGuadalupe">
                            <input type="hidden" name="s_transm" value="{{ $cuenta->comorder_id }}">
                            <input type="hidden" name="c_referencia" value="{{ trim($info->exp) }}">
                            <input type="hidden" name="val_1" value="0">
                            <input type="hidden" name="t_servicio" value="002">
                            <input type="hidden" name="t_importe" value="<?php echo number_format(@$rowAdeudo["totalAdeudo"], 2, '.', '')?>">
                            <input type="hidden" name="val_2" value="****** ******* ****">
                            <input type="hidden" name="val_3" value="1">
                            <input type="hidden" name="val_4" value="1">
                            <input type="hidden" name="val_5" value="1">
                            <input type="hidden" name="val_6" value="0">
                            <input type="hidden" name="val_11" value="">
                            <input type="hidden" name="val_12" value="">
                            <button class="btn btn-info" id="btnPagarLinea">PAGO EN LINEA &nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right" style="color: #eea236"></i></button>
                        </form>
                        <br><br><br>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <h3>Otros metodos de pago</h3>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcomb-wp">
                            <div class="breadcomb-ctn" style="width: 100%;"><br><br>
                                <div class="table-responsive">
                                    <table class="table table-condensed table-striped table-bordered">
                                        <tr>
                                            <th class="text-right">Impresión para pago en tiendas de conveniencia<br><br>
                                                <img src="{{ asset('paynet_logo.png') }}" style="height: 30px;" alt="Paynet">
                                                <img src="{{ asset('7eleven.png') }}" style="height: 30px;" alt="7 Eleven">
                                                <img src="{{ asset('extra.png') }}" style="height: 30px;" alt="Extra"><br><br>
                                                <img src="{{ asset('farmacia_ahorro.png') }}" style="height: 30px;" alt="Farmacias del Ahorro">
                                                <img src="{{ asset('benavides.png') }}" style="height: 30px;" alt="Farmacias Benavides">
                                            </th>
                                            <td class="text-right"><br>
                                                <button class="btn btn-info" id="btnPaynet" onclick="imprimirPaynet('{{ trim($info->exp) }}')"><i class="notika-icon notika-print"></i> Imprimir Paynet</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right">Impresión para pago en OXXO<br><br>
                                                <img src="{{ asset('logo-oxxo.jpg') }}" style="height: 30px;" alt="OXXO">
                                            </th>
                                            <td class="text-right"><br>
                                                <button class="btn btn-info" id="btnOxxo" onclick="imprimirOxxo('{{ trim($info->exp) }}')"><i class="notika-icon notika-print"></i> Imprimir OXXO</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right">Impresión para pago en Banco Azteca<br><br>
                                                <img src="{{ asset('logo_azteca.jpg') }}" style="height: 30px;" alt="Banco Azteca">
                                                <img src="{{ asset('logo_elektra.jpg') }}" style="height: 30px;" alt="Elektra">
                                            </th>
                                            <td class="text-right"><br>
                                                <button class="btn btn-info" id="btnAzteca" onclick="imprimirAzteca('{{ trim($info->exp) }}')"><i class="notika-icon notika-print"></i> Imprimir Banco Azteca</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12" style="height: 50px;">&nbsp;</div>
                </div>

            </div>
        </div>
    @endif

</div>