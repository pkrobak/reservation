<?php

declare(strict_types=1);

namespace App\Vacancy\UI\Http\Resources;

use App\Vacancy\Application\Models\Vacancy;
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
