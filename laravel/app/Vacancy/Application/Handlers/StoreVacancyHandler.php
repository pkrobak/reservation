<?php

declare(strict_types=1);

namespace App\Vacancy\Application\Handlers;

use App\Vacancy\Application\Events\StoreVacancy;
use App\Vacancy\Domain\Repositories\StoreVacancyInterface;
use App\Vacancy\Domain\Repositories\FindVacancyInterface;
use App\Vacancy\Domain\Services\DatesService;

final readonly class StoreVacancyHandler
{
    public function __construct(
        protected StoreVacancyInterface $repository,
        protected DatesService $datesService,
    ) {}

    public function handle(StoreVacancy $event): void
    {
        foreach ($this->datesService->getDatesBetween($event->start, $event->end)->items() as $date) {
            $this->repository->create(
                $date,
                $event->count,
                $event->userId
            );
        }
    }
}
