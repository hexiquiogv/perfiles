<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AutorizacionController extends Controller
{
    public function autorizadores($uuid){
        $orden = Mantenimiento::where('uuid',$uuid)->first();
        if (is_null($orden)) return back()->withError("Registro no encontrado");
        
        $autorizar = Catalogo::find_item(Catalogo::ESTATUS_MANTENIMIENTO,Catalogo::PENDIENTE_AUTORIZAR)->first();

        $oldOrden = $orden->replicate();
        $oldOrden->created_at = now();
        $oldOrden->save();
        $oldOrden->delete();

        $orden->estatus_id = $autorizar->id;
        $orden->fecha_reporte_revisado = now();
        $orden->user_id = Auth::id();
        $orden->save();

        // se crea una entrada por cada usuario con perfil para autorizar
        $users = User::role(Role::AUTORIZA)->get();
        foreach($users as $user){
            $autorizacion = new Autorizacion;
            $autorizacion->uuid = (string)Str::orderedUuid();
            $autorizacion->model_name = get_class($orden);
            $autorizacion->model_id = $orden->id;
            $autorizacion->user_id = $user->id;
            $autorizacion->save();
        }

        //TODO Generar PDF de Orden

        return redirect()->route('cotizaciones')->withSuccess('orden enviada para autorización');
    }

    public function autorizar()
    {
        return back()->withSuccess('autorizado');
    }
}
