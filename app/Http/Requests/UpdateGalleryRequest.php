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
            'images' => 'sometimes|array|min:1',
            'images.*.imagesUrl' => ['sometimes','regex:/^(https?:)?\/\/?[^\'"<>]+?\.(jpg|jpeg|png)(.*)?$/'],
        ];
    }
}
