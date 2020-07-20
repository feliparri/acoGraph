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
}
