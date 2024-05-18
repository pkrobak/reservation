<?php

declare(strict_types=1);

namespace App\Vacancy\Domain\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

interface VacancyRepositoryInterface
{
    public function create(
        Carbon $date,
        int    $count,
        int    $userId,
    ): void;

    public function list(int $people, ?int $userId, ?Carbon $start, ?Carbon $end): LengthAwarePaginator;
}
