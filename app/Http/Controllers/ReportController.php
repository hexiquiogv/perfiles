<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\CustomModel;
use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Str;
use DB;
use Auth;
use Log;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

class ReportController extends Controller
{
    public function filter(Report $report){
        // $r->columns = implode("|",collect($r->getColumns())->pluck('Field')->toArray());
        $route = route('export_excel',$report->id);
        return view('reports.filter_form',compact('report','route'));
    }

    public function export_excel(Report $report, Request $request){
        $columns = explode(",",$report->columns);

        // obtenemos una instancia de eloquent del modelo       
        // $model = DB::select("select * from ".$report->consulta->vista)->get();

        $query = CustomModel::fromTable($report->consulta->vista);    
        $query->setConnection($report->consulta->origen->name);    
        // $model->setTable($report->consulta->vista);

        // $fields = Schema::getColumnListing($query->getTable());
        foreach($request->except(['_token']) as $key => $value){
            $campo = str_replace("__fin", "", str_replace("__inicio", "", $key));
            
            if (is_null($value) || !in_array($campo, $columns)) continue;                        

            if (strpos(strtolower($key),"fecha") === false){
                $query = $query->where($key,'like',"%$value%");        
            } else {
                Log::info("es fecha $key $campo $value");

                if (str_contains($key , "__inicio")){
                    $query = $query->where($campo,'>=',"$value");        
                }
                if (str_contains($key , "__fin")){
                    $query = $query->where($campo,'<=',"$value");    
                }
                
            }
        }
        
        $datos = $query->select($columns)
                    //->where('grupo_id',Auth::user()->adscripcion_id)
                    ->get();
        
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser('file.xlsx'); // write data to a file or to a PHP stream
        
        //carga de encabezados
        $rowFromValues = WriterEntityFactory::createRowFromArray($columns);
        $writer->addRow($rowFromValues);
       
        //dd($encabesados);
        
        // carga de datos
        foreach ($datos as $dato) {
            $cells = [];
            foreach ($columns as $column) {
                $cells[] = WriterEntityFactory::createCell($dato[$column]);
            }        
            /** add a row at a time */
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);
        }
        $writer->close();

        //return view('exampleReport');
        //dd($vehiculos, $columnsName);
    }

    public function index(Request $request)
    {
        $route = route('reports.create');
        return view('reports.index',compact('route'));

    }

    public function edit(Report $report)
    {
        $route = route('reports.update',$report->id);
        $method = "PATCH";
        $registro = $report;

        return view('reports.form', compact('registro','route','method'));
    }

    public function create()
    {
        $route = route('reports.store');
        $method = "POST";
        $registro = new Report;

        return view('reports.form', compact('registro','route','method'));
    }

    public function store(ReportRequest $request)
    {
        $report = new Report;
        $report->uuid = (string)Str::orderedUuid();
        $report = self::persist_data($request, $report);
        return redirect( route('reports.edit',$report->id) )
                    ->withSuccess('Registro guardado éxitosamente');
    }

    public function update(ReportRequest $request, Report $report)
    {
        $report = self::persist_data($request, $report);
        return redirect( route('reports.edit',$report->id) )
                    ->withSuccess('Modificaciones guardadas éxitosamente');
    }

    public function persist_data(Request $request, Report $report) {
        $report->title = $request->title;
        $report->description = $request->description ?? null;

        $report->group_id = $request->group_id ?? 0;
        $report->user_id = Auth::id();

        $report->consulta_id = $request->consulta_id;
        $report->origen_informacion_id = $report->consulta->origen_informacion_id;

        $columns = implode(",",
            collect($report->consulta->fields)->pluck('Field')->toArray()
        );

        $report->columns = isset($request->columns) ?
                implode(",",$request->columns) : $columns;
        $report->criterial_fields = isset($request->criterial_fields) ?
                implode(",",$request->criterial_fields) : $columns;

        $report->status_id = $request->status_id ?? null;
        $report->fecha_status = $request->fecha_status ?? null;

        $report->save();

        return $report;
    }

    public function destroy(Report $report) {
        $report->delete();
        return back()->withSuccess('El elemento fué eliminado con éxito.');
    }
}
