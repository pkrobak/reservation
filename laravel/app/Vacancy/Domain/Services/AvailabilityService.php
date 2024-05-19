<?php

declare(strict_types=1);

namespace App\Vacancy\Domain\Services;

use App\Vacancy\Domain\Collections\AvailabilityCollection;
use App\Vacancy\Domain\Collections\CarbonCollection;
use App\Vacancy\Domain\DTO\AvailabilityDto;

class AvailabilityService
{
    public function getUnavailableDates(AvailabilityCollection $availabilityCollection): CarbonCollection
    {
        return new CarbonCollection(
            array_map(
                fn (AvailabilityDto $availabilityDto) => $availabilityDto->date,
                array_filter(
                    $availabilityCollection->items(),
                    fn (AvailabilityDto $availabilityDto) => $availabilityDto->vacancyId === null
                )
            )
        );
    }
}
