<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogo;
use Log;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        $route = 'catalogos';
        $parent_id = null;
        if( isset($request['parent_id']) && $request['parent_id'] != 'null'){
            $parent_id = $request['parent_id'];
        }
        $catalogos = Catalogo::where('parent_id',$parent_id)->get();
        $bread_crumbs = self::get_bread_crumbs($parent_id);
        //dd($bread_crumbs);
        return view('catalogos.index', 
            compact('catalogos','parent_id','bread_crumbs','route'));

    }

    public function show(Catalogo $catalogo)
    {
        $current_catalogo = $catalogo->current_catalogo();
        return view('catalogos.show', compact('catalogo','current_catalogo'));
    }

    public function edit(Catalogo $catalogo)
    {
        $route=route('catalogos.update',$catalogo);
        $method = "PUT";
        $title_form='Editar';
        $submitButtonText='Guardar';
        $buttonStyle='btn-success';
        $readonly='';
        $disabled='';

        $current_catalogo = $catalogo->current_catalogo();
        return view('catalogos.form', compact('catalogo','current_catalogo',
            'route','method','title_form','submitButtonText','buttonStyle',
            'readonly','disabled'));
    }

    public function create(Request $request)
    {
        $parent_id = null;
        if( isset($request['parent_id']) && $request['parent_id'] != 'null'){
            $parent_id = $request['parent_id'];
        }
        $catalogo = new Catalogo;
        $catalogo->parent_id = $parent_id;
        $current_catalogo = $catalogo->current_catalogo();

        $route=route('catalogos.store');
        $method = "POST";
        $title_form='Crear';
        $submitButtonText='Guardar';
        $buttonStyle='btn-success';
        $readonly='';
        $disabled='';

        return view('catalogos.form', compact('catalogo','current_catalogo',
            'route','method','title_form','submitButtonText','buttonStyle',
            'readonly','disabled'));
    }

    public function store(Request $request)
    {
        // validate
        $this->validate(request(), [
            'name' => 'required'           
        ]);
        $parent_id = null;
        if( isset($request['parent_id']) && $request['parent_id'] != 'null'){
            $parent_id = $request['parent_id'];
        }
        $catalogo = new Catalogo;
        $catalogo->parent_id = $parent_id;
        $catalogo->name = $request->name;
        $catalogo->description = $request->description ?? null;
        $catalogo->save();

        return redirect( route('catalogos.index',"parent_id=".$catalogo->parent_id) )
                    ->withSuccess('Elemento guardado con éxitosamente');
    }

    public function update(Request $request, Catalogo $catalogo) {
        // validate
        $this->validate(request(), [
            'name' => 'required'           
        ]);

        // store
        $catalogo->name = request('name');
        $catalogo->description = $request->description ?? null;
        $catalogo->save();
        
        return redirect()->route('catalogos.index',"parent_id=".$catalogo->parent_id)
                    ->withSuccess('Elemento actualizado con éxito');
    }

    public function destroy($catalogo_id) {
        $catalogo = Catalogo::find($catalogo_id);
        if (isset($catalogo)) {
            $catalogo->delete();
            return back()->withSuccess('El elemento eliminado');
        } else {
            return back()->withError('Fallo al eliminar el elemento');
        }
    }

    public function get_bread_crumbs($parent_id=null, $reverse=true){
        $catalogo = Catalogo::find($parent_id);
        $results = [];
        while ($catalogo){
            $results[ucfirst($catalogo->name)] = "parent_id=".$catalogo->id;
            $catalogo = $catalogo->parent;
        }
        $results["Catalogos"] = "parent_id=null";
        if ($reverse) $results = array_reverse($results);
        return $results;
    }  
}
