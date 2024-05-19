<?php

declare(strict_types=1);

namespace App\Vacancy\Application\Queries;

use App\Vacancy\Domain\Collections\AvailabilityCollection;
use App\Vacancy\Domain\Collections\CarbonCollection;
use App\Vacancy\Domain\DTO\AvailabilityDto;
use App\Vacancy\Domain\Repositories\FindVacancyInterface;
use Carbon\Carbon;

readonly class VacancyAvailabilityQuery
{
    public function __construct(protected FindVacancyInterface $repository)
    {}

    public function get(int $userId, int $people, CarbonCollection $dates): AvailabilityCollection
    {
        return new AvailabilityCollection(
            array_map(fn (Carbon $date) => new AvailabilityDto(
                $this->repository->findId($userId, $people, $date),
                $date,
            ), $dates->items())
        );
    }
}
