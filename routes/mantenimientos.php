<?php

use App\Models\Catalogo;
use Illuminate\Http\Request;
use App\Models\Mantenimiento;
use App\Models\Media;
use App\Models\Role;

Route::middleware(['roles'=>"allow_to_roles:".Role::ADMIN.'|'.
		Role::SUPER_ADMIN])->group(function () {

	Route::resource('mantenimientos', 'MantenimientoController')->except(['show','destroy']);	
	Route::post('mantenimientos/{uuid}/delete', 'MantenimientoController@destroy')
		->name('mantenimientos.delete');
	Route::get('mantenimientos.reporte/{uuid}', 'MantenimientoController@reporte')
		->name('mantenimientos.reporte');
	Route::get('reporte.download/{uuid}', 'MantenimientoController@reporte_download')
		->name('reporte.download');

	Route::view('mantenimientos.menu','mantenimientos.menu')->name('mantenimientos.menu');

	Route::match(['get', 'post'],'reportes_mtto.list', function() {
		$estatus = Catalogo::find_item(Catalogo::ESTATUS_MANTENIMIENTO,Catalogo::EN_PROCESO)->first();
		$items = Mantenimiento::with('estatus:id,name')
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
					return json_decode($item->datos_vehiculo)->tipo_vehiculo;
				})
		        ->addColumn('acciones', function($item){ 
		        	$item_id = $item->uuid;
					$btn_delete = "";
					$btn_edit = "";
					$btn_reporte = "";
					$btn_orden = "";

					if(Auth::user()->isSuperAdmin){
						$btn_delete = "#";
						$btn_delete = "
							<a href='$btn_delete' class='px-1 delete-button' 
								title='Eliminar' id='item_$item_id'>
								<span class='badge badge-danger text-white shadow'>
									<i class='fa fa-trash fa-2x'></i>
								</span>
							</a>";
					}

					if ( is_null($item->estatus) || $item->estatus->name == Catalogo::EN_PROCESO ) {
						$btn_edit = "
							<a href='$btn_edit' class='px-1' title='Editar'>
								<span class='badge orange text-white shadow'>
									<i class='fa fa-pencil fa-2x'></i>
								</span>
							</a>";
					} else {
						$btn_reporte = route('reporte.download',$item->uuid);
						$btn_reporte = "
							<a href='$btn_reporte' class='px-1' title='Ver Reporte' target='_blank'>
								<span class='badge purple text-white shadow'>
									<i class='fa fa-exclamation-triangle fa-2x'></i>
								</span>
							</a>";
					}
					
					switch ($item->estatus->name) {
						case Catalogo::EN_PROCESO:
							$btn_orden = route('mantenimientos.reporte',$item_id);
							$btn_orden = "
								<a href='$btn_orden' class='px-1' title='Orden de Servicio'>
									<span class='badge purple text-white shadow'>
										<i class='fa fa-clipboard fa-2x'></i>
									</span>
								</a>";
							break;
						case Catalogo::ORDEN_SERVICIO:
							$btn_orden = route('ordenes.edit',$item_id);
							$btn_orden = "
								<a href='$btn_orden' class='px-1' title='Orden de Servicio'>
									<span class='badge green text-white shadow'>
										<i class='fa fa-clipboard fa-2x'></i>
									</span>
								</a>";
							break;
					}

					$action_buttons = "
						<div class='row d-flex justify-content-center'>
							$btn_edit
							$btn_reporte
							$btn_orden
							$btn_delete
						</div>";
					
	                return $action_buttons;
	            })
	            ->make(TRUE);
	})->name('reportes_mtto.list');	

	Route::view('historicos', 'mantenimientos.historicos')->name('historicos');
	Route::match(['get', 'post'],'historicos.list', function() {
		$items = Mantenimiento::with('estatus:id,name')
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
					return json_decode($item->datos_vehiculo)->tipo_vehiculo;
				})
		        ->addColumn('acciones', function($item){ 
		        	$item_id = $item->uuid;
					$btn_orden = "";
					
					$btn_reporte = route('reporte.download',$item->uuid);
					$btn_reporte = "
						<a href='$btn_reporte' class='px-1' title='Ver Reporte' target='_blank'>
							<span class='badge purple text-white shadow'>
								<i class='fa fa-exclamation-triangle fa-2x'></i>
							</span>
						</a>";
					

					$action_buttons = "
						<div class='row d-flex justify-content-center'>
							$btn_orden
							$btn_reporte
						</div>";
					
	                return $action_buttons;
	            })
	            ->make(TRUE);
	})->name('historicos.list');	

	Route::get('signaturepad', 'SignaturePadController@index')->name('signaturepad');
	Route::post('signaturepad', 'SignaturePadController@upload')->name('signaturepad.upload');
});	


