<?php

declare(strict_types=1);

namespace App\Reservation\Application\Providers;

use App\Reservation\Domain\Repositories\ReservationListInterface;
use App\Reservation\Domain\Repositories\ReservationStoreInterface;
use App\Reservation\Infrastructure\ReservationList;
use Illuminate\Support\ServiceProvider;

class ReservationProvider extends ServiceProvider
{
    public array $bindings = [
        ReservationListInterface::class => ReservationList::class,
        ReservationStoreInterface::class => ReservationList::class,
    ];
}
