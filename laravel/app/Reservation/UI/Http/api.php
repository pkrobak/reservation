<?php

use App\Reservation\UI\Http\ReservationController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/', [ReservationController::class, 'index']);
});
