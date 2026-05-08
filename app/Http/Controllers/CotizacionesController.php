<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mantenimiento;
use App\Models\Cotizacion;
use App\Models\Catalogo;
use Illuminate\Support\Str;

use Telegram\Bot\Laravel\Facades\Telegram;
use Auth;

class CotizacionesController extends Controller
{
    public function index()
    {
        return view('cotizaciones.index');
    }

    public function edit($uuid){
        $registro = Mantenimiento::where('uuid',$uuid)->first();
        if (is_null($registro)) dd("Orden no encontrada");

        $title = "Orden de Mantenimiento - Cotizaciones";
        $back_url = route('ordenes',$registro->uuid);

        return view('cotizaciones.form', compact('registro','title','back_url'));
    }

    public function store(Request $request, $uuid){
        $registro = Mantenimiento::where('uuid',$uuid)->first();
        if (is_null($registro)) dd("Orden no encontrada");

        $cotizacion = new Cotizacion;
        $cotizacion->uuid = (string)Str::orderedUuid();
        $cotizacion->model_name = get_class($registro);
        $cotizacion->model_id = $registro->id;
        $cotizacion->proveedor_id = $request->proveedor_id;
        $cotizacion->instalacion_id = $request->instalacion_id;
        $cotizacion->monto = $request->monto;
        $cotizacion->user_id = Auth::id();
        $cotizacion->save();

        return redirect()->route('cotizaciones.edit',$registro->uuid)
                    ->withSuccess('cotizacion registrada');

    }

    public function destroy($uuid){
        $cotizacion = Cotizacion::where('uuid',$uuid)->first();
        if (is_null($cotizacion)) return back()->withError("Registro no encontrado");

        $oldCotizacion = $cotizacion->replicate();
        $oldCotizacion->created_at = now();
        $oldCotizacion->save();
        $oldCotizacion->delete();

        $orden = Mantenimiento::where('id',$cotizacion->model_id)->first();

        $cotizacion->user_id=Auth::id();
        $cotizacion->delete();

        $oldOrden = $orden->replicate();
        $oldOrden->created_at = now();
        $oldOrden->save();
        $oldOrden->delete();

        $orden->cotizacion_uuid = null;
        $orden->user_id = Auth::id();
        $orden->save();

        return redirect()->route('cotizaciones.edit',$orden->uuid)
                    ->withSuccess('cotizacion eliminada');
    }

    public function check($uuid){
        $cotizacion = Cotizacion::where('uuid',$uuid)->first();
        if (is_null($cotizacion)) return back()->withError("Registro no encontrado");

        $oldCotizacion = $cotizacion->replicate();
        $oldCotizacion->created_at = now();
        $oldCotizacion->save();
        $oldCotizacion->delete();

        $orden = Mantenimiento::where('id',$cotizacion->model_id)->first();
        $seleccionada = Catalogo::find_item(Catalogo::SI_NO,Catalogo::SI)->first();

        $cotizaciones = Cotizacion::where('model_name',$cotizacion->model_name)
                ->where('model_id',$cotizacion->model_id)
                ->whereNotNull('seleccionada_id')
                ->get();
        foreach($cotizaciones as $temp){
            $oldCotizacion = $temp->replicate();
            $oldCotizacion->created_at = now();
            $oldCotizacion->save();
            $oldCotizacion->delete();

            $temp->seleccionada_id = null;
            $temp->user_id=Auth::id();
            $temp->save();
        }

        $cotizacion->seleccionada_id = $seleccionada->id;
        $cotizacion->user_id=Auth::id();
        $cotizacion->save();

        $oldOrden = $orden->replicate();
        $oldOrden->created_at = now();
        $oldOrden->save();
        $oldOrden->delete();

        $orden->cotizacion_uuid = $cotizacion->uuid;
        $orden->user_id = Auth::id();
        $orden->save();

        return redirect()->route('cotizaciones.edit',$orden->uuid)
                    ->withSuccess('cotizacion seleccionada');
    }
}
