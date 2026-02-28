<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Catalogo;

class Instalacion extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['created_at','updated_at','deleted_at'];
    protected $campos_domicilio = ['calle','numero_interior','numero_exterior','colonia',
        'localidad','cp'];
    protected $fillable = ['pais_id'];
    protected $appends = ["direccion"];
    protected $table = "instalaciones";

    public function estado() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'estado_id')
                    ->withDefault(['name'=>'']);
    }

    public function municipio() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'municipio_id')
                    ->withDefault(['name'=>'']);
    }

    public function poblacion() {
        return $this->hasOne('App\Models\Catalogo', 'id', 'poblacion_id')
                    ->withDefault(['name'=>'']);
    }

    public function getLocalidadAttribute(){
        $results = ($this->poblacion->name == $this->municipio->name) 
                        ? $this->poblacion->name 
                        : $this->poblacion->name . ", ". $this->municipio->name;
        $results .= ", " . $this->estado->name;
        return $results;
    }

    public function getCpAttribute(){
        return "C.P. ".$this->codigo_postal;
    }

    public function getDireccionAttribute(){
        $results[0] = "";
        for ($i=0;$i<count($this->campos_domicilio); $i++) {
            $campo = $this->campos_domicilio[$i];
            if("" == $this[$campo]) continue;
            if ($i<=2){
                $results[0] = trim($results[0]." ".$this[$campo]);
            } else {
                $results[] = $this[$campo];    
            }
            
        }
        return implode(", ",$results);
    }

    public function cliente() {
        return $this->hasOne('App\Models\Cliente', 'id', 'cliente_id');
    }

    public function contacto() {
        return $this->hasOne('App\Models\Contacto', 'id', 'contacto_id');
    }
}
