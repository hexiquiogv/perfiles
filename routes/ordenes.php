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

	Route::patch('ordenes.update/{uuid}', 'OrdenController@update')
		->name('ordenes.update');

	Route::get('ordenes', 'OrdenController@index')
		->name('ordenes');

	Route::match(['get', 'post'],'ordenes.list', function() {
		$estatus = Catalogo::find_item(Catalogo::ESTATUS_MANTENIMIENTO,Catalogo::ORDEN_SERVICIO)->first();
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
					$btn_cotizacion = "";
					$btn_edit = "";
					$btn_reporte = "";

					$btn_edit = route('ordenes.edit',$item_id);
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

					$btn_cotizacion = "#";
					$btn_cotizacion = "
						<a href='$btn_cotizacion' class='px-1' title='Cotizaciones'>
							<span class='badge green text-white shadow'>
								<i class='fa fa-list-ul fa-2x'></i>
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


