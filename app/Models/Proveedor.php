<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use SoftDeletes;
    protected $table = "proveedores";
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function giro_proveedor() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'giro_proveedor_id')
            ->withDefault('name','');
    }

    public function estatus() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'estatus_id')
            ->withDefault('name','');
    }

}
