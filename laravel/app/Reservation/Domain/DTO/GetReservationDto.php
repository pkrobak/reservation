<?php

declare(strict_types=1);

namespace App\Reservation\Domain\DTO;

use Carbon\Carbon;

readonly class GetReservationDto
{
    public function __construct(
        public ?Carbon $start,
        public ?Carbon $end,
        public ?int $userId,
        public ?string $query
    ) {}
}
