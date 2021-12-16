<table width="100%" border="1" cellpadding="5" cellspacing="0" style="font-size: 11px;">
    <tr>
        <td>Expediente</td>
        <td>Domicilio</td>
        <td>Colonia</td>
    </tr>
    @foreach($resultados as $row)
        <tr>
            <td>
                <button style="cursor: pointer;" type="button" onclick="seleccionar('{{ trim($row->exp) }}')">{{ trim($row->exp) }}</button></td>
            <td>{{ trim($row->domubi) }}</td>
            <td>{{ trim($row->colubi) }}</td>
        </tr>

    @endforeach
</table>