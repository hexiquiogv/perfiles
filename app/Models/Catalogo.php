<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Config;

class Catalogo extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $fillable = ['name','parent_id'];
    protected $dates = ['created_at','updated_at','deleted_at'];
       
    const MEXICO = 154;
    
    const ESTATUS_MANTENIMIENTO = 'estatus_mantenimiento';
    const ESTATUS = 'estatus';

    const ESTATUS_PERSONA = 'estatus_persona';
    const SEXO = 'sexo';
    const SI_NO = 'si_no';
    const ESTADO_CIVIL = 'estado_civil';

    const MARCA = 'marca';
    const COLOR = 'color';
    const TIPO_VEHICULO = 'tipo_vehiculo';

    const SUCURSAL = 'sucursal';

    const ORIGEN_INFORMACION = "origen_informacion";
    const STATUS_REPORT = "status_report";

    public function scopeFind_by_name($query, $nombre_catalogo=null) {
        if (is_null($nombre_catalogo)) {
            return $query->whereNull('parent_id');
        }

        $query->whereRaw("LOWER(name) = '". strtolower($nombre_catalogo) . "'");
        return $query->where('name',ucwords($nombre_catalogo));
    }

    public function current_catalogo(){
        $result = "catalogos";
        if(!is_null($this->parent_id)){
            $result =  $this->parent->name;
        }
        return array('label'=>ucfirst($result),'parent_id'=>$this->parent_id);
    }    

    public function parent() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'parent_id');
    }

    public function items() {
        return $this->hasMany('App\Models\Catalogo','parent_id', 'id');
    }
    
}
