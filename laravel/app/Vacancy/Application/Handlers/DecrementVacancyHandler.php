<?php

declare(strict_types=1);

namespace App\Vacancy\Application\Handlers;

use App\Vacancy\Application\Events\DecrementVacancyCount;
use App\Vacancy\Domain\Repositories\DecrementVacancyInterface;

readonly class DecrementVacancyHandler
{
    public function __construct(protected DecrementVacancyInterface $vacancyRepository)
    {}

    public function handle(DecrementVacancyCount $event): void
    {
        $this->vacancyRepository->decrement($event->vacancyId, $event->count);
    }
}
