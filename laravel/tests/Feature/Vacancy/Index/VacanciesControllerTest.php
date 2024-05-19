<?php

declare(strict_types=1);

namespace Tests\Feature\Vacancy\Index;

use App\Models\User;
use App\Vacancy\Application\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VacanciesControllerTest extends TestCase
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
        Vacancy::factory()->lastDays((int)Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)))->create();
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
        $vacancyExpected = Vacancy::factory()->create();
        $vacancyUnexpected = Vacancy::factory()->create();

        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/vacancies?people=1&start=' . $startDate . '&end=' . $endDate . '&userId=' . $vacancyExpected->user_id)
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.user_id', $vacancyExpected->user_id)
            ->assertJsonMissing(['user_id' => $vacancyUnexpected->user_id])
            ->assertJsonFragment(['user_id' => $vacancyExpected->user_id]);
    }
    public function test_index_unAuthenticatedWorks()
    {
        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/vacancies?people=1&start=' . Carbon::now()->format('Y-m-d') . '&end=' . Carbon::now()->addDay()->format('Y-m-d'))
            ->assertOk();
    }
    public function test_index_validation()
    {
        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/vacancies?userId=asb')
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'people',
                'start',
                'end',
                'userId',
            ]);
    }
    public function test_index_validationDateRange()
    {
        $this->actingAs(User::factory()->create())
            ->json('GET', '/api/vacancies?start=2022-01-01&end=2000-01-01')
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'end',
                'people',
            ]);
    }
}
