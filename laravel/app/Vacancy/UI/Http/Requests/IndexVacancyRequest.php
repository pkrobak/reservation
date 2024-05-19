<?php

declare(strict_types=1);

namespace App\Vacancy\UI\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexVacancyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'start' => 'required|date|date_format:Y-m-d',
            'end' => 'required|date|date_format:Y-m-d|after:start',
            'people' => 'required|numeric|min:1',
            'userId' => 'sometimes|numeric|exists:users,id',
        ];
    }
}
