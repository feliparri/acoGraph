<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    //public $timestamps = false;
    //const CREATED_AT = 'last_login';
    //const UPDATED_AT = 'last_login';
}
