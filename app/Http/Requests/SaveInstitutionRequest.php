<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'institution.time_of_work' => ['nullable', 'string'],
            'institution.phone' => ['nullable', 'string'],
            'institution.active' => ['nullable', 'bool'],
            'institution.attachment' => ['nullable', 'array'],
            'institution.title' => ['nullable', 'string'],
            'institution.description' => ['nullable', 'string'],
            'institution.about_detail_text_header' => ['nullable', 'string'],
            'institution.about_detail_text_body' => ['nullable', 'string'],
            'institution.about_detail_text_footer' => ['nullable', 'string'],
            'institution.event_text_header' => ['nullable', 'string'],
            'institution.event_text_footer' => ['nullable', 'string'],
            'institution.services_and_prices_text_header' => ['nullable', 'string'],
            'institution.services_and_prices_text_footer' => ['nullable', 'string'],
            'institution.services_and_prices_capacity' => ['nullable', 'string'],
            'institution.services_and_prices_price' => ['nullable', 'string'],
            'institution.services_and_prices_include' => ['nullable', 'array'],
            'institution.services_and_prices_additionally_include' => ['nullable', 'array'],
            'events' => ['nullable', 'array'],
        ];
    }
}
