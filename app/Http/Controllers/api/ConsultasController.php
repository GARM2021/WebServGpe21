<?php


namespace App\Http\Controllers\api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultasController
{

    var $statusCode = 200;
    var $content = array();

    function policias(Request $request) {
        $empleado = $request->input('empleado');
        $nombre = $request->input('nombre');
        $where = "";
        if($empleado != "")
        {
            $where = " AND numemp LIKE '%$empleado%' ";
        }

        if($nombre != "")
        {
            $whereNombreArray = [];
            $term_array = explode(" ", $nombre);
            foreach ($term_array as $filtro) {
                $whereNombreArray[] = " (
                    (e.nombre + ' ' + e.appat + ' ' + e.apmat) like '%" . $filtro . "%'
                    OR e.nombre LIKE '%" . $filtro . "%'
                    OR e.appat LIKE '%" . $filtro . "%'
                    OR e.apmat LIKE '%" . $filtro . "%'
                    OR (e.appat + ' ' + e.apmat + ' ' + e.nombre) like '%" . $filtro . "%')
                    ";
            }
            $where .= " AND ".implode(" AND ", $whereNombreArray);
        }

        if ($where != ""){
            $top = " TOP 50 ";
        } else {
            $top = "";
        }

        $sql = "SELECT $top e.numemp, e.nombre, e.appat, e.apmat, p.nompuesto
                FROM nom01dempleados e
                LEFT JOIN nom01mpuesto p ON e.puesto = p.puesto 
                WHERE e.estatus = '00' AND e.area = '0310' AND (e.depto = '0602' OR e.depto ='0603') $where
                ORDER BY e.nombre, e.appat, e.apmat";
        $query = DB::connection('sqlsrv')->select($sql);
        $result = array();
        foreach ($query as $row) {
            $obj = new \stdClass();
            $obj->empleado = trim($row->numemp);
            $obj->paterno = trim($row->appat);
            $obj->materno = trim($row->apmat);
            $obj->nombre = trim($row->nombre);
            $obj->puesto = trim($row->nompuesto);

            $result[] = $obj;
        }

        $this->content['result'] = $result;
        return response()->json($this->content, $this->statusCode);
    }
}