<?php

use App\Models\Catalogo;
use App\Models\Role;
use Illuminate\Http\Request;

Route::middleware(['roles'=>"allow_to_roles:".Role::ADMIN.'|'.
		Role::SUPER_ADMIN])->group(function () {
	
	// Catalogos
	Route::resource('catalogos', 'CatalogoController')->except(['show']);
	Route::post('catalogos/{catalogo}/delete', 'CatalogoController@destroy')
		->name('catalogos.delete');

	Route::match(['get', 'post'],'list.catalogo/{catalogo}', 
		function(Request $request, $catalogo) {
			$parent = Catalogo::find_by_name($catalogo)->first();
			$items =  Catalogo::where('parent_id',$parent->id);

			return DataTables::eloquent($items)
		        ->addColumn('acciones', function($item){ 
		        	$item_id = $item->id;
					$btn_edit = route('list.edit',$item_id);
					$btn_delete = "#";
					$action_buttons = "
						<div class='row d-flex jsonustify-content-center'>
							<a href='$btn_edit' class='px-1' title='Editar'>
								<span class='badge orange text-white shadow'>
									<i class='fa fa-pencil fa-2x'></i>
								</span>
							</a>
							<a href='$btn_delete' class='px-1 delete-button' title='Eliminar'
								id='item_$item_id'>
								<span class='badge badge-danger text-white shadow'>
									<i class='fa fa-trash fa-2x'></i>
								</span>
							</a>
						</div>	
					";
					
	                return $action_buttons;
	            })
	            ->make(TRUE);
	})->name('list.catalogo');
	Route::get('list/{catalogo}', 'ListController@index')
		->name('list.index');
	Route::get('list/{catalogo}/create', 'ListController@create')
		->name('list.create');
	Route::get('list/{catalogo}/edit', 'ListController@edit')
		->name('list.edit');
	Route::post('list.delete/{catalogo}', 'ListController@destroy')
		->name('list.delete');
	Route::post('list.store/{catalogo}', 'ListController@store')
		->name('list.store');
	Route::patch('list.update/{catalogo}', 'ListController@update')
		->name('list.update');
});

Route::middleware(['web'])->group(function () {
	Route::match(['get', 'post'],'/items/{name}', function($name) {
		if (is_numeric($name))
			$catalogo = Catalogo::find($name);
		else
	    	$catalogo = Catalogo::find_by_name($name)->first();
	    
	    $data = !is_null($catalogo) ? $catalogo->items()->orderBy('name', 'ASC')->select('name','id')->get() : null;
	    return response()->json([
	        'status' => 'ok',
	        'data' => $data
	    ]);
	})->name('items');
});

