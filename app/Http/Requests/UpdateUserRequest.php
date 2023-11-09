<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => ['string'],
            'last_name' => ['string'],
            'email' => ['string', 'email'],
            'address' => ['string', 'nullable'],
            'city' => ['string', 'nullable'],
            'province' => ['string', 'nullable'],
            'zip' => ['string', 'nullable'],
            'roles' => ['array'],
        ];
    }
}
