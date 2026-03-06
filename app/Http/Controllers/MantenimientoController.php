<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Mantenimiento;
use App\Models\Vehiculo;
use App\Models\Instalacion;
use Auth;

class MantenimientoController extends Controller
{
    public function index()
    {
        return view('mantenimientos.index');
    }

    public function create()
    {
        $registro = new Mantenimiento;
        $route = route('mantenimientos.store');
        $method = "post";
        $title = "Reporte Mantenimiento - Nuevo Registro";

        return view('mantenimientos.form', 
                    compact('registro','title','route','method'));
    }

    public function edit($uuid)
    {
        $registro = Mantenimiento::where('uuid',$uuid)->first();
        if (is_null($registro)) dd("Reporte no encontrado");

        $route = route('mantenimientos.update',$registro->uuid);
        $method = "patch";
        $title = "Reporte Mantenimiento - Edición de Registro";

        return view('mantenimientos.form', 
                    compact('registro','title','route','method'));
    }

    public function store(Request $request)
    {
        $mantenimiento = new Mantenimiento;
        $mantenimiento->uuid = (string)Str::orderedUuid();        

        $mantenimiento = self::persist_data($request, $mantenimiento);

        return redirect()->route('mantenimientos.edit',$mantenimiento->uuid)
                    ->withSuccess('Reporte almacenado exitosamente');
    }

    public function update(Request $request, $uuid)
    {
        $mantenimiento = Mantenimiento::where('uuid',$uuid)->first();
        if (is_null($mantenimiento)) dd("Reporte no encontrado");

        $oldReporte = $mantenimiento->replicate();
        $oldReporte->created_at = now();
        $oldReporte->save();
        $oldReporte->delete();

        $mantenimiento = self::persist_data($request, $mantenimiento);

        return redirect()->route('mantenimientos.edit',$mantenimiento->uuid)
                    ->withSuccess("Reporte {$mantenimiento->folio} actualizado exitosamente");
    }

    private function persist_data(Request $request, Mantenimiento $mantenimiento){        
        $mantenimiento->folio = $request->folio ?? null;
                
        $mantenimiento->chofer_id = $request->chofer_id ?? null;
        $mantenimiento->garantia_id = $request->garantia_id ?? null;
        $mantenimiento->proveedor_id = $request->proveedor_id ?? null;
        
        $mantenimiento->vehiculo_id = $request->vehiculo_id ?? null;
        $vehiculo = Vehiculo::find($mantenimiento->vehiculo_id);
        if (!is_null($vehiculo)){
            $mantenimiento->empresa_id = $vehiculo->empresa_id ?? null;
            $mantenimiento->sucursal_id = $vehiculo->sucursal_id ?? null;
            $mantenimiento->area_id = $vehiculo->area_id ?? null;
        }

        $mantenimiento->fecha_reporte = $request->fecha_reporte ?? null;
        $mantenimiento->fecha_reporte_revisado = $request->fecha_reporte_revisado ?? null;        
        $mantenimiento->fecha_reporte_autorizado = $request->fecha_reporte_autorizado ?? null;
        $mantenimiento->programado_para_ingreso = $request->programado_para_ingreso ?? null;
        $mantenimiento->fecha_ingresado = $request->fecha_ingresado ?? null;
        $mantenimiento->fecha_entregado = $request->fecha_entregado ?? null;
        $mantenimiento->kilometraje = $request->kilometraje ?? null;

        // todo : consolidar tipo de servicios por checkboxes
        $mantenimiento->servicios = $request->servicios ?? null;
        $mantenimiento->descripcion_falla = $request->descripcion_falla ?? null;

        $mantenimiento->observaciones = $request->comentarios ?? null;
        $mantenimiento->estatus_id = $request->estatus_id ?? null;
        
        $mantenimiento->user_id = Auth::id();
        $mantenimiento->save();

        return $mantenimiento;
    }

    public function destroy($uuid)
    {
        $mantenimiento = Mantenimiento::where('uuid',$uuid)->first();
        if (is_null($mantenimiento)) dd("Reporte no encontrado");

        $mantenimiento->delete();

        return redirect(route('mantenimientos.index'))
                    ->withSucess("Se eliminó el reporte {$mantenimiento->folio} con éxito");
    }
}
