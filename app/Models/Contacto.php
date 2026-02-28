<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacto extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function cliente() {
        return $this->hasOne('App\Models\Cliente', 'id', 'cliente_id');
    }

    public function representante() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'representante_id')
                    ->withDefault('name','No');
    }
}
