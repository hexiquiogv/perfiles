<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacto;
use App\Models\Cliente;
use Lang;
use Validator;

class ContactoController extends Controller
{
    public function index(Cliente $cliente)
    {
        $registro = $cliente;
        $route = 'contactos';
        $method = "";

        $opciones = array_keys( Lang::get('client_topics') );
        $opcion = 'contactos';
        
        return view('clientes.edit',compact('registro','route','method','opcion','opciones'));
    }

    public function create(Cliente $cliente)
    {
        $registro = $cliente;
        $route = route('contactos.store',$registro->id);
        $method = "POST";

        $opciones = array_keys( Lang::get('client_topics') );
        $opcion = 'contactos';
        $contacto = new Contacto;
        
        return view('clientes.sub_forms.contacto',
                    compact('registro','route','method','opcion','opciones', 'contacto'));
    }

    public function edit(Contacto $contacto)
    {
        $registro = $contacto->cliente;
        $route = route('contactos.update',$contacto->id);
        $method = "PATCH";

        $opciones = array_keys( Lang::get('client_topics') );
        $opcion = 'contactos';
        
        return view('clientes.sub_forms.contacto',
                    compact('registro','route','method','opcion','opciones','contacto'));
    }

    public function store(Request $request, Cliente $cliente){
        $contacto = new Contacto;
        $contacto->cliente_id = $cliente->id;
        self::persist_data($contacto,$request);

        return redirect()->route('contactos',$contacto->cliente_id)
                            ->withSuccess("Registro almacenado");
    }

    public function update(Request $request, Contacto $contacto){
        self::persist_data($contacto,$request);

        return redirect()->route('contactos',$contacto->cliente_id)
                            ->withSuccess("Registro actualizado");
    }

    private function persist_data(Contacto $contacto, Request $request){
        $contacto->nombre = $request->nombre;
        $contacto->puesto = $request->puesto ?? null;
        $contacto->email = $request->email ?? null;
        $contacto->telefono = $request->telefono ?? null;
        $contacto->representante_id = $request->representante_id ?? null;
        $contacto->save();
        return $contacto;
    }

    public function destroy(Contacto $contacto){
        $contacto->delete();
        return redirect()->route('contactos',$contacto->cliente_id)
                    ->withSuccess("Contacto Eliminado");
    }
    
}
