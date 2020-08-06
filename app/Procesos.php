<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procesos extends Model  
{

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql_datos';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'procesos';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idproceso', 'idTurno', 'temporada', 'cod_planta', 'fecha', 'semana', 'estado', 'linea', 'tipo', 'turno', 'cod_especie', 'variedad', 'cod_exportador', 'frio', 'periodo_frio', 'activo', 'id_detalle', 'cod_packing', 'Lotes', 'Productor', 'codprod', 'informe', 'kilos', 'kilos_vaciado', 'Bins_vaciado', 'Bins_Prg.', 'k_exp', 'K_mercado', 'Exportador', 'Variedad Timbrada', 'cajas_exp', 'cajas_Nac', 'especie', 'COMERCIAL', 'DESECHO', 'PRECALIBRE', 'cliente', 'guias', 'fecha_cosecha', 'totes', 'huerto'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

}
