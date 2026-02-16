<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Seguro;
use App\Models\SeguroPersona;
use Auth;

class SeguroController extends Controller
{
    public function destroy($uuid)
    {
        $seguro = Seguro::where('uuid',$uuid)->first();
        if (is_null($seguro)) dd("Poliza no encontrada");

        $seguro->delete();

        return redirect(route('seguros.index'))
                    ->withSucess("Se eliminó el seguro {$seguro->poliza} con éxito");
    }

    public function index()
    {
        // foreach (Seguro::get() as $seguro) {
        //     $seguro->uuid = (string)Str::orderedUuid();
        //     $seguro->save();
        // }
        return view('seguros.index');
    }

    public function create()
    {
        $registro = new Seguro;
        $route = route('seguros.store');
        $method = "post";
        $title = "Poliza - Nuevo Registro";

        return view('seguros.form', 
                    compact('registro','title','route','method'));
    }

    public function edit($uuid)
    {
        $registro = Seguro::where('uuid',$uuid)->first();
        if (is_null($registro)) dd("registro no encontrado");

        $route = route('seguros.update',$registro->uuid);
        $method = "patch";
        $title = "Poliza - Edición de Registro";

        return view('seguros.form', 
                    compact('registro','title','route','method'));
    }

    public function store(Request $request)
    {
        $seguro = new Seguro;
        $seguro->uuid = (string)Str::orderedUuid();        

        $seguro = self::persist_data($request, $seguro);

        return redirect()->route('seguros.edit',$seguro->uuid)
                    ->withSuccess('Poliza almacenada exitosamente');
    }

    public function update(Request $request, $uuid)
    {
        $seguro = Seguro::where('uuid',$uuid)->first();
        if (is_null($seguro)) dd("Poliza no encontrado");

        $oldSeguro = $seguro->replicate();
        $oldSeguro->created_at = now();
        $oldSeguro->save();
        $oldSeguro->delete();

        $seguro = self::persist_data($request, $seguro);

        return redirect()->route('seguros.edit',$seguro->uuid)
                    ->withSuccess("Poliza {$seguro->poliza} actualizada exitosamente");
    }

    private function persist_data(Request $request, Seguro $seguro){
        $seguro->poliza = $request->poliza ?? null;
        $seguro->estatus_id = $request->estatus_id ?? null;
        $seguro->nombre_plan_id = $request->nombre_plan_id ?? null;
        $seguro->fecha_emision = $request->fecha_emision ?? null;
        $seguro->fecha_terminacion = $request->fecha_terminacion ?? null;
        $seguro->metodo_pago_id = $request->metodo_pago_id ?? null;
        $seguro->tipo_seguro_id = $request->tipo_seguro_id ?? null;
        $seguro->forma_pago_id = $request->forma_pago_id ?? null;        
        $seguro->clasificacion_plan_id = $request->clasificacion_plan_id ?? null;
        $seguro->contratante_id = $request->contratante_id ?? null;
        $seguro->asegurado_principal_id = $request->asegurado_principal_id ?? null;

        $seguro->suma_asegurada = $request->suma_asegurada ?? null;
        $seguro->suma_asegurada_convertida = $request->suma_asegurada_convertida ?? null;

        $seguro->prima_anual = $request->prima_anual ?? null;
        $seguro->prima_anual_convertida = $request->prima_anual_convertida ?? null;
        $seguro->deducible_convertido = $request->deducible_convertido ?? null;

        $seguro->comentarios = $request->comentarios ?? null;
        
        $seguro->user_id = Auth::id();
        $seguro->save();

        SeguroPersona::where('seguro_id',$seguro->id)->delete();
        if (!is_null($seguro->contratante_id)) {
            $seguro_persona = new SeguroPersona;
            $seguro_persona->seguro_id = $seguro->id;
            $seguro_persona->persona_id = $seguro->contratante_id;
            $seguro_persona->save();
        }
        if (!is_null($seguro->asegurado_principal_id) && $seguro->asegurado_principal_id <> $seguro->contratante_id) {
            $seguro_persona = new SeguroPersona;
            $seguro_persona->seguro_id = $seguro->id;
            $seguro_persona->persona_id = $seguro->asegurado_principal_id;
            $seguro_persona->save();
        }

        return $seguro;
    }
}
