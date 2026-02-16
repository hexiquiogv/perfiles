<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seguro extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['created_at','updated_at','deleted_at','fecha_emision','fecha_terminacion'];
    protected $appends = ['dias_vencimiento'];

    public function forma_pago() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'forma_pago_id')
            ->withDefault('name','');
    }

    public function clasificacion_plan() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'clasificacion_plan_id')
            ->withDefault('name','');
    }

    public function estatus() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'estatus_id')
            ->withDefault('name','');
    }

    public function tipo_seguro() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'tipo_seguro_id')
            ->withDefault('name','');
    }

    public function metodo_pago() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'metodo_pago_id')
            ->withDefault('name','');
    }

    public function nombre_plan() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'nombre_plan_id')
            ->withDefault('name','');
    }        

    public function contratante() {
        return $this->hasOne('App\Models\Persona', 'id', 'contratante_id')
            ->withDefault('fullname','');
    } 

    public function asegurado_principal() {
        return $this->hasOne('App\Models\Persona', 'id', 'asegurado_principal_id')
            ->withDefault('fullname','');
    }        

    public function getDiasVencimientoAttribute(){
        return 0; 
    }

    public function seguro_personas() {
        return $this->hasMany('App\Models\SeguroPersona','persona_id', 'id');
    }

}



    