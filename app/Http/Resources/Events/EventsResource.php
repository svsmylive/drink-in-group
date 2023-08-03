<?php

namespace App\Http\Resources\Events;

use App\Http\Resources\Attachments\AttachmentsResource;
use App\Models\Event;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Event */
class EventsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'text' => $this->text,
            'date' => $this->date,
            'time' => $this->time,
            'image' => new AttachmentsResource($this->attachment()->first()),
        ];
    }
}
