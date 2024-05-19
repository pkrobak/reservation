<?php

declare(strict_types=1);

namespace App\Reservation\UI\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Reservation\Application\Queries\GetReservationsQuery;
use App\Reservation\Domain\DTO\GetReservationDto;
use App\Reservation\UI\Http\Requests\IndexReservationRequest;
use App\Reservation\UI\Http\Resources\ReservationResource;
use Illuminate\Http\JsonResponse;

class ReservationsController extends Controller
{
    public function index(IndexReservationRequest $request, GetReservationsQuery $query): JsonResponse
    {
        return (
            ReservationResource::collection(
                $query->get(
                    new GetReservationDto(
                        $request->date('start'),
                        $request->date('end'),
                        // TODO probably better way would be to have 2 controllers:
                        // TODO one for listing all reservations
                        // TODO another one to list all reservations for a specific user
                        $request->has('userId') ? $request->integer('userId') : null,
                        $request->input('query')
                    )
                )
            )
        )->response($request);
    }
}
