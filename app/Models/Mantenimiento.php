<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Catalogo;

class Mantenimiento extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['created_at','updated_at','deleted_at','fecha_reporte','fecha_reporte_revisado',
        'fecha_reporte_autorizado','programado_para_ingreso','fecha_ingresado','fecha_entregado'];
    protected $appends = ['files','firmaChofer'];

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

    public function estatus() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'estatus_id')
            ->withDefault('name','');
    }

    public function vehiculo() {
        return $this->hasOne('App\Models\Vehiculo', 'id', 'vehiculo_id')
            ->withDefault('name','');
    }

    public function chofer() {
        return $this->hasOne('App\Models\Persona', 'id', 'persona_id');            
    }

    public function instalaciones() {
        return $this->hasOne('App\Models\Instalaciones', 'id', 'proveedor_id');
    }  
    
    public function garantia() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'garantia_id');
    }  

    public function getDiasVencimientoAttribute(){
        return 0; 
    }

    public function getServicios(){
        $catalogo = Catalogo::find_by_name(Catalogo::MANTENIMIENTOS)->first();
        $items = $catalogo->items->pluck('id','descripcion');
        $results = [];
        foreach ($items as $key => $value) {
            if($key & $this->servicios) {
                $results[] = $value;
            }
        }
        return $results;
    }    

    public function getFilesAttribute() {
        return Media::where('model_name', 'App\Models\Mantenimiento')
                    ->where('model_id', $this->id)->get();
    }

    public function getFirmaChoferAttribute() {
        $documento_type = Catalogo::find_item(Catalogo::DOCUMENT_TYPE,Catalogo::FIRMA)->first();

        return Media::where('model_name', 'App\Models\Mantenimiento')
                    ->where('model_id', $this->id)
                    ->where('document_type_id',$documento_type->id)
                    ->first();
    }
}



    