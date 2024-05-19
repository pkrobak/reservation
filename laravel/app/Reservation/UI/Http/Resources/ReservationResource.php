<?php

declare(strict_types=1);

namespace App\Reservation\UI\Http\Resources;

use App\Reservation\Application\Models\Reservation;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /** @var Reservation */
    public $resource;

    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'date' => $this->resource->date,
            'clients' => ClientResource::collection($this->resource->clients),
            'user_id' => $this->resource->user_id,
        ];
    }
}
