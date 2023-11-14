<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportTranslationsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => ['file']
        ];
    }
}
