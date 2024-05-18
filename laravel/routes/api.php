<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/reservations')->group(base_path('app/Reservation/UI/Http/api.php'));
Route::prefix('/vacancies')->group(base_path('app/Vacancy/UI/Http/api.php'));
