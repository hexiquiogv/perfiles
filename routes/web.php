<?php
use App\Models\Role;
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
});

Route::middleware(['roles'=>"allow_to_roles:".Role::ADMIN.'|'.Role::SUPER_ADMIN])->group(function () {
	Route::view('calendar', 'test.calendario')->name('calendar');
	Route::view('charts', 'test.charts')->name('charts');	
});

