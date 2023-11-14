<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDanceGroupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255', 'unique_translation:dance_groups,name'],
            'description' => ['string', 'max:255'],
            'new_image' => ['image', 'mimes:jpg,png,jpeg,gif', 'nullable'],
            'members' => ['array'],
        ];
    }
}
