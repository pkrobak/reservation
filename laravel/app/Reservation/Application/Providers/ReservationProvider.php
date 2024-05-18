<?php

declare(strict_types=1);

namespace App\Reservation\Application\Providers;

use App\Reservation\Domain\Repositories\ReservationRepositoryInterface;
use App\Reservation\Infrastructure\ReservationRepository;
use Illuminate\Support\ServiceProvider;

class ReservationProvider extends ServiceProvider
{
    public array $bindings = [
        ReservationRepositoryInterface::class => ReservationRepository::class,
    ];
}
