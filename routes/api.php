<?php

use Illuminate\Http\Request;
use App\Models\CustomModel;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/consulta/{delegacion}/{query}', 
    function (Request $request,$delegacion,$query) {

    $catalogo = App\Models\Catalogo::find($delegacion);
    // Log::debug("delegacion ".$catalogo->nombre." , query $query");
    $data = null;
    if (is_null($catalogo)) {
        return response()->json(
        [
            'status' => 'error',
            'data' => $data,
            'message' => 'parameter invalid'
        ]);    
    }
    
    $current_date = Carbon\Carbon::today();
    $fecha_inicial = $current_date;
    $fecha_final = $current_date;
    if (isset($request->fecha_inicial)){
        $fecha_inicial = Carbon\Carbon::createFromFormat('Y-m-d', 
            $request->fecha_inicial, env('TIMEZONE'));   
    }
    if (isset($request->fecha_final)){
        $fecha_final = Carbon\Carbon::createFromFormat('Y-m-d', 
            $request->fecha_final, env('TIMEZONE'));   
    }

    $connection = $catalogo->nombre;
    $data = [];

    switch ($query) {
        case 2:
            $expedientes = App\Models\Sigi\Expediente::on($connection)      
                            ->whereDate('dFechaCreacion', '>=', 
                                $fecha_inicial->format('Y-m-d'))
                            ->whereDate('dFechaCreacion', '<=', 
                                $fecha_final->format('Y-m-d'))
                            ->with('catDiscriminante','delitos','delitos.categoria_delito')
                            ->with(['catDiscriminante','caso','numero_expedientes'])
                            ->get();  

            $data['detalle'] =  $expedientes->groupBy('catDiscriminante.cNombre')
                        ->map(function ($row) {
                            return $row->count();
                        });

            $total = 0;
            foreach($data['detalle']->toArray() as $value){
                $total += $value;     
            }  
            $data['total'] = $total;

            break;
        case 3:
            $data['detalle'] = DB::connection($connection)
                ->select("SELECT c.cNumeroGeneralCaso as nuc,cd.cNombre as delito, ne.cNumeroExpediente,ne.dFechaApertura,concat(cApellidoPaternoFuncionario,' ',cApellidoMaternoFuncionario,', ',f.cNombreFuncionario) as funcionario,
                    cdl.cNombre as Municipio,e.dFechaCreacion  
                    FROM expediente e
                          inner join 
                                caso c on c.Caso_id = e.Caso_id 
                          left join 
                                delito d on d.Expediente_id = e.Expediente_id 
                                and d.bEsPrincipal=1 and d.CatDelito_id <> 628 
                          left join 
                                CatDelito cd on cd.CatDelito_id = d.CatDelito_id 
                          inner join 
                                NumeroExpediente ne on ne.Expediente_id = e.Expediente_id 
                                and ne.Estatus_val<>2958 
                                and ne.JerarquiaOrganizacional_id in (10,44) 
                          inner join 
                                CatDiscriminante cdis on cdis.catDiscriminante_id=e.catDiscriminante_id 
                          inner join 
                                CatDistrito cdl on cdl.catDistrito_id=cdis.catDistrito_id 
                          inner join 
                                Funcionario f on f.iClaveFuncionario = ne.iClaveFuncionario
                      where 
                          year(e.dfechacreacion) >= :year_start
                          and month(e.dfechacreacion) >= :month_start
                          and day(e.dfechacreacion) >= :day_start
                          and year(e.dfechacreacion) <= :year_end
                          and month(e.dfechacreacion) <= :month_end
                          and day(e.dfechacreacion) <= :day_end ",
                      [
                        'year_start' => $fecha_inicial->format('Y'),
                        'month_start' => $fecha_inicial->format('m'),
                        'day_start' => $fecha_inicial->format('d'),
                        'year_end' => $fecha_final->format('Y'),
                        'month_end' => $fecha_final->format('m'),
                        'day_end' => $fecha_final->format('d')
                      ]
                );

                $data['total'] = count($data['detalle']);
            break;
        case 4: 
            $data['detalle'] = DB::connection($connection)
                ->select("SELECT cd.cNombre, count(*) as cantidad 
                    FROM expediente e
                          inner join caso c on c.Caso_id = e.Caso_id 
                          inner join 
                                delito d on d.Expediente_id = e.Expediente_id 
                                and d.bEsPrincipal=1 and d.CatDelito_id <> 628 
                          left join 
                                CatDelito cd on cd.CatDelito_id = d.CatDelito_id 
                          inner join 
                                NumeroExpediente ne on ne.Expediente_id = e.Expediente_id 
                                and ne.Estatus_val<>2958 
                                and ne.JerarquiaOrganizacional_id in (10,44) 
                      where 
                          year(e.dfechacreacion) >= :year_start
                          and month(e.dfechacreacion) >= :month_start
                          and day(e.dfechacreacion) >= :day_start
                          and year(e.dfechacreacion) <= :year_end
                          and month(e.dfechacreacion) <= :month_end
                          and day(e.dfechacreacion) <= :day_end 
                      group by cd.cNombre order by cd.cNombre ",
                      [
                        'year_start' => $fecha_inicial->format('Y'),
                        'month_start' => $fecha_inicial->format('m'),
                        'day_start' => $fecha_inicial->format('d'),
                        'year_end' => $fecha_final->format('Y'),
                        'month_end' => $fecha_final->format('m'),
                        'day_end' => $fecha_final->format('d')
                      ] 
                );

            $data['total'] = collect($data['detalle'])->sum('cantidad');
            break;
    }

    $data['delegacion'] = $catalogo->nombre;
    $data['fecha_inicial'] = $request->fecha_inicial ?? null;
    $data['fecha_final'] = $request->fecha_final ?? null;

    return response()->json(['status' => 'ok','data' => $data]);
})->name('consulta');

Route::get('/detenidos/{delegacion_bcrypt}', function (Request $request, $uuid_delegacion) {
    // se aplica md5 a el nombre de la delegacion para que vaya codificado
    $delegaciones = App\Models\Catalogo::where('name','delegacion')->whereNull('parent_id')->first()->items;
    $catalogo = null;
    foreach ($delegaciones as $delegacion) {
      $uuid = md5($delegacion->name);
      if ($uuid == $uuid_delegacion){
        $catalogo = $delegacion;
        break;
      }
    }

    $data = null;
    if (is_null($catalogo) || $catalogo->parent->name != 'delegacion') {
        return response()->json(
        [
            'status' => 'error',
            'data' => $data,
            'message' => 'parameter invalid'
        ]);    
    }

    $connection = $catalogo->name;
    $data = [];

    $cm = CustomModel::fromTable( Config::get('consultas.detenidos') );
    $cm->setConnection( $connection );
    $results = $cm->get();
    
    $data['detalle'] = $results;
    $data['total'] = count($data['detalle']);
    $data['delegacion'] = $connection;
    $data['fecha'] = now();

    return response()->json(['status' => 'ok','data' => $data]);

})->name('detenidos');







