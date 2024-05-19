<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Repositories;

use App\Reservation\Domain\DTO\CreateReservationDto;

interface ReservationStoreInterface
{
    public function store(CreateReservationDto $reservation): void;
}
