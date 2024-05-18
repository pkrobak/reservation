<?php

declare(strict_types=1);

namespace App\Vacancy\Application\Factories;

use App\Models\User;
use App\Vacancy\Infrastructure\Vacancy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class VacancyFactory extends Factory
{
    protected $model = Vacancy::class;
    public function definition(): array
    {
        $start = Carbon::parse($this->faker->date());
        return [
            'user_id' => User::factory()->create()->id,
            'start' => $start,
            'end' => Carbon::parse($start->addDays($this->faker->numberBetween(1, 14))),
            'count' => $this->faker->numberBetween(1, 10),
        ];
    }
}
