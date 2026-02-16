<?php
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Consulta;
use App\Models\Report;

Route::middleware(['roles'=>"allow_to_roles:".Role::ADMIN.'|'.
		Role::SUPER_ADMIN])->group(function () {

	Route::get('reports.create', 'ReportController@create')
		->name('reports.create');
	Route::get('reports.edit/{report}', 'ReportController@edit')
		->name('reports.edit');
	Route::post('reports.store', 'ReportController@store')
		->name('reports.store');
	Route::patch('reports.update/{report}', 'ReportController@update')
		->name('reports.update');
	Route::post('reports.delete/{report}', 'ReportController@destroy')
		->name('reports.delete');

});
Route::middleware(['auth'])->group(function () {
	Route::get('reports.index', 'ReportController@index')
		->name('reports.index');
	route::get('reports/{report}', 'ReportController@filter')
				->name('execute');
	route::post('reports/{report}', 'ReportController@export_excel')
				->name('export_excel');

	Route::match(['get', 'post'],'reports.list', function() {
			$user = Auth::user();
			$value = 'activo';
			$items = Report::with(['status']);
			if(!$user->isAdmin){
				$items = Report::with(['status'])
						->where(function ($query) use($value) {
							$query->whereHas('status', function($qry) use($value) {
								$qry->where('name',$value);
							});
						})->orWhere('user_id',$user->id);
			}

			return DataTables::eloquent($items->orderBy('id','desc'))
		        ->addColumn('acciones', function($item){ 
		        	$item_id = $item->id;
					$btn_edit = "";
					$btn_execute = route('execute',$item_id);
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
						$btn_edit = route('reports.edit',$item_id);
						$btn_edit = "
							<a href='$btn_edit' class='px-1' title='Editar'>
								<span class='badge orange text-white shadow'>
									<i class='fa fa-pencil fa-2x'></i>
								</span>
							</a>";
					}
								
					$btn_execute = "
						<a href='$btn_execute' target='_blank' 
							class='px-1' title='Ejecutar'>
							<span class='badge purple text-white shadow'>
								<i class='fa fa-th-large fa-2x'></i>
							</span>
						</a>";
					$action_buttons = "
						<div class='row d-flex justify-content-center'>
							$btn_edit
							$btn_execute
							$btn_delete
						</div>";
					
	                return $action_buttons;
	            })
	            ->make(TRUE);
	})->name('reports.list');

	Route::match(['get', 'post'],'/reports.items', function() {
		$data = Report::select('title as name', 'id')->get();
	    return response()->json([
	        'status' => 'ok',
	        'data' => $data
	    ]);
	})->name('reports.items');

	Route::match(['get', 'post'],'/report.model.columns/{report}', function(Report $report) {
		$data = [];
		foreach(collect($report->consulta->fields)->pluck('Field') as $column){
			$data[] = [
				'id' => $column,
				'name' => $column
			];
		}
	    return response()->json([
	        'status' => 'ok',
	        'data' => $data
	    ]);
	})->name('report.model.columns');
});

