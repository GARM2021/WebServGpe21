<?php
namespace App\Http\Controllers\api\DigitoVerificador;

use Illuminate\Database\Eloquent\Model;

class DVPaynet extends Model
{
    static public function generate($ref) {
        $suma = DVPaynet::sumAllCharacters($ref, FALSE);
        $mod = ($suma % 10);
        if ($mod == 0) {
            return 0;
        } else {
            return (10 - $mod);
        }
    }

    static function sumAllCharacters($ref, $hasVerificationDigit) {
        $suma = 0;
        $needsDoubleValue = !$hasVerificationDigit;
        for ($i = (strlen($ref) - 1); ($i >= 0); --$i) {
            //$valor = $this->getCharacterValue($ref->charAt($i));
            $valor = DVPaynet::getCharacterValue($ref{$i});
            $suma += DVPaynet::getValueToSum($valor, $needsDoubleValue);
            $needsDoubleValue = !$needsDoubleValue;
        }
        return $suma;
    }

    static function getValueToSum($valor, $doubleValue) {
        $sumando = (($doubleValue) ? (($valor * 2)) : $valor);
        if ($sumando > 9) {
            return ($sumando - 9);
        } else {
            return $sumando;
        }
    }

    static function getCharacterValue ($currChar) {
        if ($currChar >= '0' && $currChar <= '9') {
            return $currChar - '0';
        } else if ($currChar == 'A' || $currChar == 'J') {
            return 1;
        } else if ($currChar == 'B' || $currChar == 'K' || $currChar == 'S') {
            return 2;
        } else if ($currChar == 'C' || $currChar == 'L' || $currChar == 'T') {
            return 3;
        } else if ($currChar == 'D' || $currChar == 'M' || $currChar == 'U') {
            return 4;
        } else if ($currChar == 'E' || $currChar == 'N' || $currChar == 'V') {
            return 5;
        } else if ($currChar == 'F' || $currChar == 'O' || $currChar == 'W') {
            return 6;
        } else if ($currChar == 'G' || $currChar == 'P' || $currChar == 'X') {
            return 7;
        } else if ($currChar == 'H' || $currChar == 'Q' || $currChar == 'Y') {
            return 8;
        } else if ($currChar == 'I' || $currChar == 'R' || $currChar == 'Z') {
            return 9;
        } else {
            return 0;
        }
    }

    static function validate($ref) {
        $suma = DVPaynet::sumAllCharacters($ref, TRUE);
        return ((($suma % 10)) == 0);
    }
}