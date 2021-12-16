<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    function dbTest()
    {
        $row = DB::table("preddexped")->first();
        dd($row);
    }

    function testDesc()
    {
        $fechaInfaccion = date('Y-m-d', strtotime(20181101));
        $fechaHoy = date('Y-m-d');
        $date1 = new \DateTime($fechaInfaccion);
        $date2 = new \DateTime($fechaHoy);
        $diasDiferencia = abs($date1->diff($date2)->days);
        $flagVigencia1 = 0;
        $flagVigencia2 = 0;
        $flagVigencia3 = 0;

        $fechaVigencia1 = date("Y-m-d", strtotime(trim(20200131)));
        if ($fechaHoy <= $fechaVigencia1) {
            $porcentajeBonificacion = 30;
            $flagVigencia1 = 1;
        }

        $fechaVigencia2 = date("Y-m-d", strtotime(trim(20200229)));
        if ($fechaHoy <= $fechaVigencia2 && $flagVigencia1 == 0) {
            $porcentajeBonificacion = 20;
            $flagVigencia2 = 1;
        }

        $fechaVigencia3 = date("Y-m-d", strtotime(trim(20200331)));
        if ($fechaHoy <= $fechaVigencia3 && $flagVigencia1 == 0 && $flagVigencia2 == 0) {
            $porcentajeBonificacion = 10;
            $flagVigencia3 = 1;
        }

        $dias1 = 15;
        $dias2 = 0;
        $dias3 = 0;
        $flagDescuento1 = 0;
        $flagDescuento3 = 0;
        $flagDescuento2 = 0;
        $porcentajeDescuentoCuota = -1;


        if ($diasDiferencia <= $dias1) {
            $porcentajeDescuentoCuota = 50;
            $flagDescuento1 = 1;
        } else if ($diasDiferencia <= abs($dias2) && $flagDescuento1 == 0 && $flagDescuento3 == 0) {
            $flagDescuento2 = 1;
            $porcentajeDescuentoCuota = 0;
        } else if($diasDiferencia <= abs($dias3) && $flagDescuento1 == 0 && $flagDescuento2 == 0){
            $flagDescuento3 = 1;
            $porcentajeDescuentoCuota = 0;
        }
        echo $porcentajeBonificacion."---<br>";
        echo $porcentajeDescuentoCuota;
        die();
    }
}