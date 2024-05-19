<?php

declare(strict_types=1);

namespace App\Vacancy\Domain\DTO;

use Carbon\Carbon;

readonly class AvailabilityDto
{
    public function __construct(public ?int $vacancyId, public Carbon $date) {}
}
