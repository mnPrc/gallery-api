<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGalleryRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:250',
            'description' => 'nullable|string|max:1000',
            'first_image_url' => 'required|url|ends_with:jpg,jpeg,png',
            'images' => 'required|array|min:1',
            'images.*.imageUrl' => 'required|url|ends_with:jpg,jpeg,png'
        ];
    }
}
