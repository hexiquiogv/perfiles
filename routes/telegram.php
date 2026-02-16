<?php

use App\Models\Catalogo;
use Illuminate\Http\Request;
use App\Models\Hotel;
//use Telegram\Bot\Laravel\Facades\Telegram;

Route::middleware(['auth'])->group(function () {
	Route::get('/updated-activity', 'TelegramBotController@updatedActivity');
	Route::get('/telegram', 'TelegramBotController@sendMessage');
	Route::post('/send-message', 'TelegramBotController@storeMessage');
	Route::get('/send-photo', 'TelegramBotController@sendPhoto');
	Route::post('/store-photo', 'TelegramBotController@storePhoto');

});

