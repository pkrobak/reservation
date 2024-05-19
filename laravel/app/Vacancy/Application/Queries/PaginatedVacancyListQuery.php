<?php

declare(strict_types=1);

namespace App\Vacancy\Application\Queries;

use App\Vacancy\Domain\Repositories\ListVacanciesInterface;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class PaginatedVacancyListQuery
{
    public function __construct(protected ListVacanciesInterface $vacancyRepository)
    {}

    public function get(int $people, ?int $userId, ?Carbon $start, ?Carbon $end): LengthAwarePaginator
    {
        return $this->vacancyRepository->list($people, $userId, $start, $end);
    }
}
