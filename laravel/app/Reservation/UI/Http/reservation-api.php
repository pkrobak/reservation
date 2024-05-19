<?php


use App\Reservation\UI\Http\Controllers\UserReservationsController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/', [UserReservationsController::class, 'store']);
});
