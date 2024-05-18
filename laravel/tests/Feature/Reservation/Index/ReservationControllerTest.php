<?php

declare(strict_types=1);

namespace Tests\Feature\Reservation\Index;


use App\Models\User;
use App\Reservation\Infrastructure\Client;
use App\Reservation\Infrastructure\Reservation;
use App\Vacancy\Infrastructure\Vacancy;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_emptyList()
    {
        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/reservations')
            ->assertOk()
            ->assertJson([
                'data' => []
            ]);
    }
    public function test_index_notEmptyList()
    {
        Reservation::factory()
            ->for(Vacancy::factory())
            ->hasAttached(Client::factory())
            ->count(2)
            ->create();
        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/reservations')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'date',
                        'clients' => [
                            '*' => [
                                'id',
                                'first_name',
                                'last_name',
                            ]
                        ]
                    ]
                ],
                'links',
                'meta',
            ]);
    }

    public function test_index_validation()
    {
        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/reservations?userId=0&start=qwe&end=asd')
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'userId',
                'start',
                'end',
            ]);
    }
    public function test_index_filter()
    {
        /** @var Reservation $reservation */
        $reservation = Reservation::factory()
            ->for(Vacancy::factory())
            ->hasAttached(Client::factory())
            ->create();

        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/reservations?userId=' . $reservation->vacancy->user_id)
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $reservation->id);
    }
    public function test_index_filterUserIdNoResult()
    {
        Reservation::factory()
            ->for(Vacancy::factory())
            ->hasAttached(Client::factory())
            ->create();
        $user = User::factory()->create();

        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/reservations?userId=' . $user->id)
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }
    public function test_index_filterStartDate()
    {
        /** @var Reservation $reservation */
        $reservation = Reservation::factory()
            ->for(Vacancy::factory())
            ->hasAttached(Client::factory())
            ->create();

        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/reservations?start=' . Carbon::now()->format('Y-m-d'))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $reservation->id);
    }
    public function test_index_filterStartDateNoResult()
    {
        Reservation::factory()
            ->for(Vacancy::factory())
            ->hasAttached(Client::factory())
            ->create();

        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/reservations?start=' . Carbon::now()->addDay()->format('Y-m-d'))
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }
    public function test_index_filterEndDate()
    {
        /** @var Reservation $reservation */
        $reservation = Reservation::factory()
            ->for(Vacancy::factory())
            ->hasAttached(Client::factory())
            ->create();

        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/reservations?end=' . Carbon::now()->format('Y-m-d'))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $reservation->id);
    }
    public function test_index_filterEndDateNoResult()
    {
        $r = Reservation::factory()
            ->for(Vacancy::factory())
            ->hasAttached(Client::factory())
            ->create();

        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/reservations?end=' . Carbon::now()->addDay()->format('Y-m-d'))
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }
}
