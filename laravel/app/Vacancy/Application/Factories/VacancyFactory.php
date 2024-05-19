<?php

declare(strict_types=1);

namespace App\Vacancy\Application\Factories;

use App\Models\User;
use App\Vacancy\Application\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class VacancyFactory extends Factory
{
    protected $model = Vacancy::class;
    public function definition(): array
    {
        return [
            'date' => Carbon::now(),
            'user_id' => User::factory()->create()->id,
            'count' => $this->faker->numberBetween(1, 10),
        ];
    }
    public function lastDays(int $days)
    {
        return $this->count($days)
            ->sequence(fn (Sequence $sequence) => [
                'date' => Carbon::now()->subDays($days)->addDays($sequence->index),
                'user_id' => User::factory()->create()->id,
            ]);
    }
}
