<?php

declare(strict_types=1);

namespace App\Vacancy\Domain;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

interface VacancyRepositoryInterface
{
    public function create(
        Carbon $start,
        Carbon $end,
        int    $count,
        int    $userId,
    ): void;

    public function list(int $people, ?int $userId, ?Carbon $start, ?Carbon $end): LengthAwarePaginator;
}
