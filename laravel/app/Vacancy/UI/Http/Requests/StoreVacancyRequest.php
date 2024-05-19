<?php

declare(strict_types=1);

namespace App\Vacancy\UI\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreVacancyRequest extends FormRequest
{
    public function authorization(): bool
    {
        // I would make an authorization, but I don't know what logic should be.
        // It can be a permission called using gates or just a flag on authentiacted model
        return true;
    }
    public function rules(): array
    {
        return [
            'start' => 'required|date|date_format:Y-m-d|after:' . Carbon::now()->format('Y-m-d'),
            'end' => 'required|date|date_format:Y-m-d|after:start',
            'people' => 'required|numeric|min:1',
        ];
    }
}
