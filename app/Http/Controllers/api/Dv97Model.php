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
        dump($amonto);

        // $i = 18;

        // // $i = $i--;
        // $i = $i--;

        // dump("i iiiiiiiiiiiiiiiiiiiiiiiiii");
        // dump($i);

        // $i = $i--;

        // dump("i iiiiiiiiiiiiiiiiiiiiiiiiii");
        // dump($i);

         
        
        for ($i = 16 ; $i  > 0 ; --$i) { 

            dump($i);

            dump ($amonto[$i]);
            
            
            $suma += $amonto[15]  * 11;
            $suma += $amonto[14]  * 13;
            $suma += $amonto[13]  * 17;
            $suma += $amonto[12]  * 19;
            $suma += $amonto[11]  * 23;
            $suma += $amonto[10]  * 11;
            $suma += $amonto[9]  * 13;
            $suma += $amonto[8]  *  17;
            $suma += $amonto[7]  * 19;
            $suma += $amonto[6]  * 23;
            $suma += $amonto[5]  * 11;
            $suma += $amonto[4]  * 13;
            $suma += $amonto[3]  * 17;
            $suma += $amonto[2]  * 19;
            $suma += $amonto[1]  * 23;
            $suma += $amonto[0]  * 11;

             dump($suma);
 
        }
       
        dump($suma);

        $resto  = ($suma % 97) + 1 ;

        

       return $resto;
    }
    
    
}
