<?php

declare(strict_types=1);

namespace Tests\Feature\Vacancy\Store;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VacanciesControllerTest extends TestCase
{
    use RefreshDatabase;

    public static function validationProvider(): array
    {
        return [
            [
                [],
                ['start', 'end', 'people']
            ],
            [
                ['start' => null, 'end' => null, 'people' => null],
                ['start', 'end', 'people']
            ],
            [
                ['start' => Carbon::now()->subDay()->format('Y-m-d'), 'end' => Carbon::now()->subDay()->format('Y-m-d'), 'people' => -1],
                ['start', 'end', 'people']
            ],
            [
                ['start' => Carbon::now()->format('Y-m-d'), 'end' => Carbon::now()->subDay()->format('Y-m-d'), 'people' => 0],
                ['end', 'people']
            ],
            [
                ['start' => Carbon::now()->format('Y-m-d'), 'end' => Carbon::now()->format('Y-m-d'), 'people' => 1],
                ['end']
            ],
        ];
    }

    public function test_store_success()
    {
        $people = random_int(1, 30);
        $days = random_int(1, 10);
        $user = User::factory()->create();
        $requestData = [
            'start' => Carbon::now()->addDay()->format('Y-m-d'),
            'end' => Carbon::now()->addDays($days)->format('Y-m-d'),
            'people' => $people
        ];

        $this->actingAs($user)
            ->postJson(route('vacancies.store'), $requestData)
            ->assertCreated();

        for (
            $i = 0;
            $i <= (int)Carbon::parse($requestData['start'])->diffInDays(Carbon::parse($requestData['end']));
            $i++
        ) {
            $this->assertDatabaseHas('vacancies', [
                'date' => Carbon::parse($requestData['start'])->addDays($i)->format('Y-m-d'),
                'count' => $requestData['people'],
                'user_id' => $user->id,
            ]);
        }
    }
    public function test_store_auth()
    {
        $people = random_int(1, 30);
        $days = random_int(1, 30);
        $requestData = [
            'start' => Carbon::now()->addDay()->format('Y-m-d'),
            'end' => Carbon::now()->addDays($days)->format('Y-m-d'),
            'people' => $people
        ];

        $this->postJson(route('vacancies.store'), $requestData)
            ->assertUnauthorized();

        $this->assertDatabaseCount('vacancies', 0);
    }

    /**
     * @dataProvider validationProvider
     */
    public function test_store_validation(array $requestData, array $errors)
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('vacancies.store'), $requestData)
            ->assertUnprocessable()
            ->assertJsonValidationErrors($errors);

        $this->assertDatabaseCount('vacancies', 0);
    }
}
