<?php

use App\Reservation\UI\Http\Controllers\ReservationsController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/', [ReservationsController::class, 'index']);
});
