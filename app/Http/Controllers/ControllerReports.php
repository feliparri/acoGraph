<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReports extends Controller
{
    public function getResumenLote(Request $request){
        $lote = \App\VResumenLote::orderBy($request->sortBy==null?'tipo_Mov':$request->sortBy, $request->descending==true?'desc':'asc')->paginate($request->rowsPerPage, ['*'], 'page', $request->page);
        return response()->json($lote);
    }
}
