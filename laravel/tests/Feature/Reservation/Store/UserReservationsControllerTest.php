<?php

declare(strict_types=1);

namespace Tests\Feature\Reservation\Store;

use App\Models\User;
use App\Vacancy\Application\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

class UserReservationsControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_store_success()
    {
        $date = Carbon::now()->format('Y-m-d');
        $vacancy = Vacancy::factory()->create([
            'date' => $date,
            'count' => 1,
        ]);
        $requestData = [
            'people' => [
                ['first_name' => 'John', 'last_name' => 'Doe'],
            ],
            'date_from' => $date,
            'date_to' => $date,
        ];
        $this->actingAs(User::factory()->create())
            ->postJson('api/users/' . $vacancy->user_id . '/reservations', $requestData)
            ->assertCreated();

        $this->assertDatabaseHas('reservations', [
            'vacancy_id' => $vacancy->id,
            'date' => $date,
        ]);
//        $this->assertDatabaseHas('clients', $requestData['people'][0]);
    }

    public function test_store_auth()
    {
        $date = Carbon::now()->format('Y-m-d');
        $vacancy = Vacancy::factory()->create([
            'date' => $date,
            'count' => 1,
        ]);
        $requestData = [
            'people' => [
                ['first_name' => 'John', 'last_name' => 'Doe'],
            ],
            'date_from' => $date,
            'date_to' => $date,
        ];
        $this->postJson('api/users/' . $vacancy->user_id . '/reservations', $requestData)
            ->assertUnauthorized();
    }

    public function test_store_validation()
    {
        $date = Carbon::now()->format('Y-m-d');
        $vacancy = Vacancy::factory()->create([
            'date' => $date,
            'count' => 1,
        ]);
        $requestData = [];
        $this->actingAs(User::factory()->create())
            ->postJson('api/users/' . $vacancy->user_id . '/reservations', $requestData)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['people', 'date_from', 'date_to']);
    }
    public function test_store_validation_noVacanciesInFuture()
    {
        $date = Carbon::now()->format('Y-m-d');
        $vacancy = Vacancy::factory()->create([
            'date' => $date,
            'count' => 1,
        ]);
        $requestData = [
            'people' => [
                ['first_name' => 'John', 'last_name' => 'Doe'],
            ],
            'date_from' => $date,
            'date_to' => Carbon::now()->addDay()->format('Y-m-d'),
        ];
        $this->actingAs(User::factory()->create())
            ->postJson('api/users/' . $vacancy->user_id . '/reservations', $requestData)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['unavailable_dates']);
    }
    public function test_store_validation_noVacanciesInPast()
    {
        $date = Carbon::now()->format('Y-m-d');
        $vacancy = Vacancy::factory()->create([
            'date' => $date,
            'count' => 1,
        ]);
        $requestData = [
            'people' => [
                ['first_name' => 'John', 'last_name' => 'Doe'],
            ],
            'date_from' => Carbon::now()->subDay()->format('Y-m-d'),
            'date_to' => $date,
        ];
        $this->actingAs(User::factory()->create())
            ->postJson('api/users/' . $vacancy->user_id . '/reservations', $requestData)
            ->dump()
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['unavailable_dates']);
    }

    public function test_store_successMultiplePeople()
    {
        $date = Carbon::now()->format('Y-m-d');
        $vacancy = Vacancy::factory()->create([
            'date' => $date,
            'count' => 2,
        ]);
        $requestData = [
            'people' => [
                ['first_name' => 'John', 'last_name' => 'Doe'],
                ['first_name' => 'Joe', 'last_name' => 'Doe'],
            ],
            'date_from' => $date,
            'date_to' => $date,
        ];
        $this->actingAs(User::factory()->create())
            ->postJson('api/users/' . $vacancy->user_id . '/reservations', $requestData)
            ->assertCreated();

        $this->assertDatabaseHas('reservations', [
            'vacancy_id' => $vacancy->id,
            'date' => $date,
        ]);
        $this->assertDatabaseCount('reservations', 2);
//        $this->assertDatabaseHas('clients', $requestData['people'][0]);
    }

}
