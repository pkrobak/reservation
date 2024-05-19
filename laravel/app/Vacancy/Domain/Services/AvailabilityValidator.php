<?php

declare(strict_types=1);

namespace App\Vacancy\Domain\Services;

use App\Vacancy\Domain\Collections\AvailabilityCollection;

class AvailabilityValidator
{
    public function __construct(protected AvailabilityService $availabilityService)
    {}

    public function validate(AvailabilityCollection $availabilityCollection): bool
    {
        return $this->availabilityService->getUnavailableDates($availabilityCollection)->count() === 0;
    }
}
