<?php

namespace App\Http\Resources\Attachments;

use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'original_name' => $this->original_name,
            'extension' => $this->extension,
            'size' => $this->size,
            'url' => '/storage/' . $this->path . $this->name . '.' . $this->extension,
        ];
    }
}
