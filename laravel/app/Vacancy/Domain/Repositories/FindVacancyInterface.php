<?php

declare(strict_types=1);

namespace App\Vacancy\Domain\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

interface FindVacancyInterface
{
    public function findId(int $userId, int $people, Carbon $date): ?int;
}
