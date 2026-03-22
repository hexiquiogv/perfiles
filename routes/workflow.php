<?php

use App\Models\Role;
use Illuminate\Http\Request;

Route::middleware(['roles'=>"allow_to_roles:".Role::ADMIN.'|'.Role::SUPER_ADMIN])->group(function () {
	Route::get('/solicitud', 'WorkflowController@solicitud')->name('solicitud');
	Route::post('/solicitud', 'WorkflowController@store')->name('solicitud');
});