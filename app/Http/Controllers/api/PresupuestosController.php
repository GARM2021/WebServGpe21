<?php


namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PresupuestosController extends Controller
{
    function usuarios_actualizarcuentas() {
        header("access-control-allow-origin: *");
        $cid = @$_POST["cid"];
        if($cid == "")die("Prohibido");

        $sql = "SELECT * FROM usuarios WHERE md5(usuario_id)='$cid'";
        $query = DB::connection('presunl')->select(DB::raw($sql));
        if(count($query) <= 0){
            die("No se encontro la informaci贸n");
        } else {
            $info = $query[0];
        }


        PresupuestosModel::getImportarUsuario($info->usuario);
        die("OK");
    }

    public function actualizarcuentas()
    {
        header("access-control-allow-origin: *");
        $cuentas = PresupuestosModel::getCuentas();
        foreach ($cuentas as $cuenta) {
            $sql_cuenta = "SELECT * FROM cuentas WHERE clave = '".trim($cuenta->cuenta)."'";
            $query_cuenta = DB::connection('presunl')->select(DB::raw($sql_cuenta));
            if (count($query_cuenta) <= 0)
            {
                DB::connection('presunl')->table("cuentas")->insert(["clave" => trim($cuenta->cuenta), "cuenta" => trim($cuenta->nomcta)]);
            }
        }

        die("OK");

    }


    public function actualizarsubcuentas()
    {
        header("access-control-allow-origin: *");

        $sql_cuenta = "SELECT * FROM cuentas WHERE cuenta_id = '".@$_POST["cuenta"]."'";
        $cuentas2 = DB::connection('presunl')->select(DB::raw($sql_cuenta));
        foreach ($cuentas2 as $c2) {
            $subcuentas = PresupuestosModel::getSubCuentas($c2->clave);
            foreach ($subcuentas as $sb) {

                $sqlsubCuenta = "SELECT * FROM cuentas_sub WHERE clave = '".trim($sb->scta)."'";
                $querysubCuenta = DB::connection('presunl')->select(DB::raw($sqlsubCuenta));
                if (count($querysubCuenta) <= 0)
                {
                    DB::connection('presunl')->table('cuentas_sub')->insert(["cuenta_id" => $c2->cuenta_id, "clave" => trim($sb->scta), "subcuenta" => trim($sb->nomcta)]);
                }
            }
        }

        die("OK");
    }

}