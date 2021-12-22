<?php
namespace App\Http\Controllers\api\DigitoVerificador;

use Illuminate\Database\Eloquent\Model;

class DVOxxo extends Model
{
    static function generar_dv($codigo)
    {
        $suma = 0;
        $size = strlen($codigo) - 1;
        $factor = 2;
        for($c = $size; $c >= 0; $c--)
        {
            $prod = $codigo{$c} * $factor;
            if ($prod > 9)
            {
                $prod -= 9;
            }

            $suma += $prod;
            $factor = ($factor == 2) ? 1 : 2;
        }

        $mod = ($suma % 10);
        if ($mod == 0) {
            $dv = 0;
        } else {
            $dv = (10 - $mod);
        }

        return $dv;
    }
}