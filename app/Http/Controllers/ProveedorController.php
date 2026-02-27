<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Proveedor;
use App\Http\Requests\ProveedorRequest;
use Auth;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;

class ProveedorController extends Controller
{    
    public function index(Request $request)
    {
        $proveedor = Proveedor::get();
        return view('proveedores.index', compact('proveedor'));
    }

    public function create()
    {
        $registro = new Proveedor();
        $route = route('proveedores.store');
        $method = "post";
        $title = "Proveedor - Nuevo registro";
        $readonly = "";
        $disabled = "";
        return view('proveedores.form', compact('registro','route','method','title','readonly','disabled'));
    }

    public function edit($uuid)
    {
        $proveedor = Proveedor::where('uuid',$uuid)->first();
        if (is_null($proveedor)) dd("Registro no encontrado");

        $registro = $proveedor;
        $route = route('proveedores.update',$proveedor->uuid);
        $method = "PATCH";
        $title = "Edición Registro (" . $proveedor->uuid . ")" ;
        //$opciones = ["generales","domicilio","contactos"];
        $opciones = ["generales"];
        $opcion = "generales";
        return view('proveedores.edit',compact('registro','route','method','title','opciones','opcion'));
    }

    public function store(ProveedorRequest $request)
    {
        $proveedor = new Proveedor;
        $proveedor = self::persist_data($request, $proveedor);

        return redirect(route('proveedores.edit',["id" => $proveedor->uuid]))
                    ->withSuccess('Datos almacenados con éxito');
    }

    public function update(ProveedorRequest $request, $uuid)
    {
        $this->authorize('update', $proveedor);

        $proveedor = self::persist_data($request, $proveedor);

        return redirect(route('proveedores.edit',['id' => $proveedor->id]))
                    ->withSuccess('Datos actualizados con éxito');
    }

    public function destroy($uuid)
    {
        $proveedor = Proveedor::where('uuid',$uuid)->first();
        if (is_null($proveedor)) dd("Registro no encontrado");

        $proveedor->delete();
        return redirect()->route('proveedores.index')->withSuccess("Registro Eliminado");
    }

    private function persist_data(Request $request, Proveedor $proveedor){
        if (is_null($proveedor->uuid)){
            $proveedor->uuid = (string)Str::orderedUuid();
        }
        $proveedor->nombre_corto = $request->nombre_corto ?? null;
        $proveedor->rfc = $request->rfc ?? null;
        $proveedor->razon_social = $request->razon_social ?? null;
        $proveedor->giro_id = $request->giro_id ?? null;
        $proveedor->servicios = $request->servicios ?? null;

        $proveedor->user_id = Auth::id();
        $proveedor->save();

        return $proveedor;
    }
}
