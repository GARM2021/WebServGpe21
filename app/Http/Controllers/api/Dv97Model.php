<?php

namespace App\Http\Controllers\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dv97Model extends Model
{
    static function fmonto97($monto){
        dump("Dv97Model.fmonto97");
        $suma = 0;

        $amonto = str_split($monto);
        
        for ($i=0; $i < 9 ; $i++) { 
            
            $suma += $amonto[$i]  * 7;
            $suma += $amonto[$i]  * 3;
            $suma += $amonto[$i]  * 1;
            $suma += $amonto[$i]  * 7;
            $suma += $amonto[$i]  * 3;
            $suma += $amonto[$i]  * 1;
            $suma += $amonto[$i]  * 7;
            $suma += $amonto[$i]  * 3;
            $suma += $amonto[$i]  * 1;
            
        }
       
        $resto  = $suma % 10;

      

       return $resto;

    }

    static function fDV97 ($ref1)
    {
        $suma = 0;

        $amonto = str_split($ref1);
        
        for ($i=0; $i < 17 ; $i++) { 
            
            $suma += $amonto[$i]  * 11;
            $suma += $amonto[$i]  * 13;
            $suma += $amonto[$i]  * 17;
            $suma += $amonto[$i]  * 19;
            $suma += $amonto[$i]  * 23;
            $suma += $amonto[$i]  * 11;
            $suma += $amonto[$i]  * 13;
            $suma += $amonto[$i]  * 17;
            $suma += $amonto[$i]  * 19;
            $suma += $amonto[$i]  * 23;
            $suma += $amonto[$i]  * 11;
            $suma += $amonto[$i]  * 13;
            $suma += $amonto[$i]  * 17;
            $suma += $amonto[$i]  * 19;
            $suma += $amonto[$i]  * 23;
            $suma += $amonto[$i]  * 11;
            $suma += $amonto[$i]  * 13;
 
        }
       
        $resto  = ($suma % 97) + 1 ;

        

       return $resto;
    }
    
    
}
