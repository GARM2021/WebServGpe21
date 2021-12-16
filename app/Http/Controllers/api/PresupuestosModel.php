<?php


namespace App\Http\Controllers\api;


use Illuminate\Support\Facades\DB;

class PresupuestosModel
{
    static function getImportarUsuario($usuario)
    {

        $sql = "SELECT usuario, nombre, area, depto FROM compramusuarios WHERE usuario = '$usuario'";
        $query = DB::connection('sqlsrv')->select(DB::raw($sql));
        if (count($query)  > 0)
        {
            $row = $query[0];
            $sql_info = "SELECT * FROM usuarios WHERE usuario = '".trim($row->usuario)."'";
            $query_info = DB::connection('presunl')->select(DB::raw($sql_info));

            if (count($query_info) <= 0)
            {


                $sql_secretaria = "SELECT * FROM secretarias WHERE clave = '".trim($row->area)."'";
                $query_secretaria = DB::connection('presunl')->select(DB::raw($sql_secretaria));
                $secretariaInfo = $query_secretaria[0];



                $sql_deparmento = "SELECT * FROM departamentos WHERE depto = '".trim($row->depto)."'";
                $query_deparmento = DB::connection('presunl')->select(DB::raw($sql_deparmento));
                $deparmentoInfo = $query_deparmento[0];

                $nuevo_id = DB::connection('presunl')->table('usuarios')->insertGetId(["nombre" => trim($row->nombre), "usuario" => trim($row->usuario), "perfil_id" => 2, "secretaria_id" => @$secretariaInfo->secretaria_id, "departamento_id" => @$secretariaInfo->departamento_id, "password" => ""]);
                $accesos = PresupuestosModel::getAccesosUsuarios($row->usuario);
                foreach ($accesos as $acceso) {


                    $sql_cuenta = "SELECT * FROM cuentas WHERE clave = '".trim($acceso->cuenta)."'";
                    $query_cuenta = DB::connection('presunl')->select(DB::raw($sql_cuenta));
                    $cuentaInfo = $query_cuenta[0];

                    $sql_subCuenta = "SELECT * FROM cuentas_sub WHERE clave = '".trim($acceso->ctascta)."'";
                    $query_subCuenta = DB::connection('presunl')->select(DB::raw($sql_subCuenta));
                    $subCuentaInfo = $query_subCuenta[0];

                    if (@$cuentaInfo->cuenta_id != "" && @$subCuentaInfo->cuenta_sub_id != "")
                    {
                        $dataPerm = array("usuario_id" => $nuevo_id, "cuenta_id" => $cuentaInfo->cuenta_id, "subcuenta_id" => $subCuentaInfo->cuenta_sub_id);

                        $sql_existe = "SELECT * FROM permisos WHERE usuario_id = $nuevo_id AND cuenta_id = ". $cuentaInfo->cuenta_id . " AND subcuenta_id = ". $subCuentaInfo->cuenta_sub_id;
                        $query_existe = DB::connection('presunl')->select(DB::raw($sql_existe));

                        if ($query_existe->num_rows() <= 0)
                        {
                            DB::connection('presunl')->table('usuarios')->insert($dataPerm);
                        }
                    }
                }

                return true;
            } else {

                $info = $query_info[0];

                $accesos = PresupuestosModel::getAccesosUsuarios($info->usuario);
                foreach ($accesos as $acceso) {
                    $sql_cuenta = "SELECT * FROM cuentas WHERE clave = '".trim($acceso->cuenta)."'";
                    $query_cuenta = DB::connection('presunl')->select(DB::raw($sql_cuenta));
                    $cuentaInfo = @$query_cuenta[0];

                    $sql_subCuenta = "SELECT * FROM cuentas_sub WHERE clave = '".trim($acceso->ctascta)."'";
                    $query_subCuenta = DB::connection('presunl')->select(DB::raw($sql_subCuenta));
                    $subCuentaInfo = @$query_subCuenta[0];

                    if (@$cuentaInfo->cuenta_id != "" && @$subCuentaInfo->cuenta_sub_id != "")
                    {
                        $dataPerm = array("usuario_id" => $info->usuario_id, "cuenta_id" => $cuentaInfo->cuenta_id, "subcuenta_id" => $subCuentaInfo->cuenta_sub_id);

                        $sql_existe = "SELECT * FROM permisos WHERE usuario_id = ".$info->usuario_id." AND cuenta_id = ". $cuentaInfo->cuenta_id . " AND subcuenta_id = ". $subCuentaInfo->cuenta_sub_id;
                        $query_existe = DB::connection('presunl')->select(DB::raw($sql_existe));

                        if (count($query_existe) <= 0)
                        {
                            DB::connection('presunl')->table('permisos')->insert($dataPerm);
                        }
                    }
                }
            }
        } else {
            return false;
        }
    }

    static function getAccesosUsuarios($usuario)
    {
        $sql = "SELECT usuario, cuenta, ctascta FROM compradusuctascta WHERE usuario = '$usuario'";
        $query = DB::connection('sqlsrv')->select(DB::raw($sql));
        return $query;
    }

    static function getCuentas()
    {

        $sql = "SELECT * FROM contabdcuentas WHERE cuenta = scta ORDER BY cuenta";
        $query = DB::connection('sqlsrv')->select(DB::raw($sql));
        return $query;
    }

    static function getSubCuentas($cuenta)
    {

        $sql = "SELECT * FROM contabdcuentas WHERE cuenta = '".trim($cuenta)."' AND cuenta <> scta ORDER BY cuenta";
        $query = DB::connection('sqlsrv')->select(DB::raw($sql));
        return $query;
    }
}