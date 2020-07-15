<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VResumenLote extends Model  
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
    protected $table = 'v_resumen_lote';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['tipo_Mov', 'Lote', 'cod_exportador', 'codprod', 'cod_variedad', 'cod_especie', 'nro_doc', 'envases', 'env_secundario', 'peso_neto', 'fecha_cosecha', 'cod_variedad_rotu', 'Huerto', 'cuartel', 'Observaciones', 'ESTADO', 'k_pesados', 'u_pesadas', 'k_Programa', 'u_Programa', 'k_Vaciado', 'u_Vaciado', 'k_disp', 'u_disp', 'Nombre', 'productor', 'exportador', 'especie', 'Tara', 'variedad', 'tara_sec', 'Env_sec', 'Temporada', 'fecha', 'semana', 'Doc_origen', 'Ingreso', 'chofer', 'patente', 'System_approach', 'cod_export', 'envases_sec', 'bulto_sec', 'idtipo_envase_sec', 'idtipo_envase', 'UM', 'autorizado', 'PDF', 'camara', 'Calle', 'cliente'];

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
    protected $dates = ['fecha_cosecha', 'fecha'];

}
