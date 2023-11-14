<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text' => ['array', 'required'],
            'text.*' => ['string', 'required'],
        ];
    }
}
