<div class="row">
    <div class="col-sm-4">&nbsp;</div>
    <div class="col-sm-4 text-center" style="min-height: 300px;">
        <img src="{{ asset('multas.gif') }}" alt=""><br><br>
        <div class="form-group text-left">
            <label for="placa">PLACA: </label>
            <input type="text" class="form-control" id="placa" name="placa">
            <small>Teclee la placa a consultar (EJ. RMP7568)</small><br><br>
            <button type="button" onclick="consultar()" class="btn btn-success"  id="btnConsultar">Consultarx</button>
            <br>
        </div>
    </div>  
    <div class="col-sm-4">&nbsp;</div>
</div>