<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UrbemController extends Controller
{
    var $statusCode = 200;
    var $content = array();
    var $dataBase = "gpe2019";

    public function __construct()
    {
        $this->content = array();
    }

    public function multas(Request $request)
    {
        $placa = $request->input('placa');
        $boleta = $request->input('boleta');
        $nombre = $request->input('nombre');

        $where = "";
        if ($boleta == "" && $placa == "" && $nombre == "") {
            $this->content['result'] = [];
            return response()->json($this->content, $this->statusCode);
            die();
        }

        if ($placa != "") {
            $where = " AND a.placa LIKE '%$placa%' ";
        }

        if($nombre != "")
        {
            $whereNombreArray = [];
            $term_array = explode(" ", $nombre);
            foreach ($term_array as $filtro) {
                $whereNombreArray[] = " (
                    c.conductor like '%" . $filtro . "%'
                    ) ";
            }
            $where .= " AND " .implode(" AND ", $whereNombreArray);
        }

        if ($boleta != "") {
            $where .= "AND a.boleta LIKE '%$boleta%' ";
        }

        $sql = "SELECT a.placa, a.boleta, a.fecinf, a.nomcru as dirmulta, b.monto, c.conductor, d.descinf
                    FROM transidencinf a 
                    LEFT JOIN transiddetinf b ON a.placa = b.placa AND a.boleta = b.boleta
                    LEFT JOIN transidconductor c ON a.placa = c.placa AND a.boleta = c.boleta
                    LEFT JOIN transimcuotas d ON d.clave = b.clave
                    WHERE a.estatusmov = 0 $where 
                    ";
        //echo $sql;
        $query = DB::connection('sqlsrv')->select($sql);

        $result = array();
        foreach ($query as $row) {
            $obj = new \stdClass();
            $obj->placa = trim($row->placa);
            $obj->boleta = trim($row->boleta);
            $obj->fechainf = trim($row->fecinf);
            $obj->dirmulta = trim($row->dirmulta);
            $obj->conductor = trim($row->conductor);
            $obj->motivo = trim($row->descinf);
            $obj->monto = number_format(trim($row->monto), 2);

            $result[] = $obj;
        }

        $this->content['result'] = $result;
        $this->statusCode = 200;

        return response()->json($this->content, $this->statusCode);
    }

    public function predial(Request $request)
    {
        $expediente = trim($request->input('expediente'));
        $nombre = trim($request->input('nombre'));
        $direccion = trim($request->input('direccion'));

        if ($expediente == "" && $nombre == "" && $direccion == "") {
            $this->content['result'] = [];
            return response()->json($this->content, $this->statusCode);
            die();
        }

        $where = "";
        $top = "1";
        if ($expediente != "") {
            $top = "1";
            $where .= "[exp] = '$expediente'";
        } else {
            $top = "20";
            if ($nombre != "") {
                $whereNombreArray = [];
                $term_array = explode(" ", $nombre);
                foreach ($term_array as $filtro) {
                    $whereNombreArray[] = " (
                    ([nombre] + ' ' + [apat] + ' ' + [amat]) like '%" . $filtro . "%'
                    OR [nombre] LIKE '%" . $filtro . "%'
                    OR [apat] LIKE '%" . $filtro . "%'
                    OR [amat] LIKE '%" . $filtro . "%'
                    OR ([apat] + ' ' + [amat] + ' ' + [nombre]) like '%" . $filtro . "%')
                    ";
                }
                $where .= implode(" AND ", $whereNombreArray);
            }

            if ($direccion != "") {
                $whereDir = "";
                $whereDireccionArray = [];
                $term_array = explode(" ", $direccion);
                foreach ($term_array as $filtro) {
                    $whereDireccionArray[] = " (
                    ([domubi] + ' ' + [colubi]) like '%" . $filtro . "%'
                    OR [domubi] LIKE '%" . $filtro . "%'
                    OR [colubi] LIKE '%" . $filtro . "%')
                    ";
                }

                $whereDir = implode(" AND ", $whereDireccionArray);

                if ($where != "") {
                    $where .= " AND " . $whereDir;
                } else {
                    $where = $whereDir;
                }
            }
        }

        $sql = "SELECT TOP $top * FROM [$this->dataBase].[dbo].[preddexped] WHERE $where";
        ///echo $sql; die();
        $query = DB::connection('sqlsrv')->select($sql);
        $result = array();
        foreach ($query as $row) {
            $obj = new \stdClass();
            $obj->expediente = trim($row->exp);
            $obj->paterno = trim($row->apat);
            $obj->materno = trim($row->amat);
            $obj->nombre = trim($row->nombre);
            $obj->domubi = trim($row->domubi) . ' Col. ' . trim($row->colubi);
            $obj->colubi = trim($row->colubi);
            $obj->adeudo = CatastroModel::getAdeudoExpediente(trim($row->exp));

            $result[] = $obj;
        }

        $this->content['result'] = $result;
        return response()->json($this->content, $this->statusCode);
    }
}