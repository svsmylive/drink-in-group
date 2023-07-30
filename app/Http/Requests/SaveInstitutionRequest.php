<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class SaveInstitutionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'institution.name' => ['required', 'string'],
            'institution.type' => ['nullable', 'string'],
            'institution.city' => ['nullable', 'string'],
            'institution.address' => ['nullable', 'string'],
            'institution.full_address' => ['nullable', 'string'],
            'institution.menu' => ['nullable', File::types(['pdf'])],
            'institution.time_of_work' => ['nullable', 'string'],
            'institution.phone' => ['nullable', 'string'],
            'institution.active' => ['nullable', 'bool'],
            'institution.attachment' => ['nullable', 'array'],
            'institution.about_detail_text' => ['nullable', 'string'],
            'event.*.name' => ['nullable', 'string'],
            'event.*.text' => ['nullable', 'string'],
            'event.*.date' => ['nullable', 'string'],
            'event.*.time' => ['nullable', 'string'],
            'event.*.image' => ['nullable', File::types(['jpg, webp', 'png'])],
        ];
    }
}
