<?php

declare(strict_types=1);

namespace App\Reservation\UI\Http\Requests;

use App\Reservation\Domain\Collections\ClientsCollection;
use App\Reservation\Domain\DTO\ClientDto;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'people' => 'required|array|min:1',
            'people.*.first_name' => 'required|string|min:3|max:255',
            'people.*.last_name' => 'required|string|min:3|max:255',
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d|after_or_equal:date_from',
        ];
    }

    public function getPeople(): ClientsCollection
    {
        $people = $this->input('people');
        if (!is_array($people)) {
            return new ClientsCollection([]);
        }

        return new ClientsCollection(array_map(function (array $person) {
            return new ClientDto($person['first_name'], $person['last_name']);
        }, $people));
    }
}
