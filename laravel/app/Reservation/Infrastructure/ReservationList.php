<?php

declare(strict_types=1);

namespace App\Reservation\Infrastructure;

use App\Reservation\Application\Models\Reservation;
use App\Reservation\Domain\DTO\CreateReservationDto;
use App\Reservation\Domain\DTO\GetReservationDto;
use App\Reservation\Domain\Repositories\ReservationListInterface;
use App\Reservation\Domain\Repositories\ReservationStoreInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ReservationList implements ReservationListInterface, ReservationStoreInterface
{
    public function getByDto(GetReservationDto $reservationDto): LengthAwarePaginator
    {
        return Reservation::query()
            ->with('clients')
            ->when(!empty($query), function (Builder $q) use ($reservationDto) {
                $q->where('first_name', 'like', '%' . $reservationDto->query . '%')
                    ->orWhere('last_name', 'like', '%' . $reservationDto->query . '%');
            })
            ->when($reservationDto->end !== null, function (Builder $query) use ($reservationDto) {
                $query->where('date', $reservationDto->end);
            })
            ->when($reservationDto->start !== null, function (Builder $query) use ($reservationDto) {
                $query->where('date', $reservationDto->start);
            })
            ->when($reservationDto->userId !== null, function (Builder $query) use ($reservationDto) {
                $query->whereHas('vacancy', function ($query) use ($reservationDto) {
                    $query->where('user_id', $reservationDto->userId);
                });
            })
            ->paginate();
    }

    public function store(CreateReservationDto $reservation): void
    {
        Reservation::query()->create([
            'vacancy_id' => $reservation->vacancyId,
            'date' => $reservation->date,
        ]);
    }
}
