<?php

declare(strict_types=1);

namespace Tests\Feature\Vacancy\Index;

use App\Models\User;
use App\Vacancy\Infrastructure\Vacancy;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VacancyControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_index_emptyList()
    {
        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/vacancies?people=1&start=' . Carbon::now()->format('Y-m-d') . '&end=' . Carbon::now()->addDay()->format('Y-m-d'))
            ->assertOk()
            ->assertJsonStructure([
                'data' => []
            ])
            ->assertJsonCount(0, 'data');
    }
    public function test_index_notEmptyList()
    {
        $startDate = Carbon::now()->format('Y-m-d');
        $endDate = Carbon::now()->addDay()->format('Y-m-d');
        Vacancy::factory([
            'start' => $startDate,
            'end' => $endDate,
        ])
            ->create();
        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/vacancies?people=1&start=' . $startDate . '&end=' . $endDate)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'start',
                        'end',
                        'count',
                    ]
                ]
            ]);
    }
    public function test_index_userId()
    {
        $startDate = Carbon::now()->format('Y-m-d');
        $endDate = Carbon::now()->addDay()->format('Y-m-d');
        $vacancyExpected = Vacancy::factory([
            'start' => $startDate,
            'end' => $endDate,
        ])
            ->create();
        $vacancyUnexpected = Vacancy::factory([
            'start' => $startDate,
            'end' => $endDate,
        ])
            ->create();
        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/vacancies?people=1&start=' . $startDate . '&end=' . $endDate . '&user_id=' . $vacancyExpected->user_id)
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.user_id', $vacancyExpected->user_id)
            ->assertJsonMissing(['user_id' => $vacancyUnexpected->user_id])
            ->assertJsonFragment(['user_id' => $vacancyExpected->user_id]);
    }
    public function test_index_unAuthenticatedWorks()
    {
        $this->json('GET', '/api/vacancies?people=1&start=' . Carbon::now()->format('Y-m-d') . '&end=' . Carbon::now()->addDay()->format('Y-m-d'))
            ->assertOk();
    }
    public function test_index_validation()
    {
        $this->json('GET', '/api/vacancies?user_id=asb')
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'people',
                'start',
                'end',
                'user_id',
            ]);
    }
    public function test_index_validationDateRange()
    {
        $this->json('GET', '/api/vacancies?start=2022-01-01&end=2000-01-01')
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'end',
                'people',
            ]);
    }
}
