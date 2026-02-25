<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function tipo_vehiculo() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'tipo_vehiculo_id')
            ->withDefault('name','');
    }

    public function marca() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'marca_id')
            ->withDefault('name','');
    }

    public function linea() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'linea_id')
            ->withDefault('name','');
    }

    public function sucursal() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'sucursal_id')
            ->withDefault('name','');
    }

    public function area() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'area_id')
            ->withDefault('name','');
    }

    public function chofer() {
        return $this->hasOne('App\Models\Persona', 'id', 'chofer_id')
            ->withDefault('name','');
    }

}
