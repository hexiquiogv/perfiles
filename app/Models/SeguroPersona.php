<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguroPersona extends Model
{
    protected $table = "seguro_persona";
    public $timestamps = false;

    public function seguros() {
        return $this->hasOne('App\Models\Seguro','id', 'seguro_id');
    }

    public function personas() {
        return $this->hasOne('App\Models\Persona','id', 'persona_id');
    }
}
