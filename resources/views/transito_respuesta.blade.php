<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="basic-tb-hd">
            <h2>Adeudos Placa #{{ @$placa }}</h2>
        </div>
        <div class="bsc-tbl">
            <table class="table table-striped table-bordered table-sm table-condensed">
                <thead>
                <tr>
                    <th>Mun</th>
                    <th>Boleta</th>
                    <th>Fecha</th>
                    <th>Infracci&oacuet;n</th>
                    <th>Crucero</th>
                    <th class="text-right">Valor</th>
                    <th class="text-right">Descuento</th>
                    <th class="text-right">Total</th>
                </tr>
                </thead>
                <tbody>
                @if(count($adeudos["multas"])>0)
                    @php $totalMonto = 0; $totalDescuento = 0; $totalMulta = 0; $totalMontoDescuento = 0; @endphp
                    @foreach($adeudos["multas"] as $row)
                        @php
                            $montoRow = round(str_replace(",", "", $row->monto),2);
                            $descuentoRow = round(str_replace(",", "", $row->descuento),2);
                            if($descuentoRow > 0)
                                {
                                    //$totalDescuento =+ $montoRow;
                                }

                            $totalMonto += $montoRow;
                            $totalDescuento += $descuentoRow;
                            $totalMulta += $montoRow - $descuentoRow;
                        @endphp
                        <tr>
                            <td>{{ $row->mun }}</td>
                            <td>{{ $row->boleta }}</td>
                            <td>{{ $row->fecinf }}</td>
                            <td>{{ $row->clave }}</td>
                            <td>{{ $row->nomcru }}</td>
                            <td class="text-right">{{ $row->monto }}</td>
                            <td class="text-right" style="color: red;">@if($row->descuento > 0) -{{ $row->descuento }} @endif</td>
                            <td class="text-right">{{ (round(str_replace(",", "",$row->monto),2) - round($row->descuento,2)) }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
                @if(count($adeudos["multas"])>0)
                    <tfoot>
                    <tr>
                        <td colspan="5" class="text-right font-weight-bold">SUB-TOTALES:</td>
                        <td class="text-right">{{ number_format($totalMonto, 2) }}</td>
                        <td class="text-right" style="color: red;">@if($totalDescuento > 0) -{{ number_format($totalDescuento, 2) }} @endif</td>
                        <td class="text-right">{{ number_format($totalMulta, 2) }}</td>
                    </tr>
                    @if(@$adeudos["DescuentosAdicionales"] > 0)
                        <tr>
                            <td colspan="7" class="text-right" style="color:#8C008C; font-style: italic;">Descuento adicional exclusivo para pagos en linea</td>
                            <td class="text-right" style="color:#8C008C; font-weight: bold; font-style: italic;">-{{ number_format(@$adeudos["DescuentosAdicionales"], 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" rowspan="2">
                                <div style="font-style: italic; font-weight: bold; color: grey; border: #5D8539 2px solid; padding: 5px; width: 80%;">
                                    Descuentos vigentes hasta el {{ date("d/m/Y", strtotime(env('DESCUENTO_FECHA'))) }}, o en su caso, hasta que las autoridades compententes
                                    determinen la conclusión de la emergencia nacional epidemiológica.
                                </div>
                            </td>
                            <td class="text-right" colspan="2"><h4>A pagar: </h4></td>
                            <td class="text-right"><h4>{{ number_format($adeudos["Neto"],2) }}</h4></td>
                        </tr>

                        <tr>
                            <td colspan="2" class="text-right" style="font-style: italic; color: #5D8539; font-size: 16px;">Ahorraste:</td>
                            <td class="text-right" style="font-style: italic; color: #5D8539; font-size: 16px;">{{ number_format($totalDescuento + @$adeudos["DescuentosAdicionales"],2) }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="text-right" colspan="7"><h4>A pagar: </h4></td>
                            <td class="text-right"><h4>{{ number_format($adeudos["Neto"],2) }}</h4></td>
                        </tr>
                    @endif
                    </tfoot>
                @endif
            </table>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">

        <p>Gracias por el pago oportuno de tus Multas de Transito</p>
    </div>


    <div class="col-lg-12 col-md-12 col-sm-12 text-left">
        <h6>PAGO CON TARJETA DE CREDITO / DEBITO (de cualquier banco) o CHEQUE BANCARIO (BBVA)</h6>
        <div class="bsc-tbl">
            <table class="table-condensed table table-bordered table-striped table-responsive">
                <thead>
                <tr>
                    <th>Concepto</th>
                    <th class="text-right">Monto</th>
                    <th class="text-center"></th>
                </tr>
                </thead>
                @foreach($tipoMultas as $rowTipo)
                     @if($adeudos[$rowTipo["variable"]] > 0)
                         <?php
                        //20211028 esta variable esta haciendo ruido
                        $s_transm = \App\Http\Controllers\api\TransitoModel::getStransmMultas($placa, $rowTipo["servicio"]);
                        //$adeudo = $adeudos[$rowTipo["variable"]];
                        //$aAde = explode(".", $adeudo);
                        //$adeudo = @$aAde[0] . "." . str_pad(@$aAde[1], 2, "0", STR_PAD_RIGHT); --}}
                        $adeudo = $adeudos[$rowTipo["variable"]];
                        $aAde = explode(".", $adeudo);
                        $adeudo = @$aAde[0] . "." . str_pad(@$aAde[1], 2, "0", STR_PAD_RIGHT); 
                        
                        // ?> --}}
                        <tr>
                            <td>{{$rowTipo["descripcion"]}}</td>
                            <td class="text-right">{{ number_format($adeudos[$rowTipo["variable"]],2) }}</td>
                            <td class="text-center">  
                                {{--  <form method="post" target="_self" action="{{ $urlPagos }}">  20211101 --}}
                                 <form method="post" target="_self" action="{{ asset('ppagomulta') }}">
                                    <input  name="s_transm" id="s_transm" value="{{ $s_transm }}">
                                    <input  name="c_referencia" id="c_referencia" value="{{ $placa }}">
                                    <input  name="val_1" id="val_1" value="0">
                                    <input  name="t_servicio" id="t_servicio" value="{{ $rowTipo["servicio"] }}">
                                    <input name="t_importe" id="t_importe" value="{{ str_replace ( ",", '', number_format( round($adeudo, 2),2))}}">
                                    <input name="val_2" id="val_2" value="**********">
                                    <input name="val_3" id="val_3" value="1">
                                    <input name="val_4" id="val_4" value="1">
                                    <input name="val_5" id="val_5" value="1">
                                    <input name="val_6" id="val_6" value="0">
                                    <input name="val_11" id="val_11" value="">
                                    <input name="val_12" id="val_12" value="">
                                    <input name="_token" id="_token" value="{{ csrf_token() }}" >   {{--  20211101 --}} 
                                    <button type="submit" class="btn btn-info">Pagar - {{$rowTipo["descripcion"]}}</button>
                                </form>
                            </td>
                        </tr>

                     @endif 
                @endforeach
            </table>
        </div>
    </div>

</div>