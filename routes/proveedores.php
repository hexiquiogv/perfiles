<?php
use App\Models\Proveedor;
use App\Models\Role;
use Illuminate\Http\Request;

Route::middleware(['roles'=>'allow_to_roles:admin|super_admin|user'])->group(function () {

	Route::resource('proveedores','ProveedorController')->parameters(['proveedores' => 'proveedor'])->except('show');
	Route::get('generales/{proveedor}','ProveedorController@edit')
		->name('generales');	
	Route::match(['get', 'post'],'list.proveedores', function(Request $request) {
		if ($request->tipo_proveedor_id){
			$tipo_proveedor_id = App\Models\Catalogo::find_by_name($request->tipo_proveedor_id)->first()->id;
			$items = Proveedor::query()->with('status')->with('tipo_proveedor')->where('tipo_proveedor_id','=',$tipo_proveedor_id);
		} else {
			$items = Proveedor::query()->with('status')->with('tipo_proveedor');
		}
		return DataTables::eloquent($items)
		        ->addColumn('acciones', function($item){
		        	$item_id = $item->id;
		        	$btn_edit = route('proveedores.edit',$item->id);
					$btn_delete = "";
					if (Auth::user()->isAdmin) {
						$btn_delete = "#";
						$btn_delete = "
						<a href='$btn_delete' title='Eliminar' class='delete-button'
							id='item_$item_id'>
							<span class='badge badge-danger text-white shadow'>
								<i class='fa fa-trash fa-2x'></i>
							</span>
						</a>";					
					}
					$action_buttons = "
					<div class='row d-flex justify-content-around pr-3'>
						<a href='$btn_edit' title='Editar'>
							<span class='badge badge-warning text-white shadow'>
								<i class='fa fa-pencil fa-2x'></i>
							</span>
						</a>
						$btn_delete
					</div>	
					";
					
	                return $action_buttons;
	            })
	            ->make(TRUE);
	})->name('list.proveedores');
		
	Route::match(['get', 'post'],'/items.proveedores', function(Request $request) {
	    $data = Proveedor::select('nombre_corto as name','id')->get();
	    return response()->json([
	        'status' => 'ok',
	        'data' => $data
	    ]);
	})->name('items.proveedores');
});

Route::middleware(['administrator'])->group(function () {
	Route::post('proveedores.delete/{proveedor}','ProveedorController@destroy')
			->name('proveedores.delete');
});

