<?php

namespace App\Http\Requests;

use App\Models\Institution;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'institution_id' => ['required', Rule::exists(Institution::class, 'id')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
