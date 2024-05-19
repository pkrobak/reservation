<?php

declare(strict_types=1);

namespace App\Vacancy\Application\Providers;

use App\Vacancy\Domain\Repositories\DecrementVacancyInterface;
use App\Vacancy\Domain\Repositories\FindVacancyInterface;
use App\Vacancy\Domain\Repositories\ListVacanciesInterface;
use App\Vacancy\Domain\Repositories\StoreVacancyInterface;
use App\Vacancy\Infrastructure\VacancyRepository;
use Illuminate\Support\ServiceProvider;

class VacancyProvider extends ServiceProvider
{
    public array $bindings = [
        ListVacanciesInterface::class => VacancyRepository::class,
        StoreVacancyInterface::class => VacancyRepository::class,
        FindVacancyInterface::class => VacancyRepository::class,
        DecrementVacancyInterface::class => VacancyRepository::class,
    ];
}
