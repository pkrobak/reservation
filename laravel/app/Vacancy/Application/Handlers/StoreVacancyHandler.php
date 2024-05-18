<?php

declare(strict_types=1);

namespace App\Vacancy\Application\Handlers;

use App\Vacancy\Application\Events\StoreVacancy;
use App\Vacancy\Domain\VacancyRepositoryInterface;

final readonly class StoreVacancyHandler
{
    public function __construct(protected VacancyRepositoryInterface $repository)
    {}

    public function handle(StoreVacancy $event): void
    {
        $this->repository->create(
            $event->start,
            $event->end,
            $event->count,
            $event->userId
        );
    }
}
