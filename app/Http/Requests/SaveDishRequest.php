<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveDishRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'dish.name' => ['required', 'string'],
            'dish.price' => ['required', 'integer'],
            'dish.is_show' => ['required', 'boolean'],
            'dish.attachment' => ['nullable', 'sometimes'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
