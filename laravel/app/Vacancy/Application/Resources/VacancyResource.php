<?php

declare(strict_types=1);

namespace App\Vacancy\Application\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Request;

class VacancyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'start' => $this->resource->start,
            'end' => $this->resource->end,
            'count' => $this->resource->people,
            'user_id' => $this->resource->user_id,
        ];
    }
}
