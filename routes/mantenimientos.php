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
	Route::view('mantenimientos.menu','mantenimientos.menu')->name('mantenimientos.menu');

	Route::match(['get', 'post'],'mantenimientos.list', function() {
		$documento_type = Catalogo::find_item(Catalogo::DOCUMENT_TYPE,Catalogo::REPORTE)->first();
		$documento_type_id = $documento_type->id;
		$sql_query = "
				select  m.id,m.uuid as uuid,m.folio folio, v.no_economico no_economico, tv.name as tipo_vehiculo,
						mc.name as marca, l.name as linea, v.placa as placa, e.name as empresa,
						s.name as sucursal, a.name as area,
						CONCAT(p.nombre,' ',p.paterno,' ',p.materno) as chofer,' ' as servicios,
						IF( g.name is null || LOWER(g.name)='si', '', 'garantia'),
						SUBSTRING(m.fecha_reporte,1,10) as fecha_reporte,
						SUBSTRING(m.fecha_entregado,1,10) as fecha_entregado,
						SUBSTRING(m.updated_at,1,10) as fecha_estatus,
						em.name as estatus,
						CONCAT(t.razon_social,' ',i.nombre) as proveedor
					from mantenimientos m 
						left join vehiculos v on m.vehiculo_id=v.id
						left join catalogos tv on v.tipo_vehiculo_id = tv.id
						left join catalogos mc on v.marca_id = mc.id
						left join catalogos l on v.linea_id = l.id
						left join catalogos e on v.empresa_id=e.id
						left join catalogos s on v.sucursal_id=s.id
						left join catalogos a on v.area_id=a.id
						left join personas p on v.chofer_id=p.id
						left join catalogos g on garantia_id=g.id
						left join catalogos em on m.estatus_id=em.id
						left join instalaciones i on m.proveedor_id=i.id
						left join proveedores t on i.proveedor_id = t.id
					where 
						m.deleted_at is null 	
			";
			$items = DB::select($sql_query);

			return DataTables::of($items)
		        ->addColumn('acciones', function($item){ 
		        	$item_id = $item->uuid;
					$btn_cotizacion = "";
					$btn_delete = "";
					$btn_edit = "";
					$btn_show = "";
					$btn_reporte = "";
					$btn_orden = "";

					$btn_delete = "#";
					$btn_delete = "
						<a href='$btn_delete' class='px-1 delete-button' 
							title='Eliminar' id='item_$item_id'>
							<span class='badge badge-danger text-white shadow'>
								<i class='fa fa-trash fa-2x'></i>
							</span>
						</a>";

					

					if (is_null($item->estatus)){
						$btn_edit = route('mantenimientos.edit',$item_id);
						$btn_edit = "
							<a href='$btn_edit' class='px-1' title='Editar'>
								<span class='badge orange text-white shadow'>
									<i class='fa fa-pencil fa-2x'></i>
								</span>
							</a>";
					} else if(!is_null($item->estatus)){
						$registro = Mantenimiento::find($item->id);
						$reporte = $registro->getReporte();
						if (!is_null($reporte)){
							$btn_reporte = route('media.download',$reporte->id);
							$btn_reporte = "
								<a href='$btn_reporte' class='px-1' title='Ver Reporte'>
									<span class='badge purple text-white shadow'>
										<i class='fa fa-exclamation-triangle fa-2x'></i>
									</span>
								</a>";
						}

						if ($item->estatus == Catalogo::EN_PROCESO){
							$btn_edit = route('mantenimientos.edit',$item_id);
							$btn_edit = "
								<a href='$btn_edit' class='px-1' title='Editar'>
									<span class='badge orange text-white shadow'>
										<i class='fa fa-pencil fa-2x'></i>
									</span>
								</a>";
							$btn_reporte = "";
						} 
						if ($item->estatus == Catalogo::ORDEN_SERVICIO){
							$btn_orden = "#";
							$btn_orden = "
								<a href='$btn_orden' class='px-1' title='Orden de Servicio'>
									<span class='badge green text-white shadow'>
										<i class='fa fa-gears fa-2x'></i>
									</span>
								</a>";
						}
						if ($item->estatus == Catalogo::COTIZANDO){
							$btn_cotizacion = "#";
							$btn_cotizacion = "
								<a href='$btn_cotizacion' class='px-1' title='Cotizaciones'>
									<span class='badge green text-white shadow'>
										<i class='fa fa-dollar fa-2x'></i>
									</span>
								</a>";
						}

					}					

					$action_buttons = "
						<div class='row d-flex justify-content-center'>
							$btn_edit
							$btn_show
							$btn_orden
							$btn_reporte
							$btn_cotizacion
							$btn_delete
						</div>";
					
	                return $action_buttons;
	            })
	            ->make(TRUE);
	})->name('mantenimientos.list');	

	Route::get('signaturepad', 'SignaturePadController@index')->name('signaturepad');
	Route::post('signaturepad', 'SignaturePadController@upload')->name('signaturepad.upload');
});	


