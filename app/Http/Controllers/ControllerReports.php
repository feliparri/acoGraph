<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReports extends Controller
{
    public function getResumenLote(Request $request){
        // return isset($request->filter['from']);
        $lote = \App\VResumenLote::orderBy($request->sortBy==null?'tipo_Mov':$request->sortBy, $request->descending==true?'desc':'asc');
        if(isset($request->filter['from'])){
            $lote = $lote->where('fecha','>', $request->filter['from']);
        }
        if(isset($request->filter['to'])){
            $lote = $lote->where('fecha','<', $request->filter['to']);
        }

        return response()->json($lote->paginate($request->rowsPerPage, ['*'], 'page', $request->page));
    }

    public function getPieChartData(Request $request){
        // return isset($request->filter['from']);
        $lote = \App\VResumenLote::groupBy('especie')
        ->selectRaw('especie, sum(peso_neto) as sum')
        ->get();

        if(isset($request->filter['from'])){
            $lote = $lote->where('fecha','>', $request->filter['from']);
        }
        if(isset($request->filter['to'])){
            $lote = $lote->where('fecha','<', $request->filter['to']);
        }

        return response()->json($lote);
    }

    public function getPieChartDataByCodVariedad(Request $request){
        // return isset($request->filter['from']);
        $lote = \App\VResumenLote::groupBy('cod_variedad')
        ->selectRaw('count(cod_variedad) as count, cod_variedad ')
        ->get();

        if(isset($request->filter['from'])){
            $lote = $lote->where('fecha','>', $request->filter['from']);
        }
        if(isset($request->filter['to'])){
            $lote = $lote->where('fecha','<', $request->filter['to']);
        }

        return response()->json($lote);
    }

    public function getPieChartDataByPesoMes(Request $request){
        // return isset($request->filter['from']);
        $lote = \App\VResumenLote::groupBy('mes')
        ->selectRaw('sum(peso_neto) as peso, MONTH(fecha_cosecha) mes')
        ->get();
        #select sum(peso_neto), MONTH(fecha_cosecha) from v_resumen_lote vrl group by MONTH(fecha_cosecha) order by MONTH(fecha_cosecha) asc
        if(isset($request->filter['from'])){
            $lote = $lote->where('fecha','>', $request->filter['from']);
        }
        if(isset($request->filter['to'])){
            $lote = $lote->where('fecha','<', $request->filter['to']);
        }

        return response()->json($lote);
    }

}
