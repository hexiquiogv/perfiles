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

	Route::get('autorizaciones','AutorizacionController@index')->name('autorizaciones');

});	


