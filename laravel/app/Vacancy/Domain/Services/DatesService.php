<?php

declare(strict_types=1);

namespace App\Vacancy\Domain\Services;

use App\Vacancy\Domain\Collections\CarbonCollection;
use Carbon\Carbon;

class DatesService
{
    public function getDatesBetween(Carbon $start, Carbon $end): CarbonCollection
    {
        $dates = [];
        for ($i = 0; $i <= Carbon::parse($start)->diffInDays(Carbon::parse($end)); $i++) {
            $dates[] = Carbon::parse($start)->addDays($i);
        }

        return new CarbonCollection($dates);
    }
}
