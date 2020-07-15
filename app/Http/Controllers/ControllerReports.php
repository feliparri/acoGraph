<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReports extends Controller
{
    public function getResumenLote(){
        $lote = \App\VResumenLote::paginate(15);
        return response()->json($lote);
    }
}
