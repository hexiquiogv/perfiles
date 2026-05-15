<?php

use App\Models\Catalogo;
use Illuminate\Http\Request;
use App\Models\Mantenimiento;
use App\Models\Autorizacion;
use App\Models\Cotizacion;
use App\Models\Media;
use App\Models\Role;

Route::middleware(['roles'=>'allow_to_roles:admin|super_admin'])->group(function () {
	Route::get('autorizadores/{uuid}','AutorizacionController@autorizadores')
		->name('autorizadores');

	Route::view('autorizaciones','autorizaciones.index')->name('autorizaciones');

	Route::match(['get', 'post'],'por_autorizar', function() {
		$estatus = Catalogo::find_item(Catalogo::ESTATUS_MANTENIMIENTO,Catalogo::AUTORIZADO)->first();
		$items = Autorizacion::query()
					->with(['estatus:id,name','orden'])
					->where('user_id',Auth::id())
					->select('autorizaciones.*');

		return DataTables::eloquent($items)
				->addColumn('no_economico', function($item){
					return json_decode($item->orden->datos_vehiculo)->no_economico;
				})
				->addColumn('tipo_vehiculo', function($item){
					return json_decode($item->orden->datos_vehiculo)->tipo_vehiculo;
				})
				->addColumn('marca', function($item){
					return json_decode($item->orden->datos_vehiculo)->marca;
				})
				->addColumn('linea', function($item){
					return json_decode($item->orden->datos_vehiculo)->linea;
				})
				->addColumn('placa', function($item){
					return json_decode($item->orden->datos_vehiculo)->placa;
				})
				->addColumn('empresa', function($item){
					return json_decode($item->orden->datos_vehiculo)->empresa;
				})
				->addColumn('sucursal', function($item){
					return json_decode($item->orden->datos_vehiculo)->sucursal;
				})
				->addColumn('area', function($item){
					return json_decode($item->orden->datos_vehiculo)->area;
				})
				->addColumn('chofer', function($item){
					return json_decode($item->orden->datos_vehiculo)->chofer;
				})
				->addColumn('acciones', function($item){ 
		        	$item_id = $item->uuid;
					$btn_autorizar = "";
					$btn_edit = "";
					$btn_reporte = "";

					// $btn_edit = route('cotizaciones.edit',$item_id);
					// $btn_edit = "
					// 	<a href='$btn_edit' class='px-1' title='Editar'>
					// 		<span class='badge orange text-white shadow'>
					// 			<i class='fa fa-pencil fa-2x'></i>
					// 		</span>
					// 	</a>";
				
					// $btn_reporte = route('reporte.download',$item_id);
					// $btn_reporte = "
					// 	<a href='$btn_reporte' class='px-1' title='Ver Reporte' target='_blank'>
					// 		<span class='badge purple text-white shadow'>
					// 			<i class='fa fa-exclamation-triangle fa-2x'></i>
					// 		</span>
					// 	</a>";

					$btn_autorizar = "#";
					$btn_autorizar = "
						<a href='$btn_autorizar' class='px-1' title='Autorizar'>
							<span class='badge pink text-white shadow'>
								<i class='fa fa-google-wallet fa-2x'></i>
							</span>
						</a>";
					
					$action_buttons = "
						<div class='row d-flex justify-content-center'>
							$btn_edit
							$btn_reporte
							$btn_autorizar
						</div>";
					
	                return $action_buttons;
	            })
	            ->make(TRUE);
	})->name('por_autorizar');

});	


