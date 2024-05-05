<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Dish\DishResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Category
 */
class CategoryResource extends JsonResource
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
                'preview_image' => $this->preview_image,
                'dishes' => DishResource::collection($this->dishes)
            ];
    }
}
