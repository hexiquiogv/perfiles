<?php

use App\Models\Catalogo;
use Illuminate\Http\Request;
use App\Models\Mantenimiento;
use App\Models\Autorizacion;
use App\Models\Cotizacion;
use App\Models\Media;
use App\Models\Role;

Route::middleware(['roles'=>'allow_to_roles:admin|super_admin'])->group(function () {
	Route::get('cotizaciones.edit/{uuid}', 'CotizacionesController@edit')
		->name('cotizaciones.edit');

	Route::post('cotizacion/{uuid}', 'CotizacionesController@store')
		->name('cotizacion');

	Route::get('cotizaciones', 'CotizacionesController@index')
		->name('cotizaciones');

	Route::match(['get', 'post'],'cotizaciones.list', function() {
		$estatus = Catalogo::find_item(Catalogo::ESTATUS_MANTENIMIENTO,Catalogo::COTIZANDO)->first();
		$items = Mantenimiento::query()
					->with(['estatus:id,name','chofer'])
					->where('estatus_id',$estatus->id)
					->select('mantenimientos.*');

		return DataTables::eloquent($items)
				->addColumn('no_economico', function($item){
					return json_decode($item->datos_vehiculo)->no_economico;
				})
				->addColumn('tipo_vehiculo', function($item){
					return json_decode($item->datos_vehiculo)->tipo_vehiculo;
				})
				->addColumn('marca', function($item){
					return json_decode($item->datos_vehiculo)->marca;
				})
				->addColumn('linea', function($item){
					return json_decode($item->datos_vehiculo)->linea;
				})
				->addColumn('placa', function($item){
					return json_decode($item->datos_vehiculo)->placa;
				})
				->addColumn('empresa', function($item){
					return json_decode($item->datos_vehiculo)->empresa;
				})
				->addColumn('sucursal', function($item){
					return json_decode($item->datos_vehiculo)->sucursal;
				})
				->addColumn('area', function($item){
					return json_decode($item->datos_vehiculo)->area;
				})
				->addColumn('chofer', function($item){
					return json_decode($item->datos_vehiculo)->chofer;
				})
				->addColumn('acciones', function($item){ 
		        	$item_id = $item->uuid;
					$btn_autorizar = "";
					$btn_edit = "";
					$btn_reporte = "";

					$btn_edit = route('cotizaciones.edit',$item_id);
					$btn_edit = "
						<a href='$btn_edit' class='px-1' title='Editar'>
							<span class='badge orange text-white shadow'>
								<i class='fa fa-pencil fa-2x'></i>
							</span>
						</a>";
				
					$btn_reporte = route('reporte.download',$item_id);
					$btn_reporte = "
						<a href='$btn_reporte' class='px-1' title='Ver Reporte' target='_blank'>
							<span class='badge purple text-white shadow'>
								<i class='fa fa-exclamation-triangle fa-2x'></i>
							</span>
						</a>";

					if (!is_null($item->cotizacion_uuid)){
						$btn_autorizar = route('autorizadores',$item_id);
						$btn_autorizar = "
							<a href='$btn_autorizar' class='px-1' title='Autorizar'>
								<span class='badge pink text-white shadow'>
									<i class='fa fa-google-wallet fa-2x'></i>
								</span>
							</a>";
					}
					
					$action_buttons = "
						<div class='row d-flex justify-content-center'>
							$btn_edit
							$btn_reporte
							$btn_autorizar
						</div>";
					
	                return $action_buttons;
	            })
	            ->make(TRUE);
	})->name('cotizaciones.list');	

	Route::match(['get', 'post'],'orden_servicio_cotizaciones.list/{uuid}', function($uuid) {
		$mantenimiento = Mantenimiento::where('uuid',$uuid)->first();
		$items = Cotizacion::where('model_name',get_class($mantenimiento))
					->where('model_id',$mantenimiento->id)
					->with(['proveedor:id,nombre_corto','instalacion:id,nombre','seleccionada:id,name'])
					->select('cotizaciones.*');

		return DataTables::eloquent($items)
				->addColumn('seleccionada', function($item){ 
					$seleccionada = $item->seleccionada->name;
					return "<span class='badge badge-success'>$seleccionada</span>";
				})
				->addColumn('acciones', function($item){ 
		        	$item_id = $item->uuid;
					$btn_seleccionar = route('cotizaciones.check',$item_id);
					$btn_seleccionar = "
						<a href='$btn_seleccionar' class='px-1' 
							title='Seleccionar' id='item_$item_id'>
							<span class='badge badge-success text-white shadow'>
								<i class='fa fa-check fa-2x'></i>
							</span>
						</a>";

					$btn_delete = "#";
					$btn_delete = "
						<a href='$btn_delete' class='px-1 delete-button' 
							title='Eliminar' id='item_$item_id'>
							<span class='badge badge-danger text-white shadow'>
								<i class='fa fa-trash fa-2x'></i>
							</span>
						</a>";

					$action_buttons = "
						<div class='row d-flex justify-content-center'>
							$btn_seleccionar
							$btn_delete
						</div>";
					
	                return $action_buttons;
	            })
	            ->make(TRUE);
	})->name('orden_servicio_cotizaciones.list');	

	Route::post('cotizaciones.delete/{uuid}','CotizacionesController@destroy')
		->name('cotizaciones.delete');

	Route::get('cotizaciones.check/{uuid}','CotizacionesController@check')
		->name('cotizaciones.check');

	Route::get('cotizaciones.show/{uuid}', 'CotizacionesController@show')->name('cotizaciones.show');

});	


