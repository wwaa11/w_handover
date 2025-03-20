<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'index']);
Route::post('/searchHN', [WebController::class, 'searchHN']);
Route::post('/searchVN', [WebController::class, 'searchVN']);
Route::get('/result', [WebController::class, 'result']);

