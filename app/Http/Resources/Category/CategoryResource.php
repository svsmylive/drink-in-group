<?php

namespace App\Http\Resources\Category;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

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
                'dishes' => $this->formatDishes($this->dishes)
            ];
    }

    /**
     * @param Collection $dishes
     * @return Collection
     */
    private function formatDishes(Collection $dishes): Collection
    {
        $dishes->each(function (Dish $dish) {
            $dish->setVisible([
                'id',
                'name', 'price',
                'preview_image',
            ]);
        });

        return $dishes;
    }
}
