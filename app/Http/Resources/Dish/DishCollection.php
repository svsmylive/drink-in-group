<?php

namespace App\Http\Resources\Dish;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class DishCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->transformCollection($this->collectResource($this->collection)),
        ];
    }

    /**
     * @param Collection $categories
     * @return Collection
     */
    private function transformCollection(Collection $dishes): Collection
    {
        return $dishes->transform(function (DishResource $dish) {
            return $this->formatDishData($dish);
        });
    }

    /**
     * @param DishResource $dish
     * @return array
     */
    private function formatDishData(DishResource $dish): array
    {
        return [
            'id' => $dish->id,
            'name' => $dish->name,
            'price' => $dish->price,
            'index' => $dish->index,
            'preview_image' => $dish->preview_image,
            'category_id' => $dish->category?->id
        ];
    }
}
