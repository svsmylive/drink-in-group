<?php

namespace App\Http\Resources\Dish;

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
                'preview_image' => $this->preview_image,
                'detail_image' => $this->detail_image,
                'institution_id' => $this->institution_id,
            ];
    }
}
