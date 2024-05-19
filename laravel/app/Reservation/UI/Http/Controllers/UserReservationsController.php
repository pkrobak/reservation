<?php

declare(strict_types=1);

namespace App\Reservation\UI\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Reservation\Application\Events\StoreReservation;
use App\Reservation\UI\Http\Requests\StoreReservationRequest;
use App\Vacancy\Domain\Exceptions\AvailabilityException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserReservationsController extends Controller
{
    public function store(StoreReservationRequest $request, User $user): JsonResponse
    {
        try {
            StoreReservation::dispatch(
                $user->id,
                $request->date('date_from'),
                $request->date('date_to'),
                $request->getPeople()
            );
        } catch (AvailabilityException $exception) {
            // TODO: I could have made the validation in a custom rule, but I realized it too late
            return response()->json(
                [
                    'message' => $exception->getMessage(),
                    'errors' => [
                        'unavailable_dates' => $exception->getInvalidDates()->items()
                    ]
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return response()->json([], Response::HTTP_CREATED);
    }

}
