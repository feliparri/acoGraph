<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReports extends Controller
{
    public function getResumenLote(Request $request){
        // return isset($request->filter['from']);
        $lote = \App\VResumenLote::orderBy($request->sortBy==null?'tipo_Mov':$request->sortBy, $request->descending==true?'desc':'asc');
        $lote = $lote->selectRaw('tipo_Mov as "TIPO MOV", Lote AS "LOTE", Huerto AS "HUERTO", k_pesados as "KILO RECIBIDOS", u_pesadas as "BINS RECEPCION", k_disp as "KILOS INVENTARIO", u_disp as "BINS INVENTARIO", productor AS "PRODUCTOR", variedad AS "VARIEDAD", env_secundario as "TOTES RECEPCION", peso_neto as "PESO NETO", fecha_cosecha as "FEC COSECHA", fecha as "FEC RECEPCION", k_Vaciado as "KILOS VACIADOS", u_Vaciado as "BINS VACIADOS", Nombre as "TIPO_ENVASE", productor AS "PRODUCTOR", exportador AS "EXPORTADOR", especie AS "ESPECIE"');
        if(isset($request->filter['from'])){
            $lote = $lote->where('fecha','>', $request->filter['from']);
        }
        if(isset($request->filter['to'])){
            $lote = $lote->where('fecha','<', $request->filter['to']);
        }
        if(isset($request->filter['filterOne'])){
            if($request->filter['filterOne']=='PRODUCTOR'){
                if($request->filter['filterTwo']!='todo'){
                    $lote = $lote->where('productor','like', '%'.$request->filter['filterTwo'].'%');
                }
            }
            if($request->filter['filterOne']=='VARIEDAD'){
                if(isset($request->filter['filterTwo'])){
                    $lote = $lote->where('variedad','like', '%'.$request->filter['filterTwo'].'%');
                }
            }
            
            //$lote = $lote->where('fecha','>', $request->filter['from']);
        }
        

        return response()->json($lote->paginate($request->rowsPerPage, ['*'], 'page', $request->page));
    }

    public function getVariedades(Request $request){
        // return isset($request->filter['from']);
        $lote = \App\VResumenLote::groupBy('variedad')
        ->selectRaw('distinct variedad ')
        ->get();

        if(isset($request->filter['from'])){
            $lote = $lote->where('fecha','>', $request->filter['from']);
        }
        if(isset($request->filter['to'])){
            $lote = $lote->where('fecha','<', $request->filter['to']);
        }

        return response()->json($lote);
    }

    public function getProductores(Request $request){
        // return isset($request->filter['from']);
        $lote = \App\VResumenLote::groupBy('productor')
        ->selectRaw('distinct productor')
        ->get();

        if(isset($request->filter['from'])){
            $lote = $lote->where('fecha','>', $request->filter['from']);
        }
        if(isset($request->filter['to'])){
            $lote = $lote->where('fecha','<', $request->filter['to']);
        }

        return response()->json($lote);
    }

    public function getPieChartDataByCodVariedadInvGrpProductor(Request $request){
        //return $request['filterOne'];
        $lote = \App\VResumenLote::groupBy(['productor','variedad'])
        ->selectRaw('variedad, productor,  sum(k_disp) as "KILOS_INVENTARIO"');
        
        if(isset($request['from'])){
            $lote = $lote->where('fecha','>', $request['from']);
        }
        if(isset($request['to'])){
            $lote = $lote->where('fecha','<', $request['to']);
        }
        if(isset($request['filterOne'])){
            if($request['filterOne']=='PRODUCTOR'){
                if($request['filterTwo']!='todo'){
                    $lote = $lote->where('productor','like', '%'.$request['filterTwo'].'%');
                }
            }
            if($request['filterOne']=='VARIEDAD'){
                if(isset($request['filterTwo'])){
                    $lote = $lote->where('variedad','like', '%'.$request['filterTwo'].'%');
                }
            }
        }

        return response()->json($lote->get());
    }

    public function getPieChartDataByCodVariedadGrpProductor(Request $request){
        //return $request['filterOne'];
        $lote = \App\VResumenLote::groupBy(['productor','variedad'])
        ->selectRaw('variedad, productor, sum(k_pesados) as "KILOS_RECEPCIONADOS"');
        
        if(isset($request['from'])){
            $lote = $lote->where('fecha','>', $request['from']);
        }
        if(isset($request['to'])){
            $lote = $lote->where('fecha','<', $request['to']);
        }
        if(isset($request['filterOne'])){
            if($request['filterOne']=='PRODUCTOR'){
                if($request['filterTwo']!='todo'){
                    $lote = $lote->where('productor','like', '%'.$request['filterTwo'].'%');
                }
            }
            if($request['filterOne']=='VARIEDAD'){
                if(isset($request['filterTwo'])){
                    $lote = $lote->where('variedad','like', '%'.$request['filterTwo'].'%');
                }
            }
        }

        return response()->json($lote->get());
    }

    public function getPieChartDataByCodVariedadInv(Request $request){
        //return $request['filterOne'];
        $lote = \App\VResumenLote::groupBy('variedad')
        ->selectRaw('variedad AS VARIEDAD, sum(k_disp) as "KILOS_INVENTARIO"');
        
        if(isset($request['from'])){
            $lote = $lote->where('fecha','>', $request['from']);
        }
        if(isset($request['to'])){
            $lote = $lote->where('fecha','<', $request['to']);
        }
        if(isset($request['filterOne'])){
            if($request['filterOne']=='PRODUCTOR'){
                if($request['filterTwo']!='todo'){
                    $lote = $lote->where('productor','like', '%'.$request['filterTwo'].'%');
                }
            }
            if($request['filterOne']=='VARIEDAD'){
                if(isset($request['filterTwo'])){
                    $lote = $lote->where('variedad','like', '%'.$request['filterTwo'].'%');
                }
            }
        }

        return response()->json($lote->get());
    }

    public function getPieChartDataByCodVariedad(Request $request){
        //return $request['filterOne'];
        $lote = \App\VResumenLote::groupBy('variedad')
        ->selectRaw('variedad AS VARIEDAD, sum(k_pesados) as "KILOS_RECEPCIONADOS"');
        
        if(isset($request['from'])){
            $lote = $lote->where('fecha','>', $request['from']);
        }
        if(isset($request['to'])){
            $lote = $lote->where('fecha','<', $request['to']);
        }
        if(isset($request['filterOne'])){
            if($request['filterOne']=='PRODUCTOR'){
                if($request['filterTwo']!='todo'){
                    $lote = $lote->where('productor','like', '%'.$request['filterTwo'].'%');
                }
            }
            if($request['filterOne']=='VARIEDAD'){
                if(isset($request['filterTwo'])){
                    $lote = $lote->where('variedad','like', '%'.$request['filterTwo'].'%');
                }
            }
        }

        return response()->json($lote->get());
    }

    public function getPieChartDataByPesoMes(Request $request){
        //return $request['filterOne'];
        $lote = \App\VResumenLote::groupBy('productor')
        ->selectRaw('productor AS PRODUCTOR, sum(k_pesados) as "KILOS_RECEPCIONADOS", SUM(k_disp) AS "KILOS_INVENTARIO"');
        
        #select sum(peso_neto), MONTH(fecha_cosecha) from v_resumen_lote vrl group by MONTH(fecha_cosecha) order by MONTH(fecha_cosecha) asc
        if(isset($request['from'])){
            $lote = $lote->where('fecha','>', $request['from']);
        }
        if(isset($request['to'])){
            $lote = $lote->where('fecha','<', $request['to']);
        }
        if(isset($request['filterOne'])){
            if($request['filterOne']=='PRODUCTOR'){
                if($request['filterTwo']!='todo'){
                    $lote = $lote->where('productor','like', '%'.$request['filterTwo'].'%');
                }
            }
            if($request['filterOne']=='VARIEDAD'){
                if(isset($request['filterTwo'])){
                    $lote = $lote->where('variedad','like', '%'.$request['filterTwo'].'%');
                }
            }
            
            //$lote = $lote->where('fecha','>', $request->filter['from']);
        }

        return response()->json($lote->get());
    }
    /*public function getDataCosolidadoProcesosByFilters(Request $request){
        // return isset($request->filter['from']);
        $lote = \App\VResumenLote::orderBy('fecha')
        ->selectRaw('*')
        ->get();
        #select sum(peso_neto), MONTH(fecha_cosecha) from v_resumen_lote vrl group by MONTH(fecha_cosecha) order by MONTH(fecha_cosecha) asc
        if(isset($request->filter['from'])){
            $lote = $lote->where('fecha','>', $request->filter['from']);
        }
        if(isset($request->filter['to'])){
            $lote = $lote->where('fecha','<', $request->filter['to']);
        }
        $lote = $lote->where('tipo_Mov','like','REC. FRUTA GRANEL A PROCESO');

        return response()->json($lote);
    }*/

}
