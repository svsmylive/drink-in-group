<?php

namespace App\Http\Resources\Institutions;

use App\Models\Institution;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Institution */
class InstitutionsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'city' => $this->city,
            'address' => $this->address,
            'full_address' => $this->full_address,
            'menu_link' => $this->menu_link,
            'time_of_work' => $this->time_of_work,
            'phone' => $this->phone,
            'active' => $this->active,
            'about_detail_text' => $this->about_detail_text,
        ];
    }
}
