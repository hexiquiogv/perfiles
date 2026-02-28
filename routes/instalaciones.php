<?php

use App\Models\Instalacion;
use Illuminate\Http\Request;

Route::middleware(['roles'=>'allow_to_roles:admin|super_admin|user'])->group(function () {
	Route::get('instalaciones/{cliente}','InstalacionController@index')
		->name('instalaciones');
	Route::get('instalaciones.create/{cliente}','InstalacionController@create')
		->name('instalaciones.create');
	Route::post('instalaciones.store/{cliente}','InstalacionController@store')
		->name('instalaciones.store');
	Route::get('instalaciones.edit/{instalacion}','InstalacionController@edit')
		->name('instalaciones.edit');
	Route::post('instalaciones.delete/{instalacion}','InstalacionController@destroy')
		->name('instalaciones.delete');
	Route::patch('instalaciones.update/{instalacion}','InstalacionController@update')
		->name('instalaciones.update');
	Route::match(['get', 'post'],'list.instalaciones/{cliente}', function(Request $request, $cliente) {
		$items = Instalacion::where('cliente_id',$cliente)->with('contacto')
			->select('instalaciones.*');
		return DataTables::eloquent($items)
				->addColumn('direccion', function($item){ 
	                return $item->direccion;
	            })
		        ->addColumn('acciones', function($item){ 
		        	$item_id = $item->id;
		        	$btn_edit = route('instalaciones.edit',$item_id);
					$btn_delete = "";
					if (Auth::user()->isAdmin) {
						$btn_delete = "#";
						$btn_delete = "
						<a href='$btn_delete' title='Eliminar' class='delete-button'
							id='item_$item_id'>
							<span class='badge badge-danger text-white shadow'>
								<i class='fa fa-trash fa-2x'></i>
							</span>
						</a>";						
					}
					$action_buttons = "
					<div class='row d-flex justify-content-around pr-3'>
						<a href='$btn_edit' title='Editar'>
							<span class='badge badge-warning text-white shadow'>
								<i class='fa fa-pencil fa-2x'></i>
							</span>
						</a>
						$btn_delete
					</div>	
					";
					
	                return $action_buttons;
	            })
	            ->make(TRUE);
	})->name('list.instalaciones');
});

Route::middleware(['auth'])->group(function () {
	Route::match(['get', 'post'],'instalacion_items/{cliente}', function(Request $request, $cliente) {
		$data = Instalacion::where('cliente_id',$cliente)->select('nombre as name','id')->get();
		return response()->json([
	        'status' => 'ok',
	        'data' => $data
	    ]);
	})->name('instalacion_items');
});

