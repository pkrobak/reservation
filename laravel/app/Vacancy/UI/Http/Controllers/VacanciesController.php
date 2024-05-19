<?php

namespace App\Vacancy\UI\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Vacancy\Application\Events\StoreVacancy;
use App\Vacancy\Application\Queries\PaginatedVacancyListQuery;
use App\Vacancy\UI\Http\Requests\IndexVacancyRequest;
use App\Vacancy\UI\Http\Requests\StoreVacancyRequest;
use App\Vacancy\UI\Http\Resources\VacancyResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VacanciesController extends Controller
{
    public function index(IndexVacancyRequest $request, PaginatedVacancyListQuery $query): JsonResponse
    {
        return VacancyResource::collection(
            $query->get(
                $request->integer('people'),
                $request->has('userId') ? $request->integer('userId') : null,
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
