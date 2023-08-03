<?php

namespace App\Http\Resources\Institutions;

use App\Http\Resources\Attachments\AttachmentsResource;
use App\Http\Resources\Events\EventsResource;
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
            'slider_images' => AttachmentsResource::collection($this->attachment()->get()),
            'events' => EventsResource::collection($this->whenNotNull($this->events()->exists() ? $this->events()->get() : null))
        ];
    }
}
