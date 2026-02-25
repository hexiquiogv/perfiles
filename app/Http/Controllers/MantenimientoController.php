<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Mantenimiento;
use Auth;

class MantenimientoController extends Controller
{
    public function destroy($uuid)
    {
        $mantenimiento = Mantenimiento::where('uuid',$uuid)->first();
        if (is_null($mantenimiento)) dd("Registro no encontrado");

        $mantenimiento->delete();

        return redirect(route('mantenimientos.index'))
                    ->withSucess("Se eliminó el registro {$mantenimiento->folio} con éxito");
    }

    public function index()
    {
        return view('mantenimientos.index');
    }

    public function create()
    {
        $registro = new Mantenimiento;
        $route = route('seguros.store');
        $method = "post";
        $title = "Poliza - Nuevo Registro";

        return view('seguros.form', 
                    compact('registro','title','route','method'));
    }

    public function edit($uuid)
    {
        $registro = Mantenimiento::where('uuid',$uuid)->first();
        if (is_null($registro)) dd("registro no encontrado");

        $route = route('seguros.update',$registro->uuid);
        $method = "patch";
        $title = "Poliza - Edición de Registro";

        return view('seguros.form', 
                    compact('registro','title','route','method'));
    }

    public function store(Request $request)
    {
        $mantenimiento = new Seguro;
        $mantenimiento->uuid = (string)Str::orderedUuid();        

        $mantenimiento = self::persist_data($request, $mantenimiento);

        return redirect()->route('seguros.edit',$mantenimiento->uuid)
                    ->withSuccess('Poliza almacenada exitosamente');
    }

    public function update(Request $request, $uuid)
    {
        $mantenimiento = Mantenimiento::where('uuid',$uuid)->first();
        if (is_null($mantenimiento)) dd("Poliza no encontrado");

        $oldSeguro = $mantenimiento->replicate();
        $oldSeguro->created_at = now();
        $oldSeguro->save();
        $oldSeguro->delete();

        $mantenimiento = self::persist_data($request, $mantenimiento);

        return redirect()->route('seguros.edit',$mantenimiento->uuid)
                    ->withSuccess("Poliza {$mantenimiento->poliza} actualizada exitosamente");
    }

    private function persist_data(Request $request, Seguro $mantenimiento){
        $mantenimiento->poliza = $request->poliza ?? null;
        $mantenimiento->estatus_id = $request->estatus_id ?? null;
        $mantenimiento->nombre_plan_id = $request->nombre_plan_id ?? null;
        $mantenimiento->fecha_emision = $request->fecha_emision ?? null;
        $mantenimiento->fecha_terminacion = $request->fecha_terminacion ?? null;
        $mantenimiento->metodo_pago_id = $request->metodo_pago_id ?? null;
        $mantenimiento->tipo_seguro_id = $request->tipo_seguro_id ?? null;
        $mantenimiento->forma_pago_id = $request->forma_pago_id ?? null;        
        $mantenimiento->clasificacion_plan_id = $request->clasificacion_plan_id ?? null;
        $mantenimiento->contratante_id = $request->contratante_id ?? null;
        $mantenimiento->asegurado_principal_id = $request->asegurado_principal_id ?? null;

        $mantenimiento->suma_asegurada = $request->suma_asegurada ?? null;
        $mantenimiento->suma_asegurada_convertida = $request->suma_asegurada_convertida ?? null;

        $mantenimiento->prima_anual = $request->prima_anual ?? null;
        $mantenimiento->prima_anual_convertida = $request->prima_anual_convertida ?? null;
        $mantenimiento->deducible_convertido = $request->deducible_convertido ?? null;

        $mantenimiento->comentarios = $request->comentarios ?? null;
        
        $mantenimiento->user_id = Auth::id();
        $mantenimiento->save();

        SeguroPersona::where('seguro_id',$mantenimiento->id)->delete();
        if (!is_null($mantenimiento->contratante_id)) {
            $mantenimiento_persona = new SeguroPersona;
            $mantenimiento_persona->seguro_id = $mantenimiento->id;
            $mantenimiento_persona->persona_id = $mantenimiento->contratante_id;
            $mantenimiento_persona->save();
        }
        if (!is_null($mantenimiento->asegurado_principal_id) && $mantenimiento->asegurado_principal_id <> $mantenimiento->contratante_id) {
            $mantenimiento_persona = new SeguroPersona;
            $mantenimiento_persona->seguro_id = $mantenimiento->id;
            $mantenimiento_persona->persona_id = $mantenimiento->asegurado_principal_id;
            $mantenimiento_persona->save();
        }

        return $mantenimiento;
    }
}
