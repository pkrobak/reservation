<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Repositories;

use App\Reservation\Domain\DTO\GetReservationDto;
use Illuminate\Pagination\LengthAwarePaginator;

interface ReservationRepositoryInterface
{
    /**
     * @param GetReservationDto $reservationDto
     * @return LengthAwarePaginator
     */
    public function getByDto(GetReservationDto $reservationDto): LengthAwarePaginator;
}
