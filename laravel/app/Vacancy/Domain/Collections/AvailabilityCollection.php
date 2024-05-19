<?php

declare(strict_types=1);

namespace App\Vacancy\Domain\Collections;

use App\Shared\Domain\AbstractCollection;
use App\Vacancy\Domain\DTO\AvailabilityDto;

class AvailabilityCollection extends AbstractCollection
{
    protected function type(): string
    {
        return AvailabilityDto::class;
    }
}
