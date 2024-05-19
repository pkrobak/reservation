<?php

declare(strict_types=1);

namespace App\Reservation\Domain\DTO;

use Carbon\Carbon;

readonly class CreateReservationDto
{
    public function __construct(public int $vacancyId, public Carbon $date)
    {}
}
