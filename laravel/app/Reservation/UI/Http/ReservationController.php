<?php

declare(strict_types=1);

namespace App\Reservation\UI\Http;

use App\Http\Controllers\Controller;
use App\Reservation\Application\Queries\GetReservationsQuery;
use App\Reservation\Application\Requests\IndexReservationRequest;
use App\Reservation\Application\Resources\ReservationResource;
use App\Reservation\Domain\DTO\GetReservationDto;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    public function index(IndexReservationRequest $request, GetReservationsQuery $query): JsonResponse
    {
        return (
            ReservationResource::collection(
                $query->get(
                    new GetReservationDto(
                        $request->date('start'),
                        $request->date('end'),
                        $request->has('userId') ? $request->integer('userId') : null,
                        $request->input('query')
                    )
                )
            )
        )->response($request);
    }
}
