<?php

declare(strict_types=1);

namespace App\Vacancy\Domain\Repositories;

use Carbon\Carbon;

interface StoreVacancyInterface
{
    public function create(
        Carbon $date,
        int    $count,
        int    $userId,
    ): void;
}
