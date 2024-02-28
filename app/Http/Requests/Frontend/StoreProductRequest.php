<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required|numeric|min:1',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'status' => 'between:0,1',
            'sale' => 'numeric|min:0|lte:price',
            // 'company' => 'string',
            'image' => 'required|array|max:3',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'detail' => 'string'
        ];
    }
}
