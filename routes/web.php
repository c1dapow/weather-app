<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::get('/', [WeatherController::class, 'mainPage']);

Route::post('/submit-form', [WeatherController::class, 'loadWeatherData']);
Route::post('/submit-date', [WeatherController::class, 'getSelectedWeather']);

