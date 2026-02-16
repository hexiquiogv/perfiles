<?php
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Consulta;
use App\Models\Catalogo;

Route::middleware(['roles'=>"allow_to_roles:".Role::ADMIN.'|'.Role::SUPER_ADMIN])->group(function () {

	Route::get('migrate.view/{consulta}', 'ConsultaController@migrate')->name('migrate.view');
	Route::get('review/{consulta}', 'ConsultaController@review')->name('review');
	Route::post('export.review/{consulta}', 'ConsultaController@export')->name('export.review');

	Route::match(['get', 'post'],'consultas.list', function() {
			$items =  Consulta::query()->orderBy('id','desc')->with(['origen','status','user'])
							->select("consultas.*");

			return DataTables::eloquent($items)
		        ->addColumn('acciones', function($item){ 
		        	$item_id = $item->id;
					$btn_edit = "";
					$btn_view = route('review',$item_id);
					$btn_migrate = "";
					$btn_delete = "";

					if (Auth::user()->isAdmin) {
						$btn_delete = "#";
						$btn_delete = "
							<a href='$btn_delete' class='px-1 delete-button' 
								title='Eliminar' id='item_$item_id'>
								<span class='badge badge-danger text-white shadow'>
									<i class='fa fa-trash fa-2x'></i>
								</span>
							</a>";
						
						if( strlen($item->sql_script)>0 ){
							$btn_migrate = route('migrate.view',$item_id);
							$btn_migrate = "
								<a href='$btn_migrate' class='px-1' title='Ejecutar Migración'>
									<span class='badge badge-success text-white shadow'>
										<i class='fa fa-gears fa-2x'></i>
									</span>
								</a>";
						}

						$btn_edit = route('consultas.edit',$item_id);
						$btn_edit = "
							<a href='$btn_edit' class='px-1' title='Editar'>
								<span class='badge orange text-white shadow'>
									<i class='fa fa-pencil fa-2x'></i>
								</span>
							</a>";
					}


					$btn_view = "
						<a href='$btn_view' class='px-1' title='Visualizar Consulta'>
							<span class='badge purple text-white shadow'>
								<i class='fa fa-th-large fa-2x'></i>
							</span>
						</a>";
					
					$action_buttons = "
						<div class='row d-flex justify-content-center'>
							$btn_edit
							$btn_migrate
							$btn_view
							$btn_delete
						</div>";
					
	                return $action_buttons;
	            })
	            ->make(TRUE);
	})->name('consultas.list');

	Route::get('consultas.index', 'ConsultaController@index')
		->name('consultas.index');
	Route::get('consultas.create', 'ConsultaController@create')
		->name('consultas.create');
	Route::get('consultas.edit/{consulta}', 'ConsultaController@edit')
		->name('consultas.edit');
	Route::post('consultas.store', 'ConsultaController@store')
		->name('consultas.store');
	Route::patch('consultas.update/{consulta}', 'ConsultaController@update')
		->name('consultas.update');
	Route::post('consultas.delete/{consulta}', 'ConsultaController@destroy')
		->name('consultas.delete');

	Route::match(['get', 'post'],'/consultas.items', function() {
		$value = 'activo';
		$data = Consulta::with(['status:id,name']);
		$user = Auth::user();
		if(!$user->isAdmin){
			$data = Consulta::with(['status:id,name'])
					->where(function ($query) use($value) {
						$query->whereHas('status', function($qry) use($value) {
							$qry->where('name',$value);
						});
					})->orWhere('user_id',$user->id);
		}
					
	    return response()->json([
	        'status' => 'ok',
	        'data' => $data->select('title as name', 'id')->get()
	    ]);
	})->name('consultas.items');
});

