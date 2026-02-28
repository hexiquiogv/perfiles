<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Domicilio;
use Carbon\Carbon;
use Lang;
use Validator;

class DomicilioController extends Controller
{
    public function store(Request $request, $domicilioable_id, $domicilioable_type){
        $this->authorize('store', Domicilio::class);

        $inputs = $request->all();
    	Validator::make($inputs, [
            'poblacion_id' => 'required',
            'municipio_id' => 'required',
            'estado_id' => 'required',
            'pais_id' => 'required',
            'calle' => 'required',
            'numero_exterior' => 'required',
            'colonia'=>'required',
        ])->validate();


        // dd($request->all());
        // dd($domicilioable_type);
        // dd($domicilioable_id);
        
	    $domicilio = Domicilio::where('domicilioable_id',$domicilioable_id)->where('domicilioable_type',$domicilioable_type)->first();
        if (is_null($domicilio)){
            $domicilio = new Domicilio;
            $domicilio->domicilioable_id = $domicilioable_id;
            $domicilio->domicilioable_type = $domicilioable_type;
        } 
        
        //dd($inputs['poblacion_id']);
        $domicilio->poblacion_id = $inputs['poblacion_id'];
        $domicilio->municipio_id = $inputs['municipio_id'];
        $domicilio->estado_id = $inputs['estado_id'];
        $domicilio->pais_id = $inputs['pais_id'];
        $domicilio->calle = $inputs['calle'];
        $domicilio->numero_exterior = $inputs['numero_exterior'];
        $domicilio->colonia = $inputs['colonia'];
        $domicilio->codigo_postal = $inputs['codigo_postal'] ?? null;
        $domicilio->numero_interior = $inputs['numero_interior'] ?? null;
        
        //dd($domicilio);
        $domicilio->save();

    	return redirect()->back()->withSuccess('Domicilio Actualizado');
    }


    public function edit(Proveedor $proveedor)
    {
        $registro = $proveedor;
        $route = route('domicilios.store',[ $proveedor->id, get_class($proveedor)]);
        $method = "POST";

        $opciones = array_keys( Lang::get('supplier.tabs') );
        $opcion = 'domicilio';
        
        $domicilio = $proveedor->domicilio();

        return view('clientes.edit',compact('registro','route','method','domicilio','opcion','opciones'));
    }
}
