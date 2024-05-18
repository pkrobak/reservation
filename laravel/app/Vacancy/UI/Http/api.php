<?php

use App\Vacancy\UI\Http\VacancyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [VacancyController::class, 'index'])
    ->name('vacancies.index');

Route::post('/', [VacancyController::class, 'store'])
    ->middleware('auth:sanctum')
    ->name('vacancies.store');
