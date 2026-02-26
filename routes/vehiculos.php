<?php

use App\Models\Catalogo;
use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Role;

Route::middleware(['roles'=>"allow_to_roles:".Role::ADMIN.'|'.
		Role::SUPER_ADMIN])->group(function () {

	Route::resource('vehiculos', 'VehiculoController')->except(['show']);
	Route::post('vehiculos/{uuid}/delete', 'VehiculoController@destroy')
		->name('vehiculos.delete');

	Route::match(['get', 'post'],'vehiculos.list', function() {
			$items =  Vehiculo::query()
					->with(['marca:id,name','tipo_vehiculo:id,name','linea:id,name','estatus:id,name',
							'sucursal:id,name','area:id,name'])
					->select("vehiculos.*");

			return DataTables::eloquent($items)
				// ->addColumn('dias_vencimiento', function($item){ 
				// 	return 1;
				// })
				// ->addColumn('fullname', function($item){ 
				// 	return $item->contratante->fullname;
				// })
		        ->addColumn('acciones', function($item){ 
		        	$item_id = $item->uuid;

					$btn_delete = "#";
					$btn_delete = "
						<a href='$btn_delete' class='px-1 delete-button' 
							title='Eliminar' id='item_$item_id'>
							<span class='badge badge-danger text-white shadow'>
								<i class='fa fa-trash fa-2x'></i>
							</span>
						</a>";

					$btn_edit = route('vehiculos.edit',$item_id);
					$btn_edit = "
						<a href='$btn_edit' class='px-1' title='Editar'>
							<span class='badge orange text-white shadow'>
								<i class='fa fa-pencil fa-2x'></i>
							</span>
						</a>";

					$action_buttons = "
						<div class='row d-flex justify-content-center'>
							$btn_edit
							$btn_delete
						</div>";
					
	                return $action_buttons;
	            })
	            ->make(TRUE);
	})->name('vehiculos.list');	

});	


