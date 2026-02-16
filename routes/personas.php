<?php

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Seguro;

Route::middleware(['auth'])->group(function () {
	Route::resource('personas', 'PersonaController')->except(['show']);
	Route::post('personas/{uuid}/delete', 'PersonaController@destroy')
		->name('personas.delete');

	Route::match(['get', 'post'],'personas.list', function() {
			$items = Persona::query()->orderBy('id','desc')
					->with(['sexo:id,name','estado_civil:id,name'])
					->select("personas.*");

			return DataTables::eloquent($items)
				->addColumn('polizas', function($item){ 					
					$polizas = [];
					foreach ($item->persona_seguros as $persona_seguro) {
						$seguro = Seguro::find($persona_seguro->seguro_id);
						if (!is_null($seguro)){
							$polizas[] = "
								<a style='color: blue !important; text-decoration: underline !important;'
								 href='". route("seguros.edit",$seguro->uuid) . "' target='_blank'>{$seguro->poliza}</a>
							";	
						}
						
					}
					return implode(", ", $polizas);
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
					$btn_edit = route('personas.edit',$item_id);
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
	})->name('personas.list');

	Route::match(['get', 'post'],'personas.seguro', function() {
		$data = [];
		foreach (Persona::query()->get() as $persona) {
		 	$data[] = [
		 		'name'=>$persona->fullname,
		 		'id'=>$persona->id
		 	];
		 } ;
	    return response()->json([
	        'status' => 'ok',
	        'data' => $data
	    ]);
	})->name('personas.seguro');


});	

