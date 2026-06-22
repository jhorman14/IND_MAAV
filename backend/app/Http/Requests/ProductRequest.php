<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'weight_kg' => 'nullable|numeric|min:0',
            'dimensions_width_mm' => 'nullable|integer',
            'dimensions_depth_mm' => 'nullable|integer',
            'dimensions_height_mm' => 'nullable|integer',
            'available_quantity' => 'nullable|integer|min:0',
            'slug' => 'nullable|string|max:255',
            'visible_public' => 'nullable|boolean',
        ];
    }
}
