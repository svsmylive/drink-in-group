<?php

namespace App\Http\Requests;

use App\Models\Institution;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateFeedbackRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'institution_id' => ['required', Rule::exists(Institution::class, 'id')],
            'name' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'date' => ['required', 'string'],
            'time' => ['required', 'string'],
            'count_guests' => ['nullable', 'string'],
            'comment' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
