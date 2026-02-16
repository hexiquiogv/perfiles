<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;
    protected $appends = ['isNotNew'];   

    public function status() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'status_id')
            ->withDefault('name','');
    }

    public function consulta() {
        return $this->hasOne('App\Models\Consulta', 'id', 'consulta_id')
            ->withDefault('name','');
    }

    public function getIsNotNewAttribute(){
        return $this->id > 0;
    }
}
