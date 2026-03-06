<?php

use App\Models\Catalogo;
use Illuminate\Http\Request;
use App\Models\Mantenimiento;
use App\Models\Role;

Route::middleware(['roles'=>"allow_to_roles:".Role::ADMIN.'|'.
		Role::SUPER_ADMIN])->group(function () {

	Route::resource('mantenimientos', 'MantenimientoController')->except(['show']);	
	Route::post('mantenimientos/{uuid}/delete', 'MantenimientoController@destroy')
		->name('mantenimientos.delete');

	Route::match(['get', 'post'],'mantenimientos.list', function() {
			$sql_query = "
				select  m.uuid as uuid,m.folio folio, v.no_economico no_economico, tv.name as tipo_vehiculo,
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
					$btn_delete = "#";
					$btn_delete = "
						<a href='$btn_delete' class='px-1 delete-button' 
							title='Eliminar' id='item_$item_id'>
							<span class='badge badge-danger text-white shadow'>
								<i class='fa fa-trash fa-2x'></i>
							</span>
						</a>";

					$btn_edit = route('mantenimientos.edit',$item_id);
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
	})->name('mantenimientos.list');	

});	


