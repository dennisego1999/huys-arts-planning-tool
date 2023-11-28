<?php

namespace App\Http\Requests;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;

class StoreCalendarEventRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'array'],
            'name.*' => ['string', 'max:255'],
            'starts_at' => ['required', 'date', 'after:' . CarbonImmutable::yesterday()->format('Y-m-d')],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'type' => ['required', 'array'],
            'type.*.id' => ['string'],
            'users' => ['required', 'array'],
        ];
    }
}
