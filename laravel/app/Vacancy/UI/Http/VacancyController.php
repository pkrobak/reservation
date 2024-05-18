<?php

namespace App\Vacancy\UI\Http;

use App\Http\Controllers\Controller;
use App\Vacancy\Application\Events\StoreVacancy;
use App\Vacancy\Application\Queries\PaginatedVacancyListQuery;
use App\Vacancy\Application\Requests\ListVacancyRequest;
use App\Vacancy\Application\Requests\StoreVacancyRequest;
use App\Vacancy\Application\Resources\VacancyResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VacancyController extends Controller
{
    public function index(ListVacancyRequest $request, PaginatedVacancyListQuery $query): JsonResponse
    {
        return VacancyResource::collection(
            $query->get(
                $request->integer('people'),
                $request->integer('user_id'),
                $request->date('start'),
                $request->date('end')
            )
        )->toResponse($request);
    }

    public function store(StoreVacancyRequest $request): JsonResponse
    {
        StoreVacancy::dispatch(
            $request->date('start'),
            $request->date('end'),
            $request->integer('people'),
            auth()->id()
        );

        return response()->json([], Response::HTTP_CREATED);
    }
}
