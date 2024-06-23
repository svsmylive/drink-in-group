<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category.name' => ['required', 'string'],
            'category.is_show' => ['required', 'boolean'],
            'category.index' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
