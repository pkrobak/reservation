<?php

declare(strict_types=1);

namespace App\Reservation\Application\Queries;

use App\Reservation\Domain\DTO\GetReservationDto;
use App\Reservation\Domain\Repositories\ReservationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class GetReservationsQuery
{
    public function __construct(
        protected ReservationRepositoryInterface $reservationRepository
    ) {}

    /**
     * @param GetReservationDto $reservationDto
     * @return LengthAwarePaginator
     */
    public function get(GetReservationDto $reservationDto): LengthAwarePaginator
    {
        return $this->reservationRepository->getByDto($reservationDto);
    }
}
