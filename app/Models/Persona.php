<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['created_at','updated_at','deleted_at','fecha_nacimiento'];
    protected $appends = ['fullname'];

    public function getFullnameAttribute(){
        return implode(", ",[ implode(" ",[$this->paterno,$this->materno]) , $this->nombre]); 
    }

    public function estado_civil() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'estado_civil_id')
            ->withDefault('name','');
    }

    public function sexo() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'sexo_id')
            ->withDefault('name','');
    }

    public function persona_seguros() {
        return $this->hasMany('App\Models\SeguroPersona','persona_id', 'id');
    }

}
