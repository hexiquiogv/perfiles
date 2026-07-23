<?php

use App\Models\Catalogo;
use Illuminate\Http\Request;
use App\Models\Mantenimiento;
use App\Models\Media;
use App\Models\Role;

Route::middleware(['roles'=>"allow_to_roles:".Role::ADMIN.'|'.
		Role::SUPER_ADMIN])->group(function () {

	Route::view('taller', 'taller.index')->name('taller');

	Route::get('taller.orden/{uuid}', 'OrdenController@reporte')->name('taller.orden');

	Route::match(['get', 'post'],'ordenes_autorizadas.list', function() {
		$estatus = Catalogo::find_item(Catalogo::ESTATUS_MANTENIMIENTO,Catalogo::AUTORIZADO)->first();
		$estatus2 = Catalogo::find_item(Catalogo::ESTATUS_MANTENIMIENTO,Catalogo::EN_TALLER)->first();
		$items = Mantenimiento::query()
					->with(['estatus:id,name','chofer'])
					->where('estatus_id',$estatus->id)
					->orWhere('estatus_id',$estatus2->id)
					->select('mantenimientos.*');

		return DataTables::eloquent($items)
				->addColumn('proveedor', function($item){
					return $item->cotizacion()->proveedor->nombre_corto;
				})
				->addColumn('instalacion', function($item){
					$instalacion = $item->cotizacion()->instalacion;
					return $instalacion->direccion . ", tel. " . $instalacion->telefono;
				})
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
					$btn_edit = route("taller.edit",$item_id);
					$btn_reporte = "#";
					$btn_orden = route("taller.orden",$item_id);

					$btn_edit = "
						<a href='$btn_edit' class='px-1' title='Editar'>
							<span class='badge orange text-white z-depth-2 p-1'>
								<i class='fa fa-pencil fa-2x'></i>
							</span>
						</a>";
				
					$btn_reporte = "
						<a href='$btn_reporte' class='px-1' title='Ver Reporte' target='_blank'>
							<span class='badge blue text-white z-depth-2 p-1'>
								<i class='fa fa-file fa-2x'></i>
							</span>
						</a>";
					$btn_orden = "
						<a href='$btn_orden' class='px-1' title='Ver Orden de Servicio' target='_blank'>
							<span class='badge green text-white z-depth-2 p-1'>
								<i class='fa fa-gears fa-2x'></i>
							</span>
						</a>";

					$action_buttons = "
						<div class='row d-flex justify-content-center'>
							$btn_edit
							$btn_reporte
							$btn_orden
						</div>";
					
	                return $action_buttons;
	            })
	            ->make(TRUE);
	})->name('ordenes_autorizadas.list');	

	Route::get('taller.edit/{uuid}', 'OrdenController@taller_edit')->name('taller.edit');

	Route::patch('taller.update/{uuid}','OrdenController@taller_update')->name('taller.update');
});	

Route::middleware(['web'])->group(function () {
	Route::get('upload/{uuid}','OrdenController@upload')->name('upload');
});

