<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:0'],
            'image' => ['required', 'string', 'max:500'],
            'category' => ['required', 'string', 'max:120'],
            'brand' => ['required', 'string', 'max:120'],
            'size' => ['required', 'string', 'max:40'],
            'color' => ['required', 'string', 'max:80'],
            'gender' => ['required', 'in:unisex,male,female'],
            'collection' => ['required', 'string', 'max:120'],
        ];
    }
}
