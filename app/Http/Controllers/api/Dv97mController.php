<?php

namespace App\Http\Controllers\api;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dv97mController extends Controller
{
  function fpaso0()
  {

    // $cexp  = '01001012';
    // $monto = 4420.90;
    // $cfecha = '20220131';
      $cexp = '923548223051';
      $monto = '898353.95';
      $cfecha = '20220330';

   
    $monto = number_format($monto, 2);
    // dd($monto);
    $monto = str_replace(",", "", $monto);
    $armonto = explode(".", $monto);
    // dump($armonto);
    if (count($armonto) > 1) {

      // dump($armonto);
      $monto = $armonto[0] . str_pad($armonto[1], 2, "0", STR_PAD_RIGHT);
      // dump($monto);
    } else {
      $monto = $monto . ".00";
    }
    // dd($monto);
    //echo "<br>$monto";
    $monto = str_replace(".", "", $monto);
    $monto = str_pad($monto, 9, "0", STR_PAD_LEFT);

    

    $rexp =  str_pad($cexp, 11, "0", STR_PAD_LEFT);

    dump($rexp);

    $cyear = substr($cfecha, 0, 4);  // abcd
    $cmes  = substr($cfecha, 4, 2);
    $cdia  = substr($cfecha, 6, 2);

    

    $cfecha = (($cyear - 2013) * 372) + (($cmes - 1) * 31) + ($cdia - 1);
     
    $mfecha = str_pad($cfecha, 4, "0", STR_PAD_LEFT);

    dump($cyear);
    dump($cmes);
    dump($cdia);

    dump($rexp);
   
    dump($mfecha);
   

    dump($monto);

    $mmonto = Dv97Model::fmonto97($monto);

    dump($mmonto);

    $ref1 = $rexp . $mfecha . $mmonto . "8";

    dump($ref1);

    $digver97 = Dv97Model::fDV97($ref1);

    $ref1 = $ref1 . $digver97;


    dump($ref1);


  }
}
