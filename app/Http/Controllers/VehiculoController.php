<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Vehiculo;
use Auth;

class VehiculoController extends Controller
{
    public function destroy($uuid)
    {
        $vehiculo = Vehiculo::where('uuid',$uuid)->first();
        if (is_null($vehiculo)) dd("registro no encontrada");

        $vehiculo->delete();

        return redirect(route('vehiculos.index'))
                    ->withSucess("Se eliminó el registro con éxito");
    }

    public function index()
    {        
        return view('vehiculos.index');
    }

    public function create()
    {
        $registro = new Vehiculo;
        $route = route('vehiculos.store');
        $method = "post";
        $title = "Vehículos - Nuevo Registro";

        return view('vehiculos.form', 
                    compact('registro','title','route','method'));
    }

    public function edit($uuid)
    {
        $registro = Vehiculo::where('uuid',$uuid)->first();
        if (is_null($registro)) dd("registro no encontrado");

        $route = route('vehiculos.update',$registro->uuid);
        $method = "patch";
        $title = "Vehículos - Edición de Registro";

        return view('vehiculos.form', 
                    compact('registro','title','route','method'));
    }

    public function store(Request $request)
    {
        $vehiculo = new Vehiculo;
        $vehiculo->uuid = (string)Str::orderedUuid();        

        $vehiculo = self::persist_data($request, $vehiculo);

        return redirect()->route('vehiculos.edit',$vehiculo->uuid)
                    ->withSuccess("Registro almacenado exitosamente");
    }

    public function update(Request $request, $uuid)
    {
        $vehiculo = Vehiculo::where('uuid',$uuid)->first();
        if (is_null($vehiculo)) dd("registro no encontrado");

        $oldSeguro = $vehiculo->replicate();
        $oldSeguro->created_at = now();
        $oldSeguro->save();
        $oldSeguro->delete();

        $vehiculo = self::persist_data($request, $vehiculo);

        return redirect()->route('vehiculos.edit',$vehiculo->uuid)
                    ->withSuccess("Registro actualizado exitosamente");
    }

    private function persist_data(Request $request, Vehiculo $vehiculo){
        $vehiculo->placa = $request->placa ?? null;
        $vehiculo->no_economico = $request->no_economico ?? null;
        $vehiculo->tipo_vehiculo_id = $request->tipo_vehiculo_id ?? null;
        $vehiculo->marca_id = $request->marca_id ?? null;
        $vehiculo->linea_id = $request->linea_id ?? null;
        $vehiculo->modelo = $request->modelo ?? null;
        $vehiculo->numero_serie = $request->numero_serie ?? null;
        $vehiculo->sucursal_id = $request->sucursal_id ?? null;
        $vehiculo->area_id = $request->area_id ?? null;  
        $vehiculo->chofer_id = $request->chofer_id ?? null;  
        $vehiculo->color_id = $request->color_id ?? null;  
        $vehiculo->estatus_id = $request->estatus_id ?? null;  
        $vehiculo->observaciones = $request->observaciones ?? null;  
        
        $vehiculo->user_id = Auth::id();
        $vehiculo->save();

        return $vehiculo;
    }
}
