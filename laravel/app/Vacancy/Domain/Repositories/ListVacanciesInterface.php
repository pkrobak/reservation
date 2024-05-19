<?php

declare(strict_types=1);

namespace App\Vacancy\Domain\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

interface ListVacanciesInterface
{
    public function list(int $people, ?int $userId, ?Carbon $start, ?Carbon $end): LengthAwarePaginator;
}
