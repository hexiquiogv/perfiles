<?php

use App\Models\Catalogo;
use Illuminate\Http\Request;

Route::middleware(['auth'])->group(function () {
	Route::get('media/{id}/delete', 'MediaController@delete')->name('media.delete');
	Route::get('media/model_name/{name}/model_id/{id}', 'MediaController@show')->name('media.show');
});	

Route::middleware(['web'])->group(function () {
	Route::post('comprobantes','MediaController@comprobantes')->name('media.comprobantes');
	Route::get('media/{id}/download', 'MediaController@download')->name('media.download');
	Route::post('media','MediaController@store')->name('media.store');
});