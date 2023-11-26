<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
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
            'name'=>'required|min:2|max:255',
            'description'=> 'max:1000',
            'images' => 'array|min:1|required',
            'images.*' => ["regex:/^(http)?s?:?(\/\/[^\']*\.(?:png|jpg|jpeg))/"],
            'user_id' => 'required'
        ];
    }
}
