<?php

declare(strict_types=1);

namespace App\Reservation\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexReservationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'start' => 'sometimes|date|date_format:Y-m-d',
            'end' => 'sometimes|date|after:start|date_format:Y-m-d',
            'userId' => 'sometimes|exists:users,id',
            'query' => 'sometimes|string|nullable',
        ];
    }
}
