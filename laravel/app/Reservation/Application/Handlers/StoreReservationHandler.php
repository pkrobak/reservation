<?php

declare(strict_types=1);

namespace App\Reservation\Application\Handlers;

use App\Reservation\Application\Events\StoreReservation;
use App\Reservation\Domain\DTO\ClientDto;
use App\Reservation\Domain\DTO\CreateReservationDto;
use App\Reservation\Domain\Repositories\ReservationStoreInterface;
use App\Vacancy\Application\Events\DecrementVacancyCount;
use App\Vacancy\Application\Queries\VacancyAvailabilityQuery;
use App\Vacancy\Domain\DTO\AvailabilityDto;
use App\Vacancy\Domain\Exceptions\AvailabilityException;
use App\Vacancy\Domain\Services\AvailabilityService;
use App\Vacancy\Domain\Services\AvailabilityValidator;
use App\Vacancy\Domain\Services\DatesService;

final readonly class StoreReservationHandler
{
    public function __construct(
        protected ReservationStoreInterface $reservationRepository,
        protected DatesService              $datesService,
        protected VacancyAvailabilityQuery  $vacancyAvailabilityQuery,
        protected AvailabilityValidator     $availabilityValidator,
        protected AvailabilityService       $availabilityService
    ) {}

    /**
     * @throws AvailabilityException
     */
    public function handle(StoreReservation $event): void
    {
        $availabilityCollection = $this->vacancyAvailabilityQuery->get(
            $event->userId,
            $event->people->count(),
            $this->datesService->getDatesBetween($event->start, $event->end)
        );
        // TODO I should not have called below domain services directly. I should made an adapter in the "application" layer
        if (!$this->availabilityValidator->validate($availabilityCollection)) {
            throw new AvailabilityException($this->availabilityService->getUnavailableDates($availabilityCollection));
        }

        /** @var AvailabilityDto $availabilityDto */
        foreach ($availabilityCollection as $availabilityDto) {
            /** @var ClientDto $person */
            foreach ($event->people->items() as $client) {
                $this->reservationRepository->store(
                    new CreateReservationDto(
                        $availabilityDto->vacancyId,
                        $availabilityDto->date
                    )
                );
                // TODO store $client
            }
            DecrementVacancyCount::dispatch($availabilityDto->vacancyId, $event->people->count());
        }
    }
}
