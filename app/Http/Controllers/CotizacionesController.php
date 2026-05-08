<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mantenimiento;
use App\Models\Cotizacion;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Helpers\CodeGenerator;
use Auth;
use Cezpdf;
use Lang;

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
}
