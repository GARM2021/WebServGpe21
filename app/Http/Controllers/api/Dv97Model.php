<?php

namespace App\Http\Controllers\api;

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

        
        $suma += $amonto[17]  * 11;
        $suma += $amonto[16]  * 13;
        $suma += $amonto[15]  * 17;
        $suma += $amonto[14]  * 19;
        $suma += $amonto[13]  * 23;
        $suma += $amonto[12]  * 11;
        $suma += $amonto[11]  * 13;
        $suma += $amonto[10]  * 17;
        $suma += $amonto[9]  * 19;
        $suma += $amonto[8]  *  23;
        $suma += $amonto[7]  * 11;
        $suma += $amonto[6]  * 13;
        $suma += $amonto[5]  * 17;
        $suma += $amonto[4]  * 19;
        $suma += $amonto[3]  *  23;
        $suma += $amonto[2]  * 11;
        $suma += $amonto[1]  *  13;
        $suma += $amonto[0]  * 17;

        $resto  = ($suma % 97) + 1;

        return $resto;
    }
}
