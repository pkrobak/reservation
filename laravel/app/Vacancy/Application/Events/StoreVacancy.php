<?php

declare(strict_types=1);

namespace App\Vacancy\Application\Events;

use Carbon\Carbon;
use Illuminate\Foundation\Events\Dispatchable;

readonly class StoreVacancy
{
    use Dispatchable;
    public function __construct(
        public Carbon $start,
        public Carbon $end,
        public int    $count,
        public int    $userId,
    ) {}
}
