<?php

use Illuminate\Http\Request;
use App\Models\Role;

Route::middleware(['roles'=>"allow_to_roles:".Role::ADMIN.'|'.Role::SUPER_ADMIN])->group(function () {
	Route::get('signaturepad', 'SignaturePadController@index')->name('signaturepad');
	Route::post('signaturepad', 'SignaturePadController@upload')->name('signaturepad.upload');
});	


