<?php

declare(strict_types=1);

namespace App\Reservation\Application\Events;

use App\Reservation\Domain\Collections\ClientsCollection;
use Carbon\Carbon;
use Illuminate\Foundation\Events\Dispatchable;

readonly class StoreReservation
{
    use Dispatchable;
    public function __construct(
        public int               $userId,
        public Carbon            $start,
        public Carbon            $end,
        public ClientsCollection $people,
    ) {}
}
