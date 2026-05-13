<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cotizacion extends Model
{
    use SoftDeletes;
    protected $table = "cotizaciones";
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function proveedor() {
        return $this->hasOne('App\Models\Proveedor', 'id', 'proveedor_id');
    }

    public function instalacion() {
        return $this->hasOne('App\Models\Instalacion', 'id', 'instalacion_id');
    }

    public function seleccionada() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'seleccionada_id')
                    ->withDefault(['name'=>'']);
    }

    
}
