<div class="row" id="div_contenido">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="breadcomb-list">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <ul class="breadcrumbPago">
                        <li class="completed"><a href="{{ asset('predial') }}">Busqueda</a></li>
                        <li class="active"><a href="#">Consulta</a></li>
                        <li class="active"><a href="#pago">Pago</a></li>
                    </ul>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br><br>
                    <h4>Se han encontrado {{ count($resultados) }} coincidencias</h4>
                    <small>Favor de dar click en el expediente para consultar su estado de cuenta</small>
                    <table class="table table-striped table-bordered table-sm table-compact" id="tabla_direccion">
                        <tr>
                            <td>Expediente</td>
                            <td>Domicilio</td>
                            <td>Colonia</td>
                        </tr>
                        @foreach($resultados as $row)
                            <tr>
                                <td>
                                    <button class="btn btn-info btn-sm btnConsultar" id="btnConsultar{{ trim($row->exp) }}" style="cursor: pointer;" type="button" onclick="seleccionar('{{ trim($row->exp) }}')">{{ trim($row->exp) }}</button>
                                </td>
                                <td>{{ trim($row->domubi) }}</td>
                                <td>{{ trim($row->colubi) }}</td>
                            </tr>

                        @endforeach
                    </table>
                    <small>Favor de dar click en el expediente para consultar su estado de cuenta</small>
                </div>

            </div>
        </div>
    </div>
</div>