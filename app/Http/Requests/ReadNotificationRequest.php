<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReadNotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'url' => ['nullable', 'url']
        ];
    }
}
