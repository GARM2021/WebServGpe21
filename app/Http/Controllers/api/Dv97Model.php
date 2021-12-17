<?php

namespace App\Http\Controllers\api;

use Barryvdh\Debugbar\Twig\Extension\Dump;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dv97Model extends Model
{
    static function fmonto97($monto)
    {
        dump("Dv97Model.fmonto97");
        $suma = 0;

        $amonto = str_split($monto);

        dump($amonto);



        $suma += $amonto[8]  * 7;
        $suma += $amonto[7]  * 3;
        $suma += $amonto[6]  * 1;
        $suma += $amonto[5]  * 7;
        $suma += $amonto[4]  * 3;
        $suma += $amonto[3]  * 1;
        $suma += $amonto[2]  * 7;
        $suma += $amonto[1]  * 3;
        $suma += $amonto[0]  * 1;



        $resto  = $suma % 10;



        return $resto;
    }

    static function fDV97($ref1)
    {
        $suma = 0;

        $amonto = str_split($ref1);

        dump("monto a calcular digito verificador");
        dump($amonto);

        
       
        $suma += $amonto[16]  * 11;
        $suma += $amonto[15]  * 13;
        $suma += $amonto[14]  * 17;
        $suma += $amonto[13]  * 19;
        $suma += $amonto[12]  * 23;
        $suma += $amonto[11]  * 11;
        $suma += $amonto[10]  * 13;
        $suma += $amonto[9]  * 17;
        $suma += $amonto[8]  *  19;
        $suma += $amonto[7]  * 23;
        $suma += $amonto[6]  * 11;
        $suma += $amonto[5]  * 13;
        $suma += $amonto[4]  * 17;
        $suma += $amonto[3]  *  19;
        $suma += $amonto[2]  * 23;
        $suma += $amonto[1]  *  11;
        $suma += $amonto[0]  * 13;

        dump($amonto[16]);
        dump($amonto[1]);
        dump($amonto[0]);

        $resto  = ($suma % 97) + 1;

        return $resto;
    }
}
