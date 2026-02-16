<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FieldsTrait;

class Consulta extends Model
{
    use FieldsTrait, SoftDeletes;
    protected $guarded = [];
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function origen() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'origen_informacion_id')
            ->withDefault('name','');
    }

    public function status() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'status_id')
            ->withDefault('name','');
    }

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id')
            ->withDefault('fullname','');
    }
}
