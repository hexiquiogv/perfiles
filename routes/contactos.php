<?php

use App\Models\Contacto;
use Illuminate\Http\Request;

Route::middleware(['roles'=>'allow_to_roles:admin|super_admin|user'])->group(function () {
	Route::get('contactos/{cliente}','ContactoController@index')
		->name('contactos');
	Route::get('contactos.create/{cliente}','ContactoController@create')
		->name('contactos.create');
	Route::post('contactos.store/{cliente}','ContactoController@store')
		->name('contactos.store');	
	Route::match(['get', 'post'],'list.contactos/{cliente}', function(Request $request, $cliente) {
		$items = Contacto::where('cliente_id',$cliente)
						->with('representante')
						->select('contactos.*');
		return DataTables::eloquent($items)
		        ->addColumn('acciones', function($item){ 
		        	$item_id = $item->id;
		        	$btn_edit = route('contactos.edit',$item_id);
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
	})->name('list.contactos');

	Route::match(['get', 'post'],'contactos_items/{cliente}', function(Request $request, $cliente) {
		$data = Contacto::where('cliente_id',$cliente)->select('nombre as name','id')->get();
		return response()->json([
	        'status' => 'ok',
	        'data' => $data
	    ]);
	})->name('contactos_items');
	
});

Route::middleware(['administrator'])->group(function () {
	Route::get('contactos.edit/{contacto}','ContactoController@edit')
		->name('contactos.edit');
	Route::patch('contactos.update/{contacto}','ContactoController@update')
		->name('contactos.update');
	Route::post('contactos.delete/{contacto}','ContactoController@destroy')
		->name('contactos.delete');
});


