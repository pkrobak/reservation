<?php

declare(strict_types=1);

namespace App\Vacancy\Application\Events;

use Illuminate\Foundation\Events\Dispatchable;

readonly class DecrementVacancyCount
{
    use Dispatchable;
    public function __construct(public int $vacancyId, public int $count)
    {}
}
