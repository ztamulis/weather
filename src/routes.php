<?php
use Illuminate\Http\Request;

use Bene\Weather\Controllers\Weather;
use Bene\Weather\Controllers\WeatherController;
use Bene\Weather\Controllers\EmailsController;


Route::get('weathers', WeatherController::class . '@index');
Route::post('weathers/create', WeatherController::class . '@store');

