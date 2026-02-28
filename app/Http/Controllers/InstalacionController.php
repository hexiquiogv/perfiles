<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instalacion;
use App\Models\Cliente;
use App\Models\Catalogo;
use Lang;
use Validator;

class InstalacionController extends Controller
{
    public function index(Cliente $cliente)
    {
        $this->authorize('viewAny', Instalacion::class);

        $registro = $cliente;
        $route = 'instalaciones';
        $method = "";

        $opciones = array_keys( Lang::get('client_topics') );
        $opcion = 'instalaciones';
        
        return view('clientes.edit',compact('registro','route','method','opcion','opciones'));
    }

    public function create(Cliente $cliente)
    {
        $this->authorize('create', Instalacion::class);

        $registro = $cliente;
        $route = route('instalaciones.store',$registro->id);
        $method = "POST";

        $opciones = array_keys( Lang::get('client_topics') );
        $opcion = 'instalaciones';
        $instalacion = new Instalacion(['pais_id'=>Catalogo::MEXICO]);
        
        return view('clientes.sub_forms.instalacion',
                    compact('registro','route','method','opcion','opciones', 'instalacion'));
    }

    public function edit(Instalacion $instalacion)
    {
        $this->authorize('edit', $instalacion);

        $registro = $instalacion->cliente;
        $route = route('instalaciones.update',$instalacion->id);
        $method = "PATCH";

        $opciones = array_keys( Lang::get('client_topics') );
        $opcion = 'instalaciones';
        
        return view('clientes.sub_forms.instalacion',
                    compact('registro','route','method','opcion','opciones','instalacion'));
    }

    public function store(Request $request, Cliente $cliente){
        $this->authorize('store', Instalacion::class);

        $instalacion = new Instalacion;
        $instalacion->cliente_id = $cliente->id;
        self::persist_data($instalacion,$request);

        return redirect()->route('instalaciones',$instalacion->cliente_id)
                            ->withSuccess("Registro almacenado");
    }

    public function update(Request $request, Instalacion $instalacion){
        $this->authorize('update', $instalacion);

        self::persist_data($instalacion,$request);

        return redirect()->route('instalaciones',$instalacion->cliente_id)
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

    public function destroy(Instalacion $instalacion){
        $this->authorize('delete', $instalacion);

        $instalacion->delete();
        return redirect()->route('instalaciones',$instalacion->cliente_id)
                    ->withSuccess("Instalacion Eliminada");
    }
    
}
