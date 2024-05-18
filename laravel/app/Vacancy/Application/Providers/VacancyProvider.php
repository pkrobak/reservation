<?php

declare(strict_types=1);

namespace App\Vacancy\Application\Providers;

use App\Vacancy\Domain\Repositories\VacancyRepositoryInterface;
use App\Vacancy\Infrastructure\VacancyRepository;
use Illuminate\Support\ServiceProvider;

class VacancyProvider extends ServiceProvider
{
    public array $bindings = [
        VacancyRepositoryInterface::class => VacancyRepository::class,
    ];
}
