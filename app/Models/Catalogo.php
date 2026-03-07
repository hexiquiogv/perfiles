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
    const COAHUILA = 249;   
    
    const ESTATUS = 'estatus';

    const ESTATUS_PERSONA = 'estatus_persona';
    const SEXO = 'sexo';
    const SI_NO = 'si_no';
    const ESTADO_CIVIL = 'estado_civil';

    const MARCA = 'marca';
    const COLOR = 'color';
    const TIPO_VEHICULO = 'tipo_vehiculo';
    const TIPO_SANGRE = 'tipo_sangre';

    const GIRO_PROVEEDOR = 'giro_proveedor';

    const EMPRESA = 'empresa';

    const ORIGEN_INFORMACION = "origen_informacion";
    const STATUS_REPORT = "status_report";
    const PUESTO = "puesto";

    const ESTATUS_MANTENIMIENTO = 'estatus_mantenimiento';    
    const REPROGRAMADO = "reprogramado";
    const PROGRAMADO = "programado";
    const EN_PROCESO = "en proceso";
    const EN_TALLER = "en taller";
    const CANCELADO = "cancelado";
    const GARANTIA = "garantía";
    const AUTORIZADO = "autorizado";
    const PENDIENTE_AUTORIZAR = "pendiente autorizar";

    const MANTENIMIENTOS = 'mantenimientos';
    const PREVENTIVO_5000KM = 'PREVENTIVO 5,000KM'; 
    const PREVENTIVO_10000KM = 'PREVENTIVO 10,000KM'; 
    const TRANSMISION = 'TRANSMISION'; 
    const SUSPENCION = 'SUSPENSION'; 
    const ELECTRICO = 'electrico'; 
    const MOTOR = 'motor'; 
    const ENDERAZO_Y_PINTURA = 'enderezado y pintura'; 
    const DIRECCION = 'direccion'; 
    const ALINEACION = 'alineacion'; 
    const BALANCEO = 'balanceo'; 
    const VULCANIZACION = 'vulcanizacion'; 
    const LLANTAS = 'llantas'; 

    const DOCUMENT_TYPE = 'document_type';

    public function scopeFind_by_name($query, $nombre_catalogo=null) {
        if (is_null($nombre_catalogo)) {
            return $query->whereNull('parent_id');
        }

        return $query->whereRaw("LOWER(name) = '". strtolower($nombre_catalogo) . "'");
        // return $query->where('name',ucwords($nombre_catalogo));
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
