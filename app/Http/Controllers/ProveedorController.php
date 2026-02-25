<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Proveedor;
use App\Http\Requests\ProveedorRequest;

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
        $catalogos = \APP\Models\Catalogo::class;
        $proveedor = new Proveedor();
        $route = route('proveedores.store');
        $method = "post";
        $title = "Proveedor - Nuevo registro";
        $readonly = "";
        $disabled = "";
        $tipo_proveedor = \App\Models\Catalogo::find_by_name('TIPO_PROVEEDOR')->first()->items()->get(['id','name']);
        return view('proveedores.form', compact('proveedor','route','method','title','readonly','disabled','tipo_proveedor'));
    }

    public function edit(Proveedor $proveedor)
    {
        $registro = $proveedor;
        $route = route('proveedores.update',['proveedor' => $proveedor]);
        $method = "PATCH";
        $title = "Edición Registro (" . $proveedor->id . ")" ;
        return view('proveedores.edit',compact('registro','route','method','title'));
    }

    public function store(ProveedorRequest $request)
    {
        $proveedor = new Proveedor;
        $proveedor = self::persist_data($request, $proveedor);

        return redirect(route('proveedores.edit',["id" => $proveedor->id]))
                    ->withSuccess('Datos almacenados con éxito');
    }

    public function update(ProveedorRequest $request, Proveedor $proveedor)
    {
        $this->authorize('update', $proveedor);

        $proveedor = self::persist_data($request, $proveedor);

        return redirect(route('proveedores.edit',['id' => $proveedor->id]))
                    ->withSuccess('Datos actualizados con éxito');
    }

    public function destroy(Proveedor $proveedor){
        $this->authorize('delete', $proveedor);

        $proveedor->delete();
        return redirect()->route('proveedores.index')->withSuccess("Registro Eliminado");
    }

    private function persist_data(Request $request, Proveedor $proveedor){
        if (is_null($proveedor->uuid)){
            $proveedor->uuid = (string)Str::orderedUuid();
        }
        $proveedor->nombre_corto = $request->nombre_corto;
        $proveedor->rfc = $request->rfc;
        $proveedor->razon_social = $request->razon_social;
        $proveedor->save();

        return $proveedor;
    }
}
