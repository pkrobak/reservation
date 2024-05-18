<?php

declare(strict_types=1);

namespace App\Vacancy\Application\Resources;

use App\Vacancy\Infrastructure\Vacancy;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Request;

class VacancyResource extends JsonResource
{
    /** @var Vacancy */
    public $resource;
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'date' => $this->resource->date,
            'count' => $this->resource->count,
            'user_id' => $this->resource->user_id,
        ];
    }
}
