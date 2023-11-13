<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDanceGroupRequest extends FormRequest
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
            'name' => ['string', 'unique_translation:dance_groups,name'],
            'description' => ['string'],
            'new_image' => ['image', 'mimes:jpg,png,jpeg,gif', 'nullable'],
            'members' => 'array',
        ];
    }
}
