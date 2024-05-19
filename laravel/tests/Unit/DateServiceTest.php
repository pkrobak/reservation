<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Vacancy\Domain\Collections\CarbonCollection;
use App\Vacancy\Domain\Services\DatesService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class DateServiceTest extends TestCase
{
    public function test_getDatesBetween_correct()
    {
        /** @var DatesService $service */
        $service = app(DatesService::class);

        $result = $service->getDatesBetween(Carbon::parse('2022-12-01'), Carbon::parse('2022-12-02'));

        $this->assertEquals(
            new CarbonCollection([
                Carbon::parse('2022-12-01'),
                Carbon::parse('2022-12-02')
            ]),
            $result);
    }
    public function test_getDatesBetween_doesNotTakeHours()
    {
        /** @var DatesService $service */
        $service = app(DatesService::class);

        $result = $service->getDatesBetween(Carbon::parse('2022-12-01'), Carbon::parse('2022-12-02'));

        $this->assertNotEquals(
            new CarbonCollection([
                Carbon::parse('2022-12-01 12:00:00'),
                Carbon::parse('2022-12-02 12:00:00')
            ]),
            $result);
    }
}
