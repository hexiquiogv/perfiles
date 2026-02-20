<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([ 'register'=>false, 'password.request'=>false]);

Route::view('/', 'welcome')->name('welcome');

Route::middleware(['auth'])->group(function () {
	Route::get('/home','HomeController@index')->name('home');
	//Route::view('signature', 'test.signature_2')->name('signature');
	Route::get('signaturepad', 'SignaturePadController@index');
	Route::post('signaturepad', 'SignaturePadController@upload')->name('signaturepad.upload');
});
