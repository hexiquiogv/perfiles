<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Persona;
use App\Models\SeguroPersona;
use Auth;

class PersonaController extends Controller
{
    public function destroy($uuid)
    {
        // TO DO : validate that the person belong to only one contract
        $persona = Persona::where('uuid',$uuid)->first();
        if (is_null($persona)) dd("registro no encontrada");

        if (count(SeguroPersona::where('persona_id',$persona->id)) > 1) 
            dd("no se puede eliminar porque tiene varias polizas");

        $persona->delete();

        return redirect(route('personas.index'))
                    ->withSucess("Se eliminó la persona {$persona->fulname} con éxito");
    }

    public function index()
    {        
        // foreach (Persona::get() as $persona) {
        //     $persona->uuid = (string)Str::orderedUuid();
        //     $persona->save();
        // }
        return view('personas.index');
    }

    public function create()
    {
        $registro = new Persona;
        $route = route('personas.store');
        $method = "post";
        $title = "Persona - Nuevo Registro";

        return view('personas.form', 
                    compact('registro','title','route','method'));
    }

    public function edit($uuid)
    {
        $registro = Persona::where('uuid',$uuid)->first();
        if (is_null($registro)) dd("registro no encontrado");

        $route = route('personas.update',$registro->uuid);
        $method = "patch";
        $title = "Persona - Edición de Registro";

        return view('personas.form', 
                    compact('registro','title','route','method'));
    }

    public function store(Request $request)
    {
        $persona = new Persona;
        $persona->uuid = (string)Str::orderedUuid();        

        $persona = self::persist_data($request, $persona);

        return redirect()->route('personas.edit',$persona->uuid)
                    ->withSuccess("Registro de persona {$persona->fullname} almacenado exitosamente");
    }

    public function update(Request $request, $uuid)
    {
        $persona = Persona::where('uuid',$uuid)->first();
        if (is_null($persona)) dd("registro no encontrado");

        $oldSeguro = $persona->replicate();
        $oldSeguro->created_at = now();
        $oldSeguro->save();
        $oldSeguro->delete();

        $persona = self::persist_data($request, $persona);

        return redirect()->route('personas.edit',$persona->uuid)
                    ->withSuccess("Registro de persona {$persona->fullname} actualizado exitosamente");
    }

    private function persist_data(Request $request, Persona $persona){
        $persona->nombre = $request->nombre ?? null;
        $persona->paterno = $request->paterno ?? null;
        $persona->materno = $request->materno ?? null;
        $persona->fecha_nacimiento = $request->fecha_nacimiento ?? null;
        $persona->sexo_id = $request->sexo_id ?? null;
        $persona->estado_civil_id = $request->estado_civil_id ?? null;
        $persona->email = $request->email ?? null;
        $persona->telefono = $request->telefono ?? null;        
        
        $persona->user_id = Auth::id();
        $persona->save();

        return $persona;
    }
}
