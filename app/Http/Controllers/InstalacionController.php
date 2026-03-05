<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instalacion;
use App\Models\Proveedor;
use App\Models\Catalogo;
use Illuminate\Support\Str;
use Lang;
use Validator;

class InstalacionController extends Controller
{
    public function index($uuid)
    {
        $registro = Proveedor::where('uuid',$uuid)->first();
        if (is_null($registro)) return back()->withError("Registro no encontrado");
        $route = 'instalaciones';
        $method = "";

        $opciones = array_keys( Lang::get('supplier.tabs') );
        $opcion = 'instalaciones';
        
        return view('proveedores.edit',compact('registro','route','method','opcion','opciones'));
    }

    public function create($uuid)
    {
        $registro = Proveedor::where('uuid',$uuid)->first();
        if (is_null($registro)) return back()->withError("Registro no encontrado");

        $route = route('instalaciones.store',$registro->uuid);
        $method = "POST";

        $opciones = array_keys( Lang::get('supplier.tabs') );
        $opcion = 'instalaciones';
        $instalacion = new Instalacion(['pais_id'=>Catalogo::MEXICO]);
        
        return view('proveedores.sub_forms.instalacion',
                    compact('registro','route','method','opcion','opciones', 'instalacion'));
    }

    public function edit($uuid)
    {
        $instalacion = Instalacion::where('uuid',$uuid)->first();
        if (is_null($instalacion)) return back()->withError("Registro no encontrado");

        $registro = $instalacion->proveedor;
        $route = route('instalaciones.update',$instalacion->uuid);
        $method = "PATCH";

        $opciones = array_keys( Lang::get('supplier.tabs') );
        $opcion = 'instalaciones';
        
        return view('proveedores.sub_forms.instalacion',
                    compact('registro','route','method','opcion','opciones','instalacion'));
    }

    public function store(Request $request, $uuid){
        $registro = Proveedor::where('uuid',$uuid)->first();
        if (is_null($registro)) return back()->withError("Registro no encontrado");

        $instalacion = new Instalacion;
        $instalacion->proveedor_id = $registro->id;
        $instalacion->uuid = (string)Str::orderedUuid();

        self::persist_data($instalacion,$request);

        return redirect()->route('instalaciones',$instalacion->instalacion->uuid)
                            ->withSuccess("Registro almacenado");
    }

    public function update(Request $request, $uuid){
        $instalacion = Instalacion::where('uuid',$uuid)->first();
        if (is_null($instalacion)) return back()->withError("Registro no encontrado");

        self::persist_data($instalacion,$request);

        return redirect()->route('instalaciones',$instalacion->proveedor->uuid)
                            ->withSuccess("Registro actualizado");
    }

    private function persist_data(Instalacion $instalacion, Request $request){
        $instalacion->nombre = $request->nombre;
        $instalacion->contacto_id = $request->contacto_id ?? null;
        $instalacion->poblacion_id = $request->poblacion_id ?? null;
        $instalacion->municipio_id = $request->municipio_id ?? null;
        $instalacion->estado_id = $request->estado_id ?? null;
        $instalacion->pais_id = $request->pais_id ?? null;
        $instalacion->calle = $request->calle ?? null;
        $instalacion->numero_exterior = $request->numero_exterior ?? null;
        $instalacion->colonia = $request->colonia ?? null;
        $instalacion->codigo_postal = $request->codigo_postal ?? null;
        $instalacion->numero_interior = $request->numero_interior ?? null;
        $instalacion->latitud = $request->latitud ?? null;
        $instalacion->longitud = $request->longitud ?? null;
        $instalacion->telefono = $request->telefono ?? null;
        $instalacion->save();
        return $instalacion;
    }

    public function destroy($uuid){
        $instalacion = Instalacion::where('uuid',$uuid)->first();
        if (is_null($instalacion)) return back()->withError("Registro no encontrado");

        $instalacion->delete();
        return redirect()->route('instalaciones',$instalacion->proveedor->uuid)
                    ->withSuccess("Instalacion Eliminada");
    }
    
}
