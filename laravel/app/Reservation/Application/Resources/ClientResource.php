<?php

declare(strict_types=1);

namespace App\Reservation\Application\Resources;

use App\Reservation\Infrastructure\Client;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /** @var Client */
    public $resource;
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
        ];
    }
}
