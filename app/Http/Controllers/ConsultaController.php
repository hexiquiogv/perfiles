<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\CustomModel;
use Illuminate\Http\Request;
use App\Exports\CustomExport;
use \Carbon\Carbon;
use DB;
use Auth;
use Excel;

class ConsultaController extends Controller
{
    public function index()
    {
        return view('consultas.index');
    }

    public function create()
    {
        $registro = new Consulta;
        $route = route('consultas.store');
        $method = "POST";
        return view('consultas.form', compact('registro','route','method'));
    }

    public function store(Request $request)
    {
        $registro = new Consulta;
        $registro = self::persist_data($registro, $request);

        return redirect()->route('consultas.edit',$registro->id)->withSuccess('Registro creado');
    }

    public function edit(Consulta $consulta)
    {
        $registro = $consulta;
        $route = route('consultas.update',$consulta->id);
        $method = "PATCH";

        return view('consultas.form', compact('registro','route','method'));
    }

    public function update(Request $request, Consulta $consulta)
    {
        $registro = self::persist_data($consulta, $request);

        return redirect()->route('consultas.edit',$registro->id)->withSuccess('Registro actualizado');
    }

    public function destroy(Consulta $consulta) {
        $consulta->delete();
        return redirect(route('consultas.index'))->withSuccess("Se eliminó el registro");
    }

    private function persist_data(Consulta $consulta, Request $request)
    {
        $consulta->origen_informacion_id = $request->origen_informacion_id;
        $consulta->title = $request->title;
        $consulta->vista = $request->vista;
        $consulta->description = $request->description ?? null;
        $consulta->sql_script = $request->sql_script ?? null;
        $consulta->status_id = $request->status_id ?? null;
        $consulta->user_id = Auth::id();

        $consulta->save();

        return $consulta;
    }

    public function migrate(Consulta $consulta)
    {
        if (strlen($consulta->sql_script) == 0) return back()->withWarning('No puede ejecutarse una migracion para una tabla');

        $old_view = $consulta->vista;
        $new_view = $consulta->vista ."_".Carbon::now()->getTimestampMs();

        $table_schema = DB::connection($consulta->origen->name)->getDatabaseName();

        $sql_verify = "select table_schema as database_name, table_name 
            from information_schema.tables 
            where table_name = '$old_view'
            and table_catalog = '$table_schema' ";
        $sql_drop_view = "drop view if exists $old_view;";

        if($consulta->origen->name != 'mysql'){
            $sql_verify = "select *  
            from information_schema.tables 
            where table_catalog = '$table_schema'
            and table_type = 'VIEW' 
            and concat(table_schema,'.',table_name) = '$old_view' ";
            $sql_drop_view = "if object_id('$old_view','v') is not null drop view $old_view;";
        }
        
        $results = DB::connection($consulta->origen->name)->select( $sql_verify );  
        if(count($results)>0)
        {            
            $sql_backup_view = "SELECT * INTO $new_view FROM $old_view ;";
            DB::connection($consulta->origen->name)->statement( $sql_backup_view );    
        }

        
        DB::connection($consulta->origen->name)->statement( $sql_drop_view );    

        DB::connection($consulta->origen->name)->statement( $consulta->sql_script );

        return back()->withSuccess("Se actualizó la vista");
    }

    public function review(Consulta $consulta)
    {
        $cm = CustomModel::fromTable($consulta->vista);
        $cm->setConnection($consulta->origen->name);
        $items = $cm->get();
        return view('consultas.review',compact('consulta','items'));
    }

    public function export(Request $request, Consulta $consulta)
    {
        if (!isset($request->select_item) || count($request->select_item) == 0) {
            return back()->withWarning('Ningún registro fué seleccionado');
        }

        $items = CustomModel::fromTable($consulta->vista)
                        ->whereIn('primary_key',$request->select_item)      
                        ->get();

        $items->each(function ($item) {
            unset($item->primary_key);
            //unset($item->grupo_id);
        });

        return Excel::download(new CustomExport($items), $consulta->vista . '.xlsx');
    }
    
}
