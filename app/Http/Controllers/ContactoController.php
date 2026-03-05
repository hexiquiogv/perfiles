<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacto;
use App\Models\Proveedor;
use Illuminate\Support\Str;
use Lang;
use Validator;

class ContactoController extends Controller
{
    public function index($uuid)
    {
        $proveedor = Proveedor::where('uuid',$uuid)->first();
        if (is_null($proveedor)) return back()->withError("Registro no encontrado");

        $registro = $proveedor;
        $route = 'contactos';
        $method = "";

        $opciones = array_keys( Lang::get('supplier.tabs') );
        $opcion = 'contactos';
        
        return view('proveedores.edit',compact('registro','route','method','opcion','opciones'));
    }

    public function create($uuid)
    {
        $proveedor = Proveedor::where('uuid',$uuid)->first();
        if (is_null($proveedor)) return back()->withError("Registro no encontrado");

        $registro = $proveedor;
        $route = route('contactos.store',$registro->uuid);
        $method = "POST";

        $opciones = array_keys( Lang::get('supplier.tabs') );
        $opcion = 'contactos';
        $contacto = new Contacto;
        
        return view('proveedores.sub_forms.contacto',
                    compact('registro','route','method','opcion','opciones', 'contacto'));
    }

    public function edit($uuid)
    {
        $contacto = Contacto::where('uuid',$uuid)->first();
        if (is_null($contacto)) return back()->withError("Registro no encontrado");

        $registro = $contacto   ;
        $route = route('contactos.update',$contacto->uuid);
        $method = "PATCH";

        $opciones = array_keys( Lang::get('supplier.tabs') );
        $opcion = 'contactos';
        
        return view('proveedores.sub_forms.contacto',
                    compact('registro','route','method','opcion','opciones','contacto'));
    }

    public function store(Request $request, $uuid){
        $proveedor = Proveedor::where('uuid',$uuid)->first();
        if (is_null($proveedor)) return back()->withError("Registro no encontrado");
        
        $contacto = new Contacto;

        $contacto->proveedor_id = $proveedor->id;
        self::persist_data($contacto,$request);

        return redirect()->route('contactos',$contacto->proveedor->uuid)
                            ->withSuccess("Registro almacenado");
    }

    public function update(Request $request, $uuid){
        $contacto = Contacto::where('uuid',$uuid)->first();
        if (is_null($contacto)) return back()->withError("Registro no encontrado");

        self::persist_data($contacto,$request);

        return redirect()->route('contactos',$contacto->proveedor->uuid)
                            ->withSuccess("Registro actualizado");
    }

    private function persist_data(Contacto $contacto, Request $request){
        if (is_null($contacto->uuid)){
            $contacto->uuid = (string)Str::orderedUuid();
        }
        $contacto->nombre = $request->nombre;
        $contacto->puesto = $request->puesto ?? null;
        $contacto->email = $request->email ?? null;
        $contacto->telefono = $request->telefono ?? null;
        $contacto->representante_id = $request->representante_id ?? null;
        $contacto->save();
        return $contacto;
    }

    public function destroy($uuid){
        $contacto = Contacto::where('uuid',$uuid)->first();
        if (is_null($contacto)) return back()->withError("Registro no encontrado");

        $contacto->delete();
        return redirect()->route('contactos',$contacto->proveedor_id)
                    ->withSuccess("Contacto Eliminado");
    }
    
}
