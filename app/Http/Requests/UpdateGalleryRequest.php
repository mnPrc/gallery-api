<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGalleryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|min:2|max:250',
            'description' => 'nullable|string|max:1000',
            'price' => 'sometimes|numeric|min:1|max:10000',
            'images' => 'sometimes|array|min:1',
            'images.*.imageUrl' => 'sometimes|url|ends_with:jpg,jpeg,png',
        ];
    }
}
