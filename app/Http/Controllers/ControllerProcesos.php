<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ControllerProcesos extends Controller
{
    public function getResumenProcesos(Request $request){
        //return $request->filter['from'];
        $procesos = \App\Procesos::orderBy($request->sortBy==null?'fecha':$request->sortBy, $request->descending==true?'desc':'asc');
        //$procesos = $procesos->selectRaw('tipo_Mov as "TIPO MOV", Lote AS "LOTE", Huerto AS "HUERTO", k_pesados as "KILO RECIBIDOS", u_pesadas as "BINS RECEPCION", k_disp as "KILOS INVENTARIO", u_disp as "BINS INVENTARIO", productor AS "PRODUCTOR", variedad AS "VARIEDAD", env_secundario as "TOTES RECEPCION", peso_neto as "PESO NETO", fecha_cosecha as "FEC COSECHA", fecha as "FEC RECEPCION", k_Vaciado as "KILOS VACIADOS", u_Vaciado as "BINS VACIADOS", Nombre as "TIPO_ENVASE", productor AS "PRODUCTOR", exportador AS "EXPORTADOR", especie AS "ESPECIE"');
        if(isset($request->filter['from'])){
            $procesos = $procesos->where('fecha','>', $request->filter['from']);
        }
        if(isset($request->filter['to'])){
            $procesos = $procesos->where('fecha','<', $request->filter['to']);
        }
        if(isset($request->filter['filterOne'])){
            if($request->filter['filterOne']=='PRODUCTOR'){
                if($request->filter['filterTwo']!='todo'){
                    $procesos = $procesos->where('productor','like', '%'.$request->filter['filterTwo'].'%');
                }
            }
            if($request->filter['filterOne']=='VARIEDAD'){
                if(isset($request->filter['filterTwo'])){
                    $procesos = $procesos->where('Variedad Timbrada','like', '%'.$request->filter['filterTwo'].'%');
                }
            }
        }

        return response()->json($procesos->paginate($request->rowsPerPage, ['*'], 'page', $request->page));
    }

    public function getReporteProcesos(Request $request){
        //return $request->filter['from'];
        $arrProductor = array();
        $allArrProductor = array();
        if(isset($request['filterOne']) && $request['filterOne']!=null){
            if($request['filterOne']=='PRODUCTOR'){
                if($request['filterTwo']!='todo'){
                    $productor = $request['filterTwo'];
                    foreach($this->getProductoresAll($productor) as $value) {
                        array_push($arrProductor,[$value->productor=>array($this->getVariedadesAllByProductor($value->productor))]);
                    }
                }else{
                    foreach($this->getProductoresAll('todo') as $value) {
                        array_push($arrProductor,[$value->productor=>array($this->getVariedadesAllByProductor($value->productor))]);
                    }
                }
            }
            if($request['filterOne']=='VARIEDAD'){
                if(isset($request['filterTwo'])){
                    $variedad = $request['filterTwo'];
                    foreach($this->getProductoresAll('todo') as $value) {
                        array_push($arrProductor,[$value->productor=>array($this->getVariedadesAllByVariedad($value, $variedad))]);
                    }
                }
            }
        }else{
            foreach($this->getProductoresAll('todo') as $value) {
                array_push($arrProductor,[$value->productor=>array($this->getVariedadesAllByProductor($value->productor))]);
            }
        }

        
        return response()->json($arrProductor);
    }

    public function getChartProcesosRendimiento(){
        $variedades = $this->getVariedadesAll();
        $productores = $this->getProductoresAll('todo');
        $arrChart = [];
        foreach ($variedades as $key => $variedad) {
            $arrChartVariedad = [];
            foreach ($productores as $key => $productor) {
                array_push($arrChartVariedad, array($productor->productor, $this->getVariedadesAllByVariedad($productor, $variedad['Variedad Timbrada'])));
            }
            array_push($arrChart, array($variedad['Variedad Timbrada'], $arrChartVariedad));
        }
        
        return response()->json($arrChart);
    }

    private function getVariedadesAll(){
        // return isset($request->filter['from']);
        $lote = \App\Procesos::groupBy('Variedad Timbrada')
        ->selectRaw('distinct `Variedad Timbrada`')
        ->get();

        return $lote;
    }

    public function getVariedades(Request $request){
        // return isset($request->filter['from']);
        $lote = \App\Procesos::groupBy('variedad')
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
        $lote = \App\Procesos::groupBy('productor')
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

    private function getProductoresAll($productor){
        $lote = \App\Procesos::groupBy('productor')->selectRaw('distinct productor');
        if($productor!='todo'){
            $lote = $lote->where('productor','like','%'.$productor.'%');
        }
        $lote = $lote->get();
        return $lote;
    }
    private function getVariedadesAllByProductor($productor){
        $procesos = \App\Procesos::groupBy('Variedad Timbrada')
        ->selectRaw('`Variedad Timbrada` variedad, sum(kilos_vaciado) kilos_vac, sum(k_exp) kilos_exp, sum(K_mercado) kilos_merc,  sum(COMERCIAL) comercial, sum(DESECHO) desecho, sum(PRECALIBRE) precalibre, sum(cajas_exp) cajas_exp, sum(cajas_Nac) cajas_nac, sum(k_exp) / sum(kilos_vaciado) as rendimiento');
        if($productor != 'todo' && $productor!=null){
            $procesos->where('productor','like', '%'.$productor.'%');
        }
        $procesos = $procesos->get()->all();
        return $procesos;

        //rendicion promedio => k_exp / kilos_vaciados
    }

    private function getVariedadesAllByVariedad($productor, $variedad){
        //print($productor->productor);
        $procesos = \App\Procesos::groupBy('Variedad Timbrada')
        ->selectRaw('`Variedad Timbrada` variedad, sum(kilos_vaciado) kilos_vac, sum(k_exp) kilos_exp, sum(K_mercado) kilos_merc,  sum(COMERCIAL) comercial, sum(DESECHO) desecho, sum(PRECALIBRE) precalibre, sum(cajas_exp) cajas_exp, sum(cajas_Nac) cajas_nac, sum(k_exp) / sum(kilos_vaciado) as rendimiento');
        if($variedad != 'todo' && $variedad!=null){
            $procesos->where('Variedad Timbrada','like', '%'.$variedad.'%');
        }
        $procesos->where('productor','like', '%'.$productor->productor.'%');
        $procesos = $procesos->get()->all();
        return $procesos;
    }


    public function getPieChartDataByCodVariedadInv(Request $request){
        //return $request['filterOne'];
        $lote = \App\Procesos::groupBy('variedad')
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
            /*if($request['filterOne']=='VARIEDAD'){
                if(isset($request['filterTwo'])){
                    $lote = $lote->where('variedad','like', '%'.$request['filterTwo'].'%');
                }
            }*/
        }

        return response()->json($lote->get());
    }

    public function getPieChartDataByCodVariedad(Request $request){
        //return $request['filterOne'];
        $lote = \App\Procesos::groupBy('variedad')
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
            /*if($request['filterOne']=='VARIEDAD'){
                if(isset($request['filterTwo'])){
                    $lote = $lote->where('variedad','like', '%'.$request['filterTwo'].'%');
                }
            }*/
        }

        return response()->json($lote->get());
    }

    public function getPieChartDataByPesoMes(Request $request){
        //return $request['filterOne'];
        $lote = \App\Procesos::groupBy('productor')
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
        $lote = \App\Procesos::orderBy('fecha')
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
