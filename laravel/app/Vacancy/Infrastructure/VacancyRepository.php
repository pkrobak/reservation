<?php

declare(strict_types=1);

namespace App\Vacancy\Infrastructure;

use App\Vacancy\Application\Models\Vacancy;
use App\Vacancy\Domain\Repositories\DecrementVacancyInterface;
use App\Vacancy\Domain\Repositories\FindVacancyInterface;
use App\Vacancy\Domain\Repositories\ListVacanciesInterface;
use App\Vacancy\Domain\Repositories\StoreVacancyInterface;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class VacancyRepository implements FindVacancyInterface, StoreVacancyInterface, ListVacanciesInterface, DecrementVacancyInterface
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

    // TODO: There are two approaches. One is to return null; the other is to throw an exception in such a case
    public function findId(int $userId, int $people, Carbon $date): ?int
    {
        return Vacancy::query()
            ->select('id')
            ->where('user_id', $userId)
            ->where('date', $date)
            ->where('count', '>=', $people)
            ->first()
            ?->id;
    }

    public function decrement(int $vacancyId, int $count): void
    {
        Vacancy::query()
            ->decrement('count', $count);
    }
}
