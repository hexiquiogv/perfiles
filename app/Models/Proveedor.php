<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use SoftDeletes;
    protected $table = "proveedores";
    protected $dates = ['created_at','updated_at','deleted_at'];


}
