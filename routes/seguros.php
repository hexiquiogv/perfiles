<?php

use App\Models\Catalogo;
use Illuminate\Http\Request;
use App\Models\Seguro;
use App\Models\Role;

Route::middleware(['roles'=>"allow_to_roles:".Role::ADMIN.'|'.
		Role::SUPER_ADMIN])->group(function () {

	Route::resource('seguros', 'SeguroController')->except(['show']);
	Route::post('seguros/{uuid}/delete', 'SeguroController@destroy')
		->name('seguros.delete');

	Route::match(['get', 'post'],'seguros.list', function() {
			$items =  Seguro::query()
					->with(['nombre_plan:id,name','tipo_seguro:id,name','clasificacion_plan:id,name','estatus:id,name',
							'contratante:id,nombre,paterno,materno'])
					->select("seguros.*");

			return DataTables::eloquent($items)
				->addColumn('dias_vencimiento', function($item){ 
					return 1;
				})
				->addColumn('fullname', function($item){ 
					return $item->contratante->fullname;
				})
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

					$btn_edit = route('seguros.edit',$item_id);
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
	})->name('seguros.list');	

});	


