<?php

namespace App\Http\Resources\Dish;

use App\Http\Resources\Attachments\AttachmentsResource;
use App\Models\Dish;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Dish $this
 */
class DishResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
            [
                'id' => $this->id,
                'name' => $this->name,
                'price' => $this->price,
                'weight' => $this->mitm_Volume * 1000 . ' гр',
                'image' => AttachmentsResource::collection(
                    $this->whenNotNull($this->image()->exists() ? $this->image()->get() : null)
                ),
                'institution_id' => $this->institution_id,
            ];
    }
}
