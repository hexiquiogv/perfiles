<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Catalogo;

class Domicilio extends Model
{
	use SoftDeletes;

    protected $guarded = [];
    protected $fillable = ['calle','numero_exterior','colonia','poblacion_id','municipio_id',
        'estado_id','pais_id','numero_interior','codigo_postal'];
    protected $dates = ['created_at','updated_at','deleted_at'];
    protected $campos_domicilio = ['calle','numero_interior','numero_exterior','colonia',
        'localidad','cp'];

    protected $table = "domicilios";
    protected $appends = ["morphic"];

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

    public function scopeMorphic($query, $type, $id){
        $results = $query->where('domicilioable_type',$type)->where('domicilioable_id',$id);

        if ($results->get()->count() == 0) {
            $results = collect();
            $domicilio = self::default_model();

            $domicilio->domicilioable_type = $type;
            $domicilio->domicilioable_id = $id;

            // $domicilio->save();

            $results->push($domicilio);
        }

        return $results;
    }

    public static function default_model(){
            $domicilio = new Domicilio;
            
            $pais = Catalogo::find(Catalogo::MEXICO);
            $domicilio->pais_id = $pais->id;

            $estado = Catalogo::find(Catalogo::COAHUILA);
            $domicilio->estado_id = $estado->id;

            $municipio = $estado->items->where('name','Saltillo')->first();
            $domicilio->municipio_id = $municipio->id;

            $poblacion = $municipio->items->where('name','Saltillo')->first();
            $domicilio->poblacion_id = $poblacion->id;   

            return $domicilio;
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
}
