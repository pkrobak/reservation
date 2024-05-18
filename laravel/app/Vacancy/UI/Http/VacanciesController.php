<?php

namespace App\Vacancy\UI\Http;

use App\Http\Controllers\Controller;
use App\Vacancy\Application\Events\StoreVacancy;
use App\Vacancy\Application\Queries\PaginatedVacancyListQuery;
use App\Vacancy\Application\Requests\IndexVacancyRequest;
use App\Vacancy\Application\Requests\StoreVacancyRequest;
use App\Vacancy\Application\Resources\VacancyResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VacanciesController extends Controller
{
    public function index(IndexVacancyRequest $request, PaginatedVacancyListQuery $query): JsonResponse
    {
        return VacancyResource::collection(
            $query->get(
                $request->integer('people'),
                $request->integer('userId'),
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
