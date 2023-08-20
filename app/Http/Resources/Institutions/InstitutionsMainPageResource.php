<?php

namespace App\Http\Resources\Institutions;

use App\Models\Institution;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Institution */
class InstitutionsMainPageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
