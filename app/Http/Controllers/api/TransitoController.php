<?php


namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Twig\Extension\Dump;
use DebugBar\DebugBar;
use Illuminate\Support\Facades\DB;

class TransitoController extends Controller
{

    function consultarMultas()
    {
        if(@$_GET["pruebas"] == "")
        {
            //return response("<h1>Sitio en Mantenimiento</h1>", 503);
        }
        return view('transito_consulta');
    }

    function consultarForma(){
        return view('transito_forma_busqueda');
    }

    function consultarResultado(){
       
       dump("TransitoController consultarResultado <<<<<<<<<<<<<<");
        
        $placa = trim(@$_POST["placa"]);
        
        if(empty($placa)){
            die("Error: #REF1");
        }
       

        //$urlPagosProduccion = 'https://www.egbs5.com.mx/egobierno/gnl/gGuadalupe/principal/indexgen.jsp';
        //$urlPagos = 'https://www.adquiramexico.com.mx/clb/endpoint/guadalupe';
        $urlPagos = 'https://www.adquiramexico.com.mx/clb/endpoint/gGuadalupe';
        
        $adeudos = TransitoModel::getAdeudosPlaca($placa);

        
        $data["adeudos"] = $adeudos;
        $data["placa"] = $placa;
        $data["tipoMultas"] = TransitoModel::getTiposPagos();
        $data["urlPagos"] = $urlPagos;
        //  dd($data); //! 20211028 //////////////////////////////
        //dump("TransitoController >>> view transito_respuesta <<<<<<<<<");
       return view('transito_respuesta', $data);
        // return view('vholamundo', $data);
       
    }

