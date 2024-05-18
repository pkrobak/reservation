<?php

declare(strict_types=1);

namespace App\Vacancy\Infrastructure;

use App\Vacancy\Domain\Repositories\VacancyRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class VacancyRepository implements VacancyRepositoryInterface
{
    public function create(Carbon $date, int $count, int $userId): void
    {
        $vacancy = Vacancy::query()
            ->where('user_id', '=', $userId)
            ->where('date', '=', $date)
            ->first();
        if ($vacancy === null) {
            Vacancy::query()->create([
                'date' => $date,
                'count' => $count,
                'user_id' => $userId,
            ]);

            return;
        }
        $vacancy->increment('count', $count);
    }

    public function list(int $people, ?int $userId, ?Carbon $start, ?Carbon $end): LengthAwarePaginator
    {
        return Vacancy::query()
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($start, function ($query) use ($start) {
                $query->where('date', '>=', $start);
            })
            ->when($end, function ($query) use ($end) {
                $query->where('date', '<=', $end);
            })
            ->where('count', '>', $people)
            ->paginate();
    }
}
