<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'images' => 'required|array',
            'images.*' => 'required|file|mimes:jpg,jpeg,png',
            'title' => 'required',
            'description' => 'required|min:5',
            'price' => 'required|integer',
            'category_ids' => 'required|array'
        ];
    }
}
