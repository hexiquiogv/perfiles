<?php

use App\Models\Catalogo;
use Illuminate\Http\Request;
use App\Models\Mantenimiento;
use App\Models\Media;
use App\Models\Role;

Route::middleware(['roles'=>"allow_to_roles:".Role::ADMIN.'|'.
		Role::SUPER_ADMIN])->group(function () {

	Route::get('ordenes.edit/{uuid}', 'OrdenController@edit')
		->name('ordenes.edit');
	

	Route::match(['get', 'post'],'ordenes.list', function() {
		$items = Mantenimiento::query()
					->with(['estatus:id,name','empresa:id,name','sucursal:id,name',
						'area:id,name','vehiculo','chofer'])
					->select('mantenimientos.*');

		return DataTables::eloquent($items)
				->addColumn('acciones', function($item){ 
		        	$item_id = $item->uuid;
					$btn_cotizacion = "";
					$btn_edit = "";
					$btn_reporte = "";

					$btn_edit = route('mantenimientos.orden',$item_id);
					$btn_edit = "
						<a href='$btn_edit' class='px-1' title='Editar'>
							<span class='badge orange text-white shadow'>
								<i class='fa fa-pencil fa-2x'></i>
							</span>
						</a>";
				
					$registro = Mantenimiento::find($item_id);
					$reporte = $registro->getReporte();
					if (!is_null($reporte)){
						$btn_reporte = route('media.download',$reporte->uuid);
						$btn_reporte = "
							<a href='$btn_reporte' class='px-1' title='Ver Reporte'>
								<span class='badge purple text-white shadow'>
									<i class='fa fa-exclamation-triangle fa-2x'></i>
								</span>
							</a>";
					}

					$btn_cotizacion = "#";
					$btn_cotizacion = "
						<a href='$btn_cotizacion' class='px-1' title='Cotizaciones'>
							<span class='badge green text-white shadow'>
								<i class='fa fa-dollar fa-2x'></i>
							</span>
						</a>";


					$action_buttons = "
						<div class='row d-flex justify-content-center'>
							$btn_edit
							$btn_reporte
							$btn_cotizacion
						</div>";
					
	                return $action_buttons;
	            })
	            ->make(TRUE);
	})->name('ordenes.list');	

});	


