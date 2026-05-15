<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Autorizacion extends Model
{
    use SoftDeletes;
    protected $table = "autorizaciones";
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function orden() {
        return $this->hasOne('App\Models\Mantenimiento', 'id', 'model_id');
    }

    public function estatus() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'estatus_id')
                ->withDefault(['name'=>'']);
    }
}
