<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obras extends Model  
{

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql_obras';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'obras';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['estado', 'nro', 'inicio', 'termino', 'programa', 'real', 'desvio'];

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
