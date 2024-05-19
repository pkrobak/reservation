<?php

declare(strict_types=1);

namespace App\Reservation\Application\Factories;

use App\Reservation\Application\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;
    public function definition(): array
    {
        return [
            'date' => Carbon::now(),
        ];
    }
}
