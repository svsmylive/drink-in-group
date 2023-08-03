<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveEventRequest extends FormRequest
{
    public function toArray(): array
    {
        return [
            'event.name' => ['required', 'string'],
            'event.text' => ['nullable', 'string'],
            'event.date' => ['nullable', 'string'],
            'event.time' => ['nullable', 'string'],
            'event.attachment' => ['nullable', 'array'],
        ];
    }
}
