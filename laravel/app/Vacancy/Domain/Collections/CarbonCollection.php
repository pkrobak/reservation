<?php

declare(strict_types=1);

namespace App\Vacancy\Domain\Collections;

use App\Shared\Domain\AbstractCollection;
use Carbon\Carbon;

class CarbonCollection extends AbstractCollection
{
    protected function type(): string
    {
        return Carbon::class;
    }
}
