<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>prueba </title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}" /> --}}

</head>

<body>

    <div class="form-group text-left">
        <label for="placa">PLACA: </label>
        <input type="text" class="form-control" id="placa" name="placa">
        <small>Teclee la placa a consultar (EJ. RMP7568)</small><br><br>
        <button type="button" onclick="consultar()" class="btn btn-success" id="btnConsultar">Consultarx</button>
        <br>
    </div>

    <div id="div_contenido"></div>



    <script type="text/javascript">
        function consultar() {
         //   >>> OK
            let placa = jQuery("#placa").val();

            if (placa == "") {
                alert('Favor de teclar la placa a consultar');
                return false;
            }
            jQuery("#btnConsultar").html('Espere un momento...');
            jQuery("#btnConsultar").prop("disabled", true);

            jQuery.ajax({
                type: "POST",
                url: "{{ asset('multas/buscar') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "placa": placa
                },
                success: function(data) {
                    jQuery("#btnConsultar").html('Consultar');
                    jQuery("#btnConsultar").prop("disabled", false);
                    jQuery("#div_contenido").html(data);
                }

            })

        }

       // <<<OK

        // >>> PRUEBA FETCH
        // let url = "{{ asset('multas/buscar') }}";

        // let datos = {

        //     "_token": "{{ csrf_token() }}",
        //             "placa": placa

        // }

        // fetch( url, {
        //     method: 'POST',
        //     body: JSON.stringify(datos),
        //     headers: {
        //         'Content-Type':'application/json'
        //     }

        // })
        // ..then((result) => {
        //     function(data) {
        //         jQuery("#btnConsultar").html('Consultar');
        //          jQuery("#btnConsultar").prop("disabled", false);
        //          jQuery("#div_contenido").html(data); 
        //     }
            
        // }).catch((err) => {
            
        // });

        // <<< PRUEBA


        // >>> EJEMPLO
        // let datos = {
        //     Username: 'raguirre',
        //     password: 'AARAAR'
        // };

        // let url = "https://gps-tracker.mx/2020/rest/api/login/authenticate";

        // fetch( url, {
        //     method: 'POST',
        //     body: JSON.stringify( datos ),
        //     headers: {
        //         'Content-Type':'application/json'
        //         }
        // })
        // .then(res => res.json())
        // .then( console.log )
        // .catch( console.log );
        // <<< EJEMPLO
    </script>
</body>

</html>
