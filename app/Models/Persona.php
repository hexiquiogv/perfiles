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

    public function empresa() {
        return $this->hasOne('App\Models\Catalogo', 'id','empresa_id')
            ->withDefault('name','');
    }

    public function sucursal() {
        return $this->hasOne('App\Models\Catalogo', 'id','sucursal_id')
            ->withDefault('name','');
    }

    public function area() {
        return $this->hasOne('App\Models\Catalogo', 'id','area_id')
            ->withDefault('name','');
    }

    public function puesto() {
        return $this->hasOne('App\Models\Catalogo', 'id','puesto_id')
            ->withDefault('name','');
    }

    public function tipo_sangre() {
        return $this->hasOne('App\Models\Catalogo', 'id','tipo_sangre_id')
            ->withDefault('name','');
    }

}
