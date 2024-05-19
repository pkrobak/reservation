<?php

use App\Vacancy\UI\Http\Controllers\VacanciesController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/', [VacanciesController::class, 'index'])
        ->name('vacancies.index');

    Route::post('/', [VacanciesController::class, 'store'])
        ->name('vacancies.store');
});