    function procesaPago()
    {
       dump("TransitoController procesaPago <<<<<<<<<<<<");
        $EXITO = false;
        /* PARAMETROS RECIBIDOS */
        $s_transm = @$_POST["s_transm"];        // Secuencia de Transmisión 	s_transm	1 a 20	NUMERIC	Recibido en envío CLIENTE-Multipagos
        $c_referencia = @$_POST["c_referencia"];    // Referencia	c_referencia	1 a 20	CHAR	Recibido en envío CLIENTE-Multipagos
        $val_1 = @$_POST["val_1"];           // Nivel 1 De Detalle	val_1	3	NUMERIC	Recibido en envío CLIENTE-Multipagos
        $t_servicio = @$_POST["t_servicio"];      // Tipo de Servicio	t_servicio	3	NUMERIC	Recibido en envío CLIENTE-Multipagos
        $t_importe = @$_POST["t_importe"];       // Importe Total 	t_importe	(9,2)	NUMERIC	Recibido en envío CLIENTE-Multipagos
        $val_3 = @$_POST["val_3"];           //  Moneda	val_3	1	NUMERIC	1 = Pesos 2 = Dólares
        $t_pago = @$_POST["t_pago"];          // Tipo de Pago	t_pago	2	NUMERIC	01 = Tarjeta de Crédito  02 = Cheque en Línea, 03 = Clabe Interbancaria., 04 = Sucursal
        $n_autoriz = @$_POST["n_autoriz"];       // Número de Operación Bancaria	n_autoriz	28	NUMERIC	Ver detalle*
        $val_9 = @$_POST["val_9"];           // Número de Tarjeta	val_9	4	NUMERIC	Solo aplica para t_pago = 01 Últimas 4 posiciones de la tarjeta de Crédito
        $val_10 = @$_POST["val_10"];          // Fecha de Pago	val_10	26	CHAR	YYYY-MM-DD HH:MM:SS.MMMMMM
        $val_5 = @$_POST["val_5"];           // Financiamiento	val_5	1	NUMERIC	Indica si la transacción utilizó financiamiento 1 = No aplica, 2 = Si aplica
        $val_6 = @$_POST["val_6"];           // Periodo de Financiamiento	val_6	Variable	CHAR	Indica el periodo de financiamiento seleccionado: Es 0 si val_5 = 1
        $val_11 = @$_POST["val_11"];          // E-Mail	val_11	50	CHAR	Recibido y/o modificado en Multipagos
        $val_12 = @$_POST["val_12"];          // Teléfono	val_12	20	CHAR	Recibido y/o modificado en Multipagos

        $placa = trim($c_referencia);
         dump($s_transm);
         dump($placa);
        // Se hace el log en la tabla
        $datosLog = [
            "s_transm" => $s_transm,
            "c_referencia" => $c_referencia,
            "val_1" => $val_1,
            "t_servicio" => $t_servicio,
            "t_importe" => $t_importe,
            "val_3" => $val_3,
            "t_pago" => $t_pago,
            "n_autoriz" => $n_autoriz,
            "val_9" => $val_9,
            "val_10" => $val_10,
            "val_5" => $val_5,
            "val_6" => $val_6,
            "val_11" => $val_11,
            "val_12" => $val_12
        ];

            //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
           //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> STORE PROCEDURE >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

            $expediente =  "01003004      ";
            $falso = "falso";
            // $data = DB::connection('sqlsrv')->select('EXEC SP_eshabita ?', ['01001012      ']);//20211103  funciona 
            $data = DB::connection('sqlsrv')->select('EXEC SP_eshabita ?', [$expediente]);//20211103  funciona
            
            dump($expediente);
            dump($data);
            dump($data[0]->habita);

            if ($data[0]->habita == "1") {  
                dump( "ES HABITA" );
            } else {
                // dd( $data );
                dump("NO ES HABITA");
            }
            
           
            // dump($data);

          //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
           //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>   

      // dd($datosLog);
      // debug($datosLog);
      
        // DB::table('multasLog')->insert($datosLog); 20211101 marca rror

        $fechaHoy = date("Y-m-d");
        $caja = '0802'; // BANCOMER TRANSITO - 0802

        $DescripcionConcepto = "Multas de transito placa " . $placa;

        // Se obtiene el folio de recaudacion
        $Folio = "";
        $queryFolio = DB::connection('sqlsrv')
            ->table('ingresmcajas')
            ->where('caja', '=', $caja)
            ->first();

        $descuentosMovs = [];

        // dump($queryFolio);

        if ($queryFolio) {
            $Folio = $queryFolio->foliorec + 1;


            // $updateFolio = DB::connection('sqlsrv')  20211101
            //     ->table('ingresmcajas')
            //     ->where('caja', '=', $caja)
            //     ->update(['foliorec' => $Folio]);


            $Folio = "0" . $Folio;

            /* BUSCAR LOS CONCEPTOS */

            //4107	FOTO MULTAS TRANSITO --- Boletas que empiecen con 281
            //4108  MULTAS ELECTRONICAS --- Boletas que empiecen con 284
            //4110	MULTAS DE GUADALUPE --- Boletas que NO empiecen con 281 o 284

            //1975	FOTO MULTAS TRANSITO --- Boletas que empiecen con 281
            //1976  MULTAS ELECTRONICAS --- Boletas que empiecen con 284
            //1974	MULTAS DE GUADALUPE --- Boletas que NO empiecen con 281 o 284

            // $folioWWW = DB::table('transitoLog') //20211101
            //     ->where('id', '=', $s_transm)
            //     ->first();

            // if(!$folioWWW){
            //     die('ERROR #REF1');
            // }

            // if($folioWWW->placa != $placa)
            // {
            //     die('ERROR #REF2');
            // }                                    //20211101
            // dump("TransitoController > TransitoModel getPlacas >>>>>>>>>>>>");
             $placas = TransitoModel::getPlacas($placa);
             dump("regresa getPlacas");

            // switch ($folioWWW->servicio)
            // {
            //     case '1975':
            //         $whereBoleta = "boleta LIKE '281%'";
            //         break;

            //     case '1976':
            //         $whereBoleta = "boleta LIKE '284%'";
            //         break;

            //     default:
            //         $whereBoleta = "SUBSTRING(boleta, 1, 3) NOT IN ('281', '284') ";
            //         break;

            // }
            //$whereBoleta = "boleta LIKE '2840140233%'";  // ojo truco con esto 20211126 2840140233 - srg8392
            //$whereBoleta = "boleta LIKE '2840123898%'";  // ojo truco con esto 20211126 2840140233 - srg8392    
            $whereBoleta = "boleta LIKE '2840148946%'";  // ojo truco con esto 20211126 2840140233 - RG41067 fecinf 20211209     
            $Conceptos = [];

            $queryMultas = DB::connection('sqlsrv')
                ->table('transidencinf')
                ->whereIn('placa', $placas)
                ->where('estatusmov', '=', '0')
                ->whereRaw($whereBoleta)
                ->get();
        //    dump("TransitoController procesaPago $queryMultas0");    
        //    dump($queryMultas);
            if (count($queryMultas) > 0) {
                foreach ($queryMultas as $rowMultas) {
                    $boleta = trim($rowMultas->boleta);
                    $iniBoleta = substr($boleta, 0, 3);

                    switch ($iniBoleta) {
                        case "281":
                            $conceptoTmp = "4107";
                            break;

                        case "284":
                            $conceptoTmp = "4108";
                            break;

                        default:
                            $conceptoTmp = "4110";
                            break;

                    }

                    if (!in_array($conceptoTmp, $Conceptos)) {
                        $Conceptos[] = $conceptoTmp;
                    }

                }

                foreach ($Conceptos as $Concepto)
                {


                    $queryConcepto = DB::connection('sqlsrv')
                        ->table('ingresmconceptos')
                        ->where('con', '=', $Concepto)
                        ->first();

                    if ($queryConcepto) {
                        $ctaimporte = trim($queryConcepto->ctaimporte);
                        $ctarecargo = trim($queryConcepto->ctarecargo);
                        $ctasancion = trim($queryConcepto->ctasancion);
                        $ctagastos = trim($queryConcepto->ctagastos);
                        $ctaotros = trim($queryConcepto->ctaotros);
                        $centro = trim($queryConcepto->centro);
                    }

                    switch ($Concepto) {
                        case '4107':
                            $iniBoleta = "281";
                            $whereIniBoleta = "a.boleta LIKE '$iniBoleta%'";
                            break;
                        case '4108':
                            $iniBoleta = "284";
                            $whereIniBoleta = "a.boleta LIKE '$iniBoleta%'";
                            break;
                        default:
                            $iniBoleta = "NOT IN";
                            $whereIniBoleta = "SUBSTRING(a.boleta, 1, 3) NOT IN ('281', '284')";
                            break;
                    }


                    $queryDetalles = DB::connection('sqlsrv')
                        ->table('transiddetinf as a')
                        ->whereIn('a.placa', $placas)
                        ->where('a.estatusmov', '=', '0')
                        ->whereRaw($whereIniBoleta)
                        ->orderByRaw('a.placa, a.mun, a.boleta')
                        ->selectRaw('a.placa, a.boleta, a.estatusmov, a.mun, a.fechamov, a.horamov, a.clave, a.monto, a.mov')
                        ->get();

                    $MontoBoleta = [];
                    $MontoBoletaTotal = [];
                    $MontoBoletaDescuento = [];
                    $tipoDescuentoBoleta = [];
                    $Boletas = [];
                    $MunBoleta = [];
                    foreach ($queryDetalles as $rowDetalles) {

                        $multaInfo = DB::connection('sqlsrv')
                            ->table('transidencinf')
                            ->where('placa', '=', trim($rowDetalles->placa))
                            ->where('boleta', '=', trim($rowDetalles->boleta))
                            ->first();

                        if($multaInfo)
                        {
                            $fechaInfraccion = $multaInfo->fecinf;
                        } else {
                            $fechaInfraccion = $rowDetalles->fechamov;
                        }


                        $Monto = $rowDetalles->monto;
                        dump("TransitoController->TransitoModel getDescuentoDetalle >>>>>>>>>>>>>>>");
                        $descuentoA = TransitoModel::getDescuentoDetalle($rowDetalles->mun, $rowDetalles->clave, $fechaInfraccion);
                        $descuento = $descuentoA["descuento"];
                        dump("descuentoA");
                        dump($descuentoA); 
                        dump("descuento retornado");
                        dump($descuento);
                        dump("monto");
                        dump($rowDetalles->monto);



                        // 20211126  
                        if ($descuento > 0  && date("Y-m-d") <= date("Y-m-d", strtotime(env('DESCUENTO_FECHA')))) {

                            $descuento = $descuento + 5;
                
                        } 




                        $MontoDescuento = round($rowDetalles->monto * ($descuento / 100), 2);
                        dump("MontoDescuento<<<<<<<<<<<<<<<<<<");
                        dump($MontoDescuento);
                        $boleta = trim($rowDetalles->boleta);
                        if (!in_array($boleta, $Boletas)) {
                            $Boletas[] = $boleta;
                        }
                        if (!isset($MontoBoleta[$boleta])) {
                            $MontoBoleta[$boleta] = $Monto;
                            $MontoBoletaDescuento[$boleta] = $MontoDescuento;
                            $MontoBoletaTotal[$boleta] = $Monto - $MontoDescuento;
                            $tipoDescuentoBoleta[$boleta] = $descuentoA["tipoDesc"];
                        } else {
                            $MontoBoleta[$boleta] += $Monto;
                            $MontoBoletaDescuento[$boleta] += $MontoDescuento;
                            $MontoBoletaTotal[$boleta] += ($Monto - $MontoDescuento);
                            $tipoDescuentoBoleta[$boleta] = $descuentoA["tipoDesc"];
                        }

                        $queryMunicipio = DB::connection('sqlsrv')
                            ->table('transimmunicipios')
                            ->where('mun', '=', trim($rowDetalles->mun))
                            ->first();

                        if(!isset($MunBoleta[$boleta])){
                            $MunBoleta[$boleta] = $queryMunicipio;
                        }

                        $descuentosMovs[] = [
                            "placa" => trim($rowDetalles->placa),
                            "boleta" => trim($rowDetalles->boleta),
                            "mov" => trim($rowDetalles->mov),
                            "descuento" => $MontoDescuento,
                            "tipoDescuento" => $descuentoA["tipoDesc"]
                        ];

                    }
                    dump("Boletas");
                    dump($Boletas);
                    foreach ($Boletas as $Bol) {
                        if (@$MontoBoleta[$Bol] != "") {
                             dump("tipoDescuentoBoleta 202112092021120920211209202112092021120920211209");
                             dump($tipoDescuentoBoleta[$boleta]);
                            $bonImporte = $MontoBoletaDescuento[$Bol];
                            $descPp = 0;
                            if(@$tipoDescuentoBoleta[$boleta] == "descpp")
                            {
                                $bonImporte = 0;
                                $descPp = $descPp + $MontoBoletaDescuento[$Bol];
                                $MontoBoletaDescuento[$Bol] = 0;
                            }
                            if(@$tipoDescuentoBoleta[$boleta] == "bonif") // 20220101 GARM Se incluyo el if 
                            {
                                $bonImporte = $bonImporte + + $MontoBoletaDescuento[$Bol];
                                $descPp = 0;
                               
                            }
                            dump("linea 347 pregunta por descuento de fecha ");
                            dump($tipoDescuentoBoleta[$boleta]);
                            dump($Bol);
                            dump($MontoBoleta[$Bol]);
                            dump($MontoBoletaTotal[$Bol]);
                            dump ($MontoBoletaDescuento[$Bol]);
                            dump ( date("Y-m-d", strtotime(env('DESCUENTO_FECHA'))));


                            // if($MontoBoletaDescuento[$Bol] > 0 && date("Y-m-d") <= date("Y-m-d", strtotime(env('DESCUENTO_FECHA'))))
                            // {
                            //     dump("===================================================");
                            //     dump("linea 350 pregunta por descuento de fecha ");
                            //    // $bonImporte = $bonImporte + round(($MontoBoletaTotal[$Bol] * ((int)env('DESCUENTO_MULTAS')/100)),2);
                            //    // $MontoBoletaTotal[$Bol] = $MontoBoletaTotal[$Bol] - round(($MontoBoletaTotal[$Bol] * ((int)env('DESCUENTO_MULTAS')/100)),2);
                            //    //$bonImporte = $bonImporte + round(($MontoBoletaTotal[$Bol] * (((int)env('DESCUENTO_MULTAS')/100) + .05)),2); //05072021 13:50
                            //    //  $MontoBoletaTotal[$Bol] = $MontoBoletaTotal[$Bol] - round(($MontoBoletaTotal[$Bol] * (((int)env('DESCUENTO_MULTAS')/100) + .05)),2); //05072021 13:50
                            //     dump("descuento en linea bonImporte 0");
                            //     dump($bonImporte); 
                            //     //$bonImporte = $bonImporte + ($MontoBoletaTotal[$Bol] * (((int)env('DESCUENTO_MULTAS')/100) + .0)); //20072021 10:04
                            //     $bonImporte = $bonImporte + ($MontoBoleta[$Bol] * (((int)env('DESCUENTO_MULTAS')/100) + .0)); //20211123 12:54
                            //      dump("descuento en linea bonImporte 1");
                            //      dump($bonImporte);   
                            //      dump($MontoBoletaTotal[$Bol]);
                            //      $pasito = (((int)env('DESCUENTO_MULTAS')/100) + .00);          
                            //      dump("pasito");   
                            //      dump($pasito);   
                              
                            //     $MontoBoletaTotal[$Bol] = $MontoBoletaTotal[$Bol] - ($MontoBoletaTotal[$Bol] * (((int)env('DESCUENTO_MULTAS')/100) + .0)); //20072021 10:04

                            //     //$bonImporte = $bonImporte + $MontoBoletaDescuento[$Bol];
                            //     //$bonImporte = $bonImporte + $MontoBoletaDescuento[$Bol];
                                
                            //     dump("descuento en linea bonImporte 2");
                            //     dump($bonImporte); 
                            //     dump("===================================================");  
                            // }


                            dump("===================================================");
                            dump("linea 350 pregunta por descuento de fecha ");
                            dump("descuento en linea bonImporte 0");
                            dump($bonImporte); 
                             dump("descuento en linea bonImporte 1");
                             dump($bonImporte);   
                             dump($MontoBoletaTotal[$Bol]);
                             $pasito = (((int)env('DESCUENTO_MULTAS')/100) + .00);          
                             dump("pasito");   
                             dump($pasito);   
                          
                                                        
                            dump("descuento en linea bonImporte 2");
                            dump($bonImporte); 
                            dump("===================================================");  





                            
                           // $bonImporte =  round (($MontoBoletaTotal[$Bol] *  ((int)env('DESCUENTO_MULTAS')/100) + .05),2) ; //30062021 11:57 AM
                           // $MontoBoletaTotal[$Bol] = $MontoBoletaTotal[$Bol] - $bonImporte;//30062021 11:57 AM  // 05072021 13:50
                            
                             $MontoBoletaTotal[$Bol] = round($MontoBoletaTotal[$Bol],2); //20072021 10:04
                             $bonImporte = round($bonImporte,2);                         //20072021 10:04
                             dump("round bonImporte 3");
                             dump($bonImporte); 
                             dump($MontoDescuento);
                            
                            $datosIngreso = [];
                            $datosIngreso["fecha"] = date("Ymd", strtotime($fechaHoy));
                            $datosIngreso["recibo"] = $Folio;
                            $datosIngreso["caja"] = $caja;
                            $datosIngreso["nombre"] = "PAGO EN LINEA PLACA " . $placa; // Nombre del que paga
                            $datosIngreso["direccion"] = ".-"; // Direccion del que paga
                            $datosIngreso["ciudad"] = ".-"; // Ciudad del que paga
                            $datosIngreso["concepto_1"] = $DescripcionConcepto;
                            $datosIngreso["concepto_2"] = "";
                            $datosIngreso["concepto_3"] = "";
                            $datosIngreso["concepto_4"] = "";
                            $datosIngreso["ctaimporte"] = $ctaimporte;
                            $datosIngreso["importe"] = $MontoBoleta[$Bol];
                            //  $datosIngreso["bonimporte"] = $bonImporte;
                            // $datosIngreso["bonimporte"] = $MontoDescuento; //20211202 garm
                             $datosIngreso["bonimporte"] = $MontoBoletaDescuento[$Bol]; //20211202 garm
                            $datosIngreso["ctarecargo"] = $ctarecargo;
                            $datosIngreso["recargos"] = 0;
                            $datosIngreso["bonrecargo"] = 0;
                            $datosIngreso["ctasancion"] = $ctasancion;
                            $datosIngreso["sanciones"] = 0;
                            $datosIngreso["bonsancion"] = 0;
                            $datosIngreso["ctagastos"] = $ctagastos;
                            $datosIngreso["gastos"] = 0;
                            $datosIngreso["bongastos"] = 0;
                            $datosIngreso["ctaotros"] = $ctaotros;
                            $datosIngreso["otros"] = 0;
                            $datosIngreso["bonotros"] = 0;
                            $datosIngreso["fun"] = @$MunBoleta[$Bol]->fun;
                            $datosIngreso["estatusmov"] = "00";
                            $datosIngreso["tipo"] = "TR";
                            $datosIngreso["centro"] = $centro;
                            $datosIngreso["descpp"] = $descPp;
                            $datosIngreso["con"] = $Concepto;
                            $datosIngreso["referencia"] = $placa;
                            $datosIngreso["numtc"] = $val_9;
                            $datosIngreso["imptc"] = $MontoBoletaTotal[$Bol];
                            $datosIngreso["refban"] = $n_autoriz;

                            dump($datosIngreso);
                            //die();

                            // DB::connection('sqlsrv')   20211122
                            //     ->table('ingresdingresos')
                            //     ->insert($datosIngreso);


                            if(@$MunBoleta[$Bol]->fun != "") {
                                $queryIngresFun = DB::connection('sqlsrv')
                                    ->table('ingresmfun')
                                    ->where('FUN', '=', @$MunBoleta[$Bol]->fun)
                                    ->first();
                                if($queryIngresFun)
                                {
                                    $rowIngresFun = (array)$queryIngresFun;
                                    $mes = date("n", strtotime($fechaHoy));
                                    $campo = "boniacum_".$mes;
                                    $datosIngresFun = [
                                        $campo => $rowIngresFun[$campo] + $MontoBoletaDescuento[$Bol]
                                    ];


                                    // DB::connection('sqlsrv')
                                    //     ->table('ingresmfun')
                                    //     ->where('FUN', '=', @$MunBoleta[$Bol]->fun)
                                    //     ->update($datosIngresFun);


                                }
                            }

                            $MontoBoletaDescuento[$Bol] = 0; // garm 20211221

                        }

                    }

                }

                $datosTransiDetInf = [
                    "estatusmov" => 1,
                    "recibo" => $Folio,
                    "fpago" => date("Ymd", strtotime($fechaHoy)),
                    "munpaga" => 28
                ];

                //die();

                // DB::connection('sqlsrv')
                //     ->table('transidencinf')
                //     ->whereIn('placa', $placas)
                //     ->whereIn('boleta', $Boletas)
                //     ->where('estatusmov', '=', 0)
                //     ->update($datosTransiDetInf);

                // DB::connection('sqlsrv')
                //     ->table('transiddetinf')
                //     ->whereIn('placa', $placas)
                //     ->whereIn('boleta', $Boletas)
                //     ->where('estatusmov', '=', 0)
                //     ->update($datosTransiDetInf);

                // DB::connection('multrannl')
                //     ->table('transidencinf')
                //     ->whereIn('placa', $placas)
                //     ->whereIn('boleta', $Boletas)
                //     ->where('estatusmov', '=', 0)
                //     ->update($datosTransiDetInf);

                // DB::connection('multrannl')
                //     ->table('transiddetinf')
                //     ->whereIn('placa', $placas)
                //     ->whereIn('boleta', $Boletas)
                //     ->where('estatusmov', '=', 0)
                //     ->update($datosTransiDetInf);


                /*
                 * $descuentosMovs[] = [
                            "placa" => trim($rowDetalles->placa),
                            "boleta" => trim($rowDetalles->boleta),
                            "mov" => trim($rowDetalles->mov),
                            "descuento" => $MontoDescuento
                        ];
                 */

                foreach ($descuentosMovs as $dm)
                {
                    dump($dm);

                                        
                    $datosUpdateBonif = [$dm["tipoDescuento"] => $dm["descuento"]];
                   
                    dump("datosUpdateBonif");
                    dump($datosUpdateBonif);

                    // DB::connection('sqlsrv')
                    //     ->table('transiddetinf')
                    //     ->where('placa', $dm["placa"])
                    //     ->where('boleta', $dm["boleta"])
                    //     ->where('mov', $dm["mov"])
                    //     ->update($datosUpdateBonif);

                    // DB::connection('multrannl')
                    //     ->table('transiddetinf')
                    //     ->where('placa', $dm["placa"])
                    //     ->where('boleta', $dm["boleta"])
                    //     ->where('mov', $dm["mov"])
                    //     ->update($datosUpdateBonif);
                }


            }

        }

        $data = [
            "fechaHoy" => $fechaHoy,
            "Folio" => $Folio,
            "Caja" => $caja,
            "DescripcionConcepto" => $DescripcionConcepto,
            "Importe" => $t_importe,
            "Placa" => $placa,
            "OperacionBancaria" => $n_autoriz
        ];

        return view('transito', $data);

    }
}