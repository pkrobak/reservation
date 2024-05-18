<?php

declare(strict_types=1);

namespace App\Vacancy\Infrastructure;

use App\Vacancy\Domain\VacancyRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class VacancyRepository implements VacancyRepositoryInterface
{
    public function create(Carbon $start, Carbon $end, int $count, int $userId): void
    {
        $vacancy = Vacancy::query()
            ->where('user_id', '=', $userId)
            ->where('start', '=', $start)
            ->where('end', '=', $end)
            ->first();
        if ($vacancy === null) {
            Vacancy::query()->create([
                'start' => $start,
                'end' => $end,
                'count' => $count,
                'user_id' => $userId,
            ]);

            return;
        }
        $vacancy->count += $count;
        $vacancy->save();
    }

    public function list(int $people, ?int $userId, ?Carbon $start, ?Carbon $end): LengthAwarePaginator
    {
        return Vacancy::query()
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($start, function ($query) use ($start) {
                $query->where('start', '>=', $start);
            })
            ->when($end, function ($query) use ($end) {
                $query->where('end', '<=', $end);
            })
            ->where('count', '>', $people)
            ->paginate();
    }
}
